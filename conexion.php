<?php
// Datos optimizados para Render -> Supabase
$host = "aws-0-us-west-2.pooler.supabase.com"; // Verifica tu región en Supabase si esta no funciona
$port = "6543"; 
$dbname = "postgres";
$user = "postgres.nuzjtrrutyplgatwduxg"; // IMPORTANTE: Supabase pide el usuario con el ID del proyecto
$password = "EstadosUnidos03";

try {
    // Conexión usando el puerto 6543 y el usuario completo
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    die("Error de conexión a la nube: " . $e->getMessage());
}
?>
