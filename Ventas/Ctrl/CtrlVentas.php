<?php
// Iniciar la sesión y conexión a la base de datos
session_start();
$carrito = $_SESSION['carrito'] ?? [];
require('../../conexion.php');

// --- Funciones para interactuar con la base de datos ---

/**
 * Obtiene todos los productos desde la base de datos.
 */
function obtenerProductos($conn) {
    $sql = "SELECT * FROM productos";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Busca productos por nombre en la base de datos.
 */
function buscarProductos($conn, $searchInput) {
    $searchInput = mysqli_real_escape_string($conn, $searchInput);
    $sql = "SELECT * FROM productos WHERE Nombre LIKE '%$searchInput%'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Obtiene todos los clientes desde la base de datos.
 */
function obtenerClientes($conn) {
    $sql = "SELECT * FROM clientes";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// --- Lógica de manejo del carrito ---

// Inicializar el carrito en la sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Lógica para agregar productos al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto'])) {
    $producto_id = $_POST['producto'];
    $cantidad = isset($_POST["cantidad_$producto_id"]) ? (int)$_POST["cantidad_$producto_id"] : 1;

    // Obtener todos los productos de la base de datos
    $productos = obtenerProductos($conn);

    // Buscar el producto seleccionado en la lista de productos
    foreach ($productos as $producto) {
        if ($producto['ID'] == $producto_id) {
            // Si el producto ya está en el carrito, actualiza la cantidad
            if (isset($_SESSION['carrito'][$producto_id])) {
                $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
            } else {
                // Agrega el producto al carrito
                $_SESSION['carrito'][$producto_id] = [
                    'nombre' => $producto['Nombre'],
                    'precio' => $producto['Precio'],
                    'cantidad' => $cantidad
                ];
            }
            break;
        }
    }
}

//logica para eliminar productos del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])){
    $producto_id = $_POST['eliminar_producto'];
        
        // Eliminar el producto del carrito
        if (isset($carrito[$producto_id])) {
            unset($carrito[$producto_id]);
        }
        
        // Actualizar el subtotal, IVA, y total si es necesario
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;
        
        // Guardar el carrito actualizado en la sesión o en una variable, según tu configuración
        $_SESSION['carrito'] = $carrito;
}



// Calcular el subtotal del carrito
$subtotal = 0;
foreach ($_SESSION['carrito'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}

// Calcular IVA y total
$iva = $subtotal * 0.16;
$total = $subtotal + $iva;



$empleado_id = null; 
$cliente_id = null;  
$modo_pago_id = null;


$total = $subtotal + $iva;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceder_pago'])) {

    mysqli_begin_transaction($conn);

    try {
        // Insertar la nueva venta
        $sqlVenta = "INSERT INTO Ventas (Empleado_ID, Cliente_ID, ModoPago_ID, Total) VALUES (?, ?, ?, ?)";
        $stmtVenta = mysqli_prepare($conn, $sqlVenta);
        mysqli_stmt_bind_param($stmtVenta, "iiii", $empleado_id, $cliente_id, $modo_pago_id, $total);
        mysqli_stmt_execute($stmtVenta);
        
        // Obtener el ID de la venta recién creada
        $venta_id = mysqli_insert_id($conn);

        // Insertar cada producto del carrito en Tdetallesventa
        $sqlDetalle = "INSERT INTO Tdetallesventa (Venta_ID, Producto_ID, Cantidad, PrecioUnitario) VALUES (?, ?, ?, ?)";
        $stmtDetalle = mysqli_prepare($conn, $sqlDetalle);

        foreach ($carrito as $producto_id => $item) {
            $cantidad = $item['cantidad'];
            $precio_unitario = $item['precio'];

            // Vincular y ejecutar cada detalle
            mysqli_stmt_bind_param($stmtDetalle, "iiii", $venta_id, $producto_id, $cantidad, $precio_unitario);
            mysqli_stmt_execute($stmtDetalle);
        }

        // Confirmar la transacción
        mysqli_commit($conn);

        // Limpiar el carrito y mostrar un mensaje de éxito
        $_SESSION['carrito'] = [];
        echo "<p>La venta se ha registrado correctamente.</p>";
    } catch (Exception $e) {
        // En caso de error, deshacer la transacción
        mysqli_rollback($conn);
        echo "<p>Error al registrar la venta: " . $e->getMessage() . "</p>";
    }
}

// Exportar variables necesarias a la vista
$carrito = $_SESSION['carrito'];

?>

