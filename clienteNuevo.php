<?php
    $nombre = $_POST['nombreC'];
    $fecha = $_POST['FechaV'];
    $edad = $_POST['edad'];
    $expl = $_POST['ExpL'];
    $modal = $_POST['Modalidad'];
    $spedido = $_POST['Spedido'];
    $calimentos = $_POST['Calimentos'];
    $precioP = $_POST['Pproductos'];
    $Amesero = $_POST['Amesero'];
    $proba = $_POST['Probabilidad'];
    $comenta = $_POST['comenta'];

    $Reseña = "Experiencia en local: $expl, modalidad: $modal, satisfacción del pedido: $spedido, calidad de los alimentos: $calimentos, precios de los productos: $precioP, calificación mesero: $Amesero, probabilidad de que vuelva: $proba y comentario: $comenta . ";
    require('conexion.php');

    $agregar = "INSERT INTO clientes(Nombre, FechaVisita, Edad, Comanetario) VALUES('$nombre', '$fecha', '$edad', '$Reseña')";
    $resultado = mysqli_query($conn, $agregar);
    mysqli_close($conn);
    if($resultado)
    {
        header("location: Proyeccto.html");
    } else {
        echo"En algo fallo";
    }
?>