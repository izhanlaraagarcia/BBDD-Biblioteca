<?php
session_start();

// Verificar si se enviaron los datos del formulario de inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Definir usuarios válidos
    $usuarios_validos = [
        'admin' => 'abcdef',
        'user' => '123456'
    ];

    // Verificar si las credenciales son correctas
    if (isset($usuarios_validos[$usuario]) && $usuarios_validos[$usuario] == $contrasena) {
        // Las credenciales son correctas, iniciar sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();  // Guardar el tiempo de acceso

        // Redirigir al index.php
        header("Location: ../index.php");
        exit();
    } else {
        // Credenciales incorrectas
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../index.php");  // Volver al formulario de login
        exit();
    }
} else {
    // Si no se han enviado los datos correctamente, redirigir al formulario
    header("Location: ../index.php");
    exit();
}
?>
