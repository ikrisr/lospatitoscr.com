<?php 
// Datos de conexión a la base de datos
$host = 'localhost';        // Dirección del servidor donde está la base de datos
$db   = 'lospatitoscr';      // Nombre de la base de datos
$user = 'root';   // Usuario con permisos sobre la base de datos
$pass = 'secret';           // Contraseña del usuario de la base de datos

try {
    // Se crea una instancia de PDO (PHP Data Object) para conectar con MySQL
    // "charset=utf8mb4" asegura que se puedan usar caracteres especiales y emojis sin problemas
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    // Configura el modo de errores de PDO para que lance excepciones (más fácil de depurar)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Si ocurre un error al conectar, se muestra un mensaje y se detiene la ejecución del script
    die("Error de conexión: " . $e->getMessage());
}
?>