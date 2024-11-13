// confirmarUsuario.php
session_start();
include '../controlador/conexion.php';  // Asegúrate de que la conexión esté bien incluida
include "../data/bibliotecaBD.php";

// Verificar si el formulario fue enviado y se ha hecho clic en el botón "confirmar"
if (isset($_POST['confirmar'])) {
    // Guardar los datos en la sesión
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['edad'] = $_POST['edad'];
    $_SESSION['nick'] = $_POST['nick'];
    $_SESSION['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT); // Encriptar la contraseña antes de guardarla en la sesión
}

// Verificar si los datos existen en la sesión antes de mostrarlos
if (!isset($_SESSION['nombre']) || !isset($_SESSION['edad']) || !isset($_SESSION['nick'])) {
    echo "Los datos de sesión no están completos.";
    exit();
}

// Variable para mostrar la etiqueta correspondiente de edad
$etiquetaEdad = "";
$imagenJoven = "";

if ($_SESSION['edad'] >= 15 && $_SESSION['edad'] <= 20) {
    $etiquetaEdad = " (joven)";
    $imagenJoven = '<img src="../img/line-icon-for-youth-vector.jpg" alt="icono joven" width="20">';
} elseif ($_SESSION['edad'] > 60) {
    $etiquetaEdad = " (senior)";
}

if (isset($_POST['confirmado'])) {
    try {
        // Preparar los datos
        $nombre = $_SESSION['nombre'];
        $edad = $_SESSION['edad'];
        $nick = $_SESSION['nick'];
        $pwd = $_SESSION['pwd'];

        // Verificar si el nick ya existe en la base de datos
        $consultaExistencia = "SELECT COUNT(*) AS total FROM usuarios WHERE nick_usuario = '$nick'";
        
        if ($conexion instanceof mysqli) {
            $resultado = $conexion->query($consultaExistencia);
            $fila = $resultado->fetch_assoc();

            if ($fila['total'] > 0) {
                echo "Error: El nombre de usuario ya existe.";
            } else {
                // Insertar el nuevo usuario
                $consulta = "INSERT INTO usuarios (nombre, edad, nick_usuario, contrasena) 
                             VALUES ('$nombre', $edad, '$nick', '$pwd')";
                if ($conexion->query($consulta) === TRUE) {
                    echo "Usuario registrado correctamente.";
                    // Mostrar la confirmación final
                    echo '
                    <div class="contenedor">
                        <h2>El usuario ' . htmlspecialchars($_SESSION['nick']) . ' ha sido creado satisfactoriamente</h2>
                        <p>Nombre: ' . htmlspecialchars($_SESSION['nombre']) . '</p>
                        <p>Edad: ' . htmlspecialchars($_SESSION['edad']) . ' ' . $etiquetaEdad . ' ' . $imagenJoven . '</p>
                        <div class="boton">
                            <a href="../index.php">Volver a la página de inicio</a>
                        </div>
                    </div>';
                } else {
                    echo "Error al insertar usuario: " . $conexion->error;
                }
            }
        } else {
            echo "Error: Conexión no válida";
        }
    } catch (PDOException $e) {
        echo "Error al insertar usuario: " . $e->getMessage();
    }
    exit();
}
