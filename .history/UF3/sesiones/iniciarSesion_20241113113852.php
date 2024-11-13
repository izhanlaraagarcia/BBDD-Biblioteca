<?php
session_start();
include("../includes/db.php");

$nick_usuario = $_POST['nick_usuario'];
$contrasena = $_POST['contrasena'];

$query = "SELECT * FROM usuarios WHERE nick_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nick_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    if (password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['user'] = $usuario['nick_usuario'];
        $_SESSION['is_admin'] = $usuario['nick_usuario'] === 'admin';
        $_SESSION['timeout'] = time();
        header("Location: ../index.php");
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
?>
