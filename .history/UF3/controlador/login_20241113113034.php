<?php
session_start();
include '../controlador/conexion.php'; // Asegúrate de que esta ruta es correcta y de que la conexión funciona

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Usuarios predefinidos
    $usuarios_validos = [
        'admin' => 'abcdef',
        'user' => '123456'
    ];

    // Verificar usuarios predefinidos
    if (isset($usuarios_validos[$usuario]) && $usuarios_validos[$usuario] === $contrasena) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['ultimo_acceso'] = time();
        header("Location: ../vista/" . ($usuario === 'admin' ? "admin.php" : "user.php"));
        exit();
    }

    // Verificar usuarios en la base de datos
    if ($conn) {
        $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE nick_usuario = ?");
        if ($stmt) {
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            $stmt->close();

            // Verificar si la contraseña coincide
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
            // Error en la preparación del statement
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
}
?>
