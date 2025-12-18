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
    <title>Incongogram</title> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui/dist/semantic.min.css">
<script src="https://cdn.jsdelivr.net/npm/semantic-ui/dist/semantic.min.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>css/estilos.css">
<link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>uploads/logo/Logo.ico">



    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<header>
    <!-- Logo + nombre a la izquierda -->
    <div class="ui inverted segment">
        <div class="ui inverted secondary menu">
            <div class="item">
                <img src="<?= BASE_URL ?>uploads/logo/Logo.ico" 
                     alt="Logo" 
                     style="width:40px; height:auto; margin-right:10px;">
                <span style="font-size:1.2em; color:white;">Incongogram</span>
            </div>
        </div>
    </div>

    <!-- Menú desplegable separado -->
    <div class="ui inverted segment" style="margin-top:0;">
        <div class="ui simple dropdown item">
            <button class="ui inverted button">
                <i class="bars icon"></i> Menú
            </button>
            <div class="ui inverted menu">
                <a class="item" href="<?= BASE_URL ?>index.php">Inicio</a>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a class="item" href="<?= BASE_URL ?>subir_foto.php">Subir foto</a>
                    <a class="item" href="<?= BASE_URL ?>perfil.php">Mi perfil</a>

                    <!-- Notificaciones -->
                    <a class="item" href="<?= BASE_URL ?>perfil.php#notificaciones">
                        </i> Notificaciones
                        <?php if ($notis > 0): ?>
                            <span class="ui red circular label"><?php echo $notis; ?></span>
                        <?php endif; ?>
                    </a>

                    <a class="item" href="<?= BASE_URL ?>logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <a class="item" href="<?= BASE_URL ?>login.php">Iniciar sesión</a>
                    <a class="item" href="<?= BASE_URL ?>registro.php">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>




    <main>