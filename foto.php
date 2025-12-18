<?php
session_start();
require_once 'includes/funciones.php';

$id = intval($_GET['id'] ?? 0);
$foto = obtenerFoto($id);

if (!$foto) {
    redirigir('index.php');
}

include 'includes/header.php';
?>

<div class="container my-5">

    <div class="row justify-content-center">

        <!-- IMAGEN -->
        <div class="col-12 col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <img
                    src="<?= BASE_URL . $foto['ruta'] ?>"
                    class="img-fluid rounded"
                    loading="lazy"
                    alt="<?= htmlspecialchars($foto['titulo']) ?>"
                >
            </div>
        </div>

        <!-- INFO -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h3 class="card-title mb-2">
                        <?= htmlspecialchars($foto['titulo']) ?>
                    </h3>

                    <p class="text-muted mb-2">
                        por <strong><?= htmlspecialchars($foto['autor']) ?></strong>
                    </p>

                    <p class="small text-muted mb-3">
                        <?= nl2br(htmlspecialchars($foto['descripcion'])) ?>
                    </p>

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span class="badge bg-dark fs-6">
                            ❤️ <?= contarVotos($foto['fotos_id']) ?>
                        </span>

                        <?php if (usuarioLogueado()): ?>

                            <?php if ($_SESSION['usuario_id'] == $foto['usuarios_id']): ?>
                                <small class="text-muted">Tu foto</small>

                            <?php elseif (usuarioHaVotado($_SESSION['usuario_id'], $foto['fotos_id'])): ?>
                                <small class="text-muted">Ya votada</small>

                            <?php else: ?>
                                <form action="votar.php" method="POST" class="form-voto">
                                    <input type="hidden" name="foto_id" value="<?= $foto['fotos_id'] ?>">
                                    <button class="btn btn-outline-dark btn-sm">Votar</button>
                                </form>
                            <?php endif; ?>

                        <?php else: ?>
                            <small class="text-muted">Inicia sesión para votar</small>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- COMENTARIOS -->
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-lg-8">

            <h4 class="mb-3">Comentarios</h4>

            <?php if (usuarioLogueado()): ?>
                <form id="form-comentario" action="procesar_comentario.php" class="mb-4">
                    <input type="hidden" name="foto_id" value="<?= $foto['fotos_id'] ?>">
                    <textarea name="comentario" class="form-control mb-2" rows="3" required></textarea>
                    <button class="btn btn-dark btn-sm">Comentar</button>
                </form>
            <?php endif; ?>

            <!-- CONTENEDOR AJAX -->
            <div id="comentarios">
                <?php include 'includes/comentarios.php'; ?>
            </div>

        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
