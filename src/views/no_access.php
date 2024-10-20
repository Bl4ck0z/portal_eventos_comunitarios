<?php //no_access.php

session_start(); // Iniciar la sesión
session_unset(); // Limpiar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Establecer un mensaje de confirmación
$_SESSION['message'] = "Has cerrado sesión con éxito.";

// Redirigir a la página principal
header('Location: index.php'); 
exit(); // Asegúrate de que la ejecución del script se detenga aquí
?>


