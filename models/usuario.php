<?php
include_once("conexion.php");

class usuario extends conexion
{
    public function validarLogin($login)
    {
        $link = $this->conectarBD();
        $loginSeguro = $link->real_escape_string($login);
        $cadena = "SELECT login FROM usuarios WHERE login = '$loginSeguro'";
        $resultado = $link->query($cadena);
        $filas = 0;
        if ($resultado) {
            $filas = $resultado->num_rows;
        }
        $this->desConectarBD($link);

        if($filas != 1)
            return 0;
        else
            return 1;
    }

    public function validarLoginPassword($login, $password)
    {
        $link = $this->conectarBD();

        $loginSeguro = $link->real_escape_string($login);
        $passwordSeguro = $link->real_escape_string($password);

        $cadena = "SELECT login FROM usuarios WHERE login = '$loginSeguro' AND password = '$passwordSeguro'";

        $resultado = $link->query($cadena);

        $filas = 0;
        if ($resultado) {
            $filas = $resultado->num_rows;
        }

        $this->desConectarBD($link);

        if($filas != 1)
            return 0;
        else
            return 1;
    }
}
?>