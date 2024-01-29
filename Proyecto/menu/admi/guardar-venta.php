<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venta = json_decode(file_get_contents('php://input'), true);

    $total = 0;

    foreach ($venta['productos'] as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }

    $sql = "INSERT INTO ventas (total) VALUES (?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('d', $total);

    if ($stmt->execute()) {
        $id_venta = $stmt->insert_id;

        foreach ($venta['productos'] as $producto) {
            $sql = "INSERT INTO detalles_ventas (id_venta, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param('iiidd', $id_venta, $producto['id'], $producto['cantidad'], $producto['precio']);
            $stmt->execute();
        }

        echo json_encode(['estado' => 'success', 'id_venta' => $id_venta]);
    } else {
        echo json_encode(['estado' => 'error', 'mensaje' => 'Error al guardar la venta']);
    }

    $stmt->close();
    $conexion->close();
}