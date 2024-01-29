<?php
// Establecer conexión con la base de datos
require("../../BD/conect.php");
$conexion = conectar_bd();

$cedula = $_GET["cedula"];

$query = "SELECT * FROM clientes WHERE cedula = '$cedula'";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
  $cliente = $result->fetch_assoc();
  echo json_encode($cliente);
} else {
  echo json_encode(null);
}

$conexion->close();
?>