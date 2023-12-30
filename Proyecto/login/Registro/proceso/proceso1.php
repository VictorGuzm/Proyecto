<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado los datos del formulario a través del método POST
    if (isset($_POST['usuario']) && isset($_POST['nombre']) && isset($_POST['password']) && isset($_POST['cedula'])) {
        // Verificar si todos los campos del formulario están presentes en el arreglo $_POST
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $password = $_POST['password'];
        $cedula = $_POST['cedula'];
        $id_rol = 1; // Cambia esto según la lógica de tu aplicación
        $regex_pass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
        if (preg_match($regex_pass, $password)) {
            // Verificar si la contraseña cumple con los requisitos utilizando una expresión regular
            if (strlen($cedula) == 8 && is_numeric($cedula)) {
                // Validar que la cédula tenga exactamente 8 números
                include("../../../BD/conect.php");
                $conexion1 = conectar_bd();
                // Establecer la codificación de caracteres a utf8
                mysqli_set_charset($conexion1, "utf8");
                $query = "SELECT * FROM usuario WHERE cedula = '$cedula'";
                $result = mysqli_query($conexion1, $query);
                if (mysqli_num_rows($result) > 0) {
                    // La cédula ya existe
                    $_SESSION['error'] = "La cédula ya existe";
                    header("Location: User.php");
                } else {
                    $consulta = "INSERT INTO usuario (cedula, usuario, nombre, password, id_rol) VALUES ('$cedula','$usuario', '$nombre', '$password', '$id_rol')";
                    $resultado = mysqli_query($conexion1, $consulta);
                    if ($resultado) {
                        // La consulta se realizó correctamente
                        $_SESSION['success'] = "Se registró correctamente";
                        header("Location: ../User.php");
                    } else {
                        // La consulta no se realizó correctamente
                        $_SESSION['error'] = "Error al registrar el usuario: " . mysqli_error($conexion1);
                        header("Location: ../User.php");
                    }
                }
                $conexion1->close();
                exit;
            } else {
                $_SESSION['error'] = "La cédula debe tener exactamente 8 números";
                header("Location: ../User.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres, al menos una letra mayúscula, una letra minúscula y un número";
            header("Location: ../User.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Por favor, complete todos los campos del formulario";
        header("Location: ../User.php");
        exit;
    }
} else {
    header("Location: ../User.php");
    exit;
}
?>