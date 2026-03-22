<?php
// Intento con puerto estándar 5432
$host = "db.nuzjtrrutyplgatwduxg.supabase.co"; 
$port = "5432"; 
$dbname = "postgres";
$user = "postgres"; // Aquí vuelve a ser solo postgres
$password = "EstadosUnidos03";

try {
    // Agregamos un timeout para que no se quede colgado
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, $options);
    
    $conn->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
