<?php
// Establecer conexión con la base de datos
require("../../BD/conect.php");
$conexion = conectar_bd();

// Agregar producto
if (isset($_POST['agregar_producto'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $query = "INSERT INTO productos (nombre, precio, stock, categoria) VALUES ('$nombre', '$precio', '$stock', '$categoria')";
    $result = $conexion->query($query);
}

// Actualizar producto
if (isset($_POST['actualizar_producto'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $query = "UPDATE productos SET nombre='$nombre', precio='$precio', stock='$stock', categoria='$categoria' WHERE id='$id'";
    $result = $conexion->query($query);
}

// Eliminar producto
if (isset($_POST['eliminar_producto'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM productos WHERE id='$id'";
    $result = $conexion->query($query);
}

$query = "SELECT * FROM productos";
$result = $conexion->query($query);
?>

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
            <li><a href="menu_admin.php"><img src="../../public/img/inicio.png" alt="inicio"><p>Inicio</p></a></li>
            <li><a href="productos_admin.php"><img src="../../public/img/productos.png" alt="productos"><p>Productos</p></a></li>
            <li><a href="ventas_admin.php"><img src="../../public/img/ventas.png" alt="ventas"><p>Ventas</p></a></li>
            <li><a href="proveedores_admin.php"><img src="../../public/img/proveedores.png" alt="proveedores"><p>Proveedores</p></a></li>
            <li><a href="reportes_admin.html"><img src="../../public/img/reportes.png" alt="reportes"><p>Reportes</p></a></li>
            <li><a href="empleados_admin.php"><img src="../../public/img/empleados.png" alt="empleados"><p>Empleados</p></a></li>
            <li><a href="../../login/"><img src="../../public/img/cerrar.png" alt="salir"><p>Cerrar</p></a></li>
        </ul>
    </nav>
    <h1>Productos</h1>
    <form method="post" class="container">
        <input type="text" name="buscar" placeholder="Buscar por nombre">
        <button type="submit" class="btn btn-primary">Buscar</button>     
        <div>
        <ul class="options"> 
        <li>+<a href="producto2.php"><img src="../../public/img/empleados.png" alt="productos"><p>Agregar</p></a></li>
        </div>
    </form>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['nombre']."</td>";
                echo "<td>".$row['precio']."</td>";
                echo "<td>".$row['stock']."</td>";
                echo "<td>".$row['categoria']."</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <input type='text' name='nombre' value='".$row['nombre']."'>
                        <input type='text' name='precio' value='".$row['precio']."'>
                        <input type='text' name='stock' value='".$row['stock']."'>
                        <input type='text' name='categoria' value='".$row['categoria']."'>
                        <button type='submit' class='btn btn-success actualizar' name='actualizar_producto'>Actualizar</button>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <button type='submit' class='btn btn-danger eliminar' name='eliminar_producto'>Eliminar</button>
                    </form>
                </td>";
            echo "</tr>";
        }
        ?> 
        </tbody> 
    </table> 
</body> 
</html> 

<?php 
// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
// Cerrar conexión
$conexion->close();
?>