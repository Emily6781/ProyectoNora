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


      <?php
    // Comprobamos si recibimos datos por POST
    // Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recoger los datos del formulario
    $nombre = isset($_POST['name']) ? $_POST['name'] : null;
    $apellidop = isset($_POST['ApeP']) ? $_POST['ApeP'] : null;
    $apellidom = isset($_POST['ApeM']) ? $_POST['ApeM'] : null;
    $fechanac = isset($_POST['FechaNac']) ? $_POST['FechaNac'] : null;
    $puesto = isset($_POST['puesto']) ? intval($_POST['puesto']) : null;
    $horario = isset($_POST['horario']) ? intval($_POST['horario']) : null;

    // Validar campos obligatorios
    if (!$nombre || !$apellidop || !$apellidom || !$fechanac || !$puesto || !$horario) {
        echo "<p>Todos los campos son obligatorios.</p>";
        exit;
    }

    // Conectar a la base de datos
    require('../conexion.php');

    // Iniciar una transacción
    mysqli_begin_transaction($conn);

    try {
        // Preparar el INSERT para registrar al empleado
        $sqlEmpleado = "INSERT INTO empleados (Nombre, ApellidoP, ApellidoM, FechaNac, Puestos_ID, Horario_ID) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmtEmpleado = mysqli_prepare($conn, $sqlEmpleado);

        // Verificar si la preparación fue exitosa
        if (!$stmtEmpleado) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($conn));
        }

        // Vincular parámetros y ejecutar la consulta
        mysqli_stmt_bind_param($stmtEmpleado, "ssssii", $nombre, $apellidop, $apellidom, $fechanac, $puesto, $horario);
        mysqli_stmt_execute($stmtEmpleado);

        // Confirmar la transacción
        mysqli_commit($conn);

        echo "<p>Empleado registrado exitosamente.</p>";

        // Redireccionar al HTML
        header("Location: ../Proyeccto.html");
        exit;

    } catch (Exception $e) {
        // En caso de error, deshacer la transacción
        mysqli_rollback($conn);
        echo "<p>Error al registrar el empleado: " . $e->getMessage() . "</p>";
    } finally {
        // Cerrar la conexión y las declaraciones
        if (isset($stmtEmpleado)) {
            mysqli_stmt_close($stmtEmpleado);
        }
        mysqli_close($conn);
    }
}
?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Empleados</title>
    </head>
    <body>
        <h1>¿Desea registrar un nuevo empleado?</h1>
        <form action="empleados.php" method="post">
            <br>Nombre<br>
            <input type="text" name="name" required> <br>

            <br>Apellido Paterno<br>
            <input type="text" name="ApeP" required> <br>

            <br>Apellido Materno<br>
            <input type="text" name="ApeM" required> <br>

            <br>Fecha de nacimiento<br>
            <input type="date" name="FechaNac" required> <br>

            <br>Puesto<br>
            <select name="puesto" required>
                <option value="">Seleccione un puesto</option>
                <option value="1">Gerente</option>
                <option value="2">Auxiliar de cocina</option>
                <option value="3">Encargado de Limpieza</option>
                <option value="4">Mesero</option>
                <!-- Agregar más opciones según la base de datos -->
            </select> <br>

            <br>Horario<br>
            <select name="horario" required>
                <option value="">Seleccione un horario</option>
                <option value="1">Matutino</option>
                <option value="2">Vespertino</option>
                <!-- Agregar más opciones según la base de datos -->
            </select> <br>

            <br><br>
            <input type="submit" value="Enviar"> <input type="reset" value="Borrar">
        </form>
    </body>
    </html>


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
