<?php
session_start();
require_once 'includes/funciones.php';

if (!usuarioLogueado()) {
    redirigir('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foto_id = intval($_POST['foto_id']);
    $comentario = limpiar($_POST['comentario']);
    $usuario_id = $_SESSION['usuario_id'];

    if (!empty($comentario)) {

        // Guardar comentario y obtener ID REAL
        $comentario_id = guardarComentario($usuario_id, $foto_id, $comentario);

        // Obtener datos de la foto
        $foto = obtenerFoto($foto_id);

        // Crear notificación SOLO si no comenta su propia foto
        if ($foto['usuarios_id'] != $usuario_id) {
            crearNotificacion(
                $foto['usuarios_id'],   // dueño de la foto
                'comentario',
                $foto_id,
                $comentario_id,         // ← AHORA ES CORRECTO
                $usuario_id
            );
        }
    }
}

redirigir("foto.php?id=" . $foto_id);
exit;
