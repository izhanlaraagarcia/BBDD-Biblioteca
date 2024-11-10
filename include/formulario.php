<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibroSphere - Iniciar Sesión</title>
    <link rel="stylesheet" href="../styles/main.css"> <!-- Asegúrate de incluir tu archivo CSS -->
</head>

<body>
    <div class="container">
        <!-- Cabecera -->
        <?php include './cabecera.html'; ?>
        <main>
            <section class="login-section">
                <h2>ACCESO</h2>
                <form action="../sesiones/validarSesion.php" method="post">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>

                    <label for="pwd">Contraseña:</label>
                    <input type="password" id="pwd" name="pwd" required>

                    <button type="submit">Enviar</button>
                </form>

                <a href="../sesiones/altaUsuario.php" class="new-user-link">Nuevo usuario</a>
            </section>
        </main>
    </div>
</body>

</html>