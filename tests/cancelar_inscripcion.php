<?php
include '../../includes/header.php';         // Dos carpetas hacia arriba para incluir el header
include '../../config/db_connection.php';    // Dos carpetas hacia arriba para incluir la conexión a la base de datos
include '../controllers/EventController.php'; // Una carpeta hacia arriba para incluir el controlador

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
$evento_id = isset($_POST['evento_id']) ? intval($_POST['evento_id']) : 0; // Validar evento_id
$usuario_id = $_SESSION['usuario'];

// Obtener detalles del evento para mostrar al usuario
$sql_evento = "SELECT nombre_evento FROM eventos WHERE id = :evento_id";
$stmt_evento = $conn->prepare($sql_evento);
$stmt_evento->execute(['evento_id' => $evento_id]);
$evento = $stmt_evento->fetch();

if (!$evento) {
    echo "<div class='container mt-4'><div class='alert alert-danger' role='alert'>Evento no encontrado.</div></div>";
    include '../includes/footer.php';
    exit();
}

// Eliminar la inscripción del evento
$sql = "DELETE FROM inscripciones WHERE usuario_id = :usuario_id AND evento_id = :evento_id";
$stmt = $conn->prepare($sql);
try {
    $stmt->execute([
        'usuario_id' => $usuario_id,
        'evento_id' => $evento_id
    ]);

    // Registro de la cancelación en la tabla de logs
    $sql_log = "INSERT INTO logs (usuario_id, evento_id, accion, fecha) VALUES (:usuario_id, :evento_id, 'cancelacion', NOW())";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->execute([
        'usuario_id' => $usuario_id,
        'evento_id' => $evento_id
    ]);
    
    // Mensaje de éxito
    $mensaje = "Te has dado de baja del evento '" . htmlspecialchars($evento['nombre_evento']) . "' con éxito.";
    $alert_type = "success";
} catch (Exception $e) {
    // Manejo de errores
    error_log("Error al cancelar la inscripción: " . $e->getMessage()); // Registrar el error
    $mensaje = "Error al cancelar la inscripción.";
    $alert_type = "danger";
}
?>

<div class="container mt-4">
    <!-- Mostrar un mensaje de éxito o error -->
    <div class="alert alert-<?php echo $alert_type; ?>" role="alert">
        <?php echo $mensaje; ?>
    </div>
    <a href="eventos.php" class="btn btn-primary mt-4">Volver a Eventos</a>
</div>

<script src="../assets/js/scripts.js"></script> <!-- Asegúrate de que la ruta sea correcta -->
<script>
    // Redirigir automáticamente después de 3 segundos si la cancelación fue exitosa
    <?php if ($alert_type === 'success'): ?>
        setTimeout(function() {
            window.location.href = 'eventos.php';
        }, 3000); // Redirigir después de 3 segundos
    <?php endif; ?>
</script>
