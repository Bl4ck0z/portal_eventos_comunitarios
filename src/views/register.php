<?php
// register.php
ob_start(); // Iniciar el búfer de salida
include '../../includes/header.php';
include '../../config/db_connection.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre'])); // Sanitizar y validar datos
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Validar la contraseña
    if (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error = "La contraseña debe contener al menos una letra mayúscula y un número.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        // Verificar si el correo ya está registrado
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            $error = "El correo ya está registrado.";
        } else {
            // Insertar el nuevo usuario
            $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute(['nombre' => $nombre, 'email' => $email, 'password' => $password_hashed])) {
                // Redirigir a la página de inicio de sesión con un mensaje de éxito
                header('Location: login.php?success=1'); 
                exit(); // Asegúrate de llamar a exit después de redirigir
            } else {
                $error = "Hubo un problema al registrar el usuario.";
            }
        }
    }
}

// Finalizar el búfer de salida y enviar la salida al navegador
ob_end_flush();
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Registrarse</h2>
    
    <!-- Mostrar mensajes de error, si los hay -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <div class="form-group mb-3">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
    
    <p class="text-center mt-3">¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
</div>
