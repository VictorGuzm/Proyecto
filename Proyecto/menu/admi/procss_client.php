<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible"content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Document</title> 
    <link rel="stylesheet" href="style/style_productos.css"> 
</head> 
<body> 
    <nav> 
        <div class="logo"> 
            <img src="../../public/img/logo_menu.png" alt="Logo"> 
        </div> 
        <ul class="options"> 
        <li><a href="menu_admin.html"><img src="../../public/img/inicio.png" alt="inicio"><p>Inicio</p></a></li> 
        <li><a href="productos_admin.html"><img src="../../public/img/productos.png" alt="productos"><p>Productos</p></a></li> 
        <li><a href="ventas_admin.html"><img src="../../public/img/ventas.png" alt="ventas"><p>Ventas</p></a></li> 
        <li><a href="proveedores_admin.html"><img src="../../public/img/proveedores.png" alt="proveedores"><p>Proveedores</p></a></li> 
        <li><a href="reportes_admin.html"><img src="../../public/img/reportes.png" alt="reportes"><p>Reportes</p></a></li> 
        <li><a href="usuarios_admin.html"><img src="../../public/img/user.png" alt="usuario"><p>Usuario</p></a></li> 
        <li><a href="c"><img src="" alt="salir"></a></li> 
        </ul> 
    </nav> 
    <h1>Agregar Cliente</h1>
    <form method="post" class="container">
        <div class="form-group">
            <label>Cédula:</label>
            <input type="text" name="cedula" required>
        </div>
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Apellido:</label>
            <input type="text" name="apellido" required>
        </div>
        <div class="form-group">
            <label>Teléfono:</label>
            <input type="text" name="telefono" required>
        </div>
        <div class="form-group">
            <label>Dirección:</label>
            <input type="text" name="direccion" required>
        </div>
        <div class="form-group">
            <label>Tipo de cliente:</label>
            <select name="tipo_cliente" required>
                <option value="1">Tipo 1</option>
                <option value="2">Tipo 2</option>
            </select>
        </div>
        <button type="submit" name="agregar_cliente" class="btn btn-primary agregar">Agregar</button>
    </form>
</body> 
</html>
<?php
// Establecer conexión con la base de datos
require("../../BD/conect.php");
$conexion = conectar_bd();

// Agregar
if (isset($_POST['agregar_cliente'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $tipo_cliente = $_POST['tipo_cliente'];
    $query = "INSERT INTO clientes_new (cedula, nombre, apellido, telefono, Direccion, id_tipo_cliente) VALUES ('$cedula', '$nombre', '$apellido', '$telefono', '$direccion', '$tipo_cliente')";
    $result = $conexion->query($query);
}

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Cerrar conexión
$conexion->close();
?>