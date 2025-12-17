<?php
require_once 'conexion.php';

// -----------------------------
// Sanitizar datos
// -----------------------------
function limpiar($dato)
{
    return htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8');
}

// -----------------------------
// Redirección segura
// -----------------------------
function redirigir($url)
{
    header("Location: $url");
    exit;
}

// -----------------------------
// Comprobar si el usuario está logueado
// -----------------------------
function usuarioLogueado()
{
    return isset($_SESSION['usuario_id']);
}

// -----------------------------
// Obtener datos de un usuario por ID
// -----------------------------
function obtenerUsuario($id)
{
    $db = conectarBD();
    $sql = "SELECT usuarios_id, nombre, email, avatar, bio, fecha_registro 
            FROM usuarios WHERE usuarios_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

// -----------------------------
// Contar votos de una foto
// -----------------------------
function contarVotos($foto_id)
{
    $db = conectarBD();
    $sql = "SELECT COUNT(*) AS total FROM votos WHERE fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();
    return $resultado['total'];
}

// -----------------------------
// Comprobar si un usuario ya votó una foto
// -----------------------------
function usuarioHaVotado($usuario_id, $foto_id)
{
    $db = conectarBD();
    $sql = "SELECT 1 FROM votos WHERE usuarios_id = ? AND fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $foto_id);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

// -----------------------------
// Registrar voto
// -----------------------------
function registrarVoto($usuario_id, $foto_id)
{
    $db = conectarBD();
    $sql = "INSERT INTO votos (usuarios_id, fotos_id) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->bind_param("ii", $usuario_id, $foto_id) && $stmt->execute();
}

// -----------------------------
// Comprobar si un email ya existe
// -----------------------------
function emailExiste($email)
{
    $db = conectarBD();
    $sql = "SELECT usuarios_id FROM usuarios WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->num_rows > 0;
}

// -----------------------------
// Registrar usuario
// -----------------------------
function registrarUsuario($nombre, $email, $password)
{
    $db = conectarBD();

    // Hash seguro
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, password, avatar, bio) 
            VALUES (?, ?, ?, 'formacombook/uploads/avatars/default.png', '')";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $passwordHash);

    return $stmt->execute();
}

// -----------------------------
// Obtener usuario por email
// -----------------------------
function obtenerUsuarioPorEmail($email)
{
    $db = conectarBD();
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}


// -----------------------------
// Actualizar perfil de usuario
// -----------------------------
function actualizarPerfil($usuario_id, $nombre, $bio, $avatarRuta)
{
    $db = conectarBD();
    $sql = "UPDATE usuarios SET nombre = ?, bio = ?, avatar = ? WHERE usuarios_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $bio, $avatarRuta, $usuario_id);
    return $stmt->execute();
}

// -----------------------------
// Registrar foto en la BD
// -----------------------------
function registrarFoto($usuario_id, $titulo, $descripcion, $ruta)
{
    $db = conectarBD();
    $sql = "INSERT INTO fotos (usuarios_id, titulo, descripcion, ruta, fecha_subida)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("isss", $usuario_id, $titulo, $descripcion, $ruta);

    return $stmt->execute();
}


// -----------------------------
// Eliminar foto
// -----------------------------

// Comprobar si la foto pertenece al usuario
function fotoPerteneceAUsuario($foto_id, $usuario_id)
{
    $db = conectarBD();
    $sql = "SELECT fotos_id FROM fotos WHERE fotos_id = ? AND usuarios_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $foto_id, $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->num_rows === 1;
}


function eliminarFoto($foto_id)
{
    $db = conectarBD();

    // Obtener ruta del archivo
    $sql = "SELECT ruta FROM fotos WHERE fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $foto = $resultado->fetch_assoc();

    if (!$foto) return false;

    $ruta = $foto['ruta'];

    // Eliminar archivo físico si existe
    if (file_exists($ruta)) {
        unlink($ruta);
    }

    // Eliminar votos asociados
    $sql = "DELETE FROM votos WHERE fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();

    // Eliminar foto de la BD
    $sql = "DELETE FROM fotos WHERE fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $foto_id);

    return $stmt->execute();
}


// Obtener foto por ID
function obtenerFoto($foto_id)
{
    $db = conectarBD();
    $sql = "SELECT f.*, u.nombre AS autor
            FROM fotos f
            INNER JOIN usuarios u ON f.usuarios_id = u.usuarios_id
            WHERE f.fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Obtener comentarios de una foto
function obtenerComentarios($foto_id)
{
    $db = conectarBD();
    $sql = "SELECT c.*, u.nombre
            FROM comentarios c
            INNER JOIN usuarios u ON c.usuarios_id = u.usuarios_id
            WHERE c.fotos_id = ? AND c.comentario_padre_id IS NULL
            ORDER BY c.fecha ASC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


// Guardar comentario
function guardarComentario($usuario_id, $foto_id, $comentario)
{
    $db = conectarBD();
    $sql = "INSERT INTO comentarios (usuarios_id, fotos_id, comentario, fecha)
            VALUES (?, ?, ?, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iis", $usuario_id, $foto_id, $comentario);
    $stmt->execute();

    return $db->insert_id; // ← DEVUELVE EL ID REAL
}



// -----------------------------
// Crear notificación
// -----------------------------
function crearNotificacion($usuario_id, $tipo, $foto_id, $comentario_id, $origen_usuario_id)
{
    $db = conectarBD();
    $sql = "INSERT INTO notificaciones (usuario_id, tipo, foto_id, comentario_id, origen_usuario_id, fecha)
            VALUES (?, ?, ?, ?, ?, NOW())";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("isiii", $usuario_id, $tipo, $foto_id, $comentario_id, $origen_usuario_id);
    return $stmt->execute();
}

// Obtener notificaciones de un usuario
function obtenerNotificaciones($usuario_id)
{
    $db = conectarBD();
    $sql = "SELECT n.*, u.nombre AS origen
            FROM notificaciones n
            INNER JOIN usuarios u ON n.origen_usuario_id = u.usuarios_id
            WHERE n.usuario_id = ?
            ORDER BY n.fecha DESC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function marcarNotificacionesLeidas($usuario_id)
{
    $db = conectarBD();
    $sql = "UPDATE notificaciones SET leido = 1 WHERE usuario_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
}

// Obtener comentario por ID
function obtenerComentario($comentario_id)
{
    $db = conectarBD();
    $sql = "SELECT c.*, u.nombre, u.usuarios_id
            FROM comentarios c
            INNER JOIN usuarios u ON c.usuarios_id = u.usuarios_id
            WHERE c.comentarios_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $comentario_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Obtener respuestas de un comentario
function obtenerRespuestas($comentario_id)
{
    $db = conectarBD();
    $sql = "SELECT c.*, u.nombre
            FROM comentarios c
            INNER JOIN usuarios u ON c.usuarios_id = u.usuarios_id
            WHERE c.comentario_padre_id = ?
            ORDER BY c.fecha ASC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $comentario_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Guardar respuesta a un comentario
function guardarRespuesta($usuario_id, $foto_id, $comentario_padre_id, $texto)
{
    $db = conectarBD();
    $sql = "INSERT INTO comentarios (usuarios_id, fotos_id, comentario, comentario_padre_id, fecha)
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iisi", $usuario_id, $foto_id, $texto, $comentario_padre_id);
    $stmt->execute();

    return $db->insert_id; // ← AQUÍ ESTÁ LA CLAVE
}

// Contar notificaciones no leídas
function contarNotificacionesNoLeidas($usuario_id)
{
    $db = conectarBD();
    $sql = "SELECT COUNT(*) AS total 
            FROM notificaciones 
            WHERE usuario_id = ? AND leido = 0";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();

    return $resultado['total'];
}

function actualizarFoto($foto_id, $titulo, $descripcion) {
    $db = conectarBD();
    $sql = "UPDATE fotos SET titulo = ?, descripcion = ? WHERE fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssi", $titulo, $descripcion, $foto_id);
    return $stmt->execute();
}

function obtenerFotoPorId($foto_id) {
    $db = conectarBD();
    $sql = "SELECT * FROM fotos WHERE fotos_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}
