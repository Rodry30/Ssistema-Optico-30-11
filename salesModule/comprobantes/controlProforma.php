<?php
class controlProforma {
public function buscarProformasPorDni($listaComprobantes,$dni){
     include_once(__DIR__ . "/../../models/proforma.php");
        $objProforma= new proforma();
        $listaProformas = $objProforma->obtenerProformasPorDNI($dni);
        $_SESSION['listaProformas'] = $listaProformas;
        
        if (($listaComprobantes == NULL or count($listaComprobantes) == 0) and ($listaProformas == NULL or count($listaProformas) == 0) ) {
            include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
            $objMensaje = new pantallaMensaje();
            $objMensaje->mensajeShow(
                1,
                "Comprobante y proforma no encontrado",
                "<form action='getEnlaceComprobante.php' method='post' style='display:inline'>
                    <input type='hidden' name='botonEnlace' value='1'>
                    <button type='submit' class='btn-link' style='background:none;border:none;color:#06c;padding:0;cursor:pointer;'>Volver</button>
                 </form>"
            );

        } else {
            include_once("ventasporConcretar.php");
            $vista = new ventasporConcretar();
            $vista->ventasporConcretarShow($listaComprobantes, $listaProformas);
        }  
    } 
}
?>