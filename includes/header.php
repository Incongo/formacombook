<?php if (usuarioLogueado()): ?>
    <?php $notis = contarNotificacionesNoLeidas($_SESSION['usuario_id']); ?>

<?php endif; ?>

<?php

require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="UTF-8">
    <title>Formacombook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>css/estilos.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <header>
        <h1><a href="<?php echo BASE_URL; ?>index.php">Formacombook</a></h1>

        <nav>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>index.php">Inicio</a></li>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="<?php echo BASE_URL; ?>subir_foto.php">Subir foto</a></li>
                    <li><a href="<?php echo BASE_URL; ?>perfil.php">Mi perfil</a></li>
                    <a href="perfil.php#notificaciones" class="icono-notis">
                        🔔
                        <?php if ($notis > 0): ?>
                            <span class="contador"><?php echo $notis; ?></span>
                        <?php endif; ?>
                    </a>
                    <li><a href="<?php echo BASE_URL; ?>logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="<?php echo BASE_URL; ?>login.php">Iniciar sesión</a></li>
                    <li><a href="<?php echo BASE_URL; ?>registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>