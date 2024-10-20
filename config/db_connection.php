
<?php
require 'config.php';

try {
    // Crear conexión
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    
    // Configurar el modo de error de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Mensaje opcional para confirmar la conexión
    // echo "Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    // Manejo de errores más detallado
    error_log("Error en la conexión: " . $e->getMessage()); // Loguear el error en el archivo de log
    echo "Hubo un problema al conectar a la base de datos."; // Mensaje genérico para el usuario
    exit();
}
?>