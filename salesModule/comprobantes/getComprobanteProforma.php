<?php
session_start();

function validarBotonRegresar($botonRegresar){
    return isset($botonRegresar);
}

function validarBotonComprobanteProforma($botonComprobanteProforma){
    return isset($botonComprobanteProforma);
}

$botonRegresar = isset($_POST['botonRegresar']) ? $_POST['botonRegresar'] : null;
$botonComprobanteProforma = isset($_POST['botonComprobanteProforma']) ? $_POST['botonComprobanteProforma'] : null;
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
$numero = isset($_POST["numero"]) ? $_POST["numero"] : null;

if (validarBotonRegresar($botonRegresar)){
    header("Location: getEnlaceComprobante.php");
    exit();
}elseif (validarBotonComprobanteProforma($botonComprobanteProforma))
{
    include_once("controlComprobanteProforma.php");
    $objControl = new controlComprobanteProforma();
    $objControl->procesarComprobanteProforma($tipo, $numero);
}
else
{
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        "ERROR 01 - Acceso Denegado",
        "<form action='getEnlaceComprobante.php' method='post' style='display:inline'>
            <input type='hidden' name='botonEnlace' value='1'>
            <button type='submit' class='btn-link' style='background:none;border:none;color:#06c;padding:0;cursor:pointer;'>Volver a intentar</button>
    </form>"
    ); 
}