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

      <h1>"Mucho más que los demás"</h1><br>


      <div id="encuesta">
    <form action="EditaEmpleado.php" method="POST">
        <?php
        // Iteramos sobre los datos
        while ($rows = $datos->fetch_assoc()) {
            echo "<input type='hidden' name='id' value='" . $rows['ID'] . "'>" .
                "<label for='nombre'>Nombre Empleado:</label>" .
                "<input type='text' name='nombre' value='" . $rows['Nombre'] . "' required><br>" .

                "<label for='ApellidoP'>Apellido Paterno:</label>" .
                "<input type='text' name='ApellidoP' value='" . $rows['ApellidoP'] . "' required><br>" .

                "<label for='ApellidoM'>Apellido Materno:</label>" .
                "<input type='text' name='ApellidoM' value='" . $rows['ApellidoM'] . "' required><br>" .

                "<label for='FechaNac'>Fecha de Nacimiento:</label>" .
                "<input type='date' name='FechaNac' value='" . $rows['FechaNac'] . "' required><br>" .

                "<label for='puestos'>Puesto:</label>" .
                "<select name='puestos' required>" .
                    "<option value='' disabled selected>Seleccione el puesto</option>" .
                    "<option value='1' " . ($rows['Puestos_ID'] == 1 ? "selected" : "") . ">Gerente</option>" .
                    "<option value='2' " . ($rows['Puestos_ID'] == 2 ? "selected" : "") . ">Auxiliar de cocina</option>" .
                    "<option value='3' " . ($rows['Puestos_ID'] == 3 ? "selected" : "") . ">Encargado de Limpieza</option>" .
                    "<option value='4' " . ($rows['Puestos_ID'] == 4 ? "selected" : "") . ">Mesero</option>" .
                "</select><br><br>" .

                "<label for='horarios'>Horario:</label>" .
                "<select name='horarios' required>" .
                    "<option value='' disabled selected>Seleccione el horario</option>" .
                    "<option value='1' " . ($rows['Horario_ID'] == 1 ? "selected" : "") . ">Matutino</option>" .
                    "<option value='2' " . ($rows['Horario_ID'] == 2 ? "selected" : "") . ">Vespertino</option>" .
                "</select><br><br>" .

                "<input type='submit' value='Modificar datos' name='ok'>";
        }

        // Cerramos la conexión
        mysqli_close($conn);
        ?>
    </form>
</div>

<footer>
    <p>Hecho por Café++ en colaboración con Team Tocino. Puerto Vallarta, Jal. 19 de Noviembre 2024.</p><br>
</footer>

</html>
