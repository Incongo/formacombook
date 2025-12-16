<?php
session_start();
require_once 'includes/funciones.php';

if (!usuarioLogueado()) {
    redirigir('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foto_id = intval($_POST['foto_id']);
    $usuario_id = $_SESSION['usuario_id'];

    // Evitar votos duplicados
    if (!usuarioHaVotado($usuario_id, $foto_id)) {

        // Registrar voto
        registrarVoto($usuario_id, $foto_id);

        // Obtener datos de la foto
        $foto = obtenerFoto($foto_id);

        // Crear notificación SOLO si no se vota a sí mismo
        if ($foto['usuarios_id'] != $usuario_id) {
            crearNotificacion(
                $foto['usuarios_id'],   // dueño de la foto
                'like_foto',
                $foto_id,
                null,
                $usuario_id             // quien dio like
            );
        }
    }
}

// Redirigir al final
redirigir('index.php');
