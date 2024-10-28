<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Cliente </title>
    <link rel="stylesheet" href="estilo.css" />
</head>
<body>
    <h2>Cliente Nuevo</h2>
    <form action="<?php echo$_SERVER['PHP_SELF'];?>" method="post">
        <div id="encuesta">
        <label for="">Nombre</label>
        <input type="text" name="nombreC" id="nombreC">
        <label for="">Fecha de Visita</label>
        <input type="date" name="FechaV" id="FechaV">
        <label for="Edad">Edad</label>
        <input type="number" name="edad" id="edad" >
        </div>
        <div id="encuesta">
          <p>En la siguiente escala, cómo calificaria su experiencia en local</p><br>
          <input type="radio" name="ExpL" value="Excelente"/>Excelente
          <input type="radio" name="ExpL" value="Buena" />Buena
          <input type="radio" name="ExpL" value="Neutra" />Neutra
          <input type="radio" name="ExpL" value="Mala" />Mala
          <input type="radio" name="ExpL" value="Terrible" />Terrible
        </div>
        <div id="encuesta">
          <p>Describa cuál fue su modalidad de visita</p><br>
          <input type="radio" name="Modalidad" value="Comedor"/>Comer en el local
          <input type="radio" name="Modalidad" value="Llevar" />Para llevar
        </div>
        <div id="encuesta">
          <p>Qué tan satisfecho estubo con su pedido</p><br>
          <input type="radio" name="Spedido" value="Excelente"/>Mucho
          <input type="radio" name="Spedido" value="Buena" />Bien
          <input type="radio" name="Spedido" value="Neutra" />Suficiente
          <input type="radio" name="Spedido" value="Mala" />Poco
          <input type="radio" name="Spedido" value="Terrible" />Nada
         </div>
        <div id="encuesta">
          <p>En la siguiente escala, como calificaria el tiempo que espero sus alimentos</p><br>
          <input type="radio" name="Calimentos" value="Excelente"/>Excelente
          <input type="radio" name="Calimentos" value="Buena" />Bueno
          <input type="radio" name="Calimentos" value="Neutra" />Neutro
          <input type="radio" name="Calimentos" value="Mala" />Malo
          <input type="radio" name="Calimentos" value="Terrible" />Terrible
        </div>
        <div id="encuesta">
          <p>Esta de acuerdo con los precios de los productos que compró</p><br>
          <input type="radio" name="Pproductos" value="Excelente"/>Muy de acuerdo
          <input type="radio" name="Pproductos" value="Buena" />De acuerdo
          <input type="radio" name="Pproductos" value="Neutra" />Neutro
          <input type="radio" name="Pproductos" value="Mala" />En desacuerdo
          <input type="radio" name="Pproductos" value="Terrible" />Muy en desacuerdo
        </div>
        <div id="encuesta">
          <p>En la siguiente escala, como calificaria la atención del meser@</p><br>
          <input type="radio" name="Amesero" value="Excelente"/>Excelente
          <input type="radio" name="Amesero" value="Buena" />Buena
          <input type="radio" name="Amesero" value="Neutra" />Neutra
          <input type="radio" name="Amesero" value="Mala" />Mala
          <input type="radio" name="Amesero" value="Terrible" />Terrible
        </div>
        <div id="encuesta">
          <p>¿Cuál es la probabilidad de que regrese?</p><br>
          <input type="radio" name="Probabilidad" value="Excelente"/>100%
          <input type="radio" name="Probabilidad" value="Buena" />75%
          <input type="radio" name="Probabilidad" value="Neutra" />50%
          <input type="radio" name="Probabilidad" value="Mala" />25%
          <input type="radio" name="Probabilidad" value="Terrible" />0%
        </div>
        <br />Escribanos al buzón de sugerencias: <br />
        <textarea name="comenta" rows="6" cols="60" placeholder="Escribe aquí"> </textarea>

        <br> </br>
        <input type="submit" name="cliente" value="Guardar">
    </form>
</body>
</html>
<?php
    if(isset($_POST['cliente'])){
        $nombre = $_POST['nombreC'];
        $fecha = $_POST['FechaV'];
        $edad = $_POST['edad'];
        $expl = $_POST['ExpL'];
        $modal = $_POST['Modalidad'];
        $spedido = $_POST['Spedido'];
        $calimentos = $_POST['Calimentos'];
        $precioP = $_POST['Pproductos'];
        $Amesero = $_POST['Amesero'];
        $Amesero = $_POST['Probabilidad'];
        $comenta = $_POST['comenta'];

        $Reseña = "Experiencia en local: $expel, modalidad: $modal, "
        include('conexion.php');

        $agregar = "INSERT INTO clientes(Nombre, FechaVisita, Edad, Comanetario) VALUES(". $nombre. ",'". $fecha. "', '". $edad. "','".$comenta. "')";
        $resultado = mysqli_query($conexion, $agregar) or die("algo paso en la inserteccion");
        mysqli_close($conexion);
        //header("location: formAlumnos.php");
    }
?>