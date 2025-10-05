<?php

    $server = "localhost";
    $username = "root";
    $password = "1234";
    $database = "sysweb";
    
    
 try {
    //Instancia de la conexion
    $pdo = new PDO("mysql:hodt=$server; dbname=$database; charset=utf8", $username, $password);
    //En caso de error lanzar exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Configurar el modo fetch para que devuelva datos es forma de array asociativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //echo "Conexión exitosa a la base de datos con PDO.";


 }catch (PDOException $e) {
    //Mostramos error
    die("Error de conexion: " . $e->getMessage());
 }

       
    


