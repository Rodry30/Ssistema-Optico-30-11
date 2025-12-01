<?php
include_once("conexion.php");

class Product extends conexion {

    public function obtenerPorId($id) {
        $link = $this->conectarBD();

        $id = intval($id);

        if ($id <= 0) {
            $this->desConectarBD($link);
            return null;
        }

        $sql = "
            SELECT 
                stock AS STOCK, 
                nombre AS NOMBRE, 
                precio AS PRECIO, 
                idProducto AS ID
            FROM productos
            WHERE idProducto = $id
            LIMIT 1
        ";

        $resultado = $link->query($sql);

        $respuesta = null;
        if ($resultado) {
            if ($fila = $resultado->fetch_assoc()) {
                $respuesta = $fila;
            }
        }

        $this->desConectarBD($link);
        return $respuesta;
    }

    public function buscarProducto($texto) {
        $link = $this->conectarBD();
        $texto = $link->real_escape_string($texto);

        $sql = "
            SELECT 
                idProducto AS ID, 
                nombre AS NOMBRE,
                precio AS PRECIO, 
                stock AS STOCK
            FROM productos
            WHERE nombre LIKE '%$texto%' 
              AND estado = 1
            LIMIT 5
        ";

        $result = $link->query($sql);

        $respuesta = array();
        if ($result) {
            while($row = $result->fetch_assoc()){
                $respuesta[] = $row;
            }
        }

        $this->desConectarBD($link);
        return $respuesta;
    }

    public function listarProducto() {
        $link = $this->conectarBD();

        $sql = "
            SELECT 
                idProducto AS ID, 
                nombre AS NOMBRE,
                precio AS PRECIO, 
                stock AS STOCK 
            FROM productos
            WHERE estado = 1
        ";

        $resultado = $link->query($sql);

        $respuesta = [];
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $respuesta[] = $fila;
            }
        }

        $this->desConectarBD($link);
        return $respuesta;
    }
}
?>
