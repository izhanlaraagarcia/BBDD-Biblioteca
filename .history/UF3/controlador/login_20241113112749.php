<?php
session_start();
include '../controlador/conexion.php';

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Usuarios predefinidos para control de acceso directo
    $usuarios_validos = [
        'admin' => 'abcdef',
        'user' => '123456'
    ];

    // Verificación de usuarios predefinidos
    if (isset($usuarios_validos[$usuario]) && $usuarios_validos[$usuario] === $contrasena) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();

        if ($usuario === 'admin') {
            header("Location: ../vista/admin.php");
        } else {
            header("Location: ../vista/user.php");
        }
        exit();
    }

    // Verificación de usuarios almacenados en la base de datos
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE nick_usuario = ?");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verificación de contraseña hasheada en la base de datos
    if ($hashed_password && password_verify($contrasena, $hashed_password)) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        header("Location: ../vista/user.php");
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../index.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<p style='color:green'>{$_SESSION['mensaje']}</p>";
        unset($_SESSION['mensaje']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
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
        <a href="./sesiones/altaUsuario.php">Registrar</a>
    </form>
</body>
</html>
