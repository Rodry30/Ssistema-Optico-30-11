<?php

class controlComprobante {

    public function buscarComprobantesPorDni($dni) {
        include_once(__DIR__ . "/../../models/comprobante.php");
        $objComprob = new comprobante();
        $listaComprobantes = $objComprob->obtenerComprobantesPorDNI($dni);
        $_SESSION['listaComprobantes'] = $listaComprobantes;
            include_once("controlProforma.php");
            $objControlC = new controlProforma();
            $objControlC->buscarProformasPorDni($listaComprobantes, $dni);      
     } 
    }
?>
