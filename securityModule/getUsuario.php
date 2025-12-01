<?php
function validaBoton($boton)
{
    if(isset($boton))
        return 1;
    else
        return 0;
}
function validaTexto($login, $password)
{
    return strlen($login) > 3 and strlen($password) > 3;
}

if(validaBoton($_POST['btnAceptar']))
{
    $login = strtolower(trim($_POST['txtLogin']));
    $password = $_POST['txtPassword'];
    if(validaTexto($login,$password))
    {
        include_once("controlAutenticarUsuario.php");
        $objControlUsuario = new controlAutenticarUsuario();
        $objControlUsuario -> validarAcceso($login,$password);
    }
    else
    {
        include_once("../shared/pantallaMensaje.php");
        $objMensaje = new pantallaMensaje();
        $objMensaje -> mensajeShow(1,"ERROR 02 - DATOS NO VALIDOS!","<a href='../index.php'>ir al inicio</a>");
    }
}
else
{
    include_once("../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje -> mensajeShow(1,"ERROR 01 - ACCESO NO PERMITIDO!","<a href='../index.php'>ir al inicio</a>");
}

?>