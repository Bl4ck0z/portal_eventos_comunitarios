<?php // evento_inscribirse.php
include '../../includes/header.php';
include '../../config/db_connection.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Redirigir a la página de inicio de sesión si no hay sesión
    header("Location: ../views/login.php");
    exit;
}

// Obtener el ID del evento
$evento_id = isset($_POST['evento_id']) ? intval($_POST['evento_id']) : null; // Asegurarse de que sea un número

if ($evento_id === null) {
    echo "<div class='alert alert-danger' role='alert'>ID de evento no válido.</div>";
    exit;
}

$usuario_id = $_SESSION['usuario']['id']; // Obtener solo el ID del usuario

// Verificar si ya está inscrito
$sql = "SELECT * FROM inscripciones WHERE usuario_id = :usuario_id AND evento_id = :evento_id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'usuario_id' => $usuario_id,
    'evento_id' => $evento_id
]);

$inscripcion = $stmt->fetch();

?>

<div class="container mt-4">
    <?php if ($inscripcion): ?>
        <!-- Mostrar un mensaje de alerta si ya está inscrito -->
        <div class="alert alert-warning" role="alert">
            Ya estás inscrito en este evento.
        </div>
    <?php else: ?>
        <?php
        // Insertar la inscripción en la base de datos
        $sql = "INSERT INTO inscripciones (usuario_id, evento_id) VALUES (:usuario_id, :evento_id)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([
            'usuario_id' => $usuario_id,
            'evento_id' => $evento_id
        ])) {
            // Mostrar un mensaje de éxito
            echo "<div class='alert alert-success' role='alert'>
                    Te has inscrito en el evento con éxito.
                  </div>";
        } else {
            // Manejo de error al insertar
            echo "<div class='alert alert-danger' role='alert'>
                    Error al inscribirte en el evento. Por favor, intenta de nuevo más tarde.
                  </div>";
        }
        ?>
    <?php endif; ?>
    <a href="evento.php" class="btn btn-primary mt-4">Volver a Eventos</a>
</div>