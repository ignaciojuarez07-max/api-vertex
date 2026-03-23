<?php
// Permitir conexiones desde la app (Android)
header("Content-Type: application/json; charset=UTF-8");

// 1. LLAMAMOS AL ARCHIVO DE CONEXIÓN NUEVO (Neon)
// Así no repetimos contraseñas. Esto nos trae la variable $conn
require_once 'conexion.php'; 

// Recibir el "paquete" JSON que mandará Android
$data = json_decode(file_get_contents("php://input"));

// Verificamos que no venga vacío
if (isset($data->nombre) && isset($data->apellido) && isset($data->codigo_empleado) && isset($data->usuario_corp) && isset($data->password)) {

    $nombre = $data->nombre;
    $apellido = $data->apellido;
    $codigo = $data->codigo_empleado;
    $usuario_corp = $data->usuario_corp;
    $pass = $data->password;

    try {
        // Insertar en la tabla usuarios (Usamos PDO con ? por seguridad)
        $query = "INSERT INTO usuarios (nombre, apellido, codigo_empleado, usuario_corp, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$nombre, $apellido, $codigo, $usuario_corp, $pass]);

        if ($result) {
            echo json_encode(["success" => true, "message" => "Cuenta creada exitosamente en la nube"]);
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
        // El código 23505 en Postgres significa que se repitió un dato único (unique constraint)
        if (strpos($error, '23505') !== false) {
            echo json_encode(["success" => false, "message" => "Ese código de empleado o usuario ya está registrado"]);
        } else {
            // Muestra el error real si algo más falla para poder arreglarlo
            echo json_encode(["success" => false, "message" => "Error al guardar: " . $error]);
        }
    }

} else {
    echo json_encode(["success" => false, "message" => "Faltan datos en el envío"]);
}
?>
