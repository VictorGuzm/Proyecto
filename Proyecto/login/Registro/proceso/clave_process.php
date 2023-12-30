<?php
session_start();

if (isset($_POST['clave'])) {
    $clave = $_POST['clave'];
    // Conectamos a la Base de Datos llamando a una función
    include("../../../BD/conect.php");
    $conexion = conectar_bd();
    $consulta = "SELECT clave FROM Clave";
    $resultado = $conexion->query($consulta);
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $claveAlmacenada = $fila['clave'];
        // Verificar si la clave ingresada coincide con la clave almacenada
        if ($clave === $claveAlmacenada) {
            // Redirigir a la página "admin.php"
            $_SESSION['loggedin'] = true;
            header("Location: ../Admin.php");
            exit;
        } else {
            $_SESSION['clave_error'] = "La clave es incorrecta";
            header("Location: ../clave.php");
            exit;
        }
    }
    $conexion->close();
}
?>