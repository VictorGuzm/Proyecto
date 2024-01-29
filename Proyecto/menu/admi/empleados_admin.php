<?php
// Establecer conexión con la base de datos
require("../../BD/conect.php");
$conexion = conectar_bd();

if (isset($_POST['agregar_usuario'])) {
    $cedula = $_POST['cedula'];
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $id_rol = $_POST['id_rol'];
    $query = "INSERT INTO usuario (cedula, usuario, nombre, password , id_rol) VALUES ('$cedula', '$usuario', '$nombre', '$password', '$id_rol')";
    $result = $conexion->query($query);
}

if (isset($_POST['actualizar_usuario'])) {
    $id = $_POST['id'];
    $cedula = $_POST['cedula'];
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $id_rol = $_POST['id_rol'];
    $query = "UPDATE usuario SET cedula='$cedula', usuario='$usuario', nombre='$nombre', password='$password', id_rol='$id_rol' WHERE id='$id'";
    $result = $conexion->query($query);
}

if (isset($_POST['eliminar_usuario'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM usuario WHERE id='$id'";
    $result = $conexion->query($query);
}

$query = "SELECT * FROM usuario";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style_empleados.css">
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
    <h1>Usuarios</h1>
    <form method="post" class="container">
        <input type="text" name="buscar" placeholder="Buscar por nombre">
        <button type="submit" class="btn btn-primary">Buscar</button>     
        <div>
        <ul class="options"> 
        <li>+<a href="usuarios2.php"><img src="../../public/img/empleados.png" alt="empleados"><p>Agregar</p></a></li>
        </div>
    </form>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Password</th>
                <th>ID Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['cedula']."</td>";
                echo "<td>".$row['usuario']."</td>";
                echo "<td>".$row['nombre']."</td>";
                echo "<td>".$row['password']."</td>";
                echo "<td>".$row['id_rol']."</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <input type='text' name='cedula' value='".$row['cedula']."'>
                        <input type='text' name='usuario' value='".$row['usuario']."'>
                        <input type='text' name='nombre' value='".$row['nombre']."'>
                        <input type='text' name='password' value='".$row['password']."'>
                        <input type='text' name='id_rol' value='".$row['id_rol']."'>
                        <button type='submit' class='btn btn-success actualizar' name='actualizar_usuario'>Actualizar</button>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <button type='submit' class='btn btn-danger eliminar' name='eliminar_usuario'>Eliminar</button>
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