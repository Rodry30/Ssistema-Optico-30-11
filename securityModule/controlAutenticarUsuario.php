<?php
class controlAutenticarUsuario
{
    public function validarAcceso($login, $password)
    {
        include_once("../models/usuario.php");
        $objUsuario = new usuario();
        $respuesta = $objUsuario->validarLogin($login);

        if($respuesta)
        {
            $respuesta = $objUsuario->validarLoginPassword($login, $password);

            if($respuesta)
            {
                include_once("../models/usuarioPrivilegio.php");
                $objusuarioPriv = new usuarioPrivilegio();
                $listaPrivilegios = $objusuarioPriv->obtenerListaPrivilegios($login);

                if($listaPrivilegios != NULL)
                {
                    // IMPORTANTE: Iniciar sesión ANTES de guardar datos
                    session_start();

                    // Guardar datos en sesión
                    $_SESSION['login'] = $login;
                    $_SESSION['privilegios'] = $listaPrivilegios;
                    $_SESSION['autenticado'] = true; // Flag adicional de seguridad
                    $_SESSION['tiempo_login'] = time(); // Para debugging

                    // Redirigir al panel
                    header("Location: getPanel.php");
                    exit();
                }
                else
                {
                    include_once("../shared/pantallaMensaje.php");
                    $objMensaje = new pantallaMensaje();
                    $objMensaje->mensajeShow(
                        1,
                        "ERROR 05 - EL USUARIO ESTÁ DESHABILITADO O NO TIENE PRIVILEGIOS",
                        "<a href='../index.php'>Ir al inicio</a>"
                    );
                }
            }
            else
            {
                include_once("../shared/pantallaMensaje.php");
                $objMensaje = new pantallaMensaje();
                $objMensaje->mensajeShow(
                    1,
                    "ERROR 04 - EL PASSWORD ES INCORRECTO",
                    "<a href='../index.php'>Ir al inicio</a>"
                );
            }
        }
        else
        {
            include_once("../shared/pantallaMensaje.php");
            $objMensaje = new pantallaMensaje();
            $objMensaje->mensajeShow(
                1,
                "ERROR 03 - EL LOGIN DE USUARIO INGRESADO NO ESTÁ REGISTRADO",
                "<a href='../index.php'>Ir al inicio</a>"
            );
        }
    }
}
?>