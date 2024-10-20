<?php 
// usuario_gestion.php

// Iniciar la sesión al principio
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no ha sido iniciada
}

include '../../config/db_connection.php';

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // No redirigir, solo puedes mostrar un mensaje o manejarlo de otra forma
    echo "Por favor, inicia sesión.";
    exit;
}

// Verificar si el usuario es administrador
if ($_SESSION['usuario']['tipo_usuario'] != 'admin') {
    // No redirigir, solo puedes mostrar un mensaje o manejarlo de otra forma
    echo "Acceso denegado.";
    exit();
}

// Inicializar mensajes de éxito y error
$message = '';
$errorMessage = '';

// Deshabilitar usuario si se ha enviado una solicitud de deshabilitación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deshabilitar_id'])) {
    $deshabilitar_id = filter_var($_POST['deshabilitar_id'], FILTER_SANITIZE_NUMBER_INT);
    
    if ($deshabilitar_id) {
        // Actualizar el estado del usuario a 'deshabilitado'
        $sql = "UPDATE usuarios SET estado = 'deshabilitado' WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute(['id' => $deshabilitar_id])) {
            $message = 'Usuario deshabilitado con éxito.'; // Mensaje de éxito
        } else {
            $errorMessage = 'Hubo un problema al procesar la solicitud.'; // Mensaje de error
        }
    } else {
        $errorMessage = 'ID de usuario no válido.'; // Mensaje de error para ID no válido
    }
}

// Consulta para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll();

include '../../includes/header.php'; // Asegúrate de incluir el header aquí, después de las cabeceras
?>

<div class="container mt-4">
    <h2 class="text-center">Gestión de Usuarios</h2>

    <?php if ($message): ?>
        <div class="alert alert-success text-center">
            <?php echo $message; ?>
        </div>
    <?php elseif ($errorMessage): ?>
        <div class="alert alert-danger text-center">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <!-- Tabla para mostrar los usuarios -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
                    <td>
                        <span class="<?php echo $usuario['estado'] == 'deshabilitado' ? 'text-danger' : 'text-success'; ?>">
                            <?php echo htmlspecialchars(ucfirst($usuario['estado'])); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($usuario['estado'] != 'deshabilitado'): ?>
                            <form method="POST" action="usuario_gestion.php" onsubmit="return confirm('¿Estás seguro de que deseas deshabilitar este usuario?');">
                                <input type="hidden" name="deshabilitar_id" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Deshabilitar</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="usuario_habilitar.php" onsubmit="return confirm('¿Estás seguro de que deseas habilitar este usuario?');">
                                <input type="hidden" name="habilitar_id" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" class="btn btn-success btn-sm">Habilitar</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



