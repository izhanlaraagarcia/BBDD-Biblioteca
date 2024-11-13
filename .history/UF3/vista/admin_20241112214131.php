<?php
include("sesiones/validarSesion.php");
include("cabecera.php");

if (!$_SESSION['is_admin']) {
    header("Location: listado_libros.php");
    exit();
}
?>

<h2>Panel de Control</h2>
<ul>
    <li><a href="gestion_clientes.php">Gestión de Clientes</a></li>
    <li><a href="gestion_pedidos.php">Gestión de Pedidos</a></li>
    <li>Gestión de Libros (No funcional)</li>
</ul>
