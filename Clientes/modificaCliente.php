<?php
    require('../conexion.php');
    $id = $_GET['id'];
    $sql = "SELECT * FROM clientes WHERE ID = '$id'";
    $datos = mysqli_query($conn, $sql);
    if(!$datos)
    {
        header("location: ../Proyeccto.html");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../estilo.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                  <!-- Inicio (Landing page) -->
                    <a class="navbar-brand" href="#" onclick="window.history.back();">C++</a>

                    <li><a href="./Clientes/mostrarClientes.php">Clientes</a></li>
                    <li><a href="./Empleados/Empleados.php">Empleados</a></li>
                    <li><a href="">Productos</a></li>
                    <li><a href="./Ventas/Views/CrearVenta.php">Ventas</a></li>
              </ul>

          </div>
      </div>
  </nav>

    <div id="encuesta">
    <form action='editaCliente.php' method='POST'>

    <?php
        while($rows = $datos->fetch_assoc()){
            echo
                "<input type='hidden' name='id' value=".$rows['ID'].">".
                "<label for='nombre'>Nombre Cliente:</label>".
                "<input type='text' name='nombre' value=".$rows['Nombre'].">".
                "<label for='fech'>Fecha de visita:</label>".
                "<input type='date' name='fecha' value=".$rows['FechaVisita'].">".
                "<label for='edad'>Edad:</label>".
                "<input type='number' name='edad' value=".$rows['Edad'].">".
                "<label for='come'>Comentario:</label>".
                "<textarea name='comenta' rows='6' cols='60'>".$rows['Comentario']."</textarea>".
                "<input type='submit' value='Modificar datos' name'ok'>".
                "</form>";
        }
                mysqli_close($conn);
    ?>
    </div>
</body>
</html>
