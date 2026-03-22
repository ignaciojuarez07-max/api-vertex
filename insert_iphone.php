<?php
// Los permisos de CORS son obligatorios para evitar bloqueos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$data = json_decode(file_get_contents("php://input"));

if (isset($data->modelo) && isset($data->capacidad_gb) && isset($data->numero_serie)) {
    
    $precio = isset($data->precio) ? $data->precio : null;
    // Forzamos el texto exacto, sin espacios, pase lo que pase.
    $estatus_venta = 'Disponible';

    try {
        // En lugar de escribir 'Disponible' directo en la línea, usamos el parámetro :estatus_venta
        $query = "INSERT INTO inventario (modelo, capacidad_gb, bateria_porc, estado, url_imagen, numero_serie, estatus_venta, precio) 
                  VALUES (:modelo, :capacidad_gb, :bateria_porc, :estado, :url_imagen, :numero_serie, :estatus_venta, :precio)";
        
        $stmt = $conn->prepare($query);
        
        $stmt->execute([
            ':modelo' => $data->modelo,
            ':capacidad_gb' => $data->capacidad_gb,
            ':bateria_porc' => $data->bateria_porc,
            ':estado' => $data->estado,
            ':url_imagen' => $data->url_imagen,
            ':numero_serie' => $data->numero_serie,
            ':estatus_venta' => $estatus_venta,
            ':precio' => $precio
        ]);

        echo json_encode(["success" => true, "message" => "Equipo registrado correctamente"]);
        
    } catch (PDOException $e) {
        if ($e->getCode() == 23505) {
            echo json_encode(["success" => false, "message" => "Ese número de serie ya existe"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error de BD: " . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios"]);
}
?>