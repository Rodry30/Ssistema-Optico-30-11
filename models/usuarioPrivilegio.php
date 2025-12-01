<?php
include_once("conexion.php");

class usuarioPrivilegio extends conexion
{
    public function obtenerListaPrivilegios($login)
    {
        $link = $this->conectarBD();

        $loginSeguro = $link->real_escape_string($login);

        $cadena = "SELECT P.labelPrivilegio, P.pathPrivilegio, P.iconPrivilegio
                   FROM usuarios U, privilegios P, usuariosPrivilegios UP
                   WHERE U.login = '$loginSeguro' AND
                         U.estado = 1 AND
                         U.login = UP.login AND
                         P.idPrivilegio = UP.idPrivilegio";

        $resultado = $link->query($cadena);

        $listaPrivilegios = array();
        $filas = 0;

        if ($resultado) {
            $filas = $resultado->num_rows;

            while ($fila = $resultado->fetch_assoc()) {
                $listaPrivilegios[] = $fila;
            }
        }

        $this->desConectarBD($link);

        if($filas == 0)
            return NULL;
        else
            return $listaPrivilegios;
    }
}
?>