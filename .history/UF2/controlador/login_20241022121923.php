<?php
session_start();

// Comprobar si el formulario de login fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Validar las credenciales
    if ($usuario == 'admin' && $contrasena == 'abcdef') {
        $_SESSION['usuario'] = 'admin';
        $_SESSION['ultimo_acceso'] = time();
        header("Location: ../vista/admin.php");
        exit();
    } elseif ($usuario == 'user' && $contrasena == '123456') {
        $_SESSION['usuario'] = 'user';
        $_SESSION['ultimo_acceso'] = time();
        header("Location: ../vista/user.php");
        exit();
    } else {
        // Redirigir con mensaje de error si las credenciales no son correctas
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../index.php");
        exit();
    }
}
?>
