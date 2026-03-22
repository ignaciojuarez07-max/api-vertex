<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

require 'conexion.php';

try {
    // Volvemos a poner el filtro, pero TRIM() borra cualquier espacio fantasma
    $query = "SELECT * FROM inventario WHERE TRIM(estatus_venta) = 'Disponible'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $iphones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($iphones);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>