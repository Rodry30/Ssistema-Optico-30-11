<?php
session_start();

function validarBotonBuscar($botonBuscar) {
    return isset($botonBuscar);
}

function validarTexto($dni) {
    return (ctype_digit($dni) && strlen($dni) == 8);
}

function mostrarError($mensaje) {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        $mensaje,
        "<form action='getEnlaceProforma.php' method='post' style='display:inline'>
            <input type='hidden' name='botonEnlace' value='1'>
            <button type='submit' class='btn-link' style='background:none;border:none;color:#06c;padding:0;cursor:pointer;'>Volver a intentar</button>
        </form>"
    );
}

$botonBuscar = isset($_POST["btnBuscar"]) ? $_POST["btnBuscar"] : null;

if (!validarBotonBuscar($botonBuscar)) {
    mostrarError("ERROR 01 - ACCESO DENEGADO");
    exit;
}

$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : '';

if (!validarTexto($dni)) {
    mostrarError("ERROR 01 - DATOS NO VÁLIDOS. Intente nuevamente");
    exit;
}

// Buscar cliente a través de controllerCliente
include_once("controllerCliente.php");
$objControllerCliente = new controllerCliente();
$resultado = $objControllerCliente->buscarCliente($dni);

// Enviar resultado al orquestador principal (controllerProforma)
include_once("controllerProforma.php");
$objControllerProforma = new controllerProforma();

if ($resultado['success']) {
    // Cliente encontrado - pasar al orquestador
    $objControllerProforma->procesarClienteEncontrado($resultado['data']);
} else {
    // Cliente no encontrado - manejar error
    $objControllerProforma->clienteNoEncontrado();
}
?>