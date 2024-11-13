<?php
session_start();

// Comprobar si el usuario ya ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario'] == 'admin') {
        header("Location: vista/admin.php");
    } elseif ($_SESSION['usuario'] == 'user') {
        header("Location: vista/user.php");
    }
    exit();
}
?>


<?php
// Tiempo máximo de inactividad (30 minutos)
$tiempo_inactividad_maximo = 1800; // 30 minutos en segundos

// Verificar si la sesión tiene un registro del último acceso
if (isset($_SESSION['ultimo_acceso'])) {
    // Calcular el tiempo que ha estado inactivo el usuario
    $tiempo_inactivo = time() - $_SESSION['ultimo_acceso'];

    // Si el tiempo de inactividad supera el máximo permitido, destruir la sesión
    if ($tiempo_inactivo > $tiempo_inactividad_maximo) {
        session_unset();   // Limpiar las variables de sesión
        session_destroy(); // Destruir la sesión actual
        header("Location: controlador/login.php?mensaje=sesion_caducada"); // Redirigir al login
        exit();
    }
}

// Actualizar el tiempo de la última actividad del usuario
$_SESSION['ultimo_acceso'] = time();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Biblioteca</title>
</head>
<body>
    <?php include 'vista/header.php'; ?>
    

    <h2>Iniciar Sesión</h2>

    <?php
    // Mostrar mensaje de error si existe
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo
    }
    ?>

    <form action="controlador/login.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
