<?php // logout.php
session_start();
session_destroy();

// Mensaje de confirmación (opcional)
$_SESSION['message'] = "Has cerrado sesión con éxito.";
header('Location: index.php');
exit();
?>
