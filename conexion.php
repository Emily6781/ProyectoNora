<?php
    $servername = "127.0.0.1";
    $database = "proyecto_nora";
    $username = "root";
    $password = "";

    //create conexiòn
    $conn = mysqli_connect($servername, $username, $password, $database);
    //Check connection
    if(!$conn)
    {
        die("connection failed: ". mysqli_connect_error());
    }
    //mysqli_close($conn);
?>
