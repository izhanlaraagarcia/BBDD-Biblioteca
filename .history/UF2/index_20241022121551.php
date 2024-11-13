<?php
session_start();

// Redirigir si ya hay un usuario autenticado
if (isset($_SESSION['usuario'])) {
    header("Location: vista/user.php");
    exit();
}

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if (($usuario == 'admin' && $contrasena == 'abcdef') || ($usuario == 'user' && $contrasena == '123456')) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        header("Location: vista/user.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <?php include 'vista/header.php'; ?>

    <h2>Iniciar Sesión</h2>
    <form action="index.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required
