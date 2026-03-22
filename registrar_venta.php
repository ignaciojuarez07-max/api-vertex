<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// IMPORTANTE: Este archivo usa tu nueva conexión a Supabase automáticamente
include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id_iphone) && isset($data->cliente)) {
    try {
        // Iniciamos transacción en la nube
        $conn->beginTransaction();

        // 1. REGISTRAR LA VENTA
        $queryVenta = "INSERT INTO ventas (id_iphone, precio_venta, fecha_venta, cliente) 
                       VALUES (:id_id, :pre, CURRENT_TIMESTAMP, :nom)";
        
        $stmtVenta = $conn->prepare($queryVenta);
        $stmtVenta->execute([
            ':id_id' => $data->id_iphone,
            ':pre'   => $data->precio,
            ':nom'   => $data->cliente
        ]);

        // 2. ACTUALIZAR EL ESTATUS EN INVENTARIO
        $queryInv = "UPDATE inventario SET estatus_venta = 'Vendido' WHERE id = :id_inv";
        $stmtInv = $conn->prepare($queryInv);
        $stmtInv->execute([':id_inv' => $data->id_iphone]);

        // Si todo salió bien, guardamos cambios en Supabase
        $conn->commit();
        echo json_encode(["success" => true, "message" => "Venta guardada con éxito en la nube"]);
        
    } catch (PDOException $e) {
        // Si algo falla, deshacemos todo para no perder datos
        if ($conn->inTransaction()) $conn->rollBack();
        echo json_encode(["success" => false, "message" => "Error de BD en la nube: " . $e->getMessage()]);
    }
}
?>