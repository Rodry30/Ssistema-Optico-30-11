<?php
session_start();

function validarBoton($boton) {
    return isset($boton);
}

function mostrarMensaje($tipo, $mensaje, $enlace) {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow($tipo, $mensaje, $enlace);
}

$botonEmitir = isset($_POST["btnEmitir"]) ? $_POST["btnEmitir"] : null;

if (!validarBoton($botonEmitir)) {
    mostrarMensaje(
        1,
        "ERROR 07 - ACCESO DENEGADO",
        "<a href='../../securityModule/pantallaPanelControl.php'>Volver al panel</a>"
    );
    exit;
}

// Guardar proforma
include_once("controllerProforma.php");
$objControllerProforma = new controllerProforma();
$idGenerado = $objControllerProforma->guardarProforma();

if ($idGenerado > 0) {
    // ÉXITO
    mostrarMensaje(
        3, // Tipo éxito (verde)
        "✅ PROFORMA GENERADA EXITOSAMENTE<br><br>Número de Proforma: <b>#$idGenerado</b>",
        "<form action='../../securityModule/getPanel.php' method='POST' style='display:inline; margin-top:15px;'>
                <button type='submit' style='padding:12px 30px; background:#007bff; color:white; 
                    border:none; border-radius:5px; cursor:pointer; font-size:1.1em; 
                    font-weight:bold; box-shadow: 0 2px 5px rgba(0,0,0,0.2);'>
                    Volver al Panel de Control
                </button>
                </form>");
} else {
    // ERROR

    mostrarMensaje(
        1, // Tipo error (rojo)
        "❌ ERROR AL GENERAR LA PROFORMA<br><br>No se pudo guardar la proforma. Por favor, intente nuevamente o contacte al administrador.",
        "<form action='./getResumen.php' method='POST' style='display:inline; margin-top:15px;'>
                <button type='submit' style='padding:12px 30px; background:#007bff; color:white; 
                    border:none; border-radius:5px; cursor:pointer; font-size:1.1em; 
                    font-weight:bold; box-shadow: 0 2px 5px rgba(0,0,0,0.2);'>
                    intentar nuevamente
                </button>
                </form>"
    );
}
?>
