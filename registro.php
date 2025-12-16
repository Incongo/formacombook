<?php
session_start();
require_once 'includes/funciones.php';

$errores = [];
$exito = false;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = limpiar($_POST['nombre']);
    $email = limpiar($_POST['email']);
    $password = $_POST['password'];

    // Validaciones
    if (empty($nombre) || empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    // Comprobar si el email ya existe
    if (emailExiste($email)) {
        $errores[] = "El email ya está registrado.";
    }

    // Si no hay errores, registrar usuario
    if (empty($errores)) {
        if (registrarUsuario($nombre, $email, $password)) {
            $exito = true;
        } else {
            $errores[] = "Error al registrar el usuario.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Registro de usuario</h2>

<?php if ($exito): ?>
    <?php
    redirigir('login.php');
    exit;
    ?>
<?php endif; ?>

<?php if (!empty($errores)): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="" method="POST">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <button type="submit">Registrarse</button>
</form>

<?php include 'includes/footer.php'; ?>