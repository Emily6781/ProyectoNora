<?php
  require('../conexion.php');
  $sql = "SELECT * FROM empleados";
  $datos = mysqli_query($conn, $sql);
  if(!$datos)
  {
    header("location: Proyeccto.html");
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


      <table>
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Fecha de visita</th>
                  <th>Edad</th>
                  <th>Comentario</th>
                  <th colspan='2'>Acciones</th>
              </tr>
          </thead>

          <?php
                  while($rows = $datos->fetch_assoc()){
                      echo "<tr>".
                           "<td>".$rows['ID']."</td>".
                           "<td>".$rows['Nombre']."</td>".
                           "<td>".$rows['FechaVisita']."</td>".
                           "<td>".$rows['Edad']."</td>".
                           "<td>".$rows['Comentario']."</td>".
                           "<td><a href='modificaCliente.php?id=$rows[ID]'>Editar</a></td>".
                           "<td><a href='eliminaCliente.php?id=$rows[ID]'>Eliminar</a></td>".
                           "</tr>";
                  }

               mysqli_close($conn);
              ?>

              <footer>
                <p>Hecho por Café++ en colobaración con Team Tocino. Puerto Vallarta, Jal. 19 de Noviembre 2024.</p><br>
              </footer>
</body>
</html>