<?php
session_start();

//  TEMPORAL MIENTRAS KRISTEL HACE EL LOGIN
$_SESSION['usuario'] = 1;
$_SESSION['nombre'] = "Kriiz";
$_SESSION['rol'] = "Usuario";

// --- AUTOLOAD MANUAL (sin Composer) ---
spl_autoload_register(function ($class) {

    $prefix = "App\\";

    if (strpos($class, $prefix) === 0) {
        $path = str_replace("App\\", "", $class);
        $path = str_replace("\\", "/", $path);
        require __DIR__ . "/../app/" . $path . ".php";
    }
});

// --- CARGAR RUTAS ---
$router = require __DIR__ . '/../config/rutas.php';

// --- DESPACHAR LA RUTA ---
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);
