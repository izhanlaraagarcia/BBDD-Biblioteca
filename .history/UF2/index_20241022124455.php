<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca</title>
</head>
<body>
    <h1>Bienvenido a la Biblioteca</h1>

    <?php
    // Mostrar mensaje de error si existe
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);  // Eliminar el mensaje de error después de mostrarlo
    }
    ?>

<form action="controlador/login.php" method="post">
    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" id="usuario" required>

    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" id="contrasena" required>

    <button type="submit">Iniciar sesión</button>
</form>

</body>
</html>
