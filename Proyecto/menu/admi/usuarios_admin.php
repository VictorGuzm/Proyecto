<?php
session_start();
require("../../BD/conect.php");
$conexion = conectar_bd();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../../login/');
}

$usuario = $_SESSION['usuario'];

$consulta = "SELECT * FROM usuario WHERE usuario = '$usuario'";
$resultado = mysqli_query($conexion, $consulta);

$usuario = mysqli_fetch_assoc($resultado);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style_usuario.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="../../public/img/logo_menu.png" alt="Logo">
        </div>
        <ul class="options"> 
            <li><a href="menu_admin.html"><img src="../../public/img/inicio.png" alt="inicio"><p>Inicio</p></a></li> 
            <li><a href="productos_admin.php"><img src="../../public/img/productos.png" alt="productos"><p>Productos</p></a></li> 
            <li><a href="ventas_admin.html"><img src="../../public/img/ventas.png" alt="ventas"><p>Ventas</p></a></li> 
            <li><a href="proveedores_admin.php"><img src="../../public/img/proveedores.png" alt="proveedores"><p>Proveedores</p></a></li> 
            <li><a href="reportes_admin.html"><img src="../../public/img/reportes.png" alt="reportes"><p>Reportes</p></a></li> 
            <li><a href="usuarios_admin.html"><img src="../../public/img/user.png" alt="usuario"><p>Usuario</p></a></li> 
            <li><a href="empleados_admin.php"><img src="../../public/img/empleados.png" alt="empleados"><p>Empleados</p></a></li> 
            <li><a href="../../login/"><img src="../../public/img/cerrar.png" alt="salir"><p>Cerrar</p></a></li> 
            </ul> 
    </nav>
<h1>Usuario</h1>
<div class="admin">
    <h1>Información del administrador</h1><img src="../../public/img/user.png" alt="Administrador">
    <div class="admin-info">
        <span>Nombre: <strong>{{ usuario.nombre }}</strong></span>
        <span>Cedula: <strong>{{ usuario.cedula }}</strong></span>
        <span>Usuario: <strong>{{ usuario.usuario }}</strong></span>
    </div>
</div>
</body>
</html>