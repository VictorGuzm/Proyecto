<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        require("../../BD/conect.php");
        $conexion=conectar_bd();
        echo "conexion exitosa";
        $consulta = "SELECT * FROM usuario WHERE usuario = ? AND contraseña = ?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("ss", $usuario, $contraseña);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $id_rol = $fila['id_rol'];
            if ($id_rol == 1) {
                header("Location: ../../menu/admin/menu_user.html ");
                exit;
            } elseif ($id_rol == 2) {
                header("Location: ../../menu/admin/menu_admin.html ");
                exit;
            }
        } else {
            $_SESSION['error'] = "Credenciales inválidas";
            echo "Error al preparar la consulta: " . $conexion->error;
            exit;
        }
    } else {
        $_SESSION['error'] = "Por favor, complete todos los campos";
        header("Location: ../index.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Error en la consulta de base de datos: " . mysqli_error($conexion);
    exit;
}

$stmt->close();
mysqli_close($conexion);
?>