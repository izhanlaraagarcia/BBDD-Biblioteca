<?php
session_start();
include '../controlador/conexion.php';

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $usuarios_validos = [
        'admin' => 'abcdef',
        'user' => '123456'
    ];

    if (isset($usuarios_validos[$usuario]) && $usuarios_validos[$usuario] === $contrasena) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();

        echo "Inicio de sesión exitoso para usuario predefinido.";
        exit();
    }

    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE nick_usuario = ?");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!$hashed_password) {
        die("Usuario no encontrado en la base de datos.");
    }

    if (password_verify($contrasena, $hashed_password)) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        echo "Inicio de sesión exitoso para usuario en base de datos.";
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        echo "Usuario o contraseña incorrectos.";
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
