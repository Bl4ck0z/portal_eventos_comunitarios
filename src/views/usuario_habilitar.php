<?php 
// usuario_habilitar.php
include '../../includes/header.php';
include '../../config/db_connection.php';

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Acceso denegado. Por favor, inicia sesión.";
    exit;
}

// Verificar si el usuario es administrador
if ($_SESSION['usuario']['tipo_usuario'] != 'admin') {
    echo "Acceso denegado. No tienes permisos suficientes.";
    exit();
}

// Habilitar usuario si se ha enviado una solicitud
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['habilitar_id'])) {
    $habilitar_id = filter_var($_POST['habilitar_id'], FILTER_SANITIZE_NUMBER_INT);
    
    if ($habilitar_id) {
        // Actualizar el estado del usuario a 'habilitado'
        $sql = "UPDATE usuarios SET estado = 'habilitado' WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute(['id' => $habilitar_id])) {
            // Mostrar mensaje de éxito
            $successMessage = "Usuario habilitado con éxito.";
        } else {
            // Mostrar mensaje de error
            $errorMessage = "Hubo un problema al habilitar el usuario.";
        }
    } else {
        // Mostrar mensaje de error por ID no válido
        $errorMessage = "ID de usuario no válido.";
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
    
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success text-center" id="success-message"><?php echo $successMessage; ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="alert alert-danger text-center" id="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Agregar script para ocultar mensajes después de 5 segundos -->
    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            var errorMessage = document.getElementById('error-message');
            
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
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
                <th>Estado</th>
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
                    <td><?php echo htmlspecialchars(ucfirst($usuario['estado'])); ?></td>
                    <td>
                        <?php if ($usuario['estado'] == 'deshabilitado'): ?>
                            <form method="POST" action="usuario_habilitar.php" onsubmit="return confirm('¿Estás seguro de que deseas habilitar este usuario?');">
                                <input type="hidden" name="habilitar_id" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" class="btn btn-success btn-sm">Habilitar</button>
                            </form>
                        <?php elseif ($usuario['estado'] == 'habilitado'): ?>
                            <form method="POST" action="usuario_desabilitar.php" onsubmit="return confirm('¿Estás seguro de que deseas deshabilitar este usuario?');">
                                <input type="hidden" name="deshabilitar_id" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Deshabilitar</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

