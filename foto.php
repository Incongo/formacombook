<?php
session_start();
require_once 'includes/funciones.php';

if (!isset($_GET['id'])) {
    redirigir('index.php');
}

$foto_id = intval($_GET['id']);
$foto = obtenerFoto($foto_id);

if (!$foto) {
    redirigir('index.php');
}

// Obtener comentarios
$comentarios = obtenerComentarios($foto_id);

include 'includes/header.php';
?>

<h2><?php echo $foto['titulo']; ?></h2>

<div class="foto-detalle">
    <img src="<?php echo BASE_URL . $foto['ruta']; ?>" alt="<?php echo $foto['titulo']; ?>">

    <p><strong>Descripción:</strong> <?php echo $foto['descripcion']; ?></p>
    <p><strong>Autor:</strong> <?php echo $foto['autor']; ?></p>
    <p><strong>Votos:</strong> <?php echo contarVotos($foto_id); ?></p>
</div>

<hr>

<h3>Comentarios</h3>

<div class="comentarios">
    <?php if (count($comentarios) === 0): ?>
        <p>No hay comentarios todavía.</p>
    <?php else: ?>
        <?php foreach ($comentarios as $c): ?>
            <div class="comentario" id="comentario<?php echo $c['comentarios_id']; ?>">
                <p><strong><?php echo $c['nombre']; ?></strong> dijo:</p>
                <p><?php echo $c['comentario']; ?></p>
                <p class="fecha"><?php echo $c['fecha']; ?></p>

                <?php if (usuarioLogueado()): ?>
                    <form action="procesar_respuesta.php" method="POST" class="form-respuesta">
                        <input type="hidden" name="foto_id" value="<?php echo $foto_id; ?>">
                        <input type="hidden" name="comentario_padre_id" value="<?php echo $c['comentarios_id']; ?>">
                        <textarea name="respuesta" placeholder="Responder..." required></textarea>
                        <button type="submit">Responder</button>
                    </form>
                <?php endif; ?>

                <?php
                $respuestas = obtenerRespuestas($c['comentarios_id']);
                if (!empty($respuestas)):
                ?>
                    <div class="respuestas">
                        <?php foreach ($respuestas as $r): ?>
                            <div class="comentario respuesta" id="comentario<?php echo $r['comentarios_id']; ?>">
                                <p><strong><?php echo $r['nombre']; ?></strong> respondió:</p>
                                <p><?php echo $r['comentario']; ?></p>
                                <p class="fecha"><?php echo $r['fecha']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

<?php if (usuarioLogueado()): ?>
    <h3>Añadir comentario</h3>

    <form action="procesar_comentario.php" method="POST">
        <input type="hidden" name="foto_id" value="<?php echo $foto_id; ?>">
        <textarea name="comentario" required></textarea>
        <button type="submit">Comentar</button>
    </form>
<?php else: ?>
    <p>Inicia sesión para comentar.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>