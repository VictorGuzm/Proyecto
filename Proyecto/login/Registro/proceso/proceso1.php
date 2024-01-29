<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keys = ['usuario', 'nombre', 'password', 'cedula'];
    foreach ($keys as $key) {
        if (!isset($_POST[$key])) {
            $_SESSION['error'] = "Por favor, complete todos los campos del formulario";
            header("Location: ../User.php");
            exit;
        }
    }
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $cedula = $_POST['cedula'];
    $id_rol = 1;
    $regex_pass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
    if (!preg_match($regex_pass, $password)) {
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres, al menos una letra mayúscula, una letra minúscula y un número";
        header("Location: ../User.php");
        exit;
    }
    if (strlen($cedula) != 8 || !is_numeric($cedula)) {
        $_SESSION['error'] = "La cédula debe tener exactamente 8 números";
        header("Location: ../User.php");
        exit;
    }
    include("../../../BD/conect.php");
    $conexion1 = conectar_bd();
    mysqli_set_charset($conexion1, "utf8");
    $query = "SELECT * FROM usuario WHERE cedula = '$cedula'";
    $result = mysqli_query($conexion1, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "La cédula ya existe";
        header("Location: User.php");
    } else {
        $consulta = "INSERT INTO usuario (cedula, usuario, nombre, password, id_rol) VALUES ('$cedula','$usuario', '$nombre', '$password', '$id_rol')";
        $resultado = mysqli_query($conexion1, $consulta);
        if ($resultado) {
            $_SESSION['success'] = "Se registró correctamente";
            header("Location: ../User.php");
        } else {
            $_SESSION['error'] = "Error al registrar el usuario: " . mysqli_error($conexion1);
            header("Location: ../User.php");
        }
    }
    $conexion1->close();
    exit;
} else {
    header("Location: ../User.php");
    exit;
}
?>