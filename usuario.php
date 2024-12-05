<?php

// Importar la conexión
// require 'includes/config/database.php';
require 'includes/app.php';
$db = conectarDB();


//Crear un email y password
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_DEFAULT);



//query para crear el usuario
$query= "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash')";

// echo $query;


//agregar a la base de datos
mysqli_query($db, $query);