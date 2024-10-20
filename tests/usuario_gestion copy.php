<?php // usuario_gestion.php
include '../../includes/header.php';
include '../../config/db_connection.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../views/login.php");
    exit;
}

// Verificar si el usuario es administrador
if ($_SESSION['usuario']['tipo_usuario'] != 'admin') {
    header('Location: no_access.php');
    exit();
}

// Deshabilitar usuario si se ha enviado una solicitud
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deshabilitar_id'])) {
    $deshabilitar_id = filter_var($_POST['deshabilitar_id'], FILTER_SANITIZE_NUMBER_INT);
    
    if ($deshabilitar_id) {
        // Actualizar el estado del usuario a 'deshabilitado'
        $sql = "UPDATE usuarios SET estado = 'deshabilitado' WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute(['id' => $deshabilitar_id])) {
            header('Location: usuario_gestion.php?success=1'); // Redirigir con éxito
            exit();
        } else {
            header('Location: usuario_gestion.php?error=1'); // Redirigir con error
            exit();
        }
    } else {
        header('Location: usuario_gestion.php?error=invalid_id');
        exit();
    }
}

// Consulta para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll();
?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success text-center">Usuario deshabilitado con éxito.</div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center">Hubo un problema al deshabilitar el usuario.</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] == 'invalid_id'): ?>
    <div class="alert alert-danger text-center">ID de usuario no válido.</div>
<?php endif; ?>

<div class="container mt-4">
    <h2 class="text-center">Gestión de Usuarios</h2>
    
    <!-- Tabla para mostrar los usuarios -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo de Usuario</th>
                <th>Estado</th> <!-- Nueva columna para estado -->
                <th>Acciones</th> <!-- Nueva columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['estado']); ?></td> <!-- Mostrar estado -->
                    <td>
                        <!-- Formulario para deshabilitar el usuario con confirmación -->
                        <?php if ($usuario['estado'] != 'deshabilitado'): ?>
                            <form method="POST" action="usuario_gestion.php" onsubmit="return confirm('¿Estás seguro de que deseas deshabilitar este usuario?');">
                                <input type="hidden" name="deshabilitar_id" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Deshabilitar</button>
                            </form>
                        <?php else: ?>
                            <span class="text-danger">Deshabilitado</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>