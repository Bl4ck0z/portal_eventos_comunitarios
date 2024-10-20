<?php // evento_cancelar.php
include '../../includes/header.php';
include '../../config/db_connection.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Solo iniciar la sesión si no ha sido iniciada
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Obtener el ID del evento y del usuario
$evento_id = $_POST['evento_id'] ?? null; // Asegúrate de que exista
$usuario_id = $_SESSION['usuario']['id'] ?? null; // Acceder al id del usuario correctamente

$mensaje = '';
// Validar que el ID del evento no esté vacío
if ($evento_id && is_numeric($evento_id)) {
    try {
        // Eliminar la inscripción del evento
        $sql = "DELETE FROM inscripciones WHERE usuario_id = :usuario_id AND evento_id = :evento_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'usuario_id' => $usuario_id,
            'evento_id' => $evento_id
        ]);

        // Verificar si se eliminó algún registro
        if ($stmt->rowCount() > 0) {
            $mensaje = 'Te has dado de baja del evento con éxito.';
        } else {
            $mensaje = 'No pudimos encontrar tu inscripción en este evento.';
        }
    } catch (Exception $e) {
        $mensaje = 'Hubo un problema al cancelar tu inscripción. Intenta nuevamente más tarde.';
    }
} else {
    $mensaje = 'ID de evento inválido.';
}
?>

<div class="container mt-4">
    <?php if ($mensaje): ?>
        <!-- Mostrar el mensaje de éxito o error -->
        <div class="alert <?= strpos($mensaje, 'éxito') !== false ? 'alert-success' : 'alert-danger' ?>" role="alert">
            <?= $mensaje; ?>
        </div>
    <?php endif; ?>
    <a href="evento.php" class="btn btn-primary mt-4">Volver a Eventos</a>
</div>

