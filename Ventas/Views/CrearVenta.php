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

<div class="form-container">
    <form method="POST" action="">
        <div class="search-bar">
            <label for="searchInput">Buscar producto:</label>
            <input type="text" id="searchInput" name="searchInput" placeholder="Buscar..." class="search-box">
            <link rel="stylesheet" href="../../estilo.css" />
            <button type="submit" class="button-search">Buscar</button>
        </div>

        <div class="products-table">
            <h2>Productos en venta</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['Stock']); ?></td>
                        <td><?php echo htmlspecialchars($producto['Precio']); ?></td>
                        <td>
                            <input type="number" name="cantidad_<?php echo $producto['ID']; ?>" value="1" min="1"
                                   max="<?php echo htmlspecialchars($producto['Stock']); ?>" required>
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
