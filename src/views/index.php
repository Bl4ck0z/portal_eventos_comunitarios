<?php
// index.php
session_start(); // Iniciar la sesi��n al principio del script

include '../../includes/header.php';
include '../../config/db_connection.php';
include '../controllers/EventController.php';

$eventController = new EventController($conn);
$eventos = $eventController->getRecentEvents(12); // Cambiar a la cantidad deseada
?>

<div class="jumbotron text-center text-white bg-dark" style="background-image: url('../../assets/images/event_background.jpg'); background-size: cover; background-position: center;">
    <div class="p-4">
        <h1 class="display-4" style="color: black;">Bienvenido al Portal de Eventos Comunitarios</h1>
        <p class="lead" style="color: black;">Descubre y participa en los eventos que tenemos para ti. �0�3Explora los m��s recientes a continuaci��n!</p>
        <a href="#eventos" class="btn btn-primary btn-lg">Ver eventos destacados</a>
    </div>
</div>

<!-- Secci��n de Eventos -->
<section id="eventos" class="my-5">
    <h2 class="text-center mb-4">Eventos Destacados</h2>
    <div class="row">
        <?php if (!empty($eventos)): ?>
            <?php foreach ($eventos as $evento): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 event-card">
                        <img src="../../assets/images/event_placeholder.jpg" class="card-img-top rounded" alt="Imagen del evento">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($evento['titulo']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($evento['descripcion'], 0, 100)) . "..."; ?></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> <?= htmlspecialchars($evento['fecha']); ?></p>
                            <p><i class="fas fa-map-marker-alt"></i> <strong>Ubicaci��n:</strong> <?= htmlspecialchars($evento['ubicacion']); ?></p>
                            <a href="evento_detalles.php?id=<?= htmlspecialchars($evento['id']); ?>" class="btn btn-outline-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    No hay eventos disponibles en este momento.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="../../assets/js/script.js"></script>

<!-- Mostrar mensaje de confirmaci��n si existe -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success text-center">
        <?php echo $_SESSION['message']; ?>
        <?php unset($_SESSION['message']); // Eliminar mensaje despu��s de mostrar ?>
    </div>
<?php endif; ?>

<?php
include '../../includes/footer.php';
?>
