<?php
include_once(__DIR__ . "/../../shared/formulario.php");

class ResumenProforma extends formulario {

    public function resumenProformaShow($proforma, $receta) {
        $this->cabeceraShow(2);
        ?>

        <div style="max-width: 800px; margin: 30px auto; padding: 20px;">

            <h2 style="text-align:center; color:#007bff; margin-bottom:30px;">
                📋 Resumen Final de Proforma
            </h2>

            <!-- DATOS DEL CLIENTE -->
            <div style="background:#f8f9fa; padding:20px; border-radius:8px; margin-bottom:20px; border-left:5px solid #007bff;">
                <h3 style="margin-top:0; color:#343a40;">👤 Datos del Cliente</h3>
                <p style="margin:8px 0;"><strong>Nombre:</strong> <?php echo htmlspecialchars($proforma['cliente']['nombres']); ?></p>
                <p style="margin:8px 0;"><strong>DNI:</strong> <?php echo htmlspecialchars($proforma['cliente']['dni']); ?></p>
            </div>

            <!-- RECETA ÓPTICA -->
            <?php if($receta): ?>
                <div style="background:#d4edda; padding:20px; border-radius:8px; margin-bottom:20px; border-left:5px solid #28a745;">
                    <h3 style="margin-top:0; color:#155724;">👓 Receta Óptica Asociada</h3>
                    <p style="margin:8px 0;"><strong>Fecha:</strong> <?php echo htmlspecialchars($receta['fechaReceta']); ?></p>
                    <p style="margin:8px 0;"><strong>Esfera OD:</strong> <?php echo htmlspecialchars($receta['esfera_od']); ?></p>
                    <?php if(isset($receta['esfera_oi'])): ?>
                        <p style="margin:8px 0;"><strong>Esfera OI:</strong> <?php echo htmlspecialchars($receta['esfera_oi']); ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div style="background:#fff3cd; padding:15px; border-radius:8px; margin-bottom:20px; border-left:5px solid #ffc107;">
                    <p style="margin:0; color:#856404;"><em>ℹ️ No se asoció receta óptica a esta proforma.</em></p>
                </div>
            <?php endif; ?>

            <!-- DETALLE DE PRODUCTOS -->
            <div style="background:white; padding:20px; border-radius:8px; margin-bottom:20px; border:1px solid #dee2e6;">
                <h3 style="margin-top:0; color:#343a40;">🛒 Detalle de Productos</h3>
                <table border="1" cellspacing="0" cellpadding="10" style="width:100%; border-collapse:collapse;">
                    <thead>
                    <tr style="background:#343a40; color:white;">
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>P/U</th>
                        <th>Descuento</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($proforma['detalles'] as $detalle): ?>
                        <tr style="background:#f8f9fa;">
                            <td><strong><?php echo htmlspecialchars($detalle['nombre']); ?></strong></td>
                            <td style="text-align:center;"><?php echo $detalle['cantidad']; ?></td>
                            <td>S/ <?php echo number_format($detalle['precio'], 2); ?></td>
                            <td style="text-align:center;"><?php echo $detalle['descuento']; ?>%</td>
                            <td style="font-weight:bold; color:#28a745;">S/ <?php echo number_format($detalle['subtotal'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- TOTAL GENERAL -->
            <div style="background:#28a745; color:white; padding:20px; border-radius:8px; margin-bottom:30px; text-align:center;">
                <h2 style="margin:0; font-size:1.8em;">
                    💰 TOTAL A PAGAR: S/ <?php echo number_format($proforma['total'], 2); ?>
                </h2>
            </div>

            <!-- BOTONES DE ACCIÓN -->
            <div style="text-align:center; padding:20px;">
                <form action="getEmitir.php" method="POST" style="display:inline;">
                    <input type="submit" name="btnEmitir" value="✅ CONFIRMAR Y EMITIR PROFORMA"
                           style="background:#007bff; color:white; padding:15px 40px; font-size:1.2em;
                           border:none; border-radius:5px; cursor:pointer; font-weight:bold; margin-right:15px;">
                </form>

                <button onclick="history.back()"
                        style="background:#6c757d; color:white; padding:15px 40px; font-size:1.2em;
                        border:none; border-radius:5px; cursor:pointer; font-weight:bold;">
                    Volver a Editar
                </button>
            </div>
        </div>

        <?php
        $this->piePaginaShow();
    }
}
?>