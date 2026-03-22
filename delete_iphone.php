<?php
header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php'; 

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    try {
        // Borramos de la tabla 'inventario'
        $query = "DELETE FROM inventario WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $data->id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Equipo eliminado"]);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontró el equipo"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error de BD: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Falta el ID"]);
}
?>