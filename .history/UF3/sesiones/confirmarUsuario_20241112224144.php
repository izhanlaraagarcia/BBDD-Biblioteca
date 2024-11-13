<?php
session_start();
include '../controlador/conexion.php';

if (isset($_POST['confirmar'])) {
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['edad'] = $_POST['edad'];
    $_SESSION['nick'] = $_POST['nick'];
    $_SESSION['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
}

if (!isset($_SESSION['nombre']) || !isset($_SESSION['edad']) || !isset($_SESSION['nick'])) {
    echo "Los datos de sesión no están completos.";
    exit();
}

if (isset($_POST['confirmado'])) {
    $nick = $_SESSION['nick'];
    
    // Asegúrate de que $conn es una conexión válida y no está cerrada
    if ($conn && $conn instanceof mysqli) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE nick_usuario = ?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        if ($fila['total'] > 0) {
            echo "Error: El nombre de usuario ya existe.";
        } else {
            // Inserta el nuevo usuario
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siss", $_SESSION['nombre'], $_SESSION['edad'], $nick, $_SESSION['pwd']);
            
            if ($stmt->execute()) {
                echo "Usuario registrado correctamente.";
            } else {
                echo "Error al insertar usuario: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        echo "Error: Conexión no válida";
    }
}

$conn->close();
?>