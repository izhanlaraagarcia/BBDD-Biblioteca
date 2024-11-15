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
            <form action="./confirmarUsuario.php" method="post" class="formulario">
                <div class="formulario-conjunto">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="formulario-conjunto">
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" required>
                </div>

                <div class="formulario-conjunto">
                    <label for="nick">Nombre de usuario:</label>
                    <input type="text" id="nick" name="nick" required>
                </div>

                <div class="formulario-conjunto">
                    <label for="pwd">Contraseña:</label>
                    <input type="password" id="pwd" name="pwd" required>
                </div>

                <div class="botones">
                    <button type="submit" name="confirmar" class="btn-aceptar">Aceptar</button>
                    <button type="reset" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </main>
    </div>

</body>

</html>
