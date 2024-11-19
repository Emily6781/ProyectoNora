<?php
// Iniciar la sesión y conexión a la base de datos
session_start();

// Conectar a la base de datos
require('../../conexion.php');

// Inicializar el carrito en la sesión si no existe
$_SESSION['carrito'] = $_SESSION['carrito'] ?? [];

// Verificar si el venta_id se recibe por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['venta_id'])) {
    // Guardar el ID de la venta en la sesión
    $_SESSION['venta_id'] = intval($_POST['venta_id']);
} elseif (!isset($_SESSION['venta_id'])) {
    // Si no se ha recibido el venta_id y no está en la sesión, mostrar un error
    echo "El ID de la venta no está disponible.";
    exit();
}

// Recuperar el venta_id desde la sesión
$venta_id = $_SESSION['venta_id'];

// --- Funciones para interactuar con la base de datos ---

// Función para obtener todos los productos desde la base de datos
function obtenerProductos($conn) {
    $sql = "SELECT * FROM productos";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function buscarProductos($conn, $searchInput) {
    $searchInput = mysqli_real_escape_string($conn, $searchInput);
    $sql = "SELECT * FROM productos WHERE Nombre LIKE '%$searchInput%'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Función para obtener los detalles de una venta
function obtenerDetallesVenta($conn, $ventaID) {
    $sql = "SELECT Producto_ID, Cantidad FROM Tdetallesventa WHERE Venta_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $ventaID);
    $stmt->execute();
    $result = $stmt->get_result();
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Función para obtener un producto por su ID
function obtenerProductoPorID($conn, $producto_id) {
    $sql = "SELECT Nombre, Precio FROM productos WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $producto_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// --- Lógica de manejo del carrito ---

// Recuperar detalles de la venta si se proporciona un venta_id
if ($venta_id) {
    $detallesVenta = obtenerDetallesVenta($conn, $venta_id);

    // Poner los detalles de la venta en el carrito (para modificar las cantidades si ya existen)
    foreach ($detallesVenta as $detalle) {
        $producto = obtenerProductoPorID($conn, $detalle['Producto_ID']);
        $_SESSION['carrito'][$detalle['Producto_ID']] = [
            'nombre' => $producto['Nombre'],
            'precio' => $producto['Precio'],
            'cantidad' => $detalle['Cantidad']
        ];
    }
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])) {
    $producto_id = $_POST['eliminar_producto'];

    // Eliminar el producto del carrito
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }

    // Actualizar el subtotal, IVA, y total si es necesario
    $subtotal = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }
    $iva = $subtotal * 0.16;
    $total = $subtotal + $iva;

    // Guardar el carrito actualizado en la sesión
    $_SESSION['carrito'] = $_SESSION['carrito'];
}

// Calcular el subtotal, IVA y total
$subtotal = 0;
foreach ($_SESSION['carrito'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}

$iva = $subtotal * 0.16;
$total = $subtotal + $iva;

// Lógica para proceder con la modificación de la venta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceder_modificar'])) {
    // Verificar si el venta_id está disponible en la sesión
    if (!isset($venta_id) || empty($venta_id)) {
        echo "El ID de la venta no está disponible.";
        exit();
    }

    // Iniciar la transacción
    mysqli_begin_transaction($conn);

    try {
        $totalVenta = 0;

        // Verificar los productos eliminados
        foreach ($_SESSION['carrito'] as $producto_id => $item) {
            // Verificar si el producto ya está en los detalles de la venta
            $sqlDetalleExistente = "SELECT * FROM Tdetallesventa WHERE Venta_ID = ? AND Producto_ID = ?";
            $stmtDetalleExistente = $conn->prepare($sqlDetalleExistente);
            $stmtDetalleExistente->bind_param('ii', $venta_id, $producto_id);
            $stmtDetalleExistente->execute();
            $result = $stmtDetalleExistente->get_result();

            if ($result->num_rows > 0) {
                // Si el producto ya existe en los detalles de la venta, actualizar la cantidad
                $sqlActualizar = "UPDATE Tdetallesventa SET Cantidad = ? WHERE Venta_ID = ? AND Producto_ID = ?";
                $stmtActualizar = $conn->prepare($sqlActualizar);
                $stmtActualizar->bind_param('iii', $item['cantidad'], $venta_id, $producto_id);
                $stmtActualizar->execute();
            } else {
                // Si el producto no existe, insertarlo en los detalles
                $sqlInsertar = "INSERT INTO Tdetallesventa (Venta_ID, Producto_ID, Cantidad, PrecioUnitario) VALUES (?, ?, ?, ?)";
                $stmtInsertar = $conn->prepare($sqlInsertar);
                $stmtInsertar->bind_param('iiii', $venta_id, $producto_id, $item['cantidad'], $item['precio']);
                $stmtInsertar->execute();
            }

            // Acumular el total de la venta
            $totalVenta += $item['cantidad'] * $item['precio'];
        }

        // Ahora, eliminar los productos que están en los detalles de la venta pero no en el carrito
        foreach ($detallesVenta as $detalle) {
            if (!isset($_SESSION['carrito'][$detalle['Producto_ID']])) {
                // Si el producto no está en el carrito, eliminarlo de los detalles de la venta
                $sqlEliminar = "DELETE FROM Tdetallesventa WHERE Venta_ID = ? AND Producto_ID = ?";
                $stmtEliminar = $conn->prepare($sqlEliminar);
                $stmtEliminar->bind_param('ii', $venta_id, $detalle['Producto_ID']);
                $stmtEliminar->execute();
            }
        }

        // Actualizar el total de la venta en la tabla Ventas
        $sqlActualizarVenta = "UPDATE Ventas SET Total = ? WHERE ID = ?";
        $stmtActualizarVenta = $conn->prepare($sqlActualizarVenta);
        $stmtActualizarVenta->bind_param('ii', $totalVenta, $venta_id);
        $stmtActualizarVenta->execute();

        // Confirmar la transacción
        mysqli_commit($conn);

        // Limpiar el carrito y mostrar mensaje de éxito
        $_SESSION['carrito'] = [];
        echo "<p>Los detalles de la venta se han modificado correctamente.</p>";
    } catch (Exception $e) {
        // En caso de error, deshacer la transacción
        mysqli_rollback($conn);
        echo "<p>Error al modificar los detalles de la venta: " . $e->getMessage() . "</p>";
    }
}

?>
