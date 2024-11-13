<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "1234", "biblioteca");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificamos si los datos se enviaron mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $edad = isset($_POST['edad']) && $_POST['edad'] !== '' ? (int)$_POST['edad'] : null;
    $nick = isset($_POST['nick']) ? $_POST['nick'] : null;
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;

    // Preparar una consulta para verificar si el nick_usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nick_usuario = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo "El nick de usuario ya está en uso. Por favor elige otro.";
    } else {
        // Preparamos la consulta de inserción para evitar errores
        $stmt_insert = $conn->prepare("INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("siss", $nombre, $edad, $nick, $contrasena);

        // Ejecutamos la consulta de inserción
        if ($stmt_insert->execute()) {
            echo "Usuario creado con éxito";
        } else {
            echo "Error al crear el usuario: " . $stmt_insert->error;
        }

        // Cerramos la consulta preparada de inserción
        $stmt_insert->close();
    }

    // Cerramos la consulta preparada de verificación
    $stmt->close();
}

// Cerramos la conexión
$conn->close();
?>
