<?php
session_start();
require_once 'includes/funciones.php';

// Si no está logueado, fuera
if (!usuarioLogueado()) {
    redirigir('login.php');
}

$usuario_id = $_SESSION['usuario_id'];
$usuario = obtenerUsuario($usuario_id);

$errores = [];
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = limpiar($_POST['nombre']);
    $bio = limpiar($_POST['bio']);

    // Validaciones básicas
    if (empty($nombre)) {
        $errores[] = "El nombre no puede estar vacío.";
    }

    // Procesar avatar si se sube
    $avatarRuta = $usuario['avatar']; // mantener el actual por defecto
    if (!empty($_FILES['avatar']['name'])) {
        $carpeta = "uploads/avatars/";
        $nombreArchivo = "avatar_" . $usuario_id . "_" . time() . ".jpg";
        $destino = $carpeta . $nombreArchivo;

        // Validar tipo de archivo
        $tipo = mime_content_type($_FILES['avatar']['tmp_name']);
        if (!in_array($tipo, ['image/jpeg', 'image/png'])) {
            $errores[] = "El avatar debe ser JPG o PNG.";
        } else {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $destino);
            $avatarRuta = $destino;
        }
    }

    // Si no hay errores, actualizar
    if (empty($errores)) {
        if (actualizarPerfil($usuario_id, $nombre, $bio, $avatarRuta)) {
            $exito = true;
            // refrescar datos
            $usuario = obtenerUsuario($usuario_id);
        } else {
            $errores[] = "Error al actualizar el perfil.";
        }
    }
}

include 'includes/header.php';
?>

<h2>Editar Perfil</h2>

<?php if ($exito): ?>
    <?php
    redirigir('perfil.php');
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

<form action="" method="POST" enctype="multipart/form-data">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>

    <label>Biografía:</label>
    <textarea name="bio"><?php echo $usuario['bio']; ?></textarea>

    <label>Avatar:</label>
    <input type="file" name="avatar" accept="image/*">

    <button type="submit">Guardar cambios</button>
</form>

<?php include 'includes/footer.php'; ?>