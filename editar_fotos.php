<?php
session_start();
require_once 'includes/funciones.php';

// Solo usuarios logueados
if (!usuarioLogueado()) {
    redirigir('login.php');
}

$errores = [];
$exito = false;

if (!isset($_GET['foto_id'])) {
    redirigir('perfil.php');
}

$foto_id = (int) $_GET['foto_id'];
$foto = obtenerFotoPorId($foto_id);

// Validar que la foto pertenece al usuario
if ($foto['usuarios_id'] != $_SESSION['usuario_id']) {
    redirigir('perfil.php');
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = limpiar($_POST['titulo']);
    $descripcion = limpiar($_POST['descripcion']);

    if (empty($titulo)) {
        $errores[] = "El título es obligatorio.";
    }

    if (empty($errores)) {
        if (actualizarFoto($foto_id, $titulo, $descripcion)) {
            $exito = true;
        } else {
            $errores[] = "Error al actualizar la foto.";
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-container">
    <div class="form-card">
        <h1>Editar Foto</h1>

        <?php if ($exito): ?>
            <div class="alert alert-success">
                Foto actualizada correctamente. Redirigiendo...
            </div>
            <?php
            redirigir('perfil.php');
            exit;
            ?>
        <?php endif; ?>

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
            <label>Título:</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($foto['titulo']); ?>" required>

            <label>Descripción:</label>
            <textarea name="descripcion"><?php echo htmlspecialchars($foto['descripcion']); ?></textarea>

            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
