<?php
class controlVerificarComprobante {
    public function validarComprobante($dni) {
      include_once("../../models/comprobante.php");
        $objNuevoUsuario = new usuario();
        $respuesta = $objNuevoUsuario -> esUsuario($login);
        if($respuesta)
        {
            $respuesta = $objNuevoUsuario -> verificarPassword($login,$password);
            if($respuesta)
            {
                include_once("../models/usuarioPrivilegio.php");
                $objNuevaLista = new usuarioPrivilegio();
                $listaPrivilegios = $objNuevaLista -> obtenerPrivilegios($login);
                if($listaPrivilegios == NULL)
                {
                    include_once("../shared/pantallaMensajeSistema.php");
                    $objMensaje = new pantallaMensajeSistema();
                    $objMensaje -> mensajeSistemaShow(3,"el usuario esta deshabilitado","<a href='../index.php'>ir al inicio</a>"); 
                }
                else
                {
                    session_start();
                    $_SESSION['login'] = $login;
                    include_once("formPanelControl.php");
                    $objNuevoPanel = new formPanelControl();
                    $objNuevoPanel -> formPanelControlShow($listaPrivilegios);
                }
            }
            else
            {
                include_once("../shared/pantallaMensajeSistema.php");
                $objMensaje = new pantallaMensajeSistema();
                $objMensaje -> mensajeSistemaShow(3,"el password iongresado es incorrecto","<a href='../index.php'>ir al inicio</a>"); 
            }
        }
        else
        {
            include_once("../shared/pantallaMensajeSistema.php");
            $objMensaje = new pantallaMensajeSistema();
            $objMensaje -> mensajeSistemaShow(3,"el login de usuario ingresado no esta registrado","<a href='../index.php'>ir al inicio</a>");
        }
    }
}
?>