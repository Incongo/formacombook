<?php
require_once 'config.php';

function conectarBD()
{
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conexion->connect_errno) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Forzar UTF-8
    $conexion->set_charset("utf8mb4");

    return $conexion;
}
