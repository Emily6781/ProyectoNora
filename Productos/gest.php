<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "proyecto_nora";

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['tipo_id'])) {
    $nombre_producto = $_POST['nombre'];
    $precio_producto = floatval($_POST['precio']);
    $tipo_id = intval($_POST['tipo_id']);
    
    // Iniciar transacción
    $conexion->begin_transaction();
    
    try {
        // Insertar el producto en la tabla 'productos'
        $stmt_producto = $conexion->prepare("INSERT INTO productos (Nombre, Precio, Tipo_ID) VALUES (?, ?, ?)");
        $stmt_producto->bind_param("sdi", $nombre_producto, $precio_producto, $tipo_id);
        $stmt_producto->execute();
        
        // Obtener el ID del producto recién insertado
        $producto_id = $stmt_producto->insert_id;
        $stmt_producto->close();

        // Insertar la imagen en la tabla 'imagenes'
        $nombre_imagen = $_FILES['imagen']['name'];
        $tipo_imagen = $_FILES['imagen']['type'];
        $datos_imagen = file_get_contents($_FILES['imagen']['tmp_name']);

        $stmt_imagen = $conexion->prepare("INSERT INTO imagenes (nombre, tipo, datos, producto_id) VALUES (?, ?, ?, ?)");
        $stmt_imagen->bind_param("sssi", $nombre_imagen, $tipo_imagen, $datos_imagen, $producto_id);
        $stmt_imagen->execute();
        $stmt_imagen->close();

        // Confirmar transacción
        $conexion->commit();
        $mensaje = "Producto y su imagen se han registrado con éxito.";
    } catch (Exception $e) {
        // En caso de error, deshacer cambios
        $conexion->rollback();
        $mensaje = "Error al registrar el producto y la imagen: " . $e->getMessage();
    }
}

// Obtener los tipos de producto para el formulario de selección
$consulta_tipos = "SELECT ID, Tipo FROM tipos";
$resultado_tipos = $conexion->query($consulta_tipos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto con Imagen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #B26400;
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #F4E1D2;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: #F4E1D2;
            color: #6F4E37;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        label, select, input, button {
            display: block;
            width: 100%;
            margin: 10px 0;
            font-size: 1em;
        }
        select, input[type="file"], input[type="text"], input[type="number"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #B26400;
        }
        button {
            background-color: #B26400;
            color: #FFFFFF;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #8F4A00;
        }
        .message {
            margin-top: 15px;
            font-weight: bold;
            color: #6F4E37;
        }
    </style>
</head>
<body>
    <h1>Registrar Producto con Imagen</h1>
    <div class="form-container">
        <?php if (isset($mensaje)) echo "<p class='message'>$mensaje</p>"; ?>

        <form action="crudproductos.php" method="POST" enctype="multipart/form-data">
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

<?php $conexion->close(); ?>
