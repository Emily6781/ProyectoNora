<?php
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $fechaV = $_POST['fecha'];
    $edad = $_POST['edad'];
    $comenta = $_POST['comenta'];
    require('../conexion.php');

    $modificar = "UPDATE clientes SET Nombre='$nombre', FechaVisita='$fechaV', Edad='$edad', Comentario ='$comenta' WHERE ID = '$id'";
    $resultado = mysqli_query($conn, $modificar);
    mysqli_close($conn);
    if($resultado)
    {
        header("location: ../Proyeccto.html");
    } else {
        echo"En algo fallo";
    }
?>