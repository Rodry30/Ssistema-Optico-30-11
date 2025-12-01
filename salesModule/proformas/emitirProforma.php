<?php
include_once("controllerProforma.php");
include_once(__DIR__ ."/../../shared/pantallaMensaje.php");

if(isset($_POST['btnEmitir'])) {
    $ctrl = new controllerProforma();
    $idProforma = $ctrl->guardarProforma();

    $msg = new pantallaMensaje();
    if($idProforma > 0) {
        $msg->mensajeShow(3, "PROFORMA #$idProforma GENERADA CON ÉXITO", "<a href='../../index.php'>Volver al Inicio</a>");
    } else {
        $msg->mensajeShow(1, "ERROR AL GUARDAR EN BASE DE DATOS", "<a href='getEnlaceProforma.php'>Reintentar</a>");
    }
}
?>