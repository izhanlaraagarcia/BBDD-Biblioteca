<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$_SESSION['ultimo_acceso'] = time(); // Actualizar tiempo de último acceso

include 'header.php'; // Incluir la cabecera de la empresa

// Mostrar información del usuario y la hora de acceso
echo "<p>Usuario: " . $_SESSION['usuario'] . "</p>";
echo "<p>Hora de acceso: " . date("H:i:s", $_SESSION['ultimo_acceso']) . "</p>";
?>

<h2>Gestion de Clientes</h2>

<!-- Listado de todos los clientes -->


<a href="../controlador/logout.php">Cerrar Sesión</a>
