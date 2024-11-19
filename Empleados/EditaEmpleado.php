<?php
// Capturamos los datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellidop = $_POST['apellidop'];
$apellidom = $_POST['apellidom'];
$fechanac = $_POST['fechanac'];
$puestos = $_POST['puestos'];
$horario = $_POST['horario'];

// Incluimos el archivo de conexión
require('../conexion.php');

// Preparamos la consulta SQL con los nombres de las columnas correctamente delimitados
$modificar = "UPDATE empleados
              SET Nombre = ?,
                  ApellidoP = ?,
                  ApellidoM = ?,
                  FechaNac = ?,
                  Puestos_ID = ?,
                  Horario_ID = ?
              WHERE ID = ?";

// Preparamos la consulta para prevenir inyecciones SQL
if ($stmt = $conn->prepare($modificar)) {
    // Asociamos los parámetros
    $stmt->bind_param('ssssiii', $nombre, $apellidop, $apellidom, $fechanac, $puestos, $horario, $id);

    // Ejecutamos la consulta
    if ($stmt->execute()) {
        // Redirigimos al usuario si todo salió bien
        header("Location: ../Proyeccto.html");
        exit();
    } else {
        // Mostramos un error si algo salió mal
        echo "Error al modificar los datos: " . $stmt->error;
    }

    // Cerramos la consulta
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conn->error;
}

// Cerramos la conexión
$conn->close();
?>
