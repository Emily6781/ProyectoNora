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

    $Reseña = "Experiencia en local: $expl, Modalidad: $modal, Satisfacción del pedido: $spedido, Calidad de los alimentos: $calimentos, Precios de los productos: $precioP, Calificación mesero: $Amesero, Probabilidad de que vuelva: $proba  Comentario: $comenta . ";
    require('conexion.php');

    $agregar = "INSERT INTO clientes(Nombre, FechaVisita, Edad, Comentario) VALUES('$nombre', '$fecha', '$edad', '$Reseña')";
    $resultado = mysqli_query($conn, $agregar);
    mysqli_close($conn);
    if($resultado)
    {
        header("location: Proyeccto.html");
    } else {
        echo"En algo fallo";
    }
?>
