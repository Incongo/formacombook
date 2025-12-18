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

<div class="ui container" style="margin-top: 40px;">
    <h2 class="ui header center aligned">Mi Perfil</h2>

    <div class="ui stackable grid">
        <!-- Info del usuario -->
        <div class="four wide column">
            <div class="ui card centered">
                <div class="image">
                    <img src="<?php echo BASE_URL . $usuario['avatar']; ?>" alt="Avatar">
                </div>
                <div class="content">
                    <h3 class="header"><?php echo $usuario['nombre']; ?></h3>
                    <div class="meta">
                        <span>Email</span>
                    </div>
                    <div class="description">
                        <?php echo $usuario['email']; ?>
                    </div>
                    <div class="meta" style="margin-top:10px;">
                        <span>Biografía</span>
                    </div>
                    <div class="description">
                        <?php echo !empty($usuario['bio']) ? $usuario['bio'] : "Sin biografía"; ?>
                    </div>
                    <div class="meta" style="margin-top:10px;">
                        <span>Miembro desde</span>
                    </div>
                    <div class="description">
                        <?php echo $usuario['fecha_registro']; ?>
                    </div>
                </div>
                <div class="extra content">
                    <a href="editar_perfil.php" class="ui fluid primary button">Editar perfil</a>
                </div>
            </div>
        </div>

        <!-- Fotos y notificaciones -->
        <div class="twelve wide column">
            <!-- Notificaciones -->
            <div class="ui raised segment">
                <h3 class="ui header">Notificaciones</h3>
                <div class="ui relaxed divided list">
                    <?php
                    $notificaciones = obtenerNotificaciones($_SESSION['usuario_id']);

                    if (empty($notificaciones)) {
                        echo "<div class='item'><div class='content'><div class='description text-muted'>No tienes notificaciones.</div></div></div>";
                    } else {
                        foreach ($notificaciones as $n) {
                            echo "<div class='item'>";
                            echo "<i class='bell icon'></i>";
                            echo "<div class='content'>";
                            switch ($n['tipo']) {
                                case 'like_foto':
                                    echo "<a class='header' href='foto.php?id={$n['foto_id']}'>
                                        {$n['origen']} le dio like a tu foto
                                    </a>";
                                    break;
                                case 'like_comentario':
                                    echo "<a class='header' href='foto.php?id={$n['foto_id']}#comentario{$n['comentario_id']}'>
                                        {$n['origen']} le dio like a tu comentario
                                    </a>";
                                    break;
                                case 'comentario':
                                    echo "<a class='header' href='foto.php?id={$n['foto_id']}#comentario{$n['comentario_id']}'>
                                        {$n['origen']} comentó tu foto
                                    </a>";
                                    break;
                                case 'respuesta':
                                    echo "<a class='header' href='foto.php?id={$n['foto_id']}#comentario{$n['comentario_id']}'>
                                        {$n['origen']} respondió a tu comentario
                                    </a>";
                                    break;
                            }
                            echo "<div class='description'><span class='date'>{$n['fecha']}</span></div>";
                            echo "</div></div>";
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Fotos -->
            <div class="ui raised segment">
                <h3 class="ui header">Mis fotos</h3>

                <?php if ($fotos->num_rows === 0): ?>
                    <p class="text-muted">No has subido ninguna foto todavía.</p>
                <?php else: ?>
                    <div class="ui three stackable cards">
                        <?php while ($foto = $fotos->fetch_assoc()): ?>
                            <div class="card">
                                <div class="image">
                                    <img src="<?php echo BASE_URL . $foto['ruta']; ?>" alt="<?php echo $foto['titulo']; ?>">
                                </div>
                                <div class="content">
                                    <h4 class="header"><?php echo $foto['titulo']; ?></h4>
                                    <div class="description"><?php echo $foto['descripcion']; ?></div>
                                    <div class="meta" style="margin-top:10px;">
                                        <span><strong>Votos:</strong> <?php echo contarVotos($foto['fotos_id']); ?></span>
                                    </div>
                                    <div class="meta">
                                        <span class="date">Subida el: <?php echo $foto['fecha_subida']; ?></span>
                                    </div>
                                </div>
                                <div class="extra content">
                                    <form action="editar_foto.php" method="GET" style="margin-bottom:5px;">
                                        <input type="hidden" name="foto_id" value="<?php echo $foto['fotos_id']; ?>">
                                        <button type="submit" class="ui button">Editar</button>
                                    </form>
                                    <form action="eliminar_foto.php" method="POST" 
                                          onsubmit="return confirm('¿Seguro que quieres eliminar esta foto?');">
                                        <input type="hidden" name="foto_id" value="<?php echo $foto['fotos_id']; ?>">
                                        <button type="submit" class="ui red button">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
