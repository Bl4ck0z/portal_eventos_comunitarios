<?php // usuario_desabilitar.php
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

// Deshabilitar usuario si se ha enviado una solicitud de deshabilitación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deshabilitar_id'])) {
    $deshabilitar_id = filter_var($_POST['deshabilitar_id'], FILTER_SANITIZE_NUMBER_INT);
    
    if ($deshabilitar_id) {
        // Actualizar el estado del usuario a deshabilitado
        $sql = "UPDATE usuarios SET estado = 'deshabilitado' WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute(['id' => $deshabilitar_id])) {
            header('Location: usuario_desabilitar.php?success=1'); // Redirigir con éxito
            exit();
        } else {
            header('Location: usuario_desabilitar.php?error=1'); // Redirigir con error
            exit();
        }
    } else {
        header('Location: usuario_desabilitar.php?error=invalid_id');
        exit();
    }
}

// Consulta para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2 class="text-center">Gestión de Usuarios</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success text-center" id="success-message">Usuario deshabilitado con éxito.</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center" id="error-message">Hubo un problema al deshabilitar el usuario.</div>
    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'invalid_id'): ?>
        <div class="alert alert-danger text-center" id="invalid-id-message">ID de usuario no válido.</div>
    <?php endif; ?>
    
    <!-- Agregar script para ocultar mensajes después de 5 segundos -->
    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            var errorMessage = document.getElementById('error-message');
            var invalidIdMessage = document.getElementById('invalid-id-message');
            
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
            if (invalidIdMessage) {
                invalidIdMessage.style.display = 'none';
            }
        }, 5000); // 5000 milisegundos = 5 segundos
    </script>

    <!-- Tabla para mostrar los usuarios -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo de Usuario</th>
                <th>Estado</th> <!-- Nueva columna para estado -->
                <th>Acciones</th>
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
                        <?php if ($usuario['estado'] != 'deshabilitado'): ?>
                            <form method="POST" action="usuario_desabilitar.php" onsubmit="return confirm('¿Estás seguro de que deseas deshabilitar este usuario?');">
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

