<?php
// Este host es el "traductor" oficial para que Render vea a Supabase
$host = "aws-0-us-west-2.pooler.supabase.com"; 
$port = "5432"; 
$dbname = "postgres";
$user = "postgres.nuzjtrrutyplgatwduxg"; 
$password = "EstadosUnidos03";

try {
    // Intentamos la conexión limpia
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Si falla, nos dirá el error exacto aquí
    die("Error de conexión: " . $e->getMessage());
}
?>
