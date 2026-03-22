<?php
// Usamos el host de sesión que es compatible con IPv4 (Render)
$host = "aws-0-us-west-2.pooler.supabase.com"; 
$port = "5432"; 
$dbname = "postgres";
$user = "postgres.nuzjtrrutyplgatwduxg"; // Usuario con ID de proyecto
$password = "EstadosUnidos03";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
