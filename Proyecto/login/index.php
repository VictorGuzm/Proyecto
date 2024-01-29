<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Web</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-box">
        <img class="avatar" src="../public/img/logo.png" alt="logo DadoBrosther">
        <h1>Login</h1>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form action="proceso/proceso.php" method="post">
            <!--User name-->
            <label for="nombre de usuario">Usuario</label>
            <input type="text" name="usuario" placeholder="Introduzca el Usuario">
            <!--Password-->
            <label for="Contrasela">Contraseña</label>
            <input type="password" name="password" placeholder="Introduzca la Contraseña">
            <input type="submit" value="Iniciar sesión">
        </form>
        <a href="Registro/User.php">Registrar Usuario</a><br>
        <a href="Registro/clave.php">Registrar Administrador</a><br>
    </div>
</body>
</html>