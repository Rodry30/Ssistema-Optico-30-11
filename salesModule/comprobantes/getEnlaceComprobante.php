<?php
session_start();

function validarEnlaceComprobante($boton) {
    return isset($boton);
}

$boton = isset($_POST["botonEnlace"]) ? $_POST["botonEnlace"] : null;

if (validarEnlaceComprobante($boton)) {

    include_once("formularioCliente.php");
    $form = new FormularioCliente();
    $form->FormularioClienteShow();

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
