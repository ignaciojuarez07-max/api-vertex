<?php
header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php'; 

$data = json_decode(file_get_contents("php://input"));

if (isset($data->usuario_corp) && isset($data->password)) {
    
    $usuario_corp = $data->usuario_corp;
    $password = $data->password;

    try {
        $query = "SELECT * FROM usuarios WHERE usuario_corp = :usuario AND password = :pass";
        $stmt = $conn->prepare($query);

        $stmt->execute([
            ':usuario' => $usuario_corp,
            ':pass' => $password
        ]);

        if ($stmt->rowCount() > 0) {
            // ¡NUEVO! Extraemos los datos de la fila encontrada
            $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombreReal = $usuarioDB['nombre'];
            
            // Mandamos el nombre en el JSON
            echo json_encode(["success" => true, "message" => "Login correcto", "nombre" => $nombreReal]);
        } else {
            echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error de BD: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["success" => false, "message" => "Faltan datos de inicio de sesión"]);
}
?>