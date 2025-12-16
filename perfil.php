<?php
session_start();
require_once 'includes/funciones.php';

// Solo usuarios logueados
if (!usuarioLogueado()) {
    redirigir('login.php');
}

$usuario_id = $_SESSION['usuario_id'];
$usuario = obtenerUsuario($usuario_id);

// Obtener fotos del usuario
$db = conectarBD();
$sql = "SELECT fotos_id, titulo, descripcion, ruta, fecha_subida
        FROM fotos
        WHERE usuarios_id = ?
        ORDER BY fecha_subida DESC";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$fotos = $stmt->get_result();

include 'includes/header.php';
?>

<h2>Mi Perfil</h2>

<div class="perfil">

    <div class="perfil-info">
        <img class="avatar" src="<?php echo BASE_URL . $usuario['avatar']; ?>" alt="Avatar">

        <h3><?php echo $usuario['nombre']; ?></h3>

        <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>

        <p><strong>Biografía:</strong><br>
            <?php echo !empty($usuario['bio']) ? $usuario['bio'] : "Sin biografía"; ?>
        </p>

        <p><strong>Miembro desde:</strong> <?php echo $usuario['fecha_registro']; ?></p>

        <a class="btn" href="editar_perfil.php">Editar perfil</a>
    </div>

    <div class="perfil-fotos">
        <h3>Mis fotos</h3>

        <h3>Notificaciones</h3>

        <div class="notificaciones">
            <?php
            $notificaciones = obtenerNotificaciones($_SESSION['usuario_id']);

            if (empty($notificaciones)) {
                echo "<p>No tienes notificaciones.</p>";
            } else {
                foreach ($notificaciones as $n) {

                    echo "<div class='notificacion " . ($n['leido'] ? "leido" : "noleido") . "'>";

                    switch ($n['tipo']) {

                        case 'like_foto':
                            echo "<a href='foto.php?id={$n['foto_id']}'>
                        {$n['origen']} le dio like a tu foto
                      </a>";
                            break;

                        case 'like_comentario':
                            echo "<a href='foto.php?id={$n['foto_id']}#comentario{$n['comentario_id']}'>
                        {$n['origen']} le dio like a tu comentario
                      </a>";
                            break;

                        case 'comentario':
                            echo "<a href='foto.php?id={$n['foto_id']}#comentario{$n['comentario_id']}'>
                        {$n['origen']} comentó tu foto
                      </a>";
                            break;

                        case 'respuesta':
                            echo "<a href='foto.php?id={$n['foto_id']}#comentario{$n['comentario_id']}'>
                        {$n['origen']} respondió a tu comentario
                      </a>";
                            break;
                    }

                    echo "<span class='fecha'>{$n['fecha']}</span>";
                    echo "</div>";
                }
            }
            ?>
        </div>


        <?php if ($fotos->num_rows === 0): ?>
            <p>No has subido ninguna foto todavía.</p>
        <?php else: ?>

            <div class="galeria">
                <?php while ($foto = $fotos->fetch_assoc()): ?>
                    <div class="foto">
                        <img src="<?php echo BASE_URL . $foto['ruta']; ?>" alt="<?php echo $foto['titulo']; ?>">

                        <h4><?php echo $foto['titulo']; ?></h4>

                        <p><?php echo $foto['descripcion']; ?></p>

                        <p><strong>Votos:</strong> <?php echo contarVotos($foto['fotos_id']); ?></p>

                        <p class="fecha">Subida el: <?php echo $foto['fecha_subida']; ?></p>

                        <form action="eliminar_foto.php" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta foto?');">
                            <input type="hidden" name="foto_id" value="<?php echo $foto['fotos_id']; ?>">
                            <button type="submit" class="btn-eliminar">Eliminar</button>
                        </form>

                    </div>
                <?php endwhile; ?>
            </div>

        <?php endif; ?>
    </div>

</div>

<?php include 'includes/footer.php'; ?>