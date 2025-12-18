<?php
session_start();
require_once 'includes/funciones.php';

// Obtener todas las fotos con su autor
$db = conectarBD();
$sql = "SELECT f.fotos_id, f.titulo, f.descripcion, f.ruta, f.fecha_subida,
               u.nombre AS autor, u.usuarios_id AS autor_id
        FROM fotos f
        INNER JOIN usuarios u ON f.usuarios_id = u.usuarios_id
        ORDER BY f.fecha_subida DESC";

$resultado = $db->query($sql);

include 'includes/header.php';
?>

<h2 class="text-center my-4">Galería de Fotos</h2>

<div class="container-fluid px-4">
    <div class="row g-4">

        <?php while ($foto = $resultado->fetch_assoc()): ?>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                <div class="card h-100 shadow-sm">

                    <a href="foto.php?id=<?= $foto['fotos_id'] ?>" class="text-decoration-none">
                        <img
    src="<?= BASE_URL . $foto['ruta'] ?>"
    loading="lazy"
    class="card-img-top"
    alt="<?= htmlspecialchars($foto['titulo']) ?>"
>

                    </a>

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title mb-1">
                            <?= htmlspecialchars($foto['titulo']) ?>
                        </h5>

                        <small class="text-muted mb-2">
                            por <?= htmlspecialchars($foto['autor']) ?>
                        </small>

                        <p class="card-text small text-muted flex-grow-1">
                            <?= htmlspecialchars($foto['descripcion']) ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-2">

                            <span class="badge bg-dark votos-contador" data-id="<?= $foto['fotos_id'] ?>">
                                ❤️ <?= contarVotos($foto['fotos_id']) ?>
                            </span>


                            <?php if (usuarioLogueado()): ?>

                                <?php if ($_SESSION['usuario_id'] == $foto['autor_id']): ?>
                                    <small class="text-muted">Tu foto</small>

                                <?php elseif (usuarioHaVotado($_SESSION['usuario_id'], $foto['fotos_id'])): ?>
                                    <small class="text-muted">Votada</small>

                                <?php else: ?>
                                    <form action="votar.php" method="POST" class="form-voto">
                                        <input type="hidden" name="foto_id" value="<?= $foto['fotos_id'] ?>">
                                        <button class="btn btn-sm btn-outline-dark">
                                            Votar
                                        </button>
                                    </form>
                                <?php endif; ?>

                            <?php else: ?>
                                <small class="text-muted">Login para votar</small>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>

            </div>

        <?php endwhile; ?>

    </div>
</div>


<?php include 'includes/footer.php'; ?>