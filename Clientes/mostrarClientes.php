<?php
    require('../conexion.php');
    $sql = "SELECT * FROM clientes";
    $datos = mysqli_query($conn, $sql);
    if(!$datos)
    {
        header("location: Proyeccto.html");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Registrados</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de visita</th>
                <th>Edad</th>
                <th>Comentario</th>
                <th>Acciones</th>
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
                         "<td><a href=''>Editar</a></td>". 
                         "<td><a href=''>Eliminar</a></td>".
                         "</tr>";
                }
                
             mysqli_close($conn);
            ?>

    </table>
    <button class="btn-regresar" onclick="window.history.back();">Regresar</button>
</body>
</html>
