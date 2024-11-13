<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Pedido</title>
</head>
<body>
    <h2>Formulario de Pedido</h2>
    <form action="procesarPedido.php" method="POST">
        <label for="titulo">Título del libro:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" readonly><br>

        <label for="isbn">ISBN del libro:</label>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" readonly><br>

        <label for="fecha">Fecha de compra:</label>
        <input type="text" id="fecha" name="fecha" value="<?php echo $fechaCompra; ?>" readonly><br>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>" readonly><br>

        <input type="submit" value="Confirmar Pedido">
    </form>
</body>
</html>
