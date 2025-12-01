<?php
class controllerProducto {

    public function buscarProductos($nombre) {
        include_once(__DIR__ . '/../../models/product.php');
        $objProducto = new Product();
        $productos = $objProducto->buscarProducto($nombre);

        if (empty($productos)) {
            return [
                'success' => false,
                'error' => 'No se encontraron productos',
                'nombre' => $nombre
            ];
        }

        return [
            'success' => true,
            'data' => $productos,
            'nombre' => $nombre
        ];
    }

    public function obtenerProductoPorId($idProducto) {
        include_once(__DIR__ . '/../../models/product.php');
        $objProducto = new Product();
        $producto = $objProducto->obtenerPorId($idProducto);

        if (!$producto) {
            return [
                'success' => false,
                'error' => 'Producto no encontrado'
            ];
        }

        return [
            'success' => true,
            'data' => $producto
        ];
    }
}
?>