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
    } else {
        redirigir('login.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foto_id = intval($_POST['foto_id'] ?? 0);
    $usuario_id = $_SESSION['usuario_id'];

    if ($foto_id <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Foto inválida'
        ]);
        exit;
    }

    // Evitar votos duplicados
    if (usuarioHaVotado($usuario_id, $foto_id)) {
        echo json_encode([
            'success' => false,
            'message' => 'Ya has votado esta foto'
        ]);
        exit;
    }

    // Obtener datos de la foto
    $foto = obtenerFoto($foto_id);

    if (!$foto) {
        echo json_encode([
            'success' => false,
            'message' => 'Foto no encontrada'
        ]);
        exit;
    }

    // Registrar voto
    registrarVoto($usuario_id, $foto_id);

    // Crear notificación SOLO si no se vota a sí mismo
    if ($foto['usuarios_id'] != $usuario_id) {
        crearNotificacion(
            $foto['usuarios_id'],
            'like_foto',
            $foto_id,
            null,
            $usuario_id
        );
    }

    // Total de votos actualizado
    $totalVotos = contarVotos($foto_id);

    // Respuesta AJAX
    echo json_encode([
        'success' => true,
        'votos'   => $totalVotos
    ]);
    exit;
}

// Fallback clásico
redirigir('index.php');
