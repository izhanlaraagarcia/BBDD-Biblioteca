<?php
session_start();

// Incluir la conexión a la base de datos
include '../controlador/conexion.php';

// Verificar si el formulario fue enviado
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    // Obtener los valores enviados del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar si la conexión a la base de datos está establecida
    if ($conn) {
        // Preparar la consulta SQL para buscar el usuario
        $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE nick_usuario = ?");
        
        if ($stmt) {
            $stmt->bind_param("s", $usuario); // Vincular el parámetro
            $stmt->execute();  // Ejecutar la consulta
            $stmt->bind_result($hashed_password); // Obtener la contraseña hasheada
            $stmt->fetch();  // Recuperar el resultado

            // Verificar si se encontró un usuario y si la contraseña es correcta
            if ($hashed_password && password_verify($contrasena, $hashed_password)) {
                // La contraseña es correcta, iniciar sesión
                $_SESSION['usuario'] = $usuario;
                $_SESSION['ultimo_acceso'] = time();
                
                // Redirigir según el tipo de usuario
                if ($usuario === 'admin') {
                    header("Location: ../vista/admin.php");
                } else {
                    header("Location: ../vista/user.php");
                }
                exit(); // Detener la ejecución después de la redirección
            } else {
                // Usuario o contraseña incorrectos
                $_SESSION['error'] = "Usuario o contraseña incorrectos.";
                header("Location: ../index.php");
                exit();
            }
            $stmt->close(); // Cerrar el statement
        } else {
            // Error en la preparación de la consulta
            $_SESSION['error'] = "Error en la consulta SQL: " . $conn->error;
            header("Location: ../index.php");
            exit();
        }
    } else {
        // Error en la conexión a la base de datos
        $_SESSION['error'] = "Error en la conexión a la base de datos.";
        header("Location: ../index.php");
        exit();
    }
} else {
    // Si no se recibieron los datos del formulario
    $_SESSION['error'] = "Por favor ingrese usuario y contraseña.";
    header("Location: ../index.php");
    exit();
}
?>
