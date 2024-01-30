<?php

//Configurar datos de acceso a la base de datos
$servidor = "localhost";
$db = "proyectosgt";
$username = "root";
$password = "";

//Validación
try {
    //Crear conexion a SQL
    $conn = new PDO("mysql:host=$servidor;dbname=$db;charset=utf8mb4", $username, $password);

    //Mostrar mensaje si la conexion es la correcta
    if ($conn) {
        //echo "Conectado a la DB correctamente";
    }


} catch (PDOException $e) {
    //Si hay error en la conexion, mostrarlo
    echo $e->getMessage();
}

