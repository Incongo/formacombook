<?php
session_start();
require_once 'includes/funciones.php';

$errores = [];
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = limpiar($_POST['nombre']);
    $email = limpiar($_POST['email']);
    $password = $_POST['password'];

    if (empty($nombre) || empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }

    if (emailExiste($email)) {
        $errores[] = "El email ya está registrado.";
    }

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

<div class="ui container" style="max-width: 400px; margin-top: 60px;">
    <div class="ui centered card">
        <div class="content">
            <h2 class="ui header center aligned">Registro de usuario</h2>

            <?php if ($exito): ?>
                <div class="ui positive message">
                    <div class="header">Registro exitoso</div>
                    <p>Usuario creado correctamente. Redirigiendo...</p>
                </div>
                <?php
                redirigir('login.php');
                exit;
                ?>
            <?php endif; ?>

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
                    <label>Nombre</label>
                    <div class="ui left icon input">
                        <input type="text" name="nombre" required>
                        <i class="user icon"></i>
                    </div>
                </div>

                <div class="field">
                    <label>Email</label>
                    <div class="ui left icon input">
                        <input type="email" name="email" required>
                        <i class="envelope icon"></i>
                    </div>
                </div>

                <div class="field">
                    <label>Contraseña</label>
                    <div class="ui left icon input">
                        <input type="password" name="password" required>
                        <i class="lock icon"></i>
                    </div>
                </div>

                <button type="submit" class="ui primary button fluid">Registrarse</button>
            </form>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
