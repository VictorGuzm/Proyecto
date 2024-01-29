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
        <h4>Clave de Seguridad</h4>
        <?php if(isset($_SESSION['clave_error'])): ?>
            <p class="error"><?php echo $_SESSION['clave_error']; ?></p>
            <?php unset($_SESSION['clave_error']); ?>
        <?php endif; ?>
        <form action="proceso/clave_process.php" method="post">
            <input class="controls" type="password" name="clave" id="clave" placeholder="Ingrese la Clave de Administrador"> 
            <input class="botons" type="submit" value="Verificar">
        </form>
        <p><a href="../index.php">¿Ya tienes una Cuenta?</a></p>
    </section>
</body>
</html>