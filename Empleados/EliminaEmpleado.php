<?php
    require('../conexion.php');
    $id = $_GET['id'];
    $sql = "DELETE FROM empleados WHERE ID = '$id'";
    $datos = mysqli_query($conn, $sql);
    if(!$datos)
    {
        header("location: ../Proyeccto.html");
    }
?>
