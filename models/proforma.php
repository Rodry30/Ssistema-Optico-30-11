<?php
include_once("conexion.php");

class proforma extends conexion {
    // En RAM usamos la sesión, este modelo persiste en BD
    public function guardarProforma($idCliente, $total, $listaDetalles) {
        $link = $this->conectarBD();

        // 1. Guardar Cabecera
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO proformas (idCliente, fecha, total) VALUES ($idCliente, '$fecha', $total)";

        if($link->query($sql)) {
            $idProforma = $link->insert_id; // Obtener ID generado

            // 2. Guardar Detalles (Cascada)
            foreach($listaDetalles as $det) {
                $idProd = $det['idProducto'];
                $cant = $det['cantidad'];
                $pu = $det['precio'];
                $sub = $det['subtotal'];

                $sqlDet = "INSERT INTO detalles_proforma (idProforma, idProducto, cantidad, precioUnitario, subtotal) 
                           VALUES ($idProforma, $idProd, $cant, $pu, $sub)";
                $link->query($sqlDet);
            }

            $this->desConectarBD($link);
            return $idProforma; // Retornamos el ID para emitir el PDF
        } else {
            $this->desConectarBD($link);
            return 0;
        }
    }

    public function obtenerProformasPorDNI($dni) {
        $link = $this->conectarBD();

        $sql = "
           SELECT 
                p.idProforma AS NUMERO,
                c.nombres AS CLIENTE_NOMBRE,
                SUM(dp.cantidad) AS CANTIDAD,
                p.total AS IMPORTE,
                p.estado AS ESTADO,
                'Proforma' AS TIPO
            FROM proformas p
            INNER JOIN clientes c ON p.idCliente = c.idCliente
            INNER JOIN detalles_proforma dp ON p.idProforma = dp.idProforma
            WHERE c.dni = '$dni'
                AND p.estado = 'P'
            GROUP BY NUMERO, CLIENTE_NOMBRE, IMPORTE, ESTADO
            ";

        $resultado = $link->query($sql);

        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }

        $this->desConectarBD($link);
        return $lista;
    }

    public function obtenerDetalleProforma($numero) {
    $link = $this->conectarBD();

    $sql = "
       SELECT 
                    p.idProforma AS numero,
                    c.nombres AS cliente,
                    c.dni,
                    p.fecha,
                    p.total,
                    p.estado,
                    d.cantidad,
                    d.precioUnitario,
                    d.subtotal,
                    pr.nombre AS producto
                FROM proformas p
                INNER JOIN clientes c ON p.idCliente = c.idCliente
                INNER JOIN detalles_proforma d ON p.idProforma = d.idProforma
                INNER JOIN productos pr ON d.idProducto = pr.idProducto
                WHERE p.idProforma = ?";

    $resultado = $link->query($sql);

    $lista = [];
    while ($fila = $resultado->fetch_assoc()) {
        $lista[] = $fila;
    }

    $this->desConectarBD($link);
    return $lista;
}
}
?>

