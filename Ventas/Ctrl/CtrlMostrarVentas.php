<?php
// Iniciar la sesión y conexión a la base de datos
session_start();
$carrito = $_SESSION['carrito'] ?? [];
require('../../conexion.php');

// --- Funciones para interactuar con la base de datos ---

/**
 * Obtiene todas las ventas desde la base de datos.
 */
function obtenerVentasAgrupadas($conn) {
    $sql = "
        SELECT 
            v.ID AS VentaID, 
            GROUP_CONCAT(CONCAT(p.Nombre, ' (', td.Cantidad, ')') SEPARATOR ', ') AS Productos, 
            SUM(td.Cantidad * td.PrecioUnitario) AS TotalVenta
        FROM ventas v
        LEFT JOIN tdetallesventa td ON v.ID = td.Venta_ID
        LEFT JOIN productos p ON td.Producto_ID = p.ID
        GROUP BY v.ID";
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$ventasConDetalles = obtenerVentasAgrupadas($conn);

/**
 * Busca la venta segun su ID en la base de datos
 */
function buscarVentasConDetalles($conn, $searchInput) {
    
    $searchInput = mysqli_real_escape_string($conn, $searchInput);

    // Consulta SQL con filtro basado en la entrada de búsqueda
    $sql = "
        SELECT 
            v.ID AS VentaID, 
            GROUP_CONCAT(CONCAT(p.Nombre, ' (', td.Cantidad, ')') SEPARATOR ', ') AS Productos, 
            SUM(td.Cantidad * td.PrecioUnitario) AS TotalVenta
        FROM ventas v
        LEFT JOIN tdetallesventa td ON v.ID = td.Venta_ID
        LEFT JOIN productos p ON td.Producto_ID = p.ID
        WHERE v.ID LIKE '%$searchInput%' 
           OR p.Nombre LIKE '%$searchInput%'
        GROUP BY v.ID";

    // Ejecutar la consulta
    $result = mysqli_query($conn, $sql);

    // Verificar si hay resultados
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_venta'])) {
    $venta_id = (int)$_POST['venta_id'];

    
    $sql_detalles = "DELETE FROM tdetallesventa WHERE Venta_ID = $venta_id";
    mysqli_query($conn, $sql_detalles);

    // Eliminar la venta
    $sql_venta = "DELETE FROM ventas WHERE ID = $venta_id";
    $result = mysqli_query($conn, $sql_venta);

    if ($result) {
        echo "<script>alert('Venta borrada correctamente.');</script>";
    } else {
        echo "<script>alert('Error al borrar la venta: " . mysqli_error($conn) . "');</script>";
    }

    // Recargar la tabla actualizada
    $ventasConDetalles = obtenerVentasAgrupadas($conn);
}

if (($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_POST['searchInput'])){
    $searchInput = (int)$_POST['searchInput'];
    $ventasConDetalles = buscarVentasConDetalles($conn, $searchInput);

}

