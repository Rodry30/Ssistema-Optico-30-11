<?php
class controllerCliente {

    public function buscarCliente($dni) {
        include_once(__DIR__ . '/../../models/client.php');
        $objCliente = new client();
        $cliente = $objCliente->verificar($dni);

        if ($cliente == NULL) {
            return [
                'success' => false,
                'error' => 'Cliente no encontrado',
                'dni' => $dni
            ];
        }

        return [
            'success' => true,
            'data' => $cliente,
            'dni' => $dni
        ];
    }
}
?>