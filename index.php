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

<h2>Galería de Fotos</h2>

<div class="galeria">

    <?php while ($foto = $resultado->fetch_assoc()): ?>

        <div class="foto">

            <a href="foto.php?id=<?php echo $foto['fotos_id']; ?>">
                <img src="<?php echo BASE_URL . $foto['ruta']; ?>" alt="<?php echo $foto['titulo']; ?>">
            </a>

            <h3><?php echo $foto['titulo']; ?></h3>

            <p class="autor">
                Subida por: <strong><?php echo $foto['autor']; ?></strong>
            </p>

            <p class="descripcion">
                <?php echo $foto['descripcion']; ?>
            </p>

            <p class="votos">
                Votos: <strong><?php echo contarVotos($foto['fotos_id']); ?></strong>
            </p>

            <?php if (usuarioLogueado()): ?>

                <?php if ($_SESSION['usuario_id'] == $foto['autor_id']): ?>
                    <p class="info">No puedes votar tu propia foto.</p>

                <?php elseif (usuarioHaVotado($_SESSION['usuario_id'], $foto['fotos_id'])): ?>
                    <p class="info">Ya has votado esta foto.</p>

                <?php else: ?>
                    <form action="votar.php" method="POST">
                        <input type="hidden" name="foto_id" value="<?php echo $foto['fotos_id']; ?>">
                        <button type="submit">Votar</button>
                    </form>

                <?php endif; ?>

            <?php else: ?>
                <p class="info">Inicia sesión para votar.</p>
            <?php endif; ?>

        </div>

    <?php endwhile; ?>

</div>

<?php include 'includes/footer.php'; ?>