<?php
session_start();

function validarBotonBuscar($botonBuscar){
    return isset($botonBuscar);
}

function validarTexto($dni) {
    return (ctype_digit($dni) && strlen($dni) == 8);
}


$botonBuscar = isset($_POST["btnBuscar"]) ? $_POST["btnBuscar"] : null;

if (validarBotonBuscar($botonBuscar)){
    $dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : '';

    if (validarTexto($dni)){

        include_once("controlCliente.php");
        $objControlCliente = new controlCliente();
        $objControlCliente->validarCliente($dni);

    } else {

        include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
        $objMensaje = new pantallaMensaje();
        $objMensaje->mensajeShow(
             1,
    "ERROR 01 - DATOS NO VALIDOS. Intente nuevamente",
    "<form action='getEnlaceComprobante.php' method='post' style='display:inline'>
        <input type='hidden' name='botonEnlace' value='1'>
        <button type='submit' class='btn-link' style='background:none;border:none;color:#06c;padding:0;cursor:pointer;'>Volver a intentar</button>
    </form>"
);
    }

} else {
    include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        "ERROR 01 - ACCESO DENEGADO",
        "<a href='getEnlaceComprobante.php'>Volver al panel</a>"
    );
}

?>
