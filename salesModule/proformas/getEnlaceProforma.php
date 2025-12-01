<?php
session_start();

function validarBoton($boton) {
    return isset($boton);
}

$boton = isset($_POST["botonEnlace"]) ? $_POST["botonEnlace"] : null;

if (validarBoton($boton)) {
    // Llamar al controlador principal
    include_once("controllerProforma.php");
    $controller = new controllerProforma();
    $controller->iniciarProforma();

} else {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        "ERROR 01 - ACCESO DENEGADO",
        "<a href='../../securityModule/pantallaPanelControl.php'>Volver al panel</a>"
    );
}
?>