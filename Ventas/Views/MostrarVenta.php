<?php
// Incluir la lógica
require('../Ctrl/CtrlMostrarVentas.php');

// Conectar a la base de datos
require('../../conexion.php');


?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mostrar Ventas</title>
    </head>
    <header>
        <link rel="stylesheet" href="../css/Ventas.css" />
        <img src="../../Recursos/Visuales/Café ++ Cartel.jpg" alt="Café ++" id="imagenC" />
        <br>
        <audio controls autoplay loop>
            <source src="../../Recursos/Auditivos/P540.wav" type="audio/wav">
            <source src="../../Recursos/Auditivos/P540.wav" type="audio/wav">
            Tu navegador no soporta la etiqueta de audio.
        </audio>
        <h1>"Mucho más que los demás"</h1><br>

        <nav>
            <ul>
                <li><a href="../../Clientes/mostrarClientes.php">Clientes</a></li>
                <li><a href="../../Empleados/Empleados.php">Empleados</a></li>
                <li><a href="../../Productos/gest.php">Productos</a></li>
                <li><a href="./CrearVenta.php">Ventas</a></li>
            </ul>
        </nav>
    </header>
    <body>
        <div class="general-container">
            <div class="form-container">

                <nav >
                    <ul>
                        <li class="button-show"><a href="crearVenta.php">Regresar a crear ventas</a></li>
                    </ul>
                </nav> 

                <form method="POST" action="">
                    <div class="search-bar">
                        <label for="searchInput">Buscar venta</label>
                        <input type="text" id="searchInput" name="searchInput" placeholder="Buscar..." class="search-box">
                        <button type="submit" class="button-search">Buscar ventas por ID</button>
                    </div>
                </form>

                <div class="products-table">
                    <h2>Ventas Realizadas</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID de Venta</th>
                                <th>Producto</th>
                                <th>Total de Venta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ventasConDetalles)): ?>
                                <?php foreach ($ventasConDetalles as $venta): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($venta['VentaID']); ?></td>
                                        <td><?php echo htmlspecialchars($venta['Productos']); ?></td>
                                        <td>$<?php echo htmlspecialchars(number_format($venta['TotalVenta'], 2)); ?></td>
                                        <td>
                                            
                                            <!-- Botón de modificar -->
                                            <!-- Botón de modificar -->
                                            <form method="POST" action="EditarVenta.php">
                                                <input type="hidden" name="venta_id" value="<?php echo $venta['VentaID']; ?>">
                                                <button type="submit" class="btn-modify">Modificar</button>
                                            </form>


                                            <!-- Botón de borrar -->
                                            <form method="POST" action="" style="display: inline;">
                                                <input type="hidden" name="venta_id" value="<?php echo $venta['VentaID']; ?>">
                                                <button type="submit" name="borrar_venta" 
                                                    class="btn-delete" 
                                                    onclick="return confirm('¿Estás seguro de que deseas borrar esta venta?');">
                                                    Borrar
                                                </button>
                                            </form>    
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">No hay ventas registradas.</td>
                                </tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>

            
            </div>
        </div>
    </body>
</html>
