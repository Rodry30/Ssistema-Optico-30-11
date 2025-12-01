<?php
class controlComprobanteProforma {
    public function procesarComprobanteProforma($tipo,$numero){
       if ($tipo == "PROFORMA") {

            include_once(__DIR__ . "/../../models/proforma.php");
            $objProforma = new proforma();
            $detalle = $objProforma->obtenerDetalleProforma($numero);

            $_SESSION['detalleProforma'] = $detalle;

            include_once("controlProforma.php");
            $objControl = new controlProforma();
            $objControl->mostrarDetalleProforma($detalle);

        } elseif ($tipo == "COMPROBANTE") {

            include_once(__DIR__ . "/../../models/comprobante.php");
            $objComp = new comprobante();
            $detalle = $objComp->obtenerDetalleComprobante($numero);

            $_SESSION['detalleComprobante'] = $detalle;

            include_once("controlComprobante.php");
            $objControl = new controlComprobante();
            $objControl->mostrarDetalleComprobante($detalle);

        } else {
            echo "ERROR: tipo no válido.";
        }           
    }
}