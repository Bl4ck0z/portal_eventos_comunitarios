<?php // evento_lista.php

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

// Obtener el ID del usuario
$usuario_id = $_SESSION['usuario']['id']; // Asegurarse de que solo se obtiene el ID del usuario

// Consulta para obtener los eventos en los que el usuario está inscrito
$sql = "SELECT eventos.* FROM eventos 
        INNER JOIN inscripciones ON eventos.id = inscripciones.evento_id 
        WHERE inscripciones.usuario_id = :usuario_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);
$eventos = $stmt->fetchAll();

// Comprobar si el usuario tiene eventos inscritos
?>

<div class="container mt-4">
    <h2 class="text-center">Mis Eventos</h2>

    <?php if (count($eventos) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Ubicación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($evento['ubicacion']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            No estás inscrito en ningún evento.
        </div>
    <?php endif; ?>
</div>