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


  /*  // Comprobamso si recibimos datos por POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Recogemos variables
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
        $nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : null;
        $apellidop = isset($_REQUEST['apellidop']) ? $_REQUEST['apellidop'] : null;
        $apellidom = isset($_REQUEST['apellidom']) ? $_REQUEST['apellidom'] : null;
        $fechanac = isset($_REQUEST['fechanac']) ? $_REQUEST['fechanac'] : null;
        $puestos = isset($_REQUEST['puestos']) ? $_REQUEST['puestos'] : null
      >//  $horario = isset($_REQUEST['horario']) ? $_REQUEST['horario'] : null;

        // Variables
        require('../conexion.php');
        $sql = "SELECT * FROM empleados";
        $datos = mysqli_query($conn, $sql);
        if(!$datos)
        // Prepara INSERT

        $miInsert = $miPDO->prepare('INSERT INTO empleados(ID, Nombre, ApellidoP, ApellidoM, FechaNac, Puestos_ID, Horario_ID) VALUES (id, nombre, apellidop,'[value-4]','[value-5]','[value-6]','[value-7]'));
        // Ejecuta INSERT con los datos
        $miInsert->execute(
            array(
                'titulo' => $titulo,
                'autor' => $autor,
                'disponible' => $disponible
            )
        );

        // Redireccionamos a Leer
    header("location: Proyeccto.html");
    }

    <!DOCTYPE html>
    <html lang="es">
    <body>
      <h1>¿Desea registrar un nuevo empleado?</h1><br>
    <form action="empleados.php" method="post">


    <br>Nombre<br>
    <input type="text" name="name"> <br>

    <br>Apellido Paterno<br>
    <input type="text" name="ApeP"> <br>

    <br>Apellido Materno<br>
    <input type="text" name="ApeM"> <br>

    <br>Fecha de nacimiento<br>
    <input type="date" name="FechaNac"> <br>

    <br>
    <br>
    <input type="submit" value="Enviar"> <input type="reset" value="Borrar">

    </form>*/


<br>
<br>
<br>
    </body>
    </html>



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
