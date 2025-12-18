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

<div class="ui container" style="max-width: 400px; margin-top: 60px;">
    <div class="ui centered card">
        <div class="content">
            <h2 class="ui header center aligned">Iniciar sesión</h2>

            <?php if (!empty($errores)): ?>
                <div class="ui negative message">
                    <div class="header">Error</div>
                    <ul class="list">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="ui form" action="" method="POST">
                <div class="field">
                    <label>Email</label>
                    <div class="ui left icon input">
                        <input type="email" name="email" required>
                        <i class="user icon"></i>
                    </div>
                </div>

                <div class="field">
                    <label>Contraseña</label>
                    <div class="ui left icon input">
                        <input type="password" name="password" required>
                        <i class="lock icon"></i>
                    </div>
                </div>

                <button type="submit" class="ui primary button fluid">Entrar</button>
            </form>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
