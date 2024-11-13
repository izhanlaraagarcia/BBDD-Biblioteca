<?php
session_start();
include '../controlador/conexion.php';  // Asegúrate de incluir la conexión a la base de datos

// Verificar si se enviaron los datos del formulario de inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // 1. Verificar si el usuario es 'admin' o 'user' (usuarios predefinidos)
    $usuarios_validos = [
        'admin' => 'abcdef',
        'user' => '123456'
    ];

    if (isset($usuarios_validos[$usuario]) && $usuarios_validos[$usuario] === $contrasena) {
        // Guardar el usuario en sesión y redirigir
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        
        if ($usuario === 'admin') {
            header("Location: ../vista/admin.php");
        } else {
            header("Location: ../vista/user.php");
        }
        exit();
    }

    // 2. Si no es usuario predefinido, buscar en la base de datos
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE nick_usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // 3. Validar la contraseña hasheada
    if ($hashed_password && password_verify($contrasena, $hashed_password)) {
        // Credenciales válidas: guardar en sesión y redirigir
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        header("Location: ../vista/user.php");
        exit();
    } else {
        // Credenciales incorrectas
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../index.php");  // Volver al formulario de login
        exit();
    }
} else {
    // Redirigir si no se enviaron datos del formulario
    header("Location: ../index.php");
    exit();
}
