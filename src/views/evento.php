<?php // evento.php
include '../../includes/header.php';
include '../../config/db_connection.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobar si el usuario ha iniciado sesión
$usuario_logueado = isset($_SESSION['usuario']);
$usuario_id = $_SESSION['usuario']['id'] ?? null; // Acceder al id del usuario si 'usuario' es un arreglo

// Inicializar variable de búsqueda
$busqueda = '';

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar'])) {
    $busqueda = htmlspecialchars(trim($_POST['buscar'])); // Usar htmlspecialchars para sanitizar
}

// Obtener eventos filtrados si hay búsqueda
$sql = "SELECT * FROM eventos WHERE titulo LIKE :busqueda OR descripcion LIKE :busqueda";
$stmt = $conn->prepare($sql);
$stmt->execute(['busqueda' => '%' . $busqueda . '%']);
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Eventos Disponibles</h2>

    <!-- Formulario de búsqueda -->
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="buscar" placeholder="Buscar eventos" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de eventos -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($eventos): ?>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($evento['ubicacion']); ?></td>
                        <td>
                            <?php if ($usuario_logueado): ?>
                                <?php
                                // Verificar inscripción del usuario
                                $sql = "SELECT * FROM inscripciones WHERE usuario_id = :usuario_id AND evento_id = :evento_id";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([
                                    'usuario_id' => $usuario_id,
                                    'evento_id' => $evento['id']
                                ]);
                                $inscrito = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?php if ($inscrito): ?>
                                    <!-- Botón para cancelar inscripción -->
                                    <form method="POST" action="evento_cancelar.php" class="d-inline">
                                        <input type="hidden" name="evento_id" value="<?php echo $evento['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Cancelar Inscripción</button>
                                    </form>
                                <?php else: ?>
                                    <!-- Botón para inscribirse -->
                                    <form method="POST" action="evento_inscribirse.php" class="d-inline">
                                        <input type="hidden" name="evento_id" value="<?php echo $evento['id']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Inscribirse</button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-danger mb-0">Inicia sesión para inscribirte.</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay eventos disponibles en este momento.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

