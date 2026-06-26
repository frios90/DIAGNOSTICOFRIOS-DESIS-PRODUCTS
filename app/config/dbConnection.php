<?php

$host = 'localhost';
// $host = 'db'; // para levantar con DOCKER

$port = '5432';
$database_name = 'diagnostico';
$db_username = 'diagnostico_usr';
$db_password = '1234';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database_name;", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $error) {
    die("Error en la conexión con la base de datos: " . $error->getMessage());
}
?>