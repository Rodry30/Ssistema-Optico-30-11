<?php
session_start();

function textoProducto($texto){
    include_once("controllerProducto.php");

    $controller = new ControllerProducto();
    $controller->nuevaBusqueda($texto);
}

//$texto = isset($_POST['textoBuscar']) ? $_POST['textoBuscar'] : "";
$texto = $_POST['textoBuscar'];
textoProducto($texto);
?>