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
            <form action="confirmarUsuario.php" method="post" class="formulario">
                <div class="formulario-conjunto">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required>
                </div>

                <div class="formulario-conjunto">
                    <label for="edad">Edad:</label>
                    <input type="number" name="edad" required>
                </div>

                <div class="formulario-conjunto">
                    <label for="nick">Nombre de usuario:</label>
                    <input type="text" name="nick" required>
                </div>

                <div class="formulario-conjunto">
                    <label for="pwd">Contraseña:</label>
                    <input type="password" name="pwd" required>
                </div>

                <div class="botones">
                    <button type="submit" name="confirmar" class="btn-aceptar">Aceptar</button>
                    <button type="reset" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </main>

        <footer>
            
            <!-- Puntos decorativos o iconos -->
            <div class="dots">
                <img src="ruta/a/icono1.png" alt="Icono 1">
                <img src="ruta/a/icono2.png" alt="Icono 2">
            </div>
        </footer>
    </div>

</body>

</html>
