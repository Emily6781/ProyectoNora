<?php
    require('../conexion.php');
    $id = $_GET['id'];
    $sql = "SELECT * FROM empleados WHERE ID = '$id'";
    $datos = mysqli_query($conn, $sql);
    if(!$datos)
    {
        header("location: ../Proyeccto.html");
    }
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Empleados</title>
    <link rel="stylesheet" href="../estilo.css" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
  </head>

  <body>
    <div class="container">
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

      <br>
      <br>
      <br>
      <br>

      <img src=".../Recursos/Visuales/Café++.png" alt="Café ++" id="imagenC" />

      <br>

      <audio controls autoplay loop>
        <source src="Recursos/Auditivos/P540.wav" type="audio/wav">
        <source src="Recursos/Auditivos/P540.wav" type="audio/wav">
        Tu navegador no soporta la etiqueta de audio.
      </audio>

      <h1>"Mucho más que los demás"</h1><br>


  <div id="encuesta">
  <form action='resultados.php' method='POST'>

  <?php
      while($rows = $datos->fetch_assoc()){
          echo
              "<input type='hidden' name='id' value=".$rows['ID'].">".
              "<label for='nombre'>Nombre Empleado:</label>".
              "<input type='text' name='nombre' value=".$rows['Nombre'].">".
              "<label for='apellidop'>Apellido Paterno:</label>".
              "<input type='text' name='apellidop' value=".$rows['Apellido Paterno'].">".
              "<label for='apellidom'>Apellido Materno:</label>".
              "<input type='text' name='apellidom' value=".$rows['Apellido Materno'].">".
              "<label for='fech'>Fecha de Nacimiento:</label>".
              "<input type='date' name='FechaNac' value=".$rows['Fecha de nacimiento'].">".
              "<label for='edad'>Edad:</label>".
              "<input type='submit' value='Modificar datos' name'ok'>".
              "</form>";
      }
              mysqli_close($conn);
  ?>
  </div>

</form>
</body>

<footer>
  <p>Hecho por Café++ en colobaración con Team Tocino. Puerto Vallarta, Jal. 19 de Noviembre 2024.</p><br>
</footer>

</html>
