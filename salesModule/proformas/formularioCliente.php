<?php
include_once(__DIR__ . '/../../shared/formulario.php');

class FormularioCliente extends formulario {
    public function formularioClienteShow() {
        $this->cabeceraShow(2); // 2 para rutas internas
        ?>
        <div class="card">
            <h2>Paso 1: Buscar Cliente</h2>
            <form action="getCliente.php" method="POST">
                <div class="form-group">
                    <label>Ingrese DNI del Cliente:</label>
                    <input type="text" name="txtDni" class="form-control" maxlength="8" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnBuscar" value="BUSCAR CLIENTE" class="btn">
                </div>
            </form>
        </div>
        <?php
        $this->piePaginaShow();
    }
}
?>