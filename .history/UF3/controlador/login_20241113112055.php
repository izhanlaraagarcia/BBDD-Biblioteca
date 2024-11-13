<?php
session_start();
include '../controlador/conexion.php';

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si se enviaron los datos del formulario de inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // 1. Usuarios predefinidos
    $usuarios_validos = [
        'admin' => 'abcdef',
        'user' => '123456'
    ];

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

    // 2. Buscar en la base de datos
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE nick_usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if ($hashed_password && password_verify($contrasena, $hashed_password)) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        header("Location: ../vista/user.php");
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
