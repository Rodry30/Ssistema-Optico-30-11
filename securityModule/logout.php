<?php
session_start();
session_unset();
session_destroy();

// Opcional: Mensaje de despedida
include_once("../shared/pantallaMensaje.php");
$objMensaje = new pantallaMensaje();
$objMensaje->mensajeShow(
    3,
    "Sesión cerrada correctamente",
    "<a href='../index.php'>Volver a iniciar sesión</a>"
);
?>
