<?php
    
    //declarations 
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $db_name = "northwind";

    //stablish connection
    $connection = new mysqli($server_name, $username, $password, $db_name);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }else{
    }    

?>