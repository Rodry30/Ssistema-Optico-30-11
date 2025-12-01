<?php
class controlCliente {

    public function validarCliente($dni) {

        include_once(__DIR__ . '/../../models/client.php');
        $objCliente = new client();
        $respuesta = $objCliente->verificar($dni);

        if ($respuesta == NULL) {

            include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
            $objMensaje = new pantallaMensaje();
            $objMensaje->mensajeShow(
                1,
                "ERROR 01 - DNI no encontrado",
                "<form action='getEnlaceComprobante.php' method='post' style='display:inline'>
                    <input type='hidden' name='botonEnlace' value='1'>
                    <button type='submit' class='btn-link' style='background:none;border:none;color:#06c;padding:0;cursor:pointer;'>Volver a intentar</button>
                 </form>"
            );

        } else {
            $_SESSION['dni'] = $dni;
            include_once("controlComprobante.php");
            $objControlC = new controlComprobante();
            $objControlC->buscarComprobantesPorDni($dni);
        }

    }
}
?>
