<?php // login.php
ob_start(); // Iniciar el buffer de salida
include '../../includes/header.php';
include '../../config/db_connection.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si ya ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Manejar el envío del formulario
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validar el formato del correo
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de correo electrónico no válido.";
    } else {
        // Consultar usuario por correo electrónico
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe
        if ($usuario) {
            // Verificar estado del usuario
            if ($usuario['estado'] === 'deshabilitado') {
                $error = "Tu cuenta ha sido deshabilitada. Contacta a un administrador.";
            } else {
                // Verificar contraseña
                if (password_verify($password, $usuario['password'])) {
                    // Guardar datos en sesión
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                        'nombre' => $usuario['nombre'],
                        'tipo_usuario' => $usuario['tipo_usuario']
                    ];
                    // Redirigir a la página principal después de iniciar sesión
                    header('Location: index.php');
                    exit();
                } else {
                    $error = "Contraseña incorrecta.";
                }
            }
        } else {
            $error = "Correo electrónico no encontrado.";
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    <!-- Mostrar mensajes de error -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Formulario de inicio de sesión -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="login.php">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>
            <p class="mt-3 text-center">¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>
</div>

<?php
ob_end_flush(); // Enviar el contenido del buffer al navegador
?>
