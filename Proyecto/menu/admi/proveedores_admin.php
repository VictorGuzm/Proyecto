<?php
// Establecer conexión con la base de datos
require("../../BD/conect.php");
$conexion = conectar_bd();
if (isset($_POST['agregar_proveedor'])) {
    $ci = $_POST['ci'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $tipo_proveedor = $_POST['tipo_proveedor'];
    $query = "INSERT INTO proveedor (ci, nombre, telefono, tipo_proveedor) VALUES ('$ci', '$nombre', '$telefono', '$tipo_proveedor')";
    $result = $conexion->query($query);
}
if (isset($_POST['actualizar_proveedor'])) {
    $ci = $_POST['ci'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $tipo_proveedor = $_POST['tipo_proveedor'];
    $query = "UPDATE proveedor SET nombre='$nombre', telefono='$telefono', tipo_proveedor='$tipo_proveedor' WHERE ci='$ci'";
    $result = $conexion->query($query);
}
if (isset($_POST['eliminar_proveedor'])) {
    $ci = $_POST['ci'];
    $query = "DELETE FROM proveedor WHERE ci='$ci'";
    $result = $conexion->query($query);
}
$query = "SELECT * FROM proveedor";
$result = $conexion->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style_proveedores.css">
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
    <h1>Proveedores</h1>
    <form method="post" class="container">
        <input type="text" name="buscar" placeholder="Buscar por nombre">
        <button type="submit" class="btn btn-primary">Buscar</button>     
        <div>
        
        <ul class="options"> 
        <li>+<a href="proveedores2.php"><img src="../../public/img/proveedores.png" alt="productos"><p>Agregar</p></a></li>
        </div>
    </form>

    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>CI</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Tipo de Proveedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['ci']."</td>";
                echo "<td>".$row['nombre']."</td>";
                echo "<td>".$row['telefono']."</td>";
                echo "<td>".$row['tipo_proveedor']."</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='ci' value='".$row['ci']."'>
                        <input type='text' name='nombre' value='".$row['nombre']."'>
                        <input type='text' name='telefono' value='".$row['telefono']."'>
                        <input type='text' name='tipo_proveedor' value='".$row['tipo_proveedor']."'>
                        <button type='submit' class='btn btn-success actualizar' name='actualizar_proveedor'>Actualizar</button>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='ci' value='".$row['ci']."'>
                        <button type='submit' class='btn btn-danger eliminar' name='eliminar_proveedor'>Eliminar</button>
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
