<?php
include_once("conexion.php");

class proforma extends conexion {

    public function guardarProforma($idCliente, $total, $listaDetalles) {
        $link = $this->conectarBD();

        // Iniciar transacción para garantizar integridad
        $link->begin_transaction();

        try {
            // 1. Guardar Cabecera
            $fecha = date('Y-m-d');
            $stmt = $link->prepare("INSERT INTO proformas (idCliente, fecha, total) VALUES (?, ?, ?)");
            $stmt->bind_param("isd", $idCliente, $fecha, $total);

            if (!$stmt->execute()) {
                throw new Exception("Error al guardar proforma");
            }

            $idProforma = $link->insert_id;
            $stmt->close();

            // 2. Guardar Detalles
            $stmtDet = $link->prepare("INSERT INTO detalles_proforma (idProforma, idProducto, cantidad, precioUnitario, subtotal) VALUES (?, ?, ?, ?, ?)");

            foreach($listaDetalles as $det) {
                $idProd = $det['idProducto'];
                $cant = $det['cantidad'];
                $pu = $det['precio'];
                $sub = $det['subtotal'];

                $stmtDet->bind_param("iiidd", $idProforma, $idProd, $cant, $pu, $sub);

                if (!$stmtDet->execute()) {
                    throw new Exception("Error al guardar detalle");
                }
            }

            $stmtDet->close();

            // Confirmar transacción
            $link->commit();
            $this->desConectarBD($link);

            return $idProforma;

        } catch (Exception $e) {
            // Revertir cambios si hay error
            $link->rollback();
            $this->desConectarBD($link);
            return 0;
        }
    }

    public function obtenerProformasPorDNI($dni) {
        $link = $this->conectarBD();

        $stmt = $link->prepare("
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
            WHERE c.dni = ? AND p.estado = 'P'
            GROUP BY NUMERO, CLIENTE_NOMBRE, IMPORTE, ESTADO
        ");

        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }

        $stmt->close();
        $this->desConectarBD($link);
        return $lista;
    }

    public function obtenerDetalleProforma($numero) {
        $link = $this->conectarBD();

        $stmt = $link->prepare("
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
            WHERE p.idProforma = ?
        ");

        $stmt->bind_param("i", $numero);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }

        $stmt->close();
        $this->desConectarBD($link);
        return $lista;
    }
}
?>

