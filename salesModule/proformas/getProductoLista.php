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

$botonEliminar = isset($_POST["btnEliminarProducto"]) ? $_POST["btnEliminarProducto"] : null;

if (!validarBoton($botonEliminar)) {
    mostrarError("ERROR 04 - ACCESO DENEGADO");
    exit;
}

$indice = isset($_POST['indiceProducto']) ? $_POST['indiceProducto'] : '';

if (!is_numeric($indice)) {
    mostrarError("ERROR 04 - Índice inválido");
    exit;
}

// Eliminar producto
include_once("controllerProforma.php");
$objControllerProforma = new controllerProforma();
$objControllerProforma->eliminarProductoLista($indice);

// Mostrar proforma actualizada
$objControllerProforma->mostrarProformaActual();
?>