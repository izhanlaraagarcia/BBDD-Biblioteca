if (isset($_POST['confirmado'])) {
    try {
        // Preparar la consulta SQL
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, edad, nick, password) VALUES (:nombre, :edad, :nick, :password)");

        // Ejecutar la consulta con los datos de la sesión
        $stmt->execute([
            ':nombre' => $_SESSION['nombre'],
            ':edad' => $_SESSION['edad'],
            ':nick' => $_SESSION['nick'],
            ':password' => $_SESSION['pwd'] // La contraseña ya está hasheada
        ]);

        // Confirmación de creación en la base de datos
        echo '<p>El usuario se ha registrado en la base de datos exitosamente.</p>';

    } catch (PDOException $e) {
        echo "Error al insertar usuario: " . $e->getMessage();
    }

    // Código HTML para mostrar la confirmación final
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LibroSphere - Confirmación de Usuario</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                background-color: #f4f4f4;
                color: #333;
            }
            .logo {
                font-size: 24px;
                margin-top: 50px;
                font-weight: bold;
            }
            .logo span {
                color: #000;
                background-color: #ccc;
                padding: 2px 5px;
                border-radius: 50%;
            }
            h2 {
                color: #555;
            }
            .contenedor {
                margin: 20px auto;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                width: 50%;
                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            }
            a {
                text-decoration: none;
                color: #333;
                font-weight: bold;
            }
            a:hover {
                text-decoration: underline;
            }
            .boton {
                margin-top: 20px;
            }
            .edad-icono {
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div class="logo">
            LibroSphere <span>Tu biblioteca en línea</span>
        </div>
        <div class="contenedor">
            <h2>El usuario ' . htmlspecialchars($_SESSION['nick']) . ' ha sido creado satisfactoriamente</h2>
            <p>Nombre: ' . htmlspecialchars($_SESSION['nombre']) . '</p>
            <p>Edad: ' . htmlspecialchars($_SESSION['edad']) . ' ' . $etiquetaEdad . ' ' . $imagenJoven . '</p>
            <div class="boton">
                <a href="../index.php">Volver a la página de inicio</a>
            </div>
        </div>
    </body>
    </html>';
    exit();
}
