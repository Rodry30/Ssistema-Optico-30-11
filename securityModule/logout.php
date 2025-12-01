<?php
// Incluye la clase SessionManager
require_once("../shared/SessionManager.php");

// Cerrar correctamente la sesión
SessionManager::logout();

// Mostrar mensaje de despedida
include_once("../shared/pantallaMensaje.php");
$objMensaje = new pantallaMensaje();
$objMensaje->mensajeShow(
    3,
    "Sesión cerrada correctamente",
    "<a href='../index.php'>Volver a iniciar sesión</a>"
);
?>
