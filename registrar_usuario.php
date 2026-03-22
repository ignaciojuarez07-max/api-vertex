<?php
// Permitir conexiones desde la app
header("Content-Type: application/json; charset=UTF-8");

// Recibir el "paquete" JSON que mandará Android
$data = json_decode(file_get_contents("php://input"));

// Verificamos que no venga vacío
if (isset($data->nombre) && isset($data->apellido) && isset($data->codigo_empleado) && isset($data->usuario_corp) && isset($data->password)) {

    // --- CONEXIÓN A SUPABASE (NUBE) ---
    $host = "db.nuzjtrrutyplgatwduxg.supabase.co";
    $port = "5432";
    $dbname = "postgres"; 
    $user = "postgres"; 
    $password = "EstadosUnidos03"; 

    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require";
    $dbconn = pg_connect($conn_string);

    if (!$dbconn) {
        echo json_encode(["success" => false, "message" => "Error de conexión a la nube"]);
        exit;
    }

    $nombre = $data->nombre;
    $apellido = $data->apellido;
    $codigo = $data->codigo_empleado;
    $usuario_corp = $data->usuario_corp;
    $pass = $data->password;

    // Insertar en la tabla usuarios
    $query = "INSERT INTO usuarios (nombre, apellido, codigo_empleado, usuario_corp, password) VALUES ($1, $2, $3, $4, $5)";
    $result = @pg_query_params($dbconn, $query, array($nombre, $apellido, $codigo, $usuario_corp, $pass));

    if ($result) {
        echo json_encode(["success" => true, "message" => "Cuenta creada exitosamente en la nube"]);
    } else {
        $error = pg_last_error($dbconn);
        if (strpos($error, 'unique constraint') !== false) {
            echo json_encode(["success" => false, "message" => "Ese código de empleado o usuario ya está registrado"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al guardar en la base de datos de la nube"]);
        }
    }

    pg_close($dbconn);
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos en el envío"]);
}
?>