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

<div class="container my-4">
    <div class="card p-3 mb-4">
        <h2 class="mb-3 text-center"><?php echo htmlspecialchars($foto['titulo']); ?></h2>

        <div class="foto-detalle text-center">
            <img src="<?php echo BASE_URL . $foto['ruta']; ?>" 
                 alt="<?php echo htmlspecialchars($foto['titulo']); ?>" 
                 class="img-fluid rounded mb-3">

            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($foto['descripcion']); ?></p>
            <p><strong>Autor:</strong> <?php echo htmlspecialchars($foto['autor']); ?></p>
            <p><strong>Votos:</strong> ❤️ <?php echo contarVotos($foto_id); ?></p>
        </div>
    </div>

    <!-- Comentarios -->
    <div class="card p-3 mb-4">
        <h3 class="mb-3">Comentarios</h3>

        <div class="comentarios">
            <?php if (count($comentarios) === 0): ?>
                <p class="text-muted">No hay comentarios todavía.</p>
            <?php else: ?>
                <?php foreach ($comentarios as $c): ?>
                    <div class="comentario mb-3" id="comentario<?php echo $c['comentarios_id']; ?>">
                        <p><strong><?php echo htmlspecialchars($c['nombre']); ?></strong> dijo:</p>
                        <p><?php echo htmlspecialchars($c['comentario']); ?></p>
                        <p class="fecha text-muted small"><?php echo $c['fecha']; ?></p>

                        <?php if (usuarioLogueado()): ?>
                            <form action="procesar_respuesta.php" method="POST" class="form-respuesta mt-2">
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
                            <div class="respuestas mt-2">
                                <?php foreach ($respuestas as $r): ?>
                                    <div class="comentario respuesta mb-2" id="comentario<?php echo $r['comentarios_id']; ?>">
                                        <p><strong><?php echo htmlspecialchars($r['nombre']); ?></strong> respondió:</p>
                                        <p><?php echo htmlspecialchars($r['comentario']); ?></p>
                                        <p class="fecha text-muted small"><?php echo $r['fecha']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Añadir comentario -->
    <div class="card p-3">
        <?php if (usuarioLogueado()): ?>
            <h3 class="mb-3">Añadir comentario</h3>
            <form action="procesar_comentario.php" method="POST">
                <input type="hidden" name="foto_id" value="<?php echo $foto_id; ?>">
                <textarea name="comentario" placeholder="Escribe tu comentario..." required></textarea>
                <button type="submit" class="btn">Comentar</button>
            </form>
        <?php else: ?>
            <p class="text-muted">Inicia sesión para comentar.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
