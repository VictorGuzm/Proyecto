<?php
// Establecer conexión con la base de datos
require("../../BD/conect.php");
$conexion = conectar_bd();

// Agregar cliente
if (isset($_POST['agregar_cliente'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $id_tipo_cliente = $_POST['id_tipo_cliente'];
    $query = "INSERT INTO clientes_new (cedula, nombre, apellido, telefono, id_tipo_cliente) VALUES ('$cedula', '$nombre', '$apellido', '$telefono', '$id_tipo_cliente')";
    $result = $conexion->query($query);
}

// Actualizar cliente
if (isset($_POST['actualizar_cliente'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $id_tipo_cliente = $_POST['id_tipo_cliente'];
    $query = "UPDATE clientes_new SET nombre='$nombre', apellido='$apellido', telefono='$telefono', id_tipo_cliente='$id_tipo_cliente' WHERE cedula='$cedula'";
    $result = $conexion->query($query);
}

// Eliminar cliente
if (isset($_POST['eliminar_cliente'])) {
    $cedula = $_POST['cedula'];
    $query = "DELETE FROM clientes_new WHERE cedula='$cedula'";
    $result = $conexion->query($query);
}

$query = "SELECT * FROM clientes_new";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="style/style_productos.css">
</head>
<body>
    <h1>Clientes</h1>
    <form method="post" class="container">
        <input type="text" name="buscar" placeholder="Buscar por cédula">
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
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>ID Tipo Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['cedula'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['apellido'] . "</td>";
                echo "<td>" . $row['telefono'] . "</td>";
                echo "<td>" . $row['id_tipo_cliente'] . "</td>";
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='cedula' value='" . $row['cedula'] . "'>
                            <input type='text' name='nombre' value='" . $row['nombre'] . "'>
                            <input type='text' name='apellido' value='" . $row['apellido'] . "'>
                            <input type='text' name='telefono' value='" . $row['telefono'] . "'>
                            <input type='text' name='id_tipo_cliente' value='" . $row['id_tipo_cliente'] . "'>
                            <button type='submit' class='btn btn-success' name='actualizar_cliente'>Actualizar</button>
                        </form>
                        <form method='post'>
                            <input type='hidden' name='cedula' value='" . $row['cedula'] . "'>
                            <button type='submit' class='btn btn-danger' name='eliminar_cliente'>Eliminar</button>
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