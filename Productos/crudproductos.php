<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "proyecto_nora");
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Obtener ID del producto seleccionado o el primero de la lista
$selected_id = isset($_GET['selected_id']) ? intval($_GET['selected_id']) : null;

// Cargar datos del producto seleccionado
if ($selected_id) {
    $consulta = $conexion->prepare("SELECT p.ID, p.Nombre, p.Precio, p.Tipo_ID, i.datos, i.tipo 
                                    FROM productos p 
                                    LEFT JOIN imagenes i ON p.ID = i.producto_id 
                                    WHERE p.ID = ?");
    $consulta->bind_param("i", $selected_id);
} else {
    $consulta = $conexion->prepare("SELECT p.ID, p.Nombre, p.Precio, p.Tipo_ID, i.datos, i.tipo 
                                    FROM productos p 
                                    LEFT JOIN imagenes i ON p.ID = i.producto_id 
                                    LIMIT 1");
}
$consulta->execute();
$producto_seleccionado = $consulta->get_result()->fetch_assoc();
$consulta->close();

// Obtener lista de todos los productos
$productos = $conexion->query("SELECT p.ID, p.Nombre, i.datos, i.tipo 
                               FROM productos p 
                               LEFT JOIN imagenes i ON p.ID = i.producto_id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Productos - Editar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            color: #333;
        }
        .main-card {
            width: 400px;
            padding: 20px;
            background-color: #FFFFFF;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .main-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .main-card input, .main-card select, .main-card button {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 5px;
        }
        .product-list {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            margin-top: 20px;
            padding: 10px;
            width: 90%;
            justify-content: center;
        }
        .product-list .card {
            width: 150px;
            background-color: #FFF3E0;
            color: #333;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }
        .product-list .card:hover {
            transform: scale(1.05);
        }
        .product-list img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .carousel-controls {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .carousel-controls button {
            padding: 10px;
            margin: 0 5px;
            border: none;
            color: white;
            background-color: #B26400;
            border-radius: 5px;
            cursor: pointer;
        }
        .carousel-controls button:disabled {
            background-color: #ccc;
            cursor: default;
        }
    </style>
</head>
<body>
    <h1>Editar Producto</h1>

    <!-- Tarjeta Principal (Producto Seleccionado) -->
    <div class="main-card">
        <?php if ($producto_seleccionado) : ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $producto_seleccionado['ID'] ?>">
                <img src="<?= $producto_seleccionado['datos'] ? "data:{$producto_seleccionado['tipo']};base64," . base64_encode($producto_seleccionado['datos']) : 'placeholder.jpg' ?>" alt="Producto">
                <input type="text" name="nombre" value="<?= htmlspecialchars($producto_seleccionado['Nombre']) ?>" placeholder="Nombre del Producto" required>
                <input type="number" name="precio" step="0.01" value="<?= $producto_seleccionado['Precio'] ?>" placeholder="Precio" required>
                <select name="tipo_id" required>
                    <?php
                    // Obtener tipos de productos
                    $tipos = $conexion->query("SELECT ID, Tipo FROM tipos");
                    while ($tipo = $tipos->fetch_assoc()) {
                        $selected = ($tipo['ID'] == $producto_seleccionado['Tipo_ID']) ? 'selected' : '';
                        echo "<option value='{$tipo['ID']}' $selected>{$tipo['Tipo']}</option>";
                    }
                    ?>
                </select>
                <input type="file" name="imagen">
                <button type="submit">Guardar Cambios</button>
            </form>

            <!-- Botón para eliminar producto -->
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $producto_seleccionado['ID'] ?>">
            <button type="submit" name="delete" style="background-color: red; color: white;">Eliminar Producto</button>
        </form>

        <?php else : ?>
            <p>No hay productos seleccionados.</p>
        <?php endif; ?>
    </div>

    <!-- Carrusel de Productos -->
    <div class="carousel-controls">
        <button onclick="scrollCarousel(-1)">&#10094; Anterior</button>
        <button onclick="scrollCarousel(1)">Siguiente &#10095;</button>
    </div>

    <div class="product-list" id="carousel">
        <?php while ($producto = $productos->fetch_assoc()) : ?>
            <a href="?selected_id=<?= $producto['ID'] ?>" class="card">
                <img src="<?= $producto['datos'] ? "data:{$producto['tipo']};base64," . base64_encode($producto['datos']) : 'placeholder.jpg' ?>" alt="<?= htmlspecialchars($producto['Nombre']) ?>">
                <p><?= htmlspecialchars($producto['Nombre']) ?></p>
            </a>
        <?php endwhile; ?>
    </div>

    <script>
        // Función para desplazar el carrusel
        function scrollCarousel(direction) {
            const carousel = document.getElementById('carousel');
            const scrollAmount = 200;
            carousel.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
        }
    </script>
</body>
</html>
<?php
// Procesar eliminación de producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Iniciar transacción
    $conexion->begin_transaction();
    try {
        // Eliminar la imagen asociada
        $stmt_imagen = $conexion->prepare("DELETE FROM imagenes WHERE producto_id = ?");
        $stmt_imagen->bind_param("i", $id);
        $stmt_imagen->execute();

        // Eliminar el producto
        $stmt_producto = $conexion->prepare("DELETE FROM productos WHERE ID = ?");
        $stmt_producto->bind_param("i", $id);
        $stmt_producto->execute();

        $conexion->commit();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        $conexion->rollback();
        die("Error al eliminar el producto: " . $e->getMessage());
    }
}
?>

<?php
// Procesar formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $tipo_id = $_POST['tipo_id'];
    $id = $_POST['id'];

    // Iniciar transacción
    $conexion->begin_transaction();
    try {
        // Actualizar producto
        $stmt_producto = $conexion->prepare("UPDATE productos SET Nombre=?, Precio=?, Tipo_ID=? WHERE ID=?");
        $stmt_producto->bind_param("sdii", $nombre, $precio, $tipo_id, $id);
        $stmt_producto->execute();

        // Actualizar imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
            $nombre_imagen = $_FILES['imagen']['name'];
            $tipo_imagen = $_FILES['imagen']['type'];
            $datos_imagen = file_get_contents($_FILES['imagen']['tmp_name']);

            $stmt_imagen = $conexion->prepare("REPLACE INTO imagenes (nombre, tipo, datos, producto_id) VALUES (?, ?, ?, ?)");
            $stmt_imagen->bind_param("sssi", $nombre_imagen, $tipo_imagen, $datos_imagen, $id);
            $stmt_imagen->execute();
        }

        $conexion->commit();
        header("Location: ".$_SERVER['PHP_SELF']."?selected_id=".$id);
        exit;
    } catch (Exception $e) {
        $conexion->rollback();
        die("Error: " . $e->getMessage());
    }
}

$conexion->close();
?>
