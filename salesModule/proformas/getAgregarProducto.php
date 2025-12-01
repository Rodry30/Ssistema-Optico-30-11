<?php
session_start();

function validarBoton($boton) {
    return isset($boton);
}

function validarCantidad($cantidad, $stockMaximo) {
    return (is_numeric($cantidad) && $cantidad > 0 && $cantidad <= $stockMaximo);
}

function validarDescuento($descuento) {
    return (is_numeric($descuento) && $descuento >= 0 && $descuento <= 20);
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

$botonAgregar = isset($_POST["btnAgregarProducto"]) ? $_POST["btnAgregarProducto"] : null;

if (!validarBoton($botonAgregar)) {
    mostrarError("ERROR 03 - ACCESO DENEGADO");
    exit;
}

$idProducto = isset($_POST['idProducto']) ? $_POST['idProducto'] : '';
$cantidad = isset($_POST['txtCantidad']) ? $_POST['txtCantidad'] : '';
$descuento = isset($_POST['txtDescuento']) ? $_POST['txtDescuento'] : 0;

// Obtener producto
include_once("controllerProducto.php");
$objControllerProducto = new controllerProducto();
$resultadoProducto = $objControllerProducto->obtenerProductoPorId($idProducto);

if (!$resultadoProducto['success']) {
    mostrarError("ERROR 03 - Producto no encontrado");
    exit;
}

$producto = $resultadoProducto['data'];

// Validar cantidad
if (!validarCantidad($cantidad, $producto['STOCK'])) {
    mostrarError("ERROR 03 - Cantidad inválida. Stock disponible: " . $producto['STOCK']);
    exit;
}

// Validar descuento
if (!validarDescuento($descuento)) {
    mostrarError("ERROR 03 - Descuento inválido. Máximo permitido: 20%");
    exit;
}

// Agregar producto
include_once("controllerProforma.php");
$objControllerProforma = new controllerProforma();

$resultadoAgregar = $objControllerProforma->agregarProducto(
    $producto['ID'],
    $producto['NOMBRE'],
    $producto['PRECIO'],
    $cantidad,
    $descuento
);

if ($resultadoAgregar['success']) {
    $objControllerProforma->mostrarProformaActual();
} else {
    mostrarError($resultadoAgregar['error']);
}
?>
