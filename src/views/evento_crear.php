<?php // evento_crear.php
include '../../includes/header.php';
include '../../config/db_connection.php';

// Verificar si no hay una sesión iniciada, para no duplicarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_usuario'] != 'admin') {
    header('Location: no_access.php');
    exit();
}

$mensajeExito = '';
$mensajeError = '';

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim(htmlspecialchars($_POST['titulo']));
    $descripcion = trim(htmlspecialchars($_POST['descripcion']));
    $fecha = $_POST['fecha'];
    $ubicacion = trim(htmlspecialchars($_POST['ubicacion']));
    $categoria = trim(htmlspecialchars($_POST['categoria']));
    $cupo = intval($_POST['cupo']); // Asegúrate de que sea un número

    // Validación básica
    if (empty($titulo) || empty($descripcion) || empty($fecha) || empty($ubicacion) || empty($categoria) || empty($cupo)) {
        $mensajeError = 'Todos los campos son obligatorios.';
    } else {
        $sql = "INSERT INTO eventos (titulo, descripcion, fecha, ubicacion, categoria, cupo, admin_id) 
                VALUES (:titulo, :descripcion, :fecha, :ubicacion, :categoria, :cupo, :admin_id)";
        
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'fecha' => $fecha,
                'ubicacion' => $ubicacion,
                'categoria' => $categoria,
                'cupo' => $cupo,
                'admin_id' => $_SESSION['usuario']['id'] // Asegúrate de que sea el ID del admin
            ]);

            $mensajeExito = "Evento creado exitosamente.";
            // Redirigir o limpiar el formulario si es necesario
            // header("Location: evento_lista.php"); // Descomenta si quieres redirigir a otra página
            // exit();
        } catch (PDOException $e) {
            $mensajeError = "Error al crear el evento: " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4">
    <h2>Crear Evento</h2>

    <!-- Mostrar mensajes de éxito o error -->
    <?php if ($mensajeError): ?>
        <div class="alert alert-danger"><?= $mensajeError; ?></div>
    <?php elseif ($mensajeExito): ?>
        <div class="alert alert-success"><?= $mensajeExito; ?></div>
    <?php endif; ?>

    <form method="POST" action="evento_crear.php">
        <div class="form-group mb-3">
            <label for="titulo">Título del Evento</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="form-group mb-3">
            <label for="ubicacion">Ubicación</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
        </div>
        <div class="form-group mb-3">
            <label for="categoria">Categoría</label>
            <input type="text" class="form-control" id="categoria" name="categoria" required>
        </div>
        <div class="form-group mb-3">
            <label for="cupo">Cupo máximo de asistentes</label>
            <input type="number" class="form-control" id="cupo" name="cupo" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Crear Evento</button>
    </form>
</div>