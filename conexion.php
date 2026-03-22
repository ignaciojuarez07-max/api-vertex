<?php
// Datos de tu nueva base de datos en Supabase
$host = "db.nuzjtrrutyplgatwduxg.supabase.co";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "EstadosUnidos03";

try {
    // La conexión ahora apunta al host de la nube
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    
    // Configuramos para que nos avise si hay errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: Esto ayuda con caracteres especiales
    $conn->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    // Si falla, nos dirá exactamente por qué
    die("Error de conexión a la nube: " . $e->getMessage());
}
?>