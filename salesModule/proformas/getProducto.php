<?php
session_start();

function validarBoton($boton) {
    return isset($boton);
}

function validarTextoProducto($texto) {
    return (strlen(trim($texto)) >= 2 && preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/', $texto));
}

$boton = isset($_POST["btnBuscarProducto"]) ? $_POST["btnBuscarProducto"] : null;

if (!validarBoton($boton)) {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        "ERROR 02 - ACCESO DENEGADO",
        "<a href='../../securityModule/pantallaPanelControl.php'>Volver al panel</a>"
    );
    exit;
}

$nombreProducto = isset($_POST['txtProducto']) ? trim($_POST['txtProducto']) : '';

if (!validarTextoProducto($nombreProducto)) {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        "ERROR 02 - El nombre debe tener al menos 2 caracteres válidos",
        "<button onclick='history.back()' style='padding:8px 15px; cursor:pointer;'>Volver</button>"
    );
    exit;
}

// Buscar productos
include_once("controllerProducto.php");
$objControllerProducto = new controllerProducto();
$resultado = $objControllerProducto->buscarProductos($nombreProducto);

// Enviar al orquestador
include_once("controllerProforma.php");
$objControllerProforma = new controllerProforma();

if ($resultado['success']) {
    $objControllerProforma->mostrarProductosEncontrados($resultado['data']);
} else {
    $objControllerProforma->productosNoEncontrados($nombreProducto);
}
?>