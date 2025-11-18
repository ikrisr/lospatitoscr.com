<?php 
    // Inicia o reanuda la sesión del usuario
    session_start();

    // Define una constante con el nombre del sitio (puede usarse en títulos, encabezados, etc.)
    define("SITIO", "Los Patitos CR");

    // Establece la zona horaria para todas las funciones de fecha/hora en el sitio
    date_default_timezone_set("America/Costa_Rica");
    
    // --- Cálculo automático de la URL base del proyecto ---
    $basePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', __DIR__ . '/../public/'));

    // Define la constante BASE_URL, quitando barras sobrantes al final y agregando una
    define('BASE_URL', rtrim($basePath, '/') . '/');
?>