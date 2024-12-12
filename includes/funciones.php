<?php

// require 'app.php';
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate($nombre, $inicio = false){
    include_once TEMPLATES_URL ."/$nombre.php";
}

// function estaAutenticado() : bool{
//     session_start();

//     $auth = $_SESSION['login'];

//     if($auth){
//         return true;
//     }else{  
//         return false;
//     }
// }
function estaAutenticado() : bool {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;

    return $auth;
}

function debuguear($variable){
    
    var_dump($variable);
    exit;
    
}

//Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido
function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}