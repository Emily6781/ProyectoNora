<?php
// Iniciar la sesión y conexión a la base de datos
session_start();
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

// Calcular el subtotal del carrito
$subtotal = 0;
foreach ($_SESSION['carrito'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}

// Calcular IVA y total
$iva = $subtotal * 0.16;
$total = $subtotal + $iva;

// Exportar variables necesarias a la vista
$carrito = $_SESSION['carrito'];
?>

