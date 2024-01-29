<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['password'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        require("../../BD/conect.php");
        $conexion = conectar_bd();

        // Verificar la conexión
        if ($conexion->connect_error) {
            $_SESSION['error'] = "Error de conexión: " . $conexion->connect_error;
            header("Location: ../../login/index.php");
            exit;
        }

        $consulta = "SELECT id_rol FROM usuario WHERE usuario = ? AND password = ?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("ss", $usuario, $password);
        $stmt->execute();
        $stmt->bind_result($id_rol);

        if ($stmt->fetch()) {
            $_SESSION["id_rol"] = $id_rol;
            $_SESSION["usuario"] = $usuario; // Guardar el nombre de usuario en la sesión si es necesario

            // Verificar si la sesión está activa y contiene las variables de rol y usuario
            if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["id_rol"]) && isset($_SESSION["usuario"])) {
                // La sesión está activa y contiene las variables de rol y usuario
                $id_rol = $_SESSION["id_rol"];
                $usuario = $_SESSION["usuario"];

                // Resto del código de tu verificación de roles y acciones

                // Redirigir a la página correspondiente según el rol
                if ($id_rol == 1) {
                    header("Location: ../../menu/user/menu_user.html");
                    exit;
                } elseif ($id_rol == 2) {
                    header("Location: ../../menu/admi/menu_admin.php");
                    exit;
                }
            } else {
                // La sesión no está activa o no contiene las variables de rol y usuario
                $_SESSION['error'] = "Error en la sesión";
                header("Location: ../../login/index.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Credenciales inválidas";
            header("Location:../../login/index.php");
            exit;
        }

        $stmt->close();
        mysqli_close($conexion);
    } else {
        $_SESSION['error'] = "Campos de usuario y contraseña requeridos";
        header("Location:../../login/index.php");
        exit;
    }
} else {
    // Página de inicio de sesión si el método de solicitud no es POST
    header("Location: ../../login/index.php");
    exit;
}
?>
