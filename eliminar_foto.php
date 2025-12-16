<?php
session_start();
require_once 'includes/funciones.php';

// Solo usuarios logueados
if (!usuarioLogueado()) {
    redirigir('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foto_id = intval($_POST['foto_id']);
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar que la foto pertenece al usuario
    if (fotoPerteneceAUsuario($foto_id, $usuario_id)) {

        // Eliminar foto
        if (eliminarFoto($foto_id)) {
            redirigir('perfil.php');
            exit;
        } else {
            echo "Error al eliminar la foto.";
        }
    } else {
        echo "No tienes permiso para eliminar esta foto.";
    }
}

redirigir('perfil.php');
exit;
