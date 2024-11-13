<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - LibroSphere</title>
    <link rel="stylesheet" href="./styles/alta.css"> <!-- Referencia a tu archivo de estilos -->
</head>

<body>

    <div class="container">
        <!-- Cabecera -->
        <?php include '../include/cabecera.html'; ?>

        <!-- Formulario de registro -->
        <main>
            <h2>Alta Usuario</h2>
            <form action="conexion.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre">

                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad">

                <label for="nick">Nick:</label>
                <input type="text" id="nick" name="nick">

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena">

                <input type="submit" value="Enviar">
            </form>

        </main>
    </div>

</body>

</html>