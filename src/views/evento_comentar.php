<?php
ob_start(); // Inicia el búfer de salida
include '../../config/db_connection.php';

// Iniciar la sesión solo si no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    die('Error: Debe iniciar sesión para comentar.');
}

// Verificar si el parámetro 'id' está presente en la URL y si se han enviado comentarios y valoraciones
if (isset($_GET['id']) && isset($_POST['comentario']) && isset($_POST['valoracion'])) {
    $evento_id = intval($_GET['id']); // Asegúrate de que sea un número
    $usuario_id = $_SESSION['usuario']['id']; // Obtener el id del usuario de la sesión
    $comentario = trim($_POST['comentario']); // Limpiar el comentario
    $valoracion = intval($_POST['valoracion']); // Asegúrate de que sea un número
    $fecha = date('Y-m-d H:i:s');

    // Validar que los campos no estén vacíos
    if (empty($comentario) || empty($valoracion)) {
        die('Error: Comentario y valoración son obligatorios.');
    }

    // Insertar el comentario en la base de datos
    $sql = "INSERT INTO comentarios (comentario, valoracion, fecha, usuario_id, evento_id) 
            VALUES (:comentario, :valoracion, :fecha, :usuario_id, :evento_id)";
    $stmt = $conn->prepare($sql);
    
    try {
        // Ejecutar la consulta con los parámetros correspondientes
        $stmt->execute([
            'comentario' => $comentario,
            'valoracion' => $valoracion,
            'fecha' => $fecha,
            'usuario_id' => $usuario_id,
            'evento_id' => $evento_id
        ]);

        // Comprobar si se insertó correctamente
        if ($stmt->rowCount() > 0) {
            // Redirigir a la página del evento después de comentar
            header("Location: evento_detalles.php?id=" . $evento_id);
            exit();
        } else {
            die('Error: No se pudo insertar el comentario.');
        }
    } catch (PDOException $e) {
        die('Error al insertar el comentario. Intenta nuevamente más tarde.');
    }
} else {
    echo "Error: Faltan datos para el comentario.";
}

ob_end_flush(); // Finaliza el búfer de salida
?>

