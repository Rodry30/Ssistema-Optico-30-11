<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class controllerProforma {

    // ========== FLUJO PRINCIPAL ==========

    public function iniciarProforma() {
        $this->nuevaProforma();
        $this->mostrarFormularioCliente();
    }

    private function mostrarFormularioCliente() {
        include_once("formularioCliente.php");
        $form = new FormularioCliente();
        $form->formularioClienteShow();
    }

    public function procesarClienteEncontrado($cliente) {
        $this->setCliente($cliente);
        $this->mostrarProformaActual();
    }

    public function clienteNoEncontrado() {
        include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
        $objMensaje = new pantallaMensaje();
        $objMensaje->mensajeShow(
            1,
            "ERROR 01 - Cliente no encontrado",
            "<form action='getEnlaceProforma.php' method='post' style='display:inline'>
                <input type='hidden' name='botonEnlace' value='1'>
                <button type='submit' class='btn-link'>Volver a intentar</button>
            </form>"
        );
    }

    // ========== GESTIÓN DE PRODUCTOS ==========

    public function mostrarProductosEncontrados($productos) {
        $proformaActual = $this->obtenerProformaActual();

        include_once(__DIR__ . "/formularioProforma.php");
        $objForm = new formularioProforma();
        $objForm->formularioProformaShow($proformaActual['cliente'], $productos, $proformaActual);
    }

    public function productosNoEncontrados($nombreBuscado) {
        include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
        $objMensaje = new pantallaMensaje();
        $objMensaje->mensajeShow(
            1,
            "No se encontraron productos con el nombre: '$nombreBuscado'",
            "<button onclick='history.back()' style='padding:8px 15px; cursor:pointer;'>Volver</button>"
        );
    }

    public function agregarProducto($idProducto, $nombre, $precio, $cantidad, $descuento) {
        $this->nuevaProforma();

        // Verificar si el producto ya está en la lista
        foreach($_SESSION['proforma_ram']['detalles'] as $detalle) {
            if ($detalle['idProducto'] == $idProducto) {
                return [
                    'success' => false,
                    'error' => "ERROR 03 - El producto '$nombre' ya está en la lista. No puede agregarlo nuevamente."
                ];
            }
        }

        // Calcular subtotal con descuento
        $subtotalSinDescuento = $precio * $cantidad;
        $montoDescuento = $subtotalSinDescuento * ($descuento / 100);
        $subtotal = $subtotalSinDescuento - $montoDescuento;

        $detalle = array(
            'idProducto' => $idProducto,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'descuento' => $descuento,
            'subtotalSinDescuento' => $subtotalSinDescuento,
            'montoDescuento' => $montoDescuento,
            'subtotal' => $subtotal
        );

        $_SESSION['proforma_ram']['detalles'][] = $detalle;
        $this->refrescarTotal();

        return [
            'success' => true,
            'message' => 'Producto agregado exitosamente'
        ];
    }

    public function eliminarProductoLista($index) {
        if(isset($_SESSION['proforma_ram']['detalles'][$index])) {
            unset($_SESSION['proforma_ram']['detalles'][$index]);
            $_SESSION['proforma_ram']['detalles'] = array_values($_SESSION['proforma_ram']['detalles']);
            $this->refrescarTotal();
        }
    }

    // ========== GESTIÓN DE RECETA ÓPTICA ==========

    public function buscarReceta($idCliente) {
        include_once(__DIR__ . '/../../models/recetaOp.php');
        $objReceta = new RecetaOp();
        return $objReceta->buscarReceta($idCliente);
    }

    public function procesarRecetaEncontrada($receta) {
        $_SESSION['proforma_ram']['receta'] = $receta;
        $this->mostrarProformaActual();
    }

    public function recetaNoEncontrada() {
        include_once(__DIR__ . "/../../shared/pantallaMensaje.php");
        $objMensaje = new pantallaMensaje();
        $objMensaje->mensajeShow(
            2,
            "NO EXISTE RECETA PARA ESTE CLIENTE",
            "<button onclick='history.back()' style='padding:8px 15px; cursor:pointer;'>Continuar sin receta</button>"
        );
    }

    // ========== MOSTRAR VISTAS ==========

    public function mostrarProformaActual() {
        $proformaActual = $this->obtenerProformaActual();

        include_once(__DIR__ . "/formularioProforma.php");
        $objForm = new formularioProforma();
        $objForm->formularioProformaShow($proformaActual['cliente'], null, $proformaActual);
    }

    public function mostrarResumenProforma() {
        $proformaActual = $this->obtenerProformaActual();
        $receta = isset($proformaActual['receta']) ? $proformaActual['receta'] : null;

        include_once(__DIR__ . "/resumenProforma.php");
        $objResumen = new ResumenProforma();
        $objResumen->resumenProformaShow($proformaActual, $receta);
    }

    // ========== GUARDAR EN BASE DE DATOS ==========

    public function guardarProforma() {
        $proformaRam = $this->obtenerProformaActual();

        // Validar que tenga cliente y productos
        if(empty($proformaRam['cliente']) || empty($proformaRam['detalles'])) {
            return 0;
        }

        include_once(__DIR__ . '/../../models/proforma.php');
        $objProformaModel = new proforma();

        // Extraer datos
        $idCliente = $proformaRam['cliente']['idCliente'];
        $total = $proformaRam['total'];
        $detalles = $proformaRam['detalles'];

        // Guardar en BD
        $idGenerado = $objProformaModel->guardarProforma($idCliente, $total, $detalles);

        // Si se guardó exitosamente, limpiar RAM
        if($idGenerado > 0) {
            unset($_SESSION['proforma_ram']);
        }

        return $idGenerado;
    }

    // ========== MÉTODOS AUXILIARES ==========

    private function refrescarTotal() {
        $total = 0;
        foreach($_SESSION['proforma_ram']['detalles'] as $d) {
            $total += $d['subtotal'];
        }
        $_SESSION['proforma_ram']['total'] = $total;
    }

    public function nuevaProforma() {
        if(!isset($_SESSION['proforma_ram'])) {
            $_SESSION['proforma_ram'] = array(
                'cliente' => null,
                'detalles' => array(),
                'receta' => null,
                'total' => 0
            );
        }
    }

    public function setCliente($cliente) {
        $this->nuevaProforma();
        $_SESSION['proforma_ram']['cliente'] = $cliente;
    }

    public function obtenerProformaActual() {
        $this->nuevaProforma();
        return $_SESSION['proforma_ram'];
    }
}
?>