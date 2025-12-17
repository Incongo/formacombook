<?php
session_start();
require_once 'includes/funciones.php';

$errores = [];

// Si ya está logueado, lo mandamos a la zona privada
if (usuarioLogueado()) {
    redirigir('index.php');
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = limpiar($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    // Si no hay errores, intentamos loguear
    if (empty($errores)) {

        $usuario = obtenerUsuarioPorEmail($email);

        if ($usuario && password_verify($password, $usuario['password'])) {

            // Crear sesión
            $_SESSION['usuario_id'] = $usuario['usuarios_id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];

            redirigir('index.php');
        } else {
            $errores[] = "Credenciales incorrectas.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="auth-container">
    <div class="login-card">
        <h1>Iniciar sesión</h1>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
