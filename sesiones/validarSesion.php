<?php
session_start();

function alerta($mensaje)
{
    echo "<script>alert('$mensaje');</script>";
}

// No hay ninguna salida antes de esta sección para que funcione el header()
if (isset($_POST['usuario']) && isset($_POST['pwd'])) {
    $usuario = $_POST['usuario'];
    $pwd = $_POST['pwd'];

    if ($usuario == "admin" && $pwd == "abcdef") {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['hora'] = date("d-m-Y H:i:s");
        header("Location: ../index.php");
        exit(); // Detener la ejecución después de la redirección
    } else {
        // Mostrar la alerta y luego redirigir con JavaScript si hacemos esto avisamos al usuario de que las credenciales son incorrectas y le volvemos a cargar 
        // form vacio para validar las credenciales de nuevo.
        echo "<script>
                alert('Usuario o contraseña incorrectos');
                window.location.href = '../include/formulario.php';
              </script>";
        exit(); // Detener la ejecución después de la redirección
    }
}

// Incluir cabecera solo si no se ha hecho la redirección
include "../include/cabecera.html";
