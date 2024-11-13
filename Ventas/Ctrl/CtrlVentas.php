<?php
// Incluir la conexión a la base de datos
require('../../conexion.php');

// Función para obtener todos los productos
function obtenerProductos($conn) {
    $sql = "SELECT * FROM productos";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Función para buscar productos por nombre
function buscarProductos($conn, $searchInput) {
    $searchInput = mysqli_real_escape_string($conn, $searchInput);
    $sql = "SELECT * FROM productos WHERE Nombre LIKE '%$searchInput%'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Función para obtener todos los clientes
function obtenerClientes($conn) {
    $sql = "SELECT * FROM clientes";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
