<?php
function conectar_bd() {  
    // Establecer conexion con la base de datos  
    $conexion = new mysqli("localhost", "root", "", "dadobrosther");  
    //Verificar conexion  
    if ($conexion->connect_error) {  
        die("Error de conexión: " . $conexion->connect_error);  
    }  
    // Retornar la conexión establecida  
    return $conexion;  
}  
?>