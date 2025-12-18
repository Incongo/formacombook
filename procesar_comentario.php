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
    $comentario = limpiar($_POST['comentario'] ?? '');
    $usuario_id = $_SESSION['usuario_id'];

    if ($foto_id <= 0 || empty($comentario)) {
        echo json_encode([
            'success' => false,
            'message' => 'Comentario inválido'
        ]);
        exit;
    }

    // Guardar comentario
    $comentario_id = guardarComentario($usuario_id, $foto_id, $comentario);

    // Obtener datos de la foto
    $foto = obtenerFoto($foto_id);

    if ($foto && $foto['usuarios_id'] != $usuario_id) {
        crearNotificacion(
            $foto['usuarios_id'],
            'comentario',
            $foto_id,
            $comentario_id,
            $usuario_id
        );
    }

    // Datos para pintar el comentario
    $usuario = obtenerUsuario($usuario_id);

    echo json_encode([
        'success' => true,
        'comentario' => [
            'id'      => $comentario_id,
            'autor'   => $usuario['nombre'],
            'texto'   => nl2br(htmlspecialchars($comentario)),
            'fecha'   => date('Y-m-d H:i'),
            'usuario_id' => $usuario_id
        ]
    ]);
    exit;
}

redirigir("foto.php?id=" . $foto_id);
exit;
