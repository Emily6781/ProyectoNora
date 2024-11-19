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

                        <li><a href="../../Clientes/mostrarClientes.php">Clientes</a></li>
                        <li><a href="../../Empleados/Empleados.php">Empleados</a></li>
                        <li><a href="">Productos</a></li>
                        <li><a href="../../Ventas/Views/CrearVenta.php">Ventas</a></li>
                  </ul>

              </div>
          </div>
      </nav>

      <br>
      <br>
      <br>
      <br>

      <h1>"Mucho más que los demás"</h1><br>


      <table>
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>ApellidoP</th>
                  <th>Apellidom</th>
                  <th>FechaNac</th>
                  <th>Puesto_ID</th>
                  <th>Horario_ID</th>
                  <th colspan='2'>Acciones</th>
              </tr>
          </thead>

          <?php
                  while($rows = $datos->fetch_assoc()){
                      echo "<tr>".
                           "<td>".$rows['ID']."</td>".
                           "<td>".$rows['Nombre']."</td>".
                           "<td>".$rows['ApellidoP']."</td>".
                           "<td>".$rows['ApellidoM']."</td>".
                           "<td>".$rows['FechaNac']."</td>".
                           "<td>".$rows['Puestos_ID']."</td>".
                           "<td>".$rows['Horario_ID']."</td>".
                           "<td><a href='modificaEmpleado.php?id=$rows[ID]'>Modificar</a></td>".
                           "<td><a href='EliminaEmpleado.php?id=$rows[ID]'>Eliminar</a></td>".
                           "</tr>";
                  }

               mysqli_close($conn);
              ?>

    </table>
    <br>
    <br>
    <br>
    <br>

              <footer>
                <p>Hecho por Café++ en colobaración con Team Tocino. Puerto Vallarta, Jal. 19 de Noviembre 2024.</p><br>
              </footer>
</body>
</html>
