<?php
session_start();
require_once 'includes/funciones.php';

// Obtener todas las fotos con su autor
$db = conectarBD();
$sql = "SELECT f.fotos_id, f.titulo, f.descripcion, f.ruta, f.fecha_subida,
               u.nombre AS autor, u.usuarios_id AS autor_id, u.avatar
        FROM fotos f
        INNER JOIN usuarios u ON f.usuarios_id = u.usuarios_id
        ORDER BY f.fecha_subida DESC";

$resultado = $db->query($sql);

include 'includes/header.php';
?>

<div class="ui container" style="margin-top: 30px;">


    <?php if (!$resultado || $resultado->num_rows === 0): ?>
        <div class="ui info message">
            <div class="header">Sin contenido</div>
            <p>No hay fotos publicadas todavía.</p>
        </div>
    <?php else: ?>
        <div class="ui three stackable cards">
            <?php while ($foto = $resultado->fetch_assoc()): ?>
                <div class="ui card">
                    <!-- Cabecera con autor y fecha -->
                    <div class="content">
                        <div class="right floated meta">
                            <?php 
                            // Mostrar solo la fecha sin hora
                            $fecha = new DateTime($foto['fecha_subida']);
                            echo $fecha->format('d/m/Y'); 
                            ?>
                        </div>
                        <div class="header">
                            <?php if (!empty($foto['avatar'])): ?>
                                <img class="ui avatar image" 
                                     src="<?php echo BASE_URL . $foto['avatar']; ?>" 
                                     alt="Avatar de <?php echo htmlspecialchars($foto['autor']); ?>">
                            <?php endif; ?>
                            <?php echo htmlspecialchars($foto['autor']); ?>
                        </div>
                    </div>

                    <!-- Imagen principal (click abre detalle) -->
                    <a class="image" href="foto.php?id=<?php echo $foto['fotos_id']; ?>">
                        <img
                            src="<?php echo BASE_URL . $foto['ruta']; ?>"
                            alt="<?php echo htmlspecialchars($foto['titulo']); ?>"
                            loading="lazy"
                        >
                    </a>

                    <!-- Título y descripción corta -->
                    <div class="content">
                        <div class="header"><?php echo htmlspecialchars($foto['titulo']); ?></div>
                        <?php if (!empty($foto['descripcion'])): ?>
                            <div class="description">
                                <?php
                                // Recorta descripción para la card
                                $desc = strip_tags($foto['descripcion']);
                                echo htmlspecialchars(mb_strimwidth($desc, 0, 140, '…'));
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Likes y comentarios -->
                    <div class="content">
                        <span class="right floated">
                            <i class="heart outline like icon"></i>
                            <?php echo contarVotos($foto['fotos_id']); ?> likes
                        </span>
                        <i class="comment icon"></i>
                        <?php echo contarComentarios($foto['fotos_id']); ?> comentarios
                    </div>

                    <!-- Caja para añadir comentario -->
                    <?php if (usuarioLogueado()): ?>
                        <div class="extra content">
                            <form action="procesar_comentario.php" method="POST" class="ui form">
                                <input type="hidden" name="foto_id" value="<?= $foto['fotos_id'] ?>">
                                <div class="ui action input" style="width:100%;">
                                    <input type="text" name="comentario" placeholder="Añadir comentario..." required>
                                    <button type="submit" class="ui button">Comentar</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
