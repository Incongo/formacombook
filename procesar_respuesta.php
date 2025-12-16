<?php
session_start();
require_once 'includes/funciones.php';

if (!usuarioLogueado()) {
    redirigir('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foto_id = intval($_POST['foto_id']);
    $comentario_padre_id = intval($_POST['comentario_padre_id']);
    $texto = limpiar($_POST['respuesta']);
    $usuario_id = $_SESSION['usuario_id'];

    if (!empty($texto)) {

        // Guardar respuesta y obtener ID REAL
        $comentario_id = guardarRespuesta($usuario_id, $foto_id, $comentario_padre_id, $texto);

        // Obtener comentario padre
        $comentario_padre = obtenerComentario($comentario_padre_id);

        // Crear notificación SOLO si no responde a sí mismo
        if ($comentario_padre && $comentario_padre['usuarios_id'] != $usuario_id) {
            crearNotificacion(
                $comentario_padre['usuarios_id'], // a quién notifico
                'respuesta',                      // tipo
                $foto_id,                         // foto
                $comentario_id,                   // ID REAL de la respuesta
                $usuario_id                       // quién respondió
            );
        }
    }
}

redirigir("foto.php?id=" . $foto_id);
exit;
