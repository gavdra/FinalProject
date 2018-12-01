<?php
    $conn = new mysqli("localhost","grd2747", "polandescape", "grd2747");
    // database link for connection to database
    if ($conn->connect_error){
        echo "connection failed: ".mysqli_connect_error();
        die();
    }
?>
