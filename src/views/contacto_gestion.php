<?php // contacto_gestion.php
// Incluir la conexión a la base de datos y el encabezado
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

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']['tipo_usuario']) || $_SESSION['usuario']['tipo_usuario'] != 'admin') {
    header('Location: no_access.php');
    exit();
}

$mensajeExito = '';
$mensajeError = '';

// Eliminar mensaje si se ha enviado una solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_id'])) {
    $eliminar_id = $_POST['eliminar_id'];

    // Verificar si el ID no está vacío
    if (!empty($eliminar_id)) {
        // Consulta para eliminar el mensaje
        $sql = "DELETE FROM contactos WHERE id = :id";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute(['id' => $eliminar_id])) {
            $mensajeExito = "Mensaje eliminado con éxito.";
        } else {
            $mensajeError = "Error al eliminar el mensaje. Intenta nuevamente.";
        }
    } else {
        $mensajeError = "ID inválido. No se puede eliminar.";
    }
}

// Consulta para obtener los mensajes de contacto
$sql = "SELECT * FROM contactos ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$contactos = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2 class="text-center">Mensajes de Contacto</h2>

    <!-- Mostrar mensajes de éxito o error -->
    <?php if ($mensajeExito): ?>
        <div class="alert alert-success text-center"><?= $mensajeExito; ?></div>
    <?php elseif ($mensajeError): ?>
        <div class="alert alert-danger text-center"><?= $mensajeError; ?></div>
    <?php endif; ?>

    <!-- Tabla para mostrar los mensajes de contacto -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contactos as $contacto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contacto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($contacto['email']); ?></td>
                    <td><?php echo htmlspecialchars($contacto['mensaje']); ?></td>
                    <td><?php echo htmlspecialchars($contacto['fecha']); ?></td>
                    <td>
                        <!-- Formulario para eliminar el mensaje -->
                        <form method="POST" action="contacto_gestion.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este mensaje?');">
                            <input type="hidden" name="eliminar_id" value="<?php echo $contacto['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>