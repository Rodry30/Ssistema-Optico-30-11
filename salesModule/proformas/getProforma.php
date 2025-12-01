<?php
include_once("controllerProforma.php");
include_once("controllerProducto.php");
include_once("formularioProforma.php");
include_once(__DIR__ ."/../../shared/pantallaMensaje.php");

session_start();
$ctrlProf = new controllerProforma();

if(isset($_POST['btnAgregar'])) {
    // Validar Stock antes de agregar
    $ctrlProd = new ControllerProducto();
    $cantidad = $_POST['cantidad'];
    $idProd = $_POST['idProducto'];

    if($ctrlProd->validarStock($idProd, $cantidad)) {
        // Agregar a RAM
        $ctrlProf->agregarProductoLista($idProd, $_POST['nombre'], $_POST['precio'], $cantidad);

        // Volver a la vista limpia
        header("Location: getEnlaceProforma.php");
    } else {
        $msg = new pantallaMensaje();
        $msg->mensajeShow(2, "STOCK INSUFICIENTE", "<a href='getEnlaceProforma.php'>Volver</a>");
    }

} elseif(isset($_POST['btnEliminar'])) {
    // Eliminar de RAM
    $ctrlProf->eliminarProductoLista($_POST['indexEliminar']);
    header("Location: getEnlaceProforma.php");
}
?>