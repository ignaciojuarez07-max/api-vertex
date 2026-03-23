<?php
// Datos de conexión a Neon
$host = "ep-round-block-ammv0ur1-pooler.c-5.us-east-1.aws.neon.tech"; 
$port = "5432"; 
$dbname = "neondb";
$user = "neondb_owner";
$password = "npg_QgSj6JoBrzv0";

try {
    // A Neon le gusta que le confirmemos el uso de seguridad (sslmode=require)
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
