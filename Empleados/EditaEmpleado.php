<?php
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidop = $_POST['apellidop'];
    $apellidom = $_POST['apellidom'];
    $fechanac = $_POST['fechanac'];
    $puestos = $_POST['puestos'];
    $horario = $_POST['horario'];
    require('../conexion.php');

    $modificar = "UPDATE empleados SET Nombre='$nombre', Apellido Paterno='$apellidop', Apellido Materno='$apellidom', Fecha de nacimiento ='$fechanac' Puesto de trabajo='$puestos', Turno de trabajo ='$horario' WHERE ID = '$id'";
    $resultado = mysqli_query($conn, $modificar);
    mysqli_close($conn);
    if($resultado)
    {
        header("location: ../Proyeccto.html");
    } else {
        echo"En algo fallo";
    }
?>
