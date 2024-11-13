<?php
include("sesiones/validarSesion.php");
include("cabecera.php");

if ($_SESSION['is_admin']) {
    header("Location: panel_admin.php");
} else {
    header("Location: listado_libros.php");
}
?>
