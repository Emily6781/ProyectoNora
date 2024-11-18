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
                    <li class="button-show"><a href="mostrarVenta.php">Mostrar ventas</a></li>
                </ul>
            </nav> 

            <form method="POST" action="">
                <div class="search-bar">
                    <label for="searchInput">Buscar producto:</label>
                    <input type="text" id="searchInput" name="searchInput" placeholder="Buscar..." class="search-box">
                    <button type="submit" class="button-search">Buscar</button>
                </div>

                 

                <div class="products-table">
                    <h2>Productos en venta</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['Nombre']); ?></td>
                                <td>$<?php echo htmlspecialchars(number_format($producto['Precio'], 2)); ?></td>
                                <td>
                                    <input type="number" name="cantidad_<?php echo $producto['ID']; ?>" value="1" min="1" max="10" required>
                                </td>
                                <td>
                                    <button class="button-add" type="submit" name="producto" 
                                            value="<?php echo $producto['ID']; ?>">Agregar al Carrito</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- Carrito de compra -->
        <div class="shopping-cart">
            <h2>Carrito de compra</h2>
            <form method="POST" action="">
                <ul>
                    <?php if (!empty($carrito)): ?>
                        <?php foreach ($carrito as $producto_id => $item): ?>
                            <li>
                                <?php echo htmlspecialchars($item['cantidad']); ?>x 
                                <?php echo htmlspecialchars($item['nombre']); ?> - 
                                $<?php echo htmlspecialchars(number_format($item['precio'] * $item['cantidad'], 2)); ?>
                                <button type="submit" name="eliminar_producto" value="<?php echo $producto_id; ?>" class="button-remove">Eliminar</button>
                            </li>
                        <?php endforeach; ?>
                        <li>Subtotal: $<?php echo number_format($subtotal, 2); ?></li>
                        <li>IVA (16%): $<?php echo number_format($iva, 2); ?></li>
                        <li><strong>Total a Pagar: $<?php echo number_format($total, 2); ?></strong></li>
                        <li>
                            <button type="submit" name="proceder_pago" class="button-pay">Proceder con el pago</button>
                        </li>
                    <?php else: ?>
                        <li>El carrito está vacío.</li>
                    <?php endif; ?>
                </ul>
            </form>
        </div>
    </div>  
      
</body>
