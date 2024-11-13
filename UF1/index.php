<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: include/formulario.php");
    exit();
}

// Variables de sesión
$usuario = $_SESSION['usuario'];
$hora = $_SESSION['hora'];


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - LibroSphere</title>
    <link rel="stylesheet" href="main.css"> <!-- Agregar el archivo de estilos CSS -->
</head>

<body>

    <div class="container">
        <!-- Cabecera -->
        <?php include './include/cabecera.html'; ?>
        <!-- Cuerpo principal -->
        <main>
            <h2>Bienvenido <?php echo $usuario; ?></h2>
            <p>La hora de inicio de sesión es: <?php echo $hora; ?></p>
        </main>

        <!-- Pie de página -->
        <footer>
            <div class="dots">
                <!-- Aquí puedes agregar los iconos decorativos de los puntos -->
                <img src="ruta/a/icono1.png" alt="Icono 1">
                <img src="ruta/a/icono2.png" alt="Icono 2">
            </div>
            <a href="sesiones/cerrarSesion.php">Cerrar Sesión</a>
        </footer>
    </div>

</body>

</html>
