<?php
// Configuración de la base de datos
define('DB_DSN', 'mysql:host=localhost;dbname=nombre_basedatos');
define('DB_USERNAME', 'usuario');
define('DB_PASSWORD', 'contraseña');

// Crear la conexión a la base de datos
try {
    $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    die();
}
?>