<?php
session_start();
require_once 'includes/funciones.php';

// Solo usuarios logueados
if (!usuarioLogueado()) {
    redirigir('login.php');
}

$errores = [];
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = limpiar($_POST['titulo']);
    $descripcion = limpiar($_POST['descripcion']);
    $usuario_id = $_SESSION['usuario_id'];

    // Validaciones básicas
    if (empty($titulo)) {
        $errores[] = "El título es obligatorio.";
    }

    if (empty($_FILES['foto']['name'])) {
        $errores[] = "Debes seleccionar una imagen.";
    }

    // Procesar imagen
    if (empty($errores)) {

        $carpeta = "uploads/fotos/";
        $nombreArchivo = "foto_" . $usuario_id . "_" . time() . ".jpg";
        $destino = $carpeta . $nombreArchivo;

        // Validar tipo MIME
        $tipo = mime_content_type($_FILES['foto']['tmp_name']);
        if (!in_array($tipo, ['image/jpeg', 'image/png'])) {
            $errores[] = "La imagen debe ser JPG o PNG.";
        } else {
            move_uploaded_file($_FILES['foto']['tmp_name'], $destino);

            // Registrar en BD
            if (registrarFoto($usuario_id, $titulo, $descripcion, $destino)) {
                $exito = true;
            } else {
                $errores[] = "Error al guardar la foto en la base de datos.";
            }
        }
    }
}

include 'includes/header.php';
?>

<h2>Subir Foto</h2>

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
    <label>Título:</label>
    <input type="text" name="titulo" required>

    <label>Descripción:</label>
    <textarea name="descripcion"></textarea>

    <label>Imagen:</label>
    <input type="file" name="foto" accept="image/*" required>

    <button type="submit">Subir foto</button>
</form>

<?php include 'includes/footer.php'; ?>