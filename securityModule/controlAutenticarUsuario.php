<?php
    class controlAutenticarUsuario
    {
        public function validarAcceso($login,$password)
        {
            include_once("../models/usuario.php");
            $objUsuario = new usuario();
            $respuesta = $objUsuario->validarLogin($login);
            if($respuesta)
            {
                $respuesta = $objUsuario->validarLoginPassword($login,$password);
                if($respuesta)
                {
                    include_once("../models/usuarioPrivilegio.php");
                    $objusuarioPriv = new usuarioPrivilegio();
                    $listaPrivilegios = $objusuarioPriv->obtenerListaPrivilegios($login);
                    if($listaPrivilegios != NULL)
                    {
                        include_once("pantallaPanelcontrol.php");
                        $objPanel = new pantallaPanelcontrol();
                        $objPanel -> panelcontrolShow($listaPrivilegios);    
                    }
                    else
                    {
                        include_once("../shared/pantallaMensaje.php");
                        $objMensaje = new pantallaMensaje();
                        $objMensaje -> mensajeShow(1,"ERROR 05 - EL USUARIO ESTA DESHABILITADO!","<a href='../index.php'>ir al inicio</a>");
                    }
                }
                else
                {
                    include_once("../shared/pantallaMensaje.php");
                    $objMensaje = new pantallaMensaje();
                    $objMensaje -> mensajeShow(1,"ERROR 04 - EL PASSWORD ES INCORRECTO!","<a href='../index.php'>ir al inicio</a>");
                }
            }
            else
            {
                include_once("../shared/pantallaMensaje.php");
                $objMensaje = new pantallaMensaje();
                $objMensaje -> mensajeShow(1,"ERROR 03 - EL LOGIN DE USUARIO INGRESADO, NO ESTA REGISTRADO!","<a href='../index.php'>ir al inicio</a>");
            }
        }
    }
?>