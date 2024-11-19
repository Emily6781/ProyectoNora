<?php
require('../conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <input type="number" name="precio" placeholder="Precio" required>
            <select name="tipo_id" required>
                <option value="" disabled selected>Seleccione un tipo</option>
                <?php
                $tipos_resultado = $conn->query("SELECT * FROM tipos");
                while ($tipo = $tipos_resultado->fetch_assoc()) {
                    echo "<option value='{$tipo['ID']}'>{$tipo['Tipo']}</option>";
                }
                ?>
            </select>
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit" name="accion" value="guardar">Guardar Producto</button>
        </form>
    </div>

    <div class="products-container">
        <?php
        if ($resultado->num_rows > 0) {
            while ($producto = $resultado->fetch_assoc()) {
                $imagen_src = !empty($producto['imagen_datos']) 
                              ? "data:{$producto['imagen_tipo']};base64," . base64_encode($producto['imagen_datos']) 
                              : 'path/to/placeholder_image.jpg';

                echo "<div class='product-card'>";
                echo "<img src='$imagen_src' alt='{$producto['Nombre']}'>";
                echo "<h3>{$producto['Nombre']}</h3>";
                echo "<p>$ {$producto['Precio']}</p>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='producto_id' value='{$producto['ID']}'>";
                echo "<button type='submit' name='accion' value='eliminar'>Eliminar</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>