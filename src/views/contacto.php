<?php //contacto.php
include '../../includes/header.php';
include '../../config/db_connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensajeError = '';
$mensajeExito = '';

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim(htmlspecialchars($_POST['nombre']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mensaje = trim(htmlspecialchars($_POST['mensaje']));
    
    // Campo honeypot para evitar spam
    $honeypot = $_POST['website'];

    // Validación básica
    if (!empty($honeypot)) {
        // Honeypot activado: es spam
        $mensajeError = "Hubo un problema al enviar tu mensaje.";
    } elseif (empty($nombre) || empty($email) || empty($mensaje)) {
        $mensajeError = 'Por favor completa todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensajeError = 'El correo electrónico no es válido.';
    } elseif (strlen($nombre) > 50) {
        $mensajeError = 'El nombre no puede exceder los 50 caracteres.';
    } elseif (strlen($mensaje) > 500) {
        $mensajeError = 'El mensaje no puede exceder los 500 caracteres.';
    } else {
        // Inserción en la base de datos
        $sql = "INSERT INTO contactos (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute(['nombre' => $nombre, 'email' => $email, 'mensaje' => $mensaje])) {
            $mensajeExito = 'Gracias por contactarnos. Nos pondremos en contacto contigo pronto.';
        } else {
            $mensajeError = 'Hubo un problema al enviar tu mensaje. Intenta nuevamente más tarde.';
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Contáctanos</h2>
    
    <!-- Mostrar mensajes de éxito o error -->
    <?php if ($mensajeError): ?>
        <div class="alert alert-danger text-center"><?= $mensajeError; ?></div>
    <?php elseif ($mensajeExito): ?>
        <div class="alert alert-success text-center"><?= $mensajeExito; ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="contacto.php">
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required maxlength="50">
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="mensaje" class="form-label">Mensaje:</label>
                    <textarea name="mensaje" class="form-control" rows="4" required maxlength="500"></textarea>
                </div>
                <!-- Campo honeypot oculto -->
                <input type="text" name="website" class="d-none">
                
                <button type="submit" class="btn btn-primary w-100">Enviar</button>
            </form>
        </div>
    </div>
</div>