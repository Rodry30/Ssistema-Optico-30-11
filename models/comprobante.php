<?php
include_once("conexion.php");

class comprobante extends conexion {

    // Obtener comprobantes pendientes por DNI
    public function obtenerComprobantesPorDNI($dni) {
        $link = $this->conectarBD();

        // IMPORTANTE: sanitizar DNI
        $dni = $link->real_escape_string($dni);

        $sql = "
                SELECT 
                    c.numero_comprobante AS NUMERO,
                    cl.nombres AS CLIENTE_NOMBRE,
                    SUM(dp.cantidad) AS CANTIDAD,
                    p.total AS IMPORTE,
                    c.estado AS ESTADO,
                    'Comprobante' AS TIPO
                FROM comprobantes c
                INNER JOIN proformas p ON c.id_proforma = p.idProforma
                INNER JOIN clientes cl ON p.idCliente = cl.idCliente
                INNER JOIN detalles_proforma dp ON p.idProforma = dp.idProforma
                WHERE cl.dni = '$dni'
                    AND c.estado = 'P'
                GROUP BY NUMERO, CLIENTE_NOMBRE, IMPORTE, ESTADO
            ";

        $result = $link->query($sql);

        $lista = [];

        if ($result && $result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $lista[] = $fila;
            }
        }

        $this->desConectarBD($link);
        return $lista; 
    }
}
?>
