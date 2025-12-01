<?php
include_once(__DIR__ ."/../../shared/formulario.php");

class ResumenProforma extends formulario {
    public function resumenProformaShow($proforma, $receta) {
        $this->cabeceraShow(2);
        ?>
        <div class="card" style="max-width: 600px;">
            <h2>Resumen Final</h2>
            <p><strong>Cliente:</strong> <?php echo $proforma['cliente']['nombres']; ?></p>
            <p><strong>Total a Pagar:</strong> S/. <?php echo $proforma['total']; ?></p>

            <?php if($receta): ?>
                <div style="background: #e9ecef; padding: 10px; margin: 10px 0; border-radius: 5px;">
                    <h4>Receta Óptica Asociada</h4>
                    <p>OD: <?php echo $receta['esfera_od']; ?> | OI: <?php echo $receta['esfera_oi']; ?></p>
                </div>
            <?php else: ?>
                <p><em>No se seleccionó receta óptica.</em></p>
            <?php endif; ?>

            <form action="emitirProforma.php" method="POST" style="margin-top: 20px;">
                <input type="submit" name="btnEmitir" value="CONFIRMAR Y EMITIR" class="btn">
            </form>
            <br>
            <a href="getEnlaceProforma.php">Volver</a>
        </div>
        <?php
        $this->piePaginaShow();
    }
}
?>