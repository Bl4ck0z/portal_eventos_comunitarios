<?php // evento_eliminar.php

include '../../includes/header.php';
include '../../config/db_connection.php'; 

// Verificar si no hay una sesión iniciada, para no duplicarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Location: no_access.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y sanitizar el ID
    $id = intval($_POST['id']);

    // Verificar que el ID no sea nulo
    if ($id > 0) {
        // Consulta para verificar si el evento existe
        $sql_check = "SELECT COUNT(*) FROM eventos WHERE id = :id";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute(['id' => $id]);
        $event_exists = $stmt_check->fetchColumn();

        if ($event_exists) {
            // Proceder a eliminar el evento
            $sql = "DELETE FROM eventos WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $id]);

            // Mensaje de éxito
            $_SESSION['mensaje'] = "Evento eliminado exitosamente.";
        } else {
            // Mensaje de error si el evento no existe
            $_SESSION['mensaje'] = "No se encontró el evento para eliminar.";
        }
    } else {
        // Mensaje de error si el ID es inválido
        $_SESSION['mensaje'] = "ID de evento no válido.";
    }

    header('Location: evento_gestion.php');
    exit();
}

// Mostrar mensaje después de la redirección (opcional)
if (isset($_SESSION['mensaje'])) {
    echo "<div class='alert alert-info'>{$_SESSION['mensaje']}</div>";
    unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
}
?>