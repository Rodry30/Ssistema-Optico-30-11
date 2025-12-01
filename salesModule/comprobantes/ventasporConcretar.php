<?php
include_once(__DIR__ . "/../../shared/formulario.php");

class ventasporConcretar extends formulario
{
    public function ventasporConcretarShow($listaComprobantes,$listaProformas)
    {
        $listaFinal= array_Merge($listaComprobantes, $listaProformas);
        $nombreCliente = $listaFinal[0]["CLIENTE_NOMBRE"];

        $this->cabeceraShow(2);

        echo "
        <div style='width:80%; margin:20px auto;'>
            <label><b>Nombre</b></label><br>
            <input type='text' value='{$nombreCliente}' readonly 
                   style='width:250px; padding:5px; margin-top:5px; margin-bottom:20px;'> 

            <h3>Lista de Pendientes:</h3>

            <table border='1' cellspacing='0' cellpadding='5' style='width:100%; border-collapse:collapse; text-align:center;'>
                <tr style='background:#f4f4f4; font-weight:bold;'>
                    <td>proforma / comprobante</td>
                    <td>Cliente</td>
                    <td>Cantidad productos</td>
                    <td>fecha emisión</td>
                    <td>importe pendiente</td>
                    <td>Estado</td>
                </tr>
        ";

        foreach ($listaFinal as $item) {

            $cliente = $item["CLIENTE_NOMBRE"];
            $numero = $item["NUMERO"];
            $cantidad = $item["CANTIDAD"];
            $importe = $item["IMPORTE"];
            //$estado = $item["ESTADO"];
            $fecha = "----";
            $tipo = $item["TIPO"];
            echo "
                <tr>
                    <td>$numero</td>
                    <td>$cliente</td>
                    <td>$cantidad</td>
                    <td>$fecha</td>
                    <td>$importe</td>
                    <td> 
                        <form action='getComprobanteProforma.php' method='post'>
                            <input type='hidden' name='tipo' value='$tipo'>
                            <input type='hidden' name='numero' value='$numero'>
                            <button type='submit' name='botonComprobanteProforma' value='1'
                                style='padding:5px 12px; background:#0099ff; color:white; border:none; border-radius:5px; cursor:pointer;'>
                                {$tipo}
                            </button>
                        </form>
                    </td>
                </tr>
            ";
        }

        echo "
            </table>

            <br><br>
            <form action='getEnlaceComprobante.php' method='post'>
                <input type='hidden' name='botonRegresar' value='1'>
                <button style='padding:10px 20px; background:#ffeb94; border:1px solid #000; border-radius:6px; cursor:pointer;'>
                    Regresar
                </button>
            </form>
        </div>
        ";

        $this->piePaginaShow();
    }
}
?>
