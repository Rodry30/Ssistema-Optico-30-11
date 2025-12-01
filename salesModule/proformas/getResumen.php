<?php
session_start();

function validarBoton($boton) {
    return isset($boton);
}

function mostrarError($mensaje, $enlaceVolver = 'getEnlaceProforma.php') {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        $mensaje,
        "<form action='$enlaceVolver' method='post' style='display:inline'>
            <input type='hidden' name='botonEnlace' value='1'>
            <button type='submit' class='btn-link'>Volver</button>
        </form>"
    );
}

$botonResumen = isset($_POST["btnVerResumen"]) ? $_POST["btnVerResumen"] : null;

if (!validarBoton($botonResumen)) {
    mostrarError("ERROR 06 - ACCESO DENEGADO");
    exit;
}

// Validar que haya proforma en sesión
include_once("controllerProforma.php");
$objControllerProforma = new controllerProforma();
$proformaActual = $objControllerProforma->obtenerProformaActual();

// Validar que tenga cliente
if (empty($proformaActual['cliente'])) {
    mostrarError("ERROR 06 - No hay cliente seleccionado");
    exit;
}

// Validar que la lista de productos NO esté vacía
if (empty($proformaActual['detalles']) || count($proformaActual['detalles']) == 0) {
    // En lugar de mostrar error, mostrar la proforma con un mensaje de advertencia
    $_SESSION['mensaje_error'] = "La lista de productos está vacía. Agregue al menos un producto antes de ver el resumen.";

    // Mostrar la proforma actual (con el cliente ya cargado)
    $objControllerProforma->mostrarProformaActual();
    exit;
}

// Mostrar resumen
$objControllerProforma->mostrarResumenProforma();
?>