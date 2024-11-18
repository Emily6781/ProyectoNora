<?php
// Incluir la lógica
require('../Ctrl/CtrlVentas.php');

// Conectar a la base de datos
require('../../conexion.php');

// Obtener productos o buscar productos si se envió el formulario
$productos = isset($_POST['searchInput']) ? buscarProductos($conn, $_POST['searchInput']) : obtenerProductos($conn);        

// Obtener todos los clientes
$clientes = obtenerClientes($conn);
?>

<header>
    
    <link rel="stylesheet" href="../css/Ventas.css" />
    
    <img src="../../Imagenes/Café ++ Cartel.jpg" alt="Café ++" id="imagenC" />

    <br>

    <audio controls autoplay loop>
        <source src="../../Imagenes/P540.wav" type="audio/wav">
        <source src="../../Imagenes/P540.wav" type="audio/wav">
        Tu navegador no soporta la etiqueta de audio.
    </audio>

    <h1>"Mucho más que los demás"</h1><br>

    <nav>
        <ul>
        <li><a href="./Clientes/mostrarClientes.php">Clientes</a></li>
        <li><a href="">Empleados</a></li>
        <li><a href="">Productos</a></li>
        <li><a href="./Ventas/Views/CrearVenta.php">Ventas</a></li>
        </ul>
    </nav>  


</header>
<body>

    <div class="general-container">
        <div class="form-container">
            <nav >
                <ul>
                    <li class="button-show"><a href="MostrarVenta.php">Regresar a la pagina de muestras</a></li>
                </ul>
            </nav> 
            <h2>Editar Detalle de Venta</h2>
            
            <?php if (!empty($detalle)): ?>
            <form method="POST" action="">
                <input type="hidden" name="detalle_id" value="<?php echo htmlspecialchars($detalle['ID']); ?>">

                <label for="producto">Producto:</label>
                <input type="text" id="producto" value="<?php echo htmlspecialchars($detalle['Nombre']); ?>" disabled>

                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" 
                    value="<?php echo htmlspecialchars($detalle['Cantidad']); ?>" min="1" required>

                <label for="precio_unitario">Precio Unitario:</label>
                <input type="number" id="precio_unitario" name="precio_unitario" 
                    value="<?php echo htmlspecialchars($detalle['PrecioUnitario']); ?>" step="0.01" required>

                <button type="submit" class="button-save">Guardar Cambios</button>
            </form>
            <?php else: ?>
                <p>No se encontró el detalle de venta.</p>
            <?php endif; ?>
        </div>

    </div>
</body> 