<?php
include_once("conexion.php");

class client extends conexion {

    public function verificar($dni) {
        $link = $this->conectarBD();
        $dni = $link->real_escape_string($dni);

        $sql = "SELECT * FROM clientes WHERE dni = '$dni' AND estado = 1";
        $cliente = $link->query($sql);

        $respuesta = null;
        if ($cliente&& $cliente->num_rows == 1) {
            $respuesta = $cliente->fetch_assoc();
        }

        $this->desConectarBD($link);
        return $respuesta;  
    }
}
?>
