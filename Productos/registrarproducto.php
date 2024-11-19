<?php
    require('../conexion.php');
    // Obtener los tipos de producto para el formulario de selección
    $consulta_tipos = "SELECT ID, Tipo FROM tipos";
    $resultado_tipos = $conn->query($consulta_tipos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto con Imagen</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <h1>Registrar Producto con Imagen</h1>
    <div class="form-container">
        <?php if (isset($mensaje)) echo "<p class='message'>$mensaje</p>"; ?>

        <form action="nuevoProducto.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="precio">Precio del Producto:</label>
            <input type="number" name="precio" id="precio" step="0.01" required>

            <label for="tipo_id">Tipo de Producto:</label>
            <select name="tipo_id" id="tipo_id" required>
                <?php
                // Llenar el menú desplegable con los tipos de productos
                while ($tipo = $resultado_tipos->fetch_assoc()) {
                    echo "<option value='{$tipo['ID']}'>{$tipo['Tipo']}</option>";
                }
                ?>
            </select>

            <label for="imagen">Seleccionar Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*" required>

            <button type="submit">Registrar Producto e Imagen</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
