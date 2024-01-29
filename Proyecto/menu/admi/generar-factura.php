<?php
require_once 'conexion.php';
require_once '../dompdf/autoload.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_venta = $_POST['id_venta'];
    $sql = "SELECT * FROM ventas WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_venta);
    $stmt->execute();
    $venta = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $sql = "SELECT * FROM detalles_ventas WHERE id_venta = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_venta);
    $stmt->execute();
    $detalles_venta = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Crear objeto PDF
    $pdf = new Dompdf\Dompdf();
    $pdf->setPaper('A4', 'portrait');

    // Generar HTML del documento
    $html = '
        <h1>Factura de venta</h1>
        <table border="1" cellpadding="2">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
    ';

    foreach ($detalles_venta as $producto) {
        $html .= '
            <tr>
                <td>' . $producto['nombre'] . '</td>
                <td>' . $producto['cantidad'] . '</td>
                <td>' . $producto['precio'] . '</td>
                <td>' . ($producto['cantidad'] * $producto['precio']) . '</td>
            </tr>
        ';
    }

    $html .= '
        </table>
        <h3>Total: $' . $venta['total'] . '</h3>
    ';

    // Cargar HTML en el objeto PDF y renderizar el documento
    $pdf->loadHtml($html);
    $pdf->render();

    // Guardar el archivo PDF
    $pdf->stream('factura_' . $id_venta . '.pdf', array('Attachment' => 0));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Factura de venta</title>
</head>
<body>
    <h1>Factura de venta</h1>
    <form method="post">
        <label for="id_venta">ID de Venta:</label>
        <input type="text" name="id_venta" id="id_venta">
        <button type="submit" name="generarPDF">Generar PDF</button>
    </form>
</body>
</html>