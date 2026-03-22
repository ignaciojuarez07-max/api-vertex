<?php
// Permisos para Android y Web
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

require 'conexion.php';

try {
    // Unimos la tabla ventas con inventario para saber el nombre del teléfono
   // Le agregamos i.url_imagen al final
    $query = "SELECT v.id, v.cliente, v.precio_venta, v.fecha_venta, i.modelo, i.url_imagen 
              FROM ventas v
              JOIN inventario i ON v.id_iphone = i.id
              ORDER BY v.fecha_venta DESC";;
              
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ventas);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>