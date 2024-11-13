<?php
session_start();
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Usuarios predefinidos
$usuarios_validos = [
    'admin' => 'abcdef',
    'user' => '123456'
];

// Verificar si se enviaron los datos del formulario de inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar primero si es un usuario predefinido
    if (isset($usuarios_validos[$usuario]) && $usuarios_validos[$usuario] === $contrasena) {
        // Credenciales válidas para usuario predefinido
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        header("Location: ../index.php");
        exit();
    } else {
        // Si no es predefinido, buscar en la base de datos
        $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE nick_usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Verificar si el usuario existe en la base de datos y si la contraseña es correcta
        if ($hashed_password && password_verify($contrasena, $hashed_password)) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['ultimo_acceso'] = time();
            header("Location: ../index.php");
            exit();
        } else {
            // Credenciales incorrectas
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            header("Location: ../index.php");
            exit();
        }
    }
} else {
    // Si no se han enviado los datos correctamente, redirigir al formulario
    header("Location: ../index.php");
    exit();
}
?>
