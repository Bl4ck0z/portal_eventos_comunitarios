<?php // evento_detalles.php
include '../../includes/header.php';
include '../../config/db_connection.php';

// Verificar si no hay una sesión iniciada, para no duplicarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $evento_id = intval($_GET['id']); // Asegurarse de que sea un número entero

    // Consulta para obtener los detalles del evento
    $sql = "SELECT * FROM eventos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $evento_id]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener como un array asociativo

    // Verificar si se encontró el evento
    if ($evento) {
        ?>
        <div class="container mt-4">
            <h2><?php echo htmlspecialchars($evento['titulo']); ?></h2>
            <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($evento['descripcion'])); ?></p>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($evento['fecha']); ?></p>
            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['ubicacion']); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($evento['categoria']); ?></p>
            <p><strong>Cupo máximo:</strong> <?php echo htmlspecialchars($evento['cupo']); ?></p>

            <!-- Formulario de comentarios y valoraciones -->
            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="mt-5">
                    <h3>Deja tu comentario y valoración</h3>
                    <?php if (isset($_GET['comentario'])): ?>
                        <div class="alert alert-success">Comentario enviado exitosamente.</div>
                    <?php endif; ?>
                    <form method="POST" action="evento_comentar.php?id=<?php echo $evento_id; ?>">
                        <div class="form-group mb-3">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="valoracion">Valoración (1 a 5)</label>
                            <select class="form-control" id="valoracion" name="valoracion" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="1">1 estrella</option>
                                <option value="2">2 estrellas</option>
                                <option value="3">3 estrellas</option>
                                <option value="4">4 estrellas</option>
                                <option value="5">5 estrellas</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar comentario</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Inicia sesión para dejar un comentario.</p>
            <?php endif; ?>

            <!-- Mostrar comentarios existentes -->
            <h3 class="mt-5">Comentarios</h3>
            <?php
            // Consulta para obtener los comentarios
            $sql_comentarios = "SELECT c.comentario, c.valoracion, c.fecha, u.nombre
                                FROM comentarios c
                                JOIN usuarios u ON c.usuario_id = u.id
                                WHERE c.evento_id = :evento_id
                                ORDER BY c.fecha DESC";
            $stmt_comentarios = $conn->prepare($sql_comentarios);
            $stmt_comentarios->execute(['evento_id' => $evento_id]);
            $comentarios = $stmt_comentarios->fetchAll(PDO::FETCH_ASSOC); // Obtener como un array asociativo

            if ($comentarios) {
                foreach ($comentarios as $comentario) {
                    echo "<div class='comentario mt-3'>";
                    echo "<p><strong>" . htmlspecialchars($comentario['nombre']) . "</strong> ";
                    echo "<span>(" . htmlspecialchars($comentario['valoracion']) . " estrellas)</span></p>";
                    echo "<p>" . nl2br(htmlspecialchars($comentario['comentario'])) . "</p>";
                    echo "<small>" . htmlspecialchars($comentario['fecha']) . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay comentarios para este evento.</p>";
            }
            ?>
        </div>
        <?php
    } else {
        echo "<div class='container mt-4'><p class='alert alert-warning'>Evento no encontrado. <a href='eventos_lista.php'>Regresar a la lista de eventos.</a></p></div>";
    }
} else {
    echo "<div class='container mt-4'><p class='alert alert-warning'>ID de evento no proporcionado.</p></div>";
}
?>