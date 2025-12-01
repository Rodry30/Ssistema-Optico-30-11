<?php
include_once("conexion.php");

class RecetaOp extends conexion {
    public function buscarReceta($idCliente) {
        $link = $this->conectarBD();
        $sql = "SELECT * FROM recetas WHERE idCliente = $idCliente ORDER BY fechaReceta DESC LIMIT 1";
        $res = $link->query($sql);

        $receta = null;
        if($res && $res->num_rows > 0){
            $receta = $res->fetch_assoc();
        }

        $this->desConectarBD($link);
        return $receta;
    }
}
?>