<?php
// Importar la biblioteca PDO
require_once "database.php";

// Obtener la conexión a la base de datos
$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

// Obtener los datos de la venta
$cedula = $_POST["cedula"];
$cantidad = $_POST["cantidad"];
$productoId = $_POST["producto"];

// Consultar la base de datos para obtener los datos del cliente
$sql = "SELECT * FROM clientes_new WHERE cedula = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$cedula]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente) {
    // Insertar los datos de la venta en la tabla "ventas"
    $sql = "INSERT INTO ventas (cliente_id, cantidad_producto, precio_producto, fecha, hr, ci_empleado, metodo_pago, nro_factura, id_producto, tipo_servicio_id, cliente_cedula) VALUES (?, ?, ?, CURDATE(), CURTIME(), ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$cliente['id'], $cantidad, $cliente['precio'], 'CI_EMPLEADO', 'METODO_PAGO', 'NRO_FACTURA', $productoId, 'TIPO_SERVICIO', $cedula]);

    // Actualizar el stock del producto en la tabla "productos"
    $sql = "UPDATE productos SET stock = stock - ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$cantidad, $productoId]);

    // Realizar cualquier otro procesamiento necesario, como generar la factura

    // Redirigir al usuario a una página de éxito o mostrar un mensaje de éxito
    echo "La venta se ha guardado correctamente.";
} else {
    // El cliente no existe en la base de datos
    echo "No se encontró un cliente con la cédula proporcionada.";
}
?>