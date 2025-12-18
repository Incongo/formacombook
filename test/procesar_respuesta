<?php
session_start();
require_once 'includes/funciones.php';

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (!usuarioLogueado()) {
    if ($isAjax) {
        echo json_encode([
            'success' => false,
            'message' => 'No autenticado'
        ]);
        exit;
    }
    redirigir('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foto_id = intval($_POST['foto_id'] ?? 0);
    $comentario_padre_id = intval($_POST['comentario_padre_id'] ?? 0);
    $texto = limpiar($_POST['respuesta'] ?? '');
    $usuario_id = $_SESSION['usuario_id'];

    if ($foto_id <= 0 || $comentario_padre_id <= 0 || empty($texto)) {
        echo json_encode([
            'success' => false,
            'message' => 'Respuesta inválida'
        ]);
        exit;
    }

    $comentario_id = guardarRespuesta(
        $usuario_id,
        $foto_id,
        $comentario_padre_id,
        $texto
    );

    $comentario_padre = obtenerComentario($comentario_padre_id);

    if ($comentario_padre && $comentario_padre['usuarios_id'] != $usuario_id) {
        crearNotificacion(
            $comentario_padre['usuarios_id'],
            'respuesta',
            $foto_id,
            $comentario_id,
            $usuario_id
        );
    }

    $usuario = obtenerUsuario($usuario_id);

    echo json_encode([
        'success' => true,
        'respuesta' => [
            'id' => $comentario_id,
            'autor' => $usuario['nombre'],
            'texto' => nl2br(htmlspecialchars($texto)),
            'fecha' => date('Y-m-d H:i'),
            'usuario_id' => $usuario_id
        ]
    ]);
    exit;
}

redirigir("foto.php?id=" . $foto_id);
exit;
