<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$_SESSION['ultimo_acceso'] = time();
include 'header.php';
?>

<h2>Panel de Control ERP LibroSphere</h2>

<ul>
    <li><a href="#">Gestión de Clientes</a></li>
    <li><a href="#">Gestión de Libros</a></li>
    <li><a href="#">Gestión de Pedidos</a></li>
</ul>

<a href="../controlador/logout.php">Cerrar Sesión</a>
