<?php
session_start();
include '../controlador/conexion.php'; // Asegúrate de que la conexión esté establecida aquí

// Comprobar si se enviaron los datos del formulario de inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Preparar consulta para verificar si el usuario existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nick_usuario = ? AND contrasena = ?");
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Las credenciales son correctas, iniciar sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();  // Guardar el tiempo de acceso

        // Redirigir según el usuario
        if ($usuario === 'admin') {
            header("Location: ../vista/admin.php");
        } else {
            header("Location: ../vista/user.php");
        }
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
