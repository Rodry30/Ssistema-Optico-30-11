<?php
session_start();

function validarBoton($boton) {
    return isset($boton);
}

function mostrarError($mensaje) {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        $mensaje,
        "<button onclick='history.back()' style='padding:8px 15px; cursor:pointer;'>Volver</button>"
    );
}

$botonBuscar = isset($_POST["btnBuscarReceta"]) ? $_POST["btnBuscarReceta"] : null;

if (!validarBoton($botonBuscar)) {
    mostrarError("ERROR 05 - ACCESO DENEGADO");
    exit;
}

// Obtener cliente de la sesión
include_once("controllerProforma.php");
$objControllerProforma = new controllerProforma();
$proformaActual = $objControllerProforma->obtenerProformaActual();

if (empty($proformaActual['cliente'])) {
    mostrarError("ERROR 05 - No hay cliente seleccionado");
    exit;
}

$idCliente = $proformaActual['cliente']['idCliente'];

// Buscar receta usando el controlador de proforma
$receta = $objControllerProforma->buscarReceta($idCliente);

if ($receta) {
    $objControllerProforma->procesarRecetaEncontrada($receta);
} else {
    $objControllerProforma->recetaNoEncontrada();
}
?>