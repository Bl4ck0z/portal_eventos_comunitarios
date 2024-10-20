<?php // evento_gestion.php
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
if ($_SESSION['usuario']['tipo_usuario'] != 'admin') { // Cambiado aquí
    header('Location: no_access.php');
    exit();
}

// Inicializar mensaje de error o éxito
$mensaje = '';

// Eliminar evento si se ha enviado una solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_id'])) {
    $eliminar_id = intval($_POST['eliminar_id']); // Asegurarse de que sea un número entero

    if ($eliminar_id > 0) {
        // Comprobar si el evento existe antes de eliminarlo
        $sql_check = "SELECT COUNT(*) FROM eventos WHERE id = :id";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute(['id' => $eliminar_id]);
        $event_exists = $stmt_check->fetchColumn();

        if ($event_exists) {
            // Proceder a eliminar el evento
            $sql = "DELETE FROM eventos WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $eliminar_id]);
            $mensaje = "Evento eliminado con éxito.";
        } else {
            $mensaje = "Error: No se encontró el evento para eliminar.";
        }
    } else {
        $mensaje = "Error: ID de evento no válido.";
    }
}

// Consulta para obtener todos los eventos
$sql = "SELECT * FROM eventos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$eventos = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2 class="text-center">Gestión de Eventos</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <a href="evento_crear.php" class="btn btn-success mb-4">Crear Evento</a>

    <!-- Tabla para mostrar los eventos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th>Acciones</th> <!-- Nueva columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventos as $evento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($evento['ubicacion']); ?></td>
                    <td>
                        <!-- Formulario para eliminar el evento con confirmación -->
                        <form method="POST" action="evento_gestion.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento?');">
                            <input type="hidden" name="eliminar_id" value="<?php echo $evento['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>