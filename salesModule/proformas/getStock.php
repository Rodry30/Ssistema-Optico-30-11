<?php
session_start();

function validarBoton($boton) {
    return isset($boton);
}

$boton = isset($_POST["botonValidarStock"]) ? $_POST["botonValidarStock"] : null;

if (validarBoton($boton)) {
    $id = isset($_POST['idProducto']) ? intval($_POST['idProducto']) : 0;
    include_once("controllerProducto.php");
    $controller = new ControllerProducto();
    $controller->validarStock($id); 
} else {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        "ERROR 01 - ACCESO DENEGADO",
        "<a href='../../securityModule/pantallaPanelControl.php'>Volver al panel</a>"
    );
}