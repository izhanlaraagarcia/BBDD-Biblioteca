<?php
session_start();

// Verificar que el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar que el formulario se haya enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];

    // Verificar si el usuario existe en la tabla usuarios
    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE nick_usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($usuarioExists);
    $stmt->fetch();
    $stmt->close();

    if ($usuarioExists == 0) {
        die("Error: El usuario no existe en la base de datos.");
    }

    // Insertar el pedido en la base de datos
    $stmt = $conn->prepare("INSERT INTO pedidos (titulo, isbn, fecha, usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $isbn, $fecha, $usuario);

    if ($stmt->execute()) {
        echo "Pedido realizado con éxito.";
    } else {
        echo "Error al realizar el pedido: " . $stmt->error;
    }

    // Redireccionar al catálogo o a una página de confirmación
    header("Location: ../vista/user.php");
    exit();
} else {
    echo "Método de solicitud no válido.";
}
?>
