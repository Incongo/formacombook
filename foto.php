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

        <!-- INFO -->
<div class="ui container" style="margin-top: 30px; max-width: 900px;">
    <div class="ui card fluid">
        <!-- Imagen protagonista -->
        <div class="image">
            <img class="ui fluid image"
                 src="<?= BASE_URL . $foto['ruta'] ?>"
                 alt="<?= htmlspecialchars($foto['titulo']) ?>"
                 loading="lazy">
        </div>

        <!-- Datos de la foto -->
        <div class="content">
            <div class="header"><?= htmlspecialchars($foto['titulo']) ?></div>
            <div class="meta">
                <?php if (!empty($foto['avatar'])): ?>
                    <img class="ui avatar image"
                         src="<?= BASE_URL . $foto['avatar']; ?>"
                         alt="Avatar de <?= htmlspecialchars($foto['autor']); ?>">
                <?php endif; ?>
                por <strong><?= htmlspecialchars($foto['autor']) ?></strong> · 
                <?php 
                $fecha = new DateTime($foto['fecha_subida']);
                echo $fecha->format('d/m/Y'); 
                ?>
            </div>
            <div class="description">
                <?= nl2br(htmlspecialchars($foto['descripcion'])) ?>
            </div>
        </div>

        <!-- Likes y votos -->
        <div class="extra content">
            <span class="right floated">
                ❤️ <?= contarVotos($foto['fotos_id']) ?>
            </span>

            <?php if (usuarioLogueado()): ?>
                <?php if ($_SESSION['usuario_id'] == $foto['usuarios_id']): ?>
                    <small class="text-muted">Tu foto</small>
                <?php elseif (usuarioHaVotado($_SESSION['usuario_id'], $foto['fotos_id'])): ?>
                    <small class="text-muted">Ya votada</small>
                <?php else: ?>
                    <form action="votar.php" method="POST" style="display:inline;">
                        <input type="hidden" name="foto_id" value="<?= $foto['fotos_id'] ?>">
                        <button class="ui tiny button">Votar</button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <small class="text-muted">Inicia sesión para votar</small>
            <?php endif; ?>
        </div>
    </div>

    <!-- Comentarios -->
    <div class="ui segment">
        <h4 class="ui dividing header">Comentarios</h4>

        <?php if (usuarioLogueado()): ?>
            <form class="ui reply form" action="procesar_comentario.php" method="POST">
                <input type="hidden" name="foto_id" value="<?= $foto['fotos_id'] ?>">
                <div class="field">
                    <textarea name="comentario" rows="2" placeholder="Escribe un comentario..." required></textarea>
                </div>
                <button class="ui primary button tiny">Comentar</button>
            </form>
        <?php else: ?>
            <p class="text-muted">Inicia sesión para comentar.</p>
        <?php endif; ?>

        <div class="ui comments" style="max-width: 100%;">
            <?php foreach (obtenerComentarios($foto['fotos_id']) as $c): ?>
                <div class="comment">
                    <div class="content">
                        <a class="author"><?= htmlspecialchars($c['nombre']) ?></a>
                        <div class="metadata">
                            <span class="date">
                                <?php 
                                $fechaC = new DateTime($c['fecha']);
                                echo $fechaC->format('d/m/Y'); 
                                ?>
                            </span>
                        </div>
                        <div class="text">
                            <?= htmlspecialchars($c['comentario']) ?>
                        </div>
                        <?php if (usuarioLogueado()): ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
