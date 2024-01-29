<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Web</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="form-register">
        <h4>Formulario de Registro</h4>
        
        <?php if(isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if(isset($_SESSION['success'])): ?>
            <div><p class="success"><?php echo $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="proceso/proceso1.php" method="post">
            <input class="controls" type="text" name="usuario" id="usuario" placeholder="Ingrese su Usuario"required maxlength="10">
            <input class="controls" type="text" name="nombre" id="nombre" placeholder="Ingrese su Nombre"required maxlength="10">
            <input class="controls" type="number" name="cedula" id="cedula" placeholder="Ingrese su Cedula"required maxlength="8">
            <input class="controls" type="password" name="password" id="password" placeholder="Ingrese su Contraseña"required maxlength="10"><br>
            <input class="botons" type="submit" value="Registrar">
        </form>
        <p><a href="../index.php">¿Ya tienes una Cuenta?</a></p>
    </section>
</body>
</html>