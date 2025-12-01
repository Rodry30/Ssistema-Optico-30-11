<?php
include_once(__DIR__ . "/../../shared/formulario.php");

class formularioProforma extends formulario
{
    public function formularioProformaShow($cliente, $productosEncontrados = null, $proformaActual = null)
    {
        // Si no hay proforma actual, obtenerla
        if ($proformaActual == null) {
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            $proformaActual = isset($_SESSION['proforma_ram']) ? $_SESSION['proforma_ram'] : null;
        }

        $dniCliente = htmlspecialchars($cliente["dni"]);
        $nombreCliente = htmlspecialchars($cliente["nombres"]);

        // Datos de receta si existen
        $tieneReceta = isset($proformaActual['receta']) && $proformaActual['receta'] != null;
        $fechaReceta = $tieneReceta ? htmlspecialchars($proformaActual['receta']['fechaReceta']) : '';
        $esferaOD = $tieneReceta ? htmlspecialchars($proformaActual['receta']['esfera_od']) : '';

        $this->cabeceraShow(2);
        ?>

        <div style='width:90%; margin:20px auto;'>
            <h2 style='text-align:center;'>Generar Proforma</h2>

            <!-- DATOS DEL CLIENTE -->
            <div style='margin: 15px 0; padding:10px; background:#eef; border-left:4px solid #55f;'>
                <label><b>Cliente:</b></label>
                <span style='padding:8px; border:1px solid #ccc; border-radius:4px; background:#fafafa;'>
                    <?php echo $nombreCliente; ?>
                </span>

                <label style='margin-left:20px;'><b>DNI:</b></label>
                <span style='padding:8px; border:1px solid #ccc; border-radius:4px; background:#fafafa;'>
                    <?php echo $dniCliente; ?>
                </span>
            </div>

            <!-- DATOS DE RECETA (si existe) -->
            <?php if ($tieneReceta): ?>
                <div style='margin: 15px 0; padding:10px; background:#efe; border-left:4px solid #5f5;'>
                    <label><b>Receta Óptica:</b></label>
                    <span style='padding:8px; border:1px solid #ccc; border-radius:4px; background:#fafafa; margin-left:10px;'>
                    Fecha: <?php echo $fechaReceta; ?>
                </span>
                    <span style='padding:8px; border:1px solid #ccc; border-radius:4px; background:#fafafa; margin-left:10px;'>
                    Esfera OD: <?php echo $esferaOD; ?>
                </span>
                </div>
            <?php else: ?>
                <!-- BOTÓN BUSCAR RECETA -->
                <div style='margin: 15px 0;'>
                    <form action='getRecetaOpt.php' method='POST' style='display:inline;'>
                        <input type='submit' name='btnBuscarReceta' value='BUSCAR RECETA ÓPTICA'
                               style='background:#28a745; color:white; padding:8px 15px; border:none;
                           border-radius:4px; cursor:pointer; font-size:14px;'>
                    </form>
                </div>
            <?php endif; ?>

            <!-- BÚSQUEDA DE PRODUCTOS -->
            <div style='margin: 25px 0; padding:15px; background:#fff; border:2px solid #007bff; border-radius:5px;'>
                <h3 style='margin-top:0;'>🔍 Buscar Productos</h3>
                <form action='getProducto.php' method='POST'>
                    <div style='display:flex; gap:10px; align-items:end;'>
                        <div style='flex:1;'>
                            <label><b>Nombre del Producto:</b></label><br>
                            <input type='text' name='txtProducto'
                                   placeholder='Ej: lentes, armazón...'
                                   style='width:100%; padding:10px; font-size:14px; border:1px solid #ccc; border-radius:4px;'
                                   required>
                        </div>
                        <div>
                            <input type='submit' name='btnBuscarProducto' value='BUSCAR'
                                   style='padding:10px 25px; background:#007bff; color:white;
                                   border:none; border-radius:4px; cursor:pointer; font-size:14px; font-weight:bold;'>
                        </div>
                    </div>
                </form>
            </div>

            <!-- LISTA DE PRODUCTOS ENCONTRADOS (si hay búsqueda) -->
            <?php if ($productosEncontrados != null && !empty($productosEncontrados)): ?>
                <div style='margin: 15px 0; padding:15px; background:#ffffcc; border:2px solid #ffc107; border-radius:5px;'>
                    <h3 style='margin-top:0;'>✅ Productos Encontrados (<?php echo count($productosEncontrados); ?>)</h3>
                    <table border='1' cellspacing='0' cellpadding='10' style='width:100%; border-collapse:collapse;'>
                        <tr style='background:#f8f9fa; font-weight:bold;'>
                            <td>Producto</td>
                            <td>Precio Unitario</td>
                            <td>Stock Disponible</td>
                            <td>Cantidad</td>
                            <td>Descuento %</td>
                            <td>Acción</td>
                        </tr>
                        <?php foreach($productosEncontrados as $prod): ?>
                            <tr>
                                <form action='getAgregarProducto.php' method='POST'>
                                    <td><b><?php echo htmlspecialchars($prod['NOMBRE']); ?></b></td>
                                    <td>S/ <?php echo number_format($prod['PRECIO'], 2); ?></td>
                                    <td style='text-align:center; color:#28a745; font-weight:bold;'>
                                        <?php echo $prod['STOCK']; ?> unidades
                                    </td>
                                    <td style='text-align:center;'>
                                        <input type='number' name='txtCantidad'
                                               min='1' max='<?php echo $prod['STOCK']; ?>'
                                               value='1'
                                               style='width:70px; padding:6px; text-align:center; font-size:14px;'
                                               required>
                                    </td>
                                    <td style='text-align:center;'>
                                        <input type='number' name='txtDescuento'
                                               min='0' max='20' value='0' step='0.01'
                                               style='width:70px; padding:6px; text-align:center; font-size:14px;'
                                               required>
                                        <small style='display:block; color:#666;'>Máx: 20%</small>
                                    </td>
                                    <td style='text-align:center;'>
                                        <input type='hidden' name='idProducto' value='<?php echo $prod['ID']; ?>'>
                                        <input type='submit' name='btnAgregarProducto' value='➕ AGREGAR'
                                               style='padding:8px 15px; background:#28a745; color:white;
                                       border:none; border-radius:4px; cursor:pointer; font-weight:bold;'>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>

            <!-- TABLA DE PRODUCTOS EN LA PROFORMA -->
            <h3 style='margin-top:30px;'>🛒 Productos en la Proforma</h3>
            <table border='1' cellspacing='0' cellpadding='8'
                   style='width:100%; border-collapse:collapse; text-align:center;'>
                <tr style='background:#343a40; color:white; font-weight:bold;'>
                    <td>Producto</td>
                    <td>Stock</td>
                    <td>Cantidad</td>
                    <td>P/U</td>
                    <td>Subtotal</td>
                    <td>Descuento %</td>
                    <td>Total</td>
                    <td>Acción</td>
                </tr>
                <?php
                if (isset($proformaActual['detalles']) && !empty($proformaActual['detalles'])):
                    foreach($proformaActual['detalles'] as $index => $detalle):
                        ?>
                        <tr style='background:#f8f9fa;'>
                            <td><b><?php echo htmlspecialchars($detalle['nombre']); ?></b></td>
                            <td>-</td>
                            <td><?php echo $detalle['cantidad']; ?></td>
                            <td>S/ <?php echo number_format($detalle['precio'], 2); ?></td>
                            <td>S/ <?php echo number_format($detalle['subtotalSinDescuento'], 2); ?></td>
                            <td><?php echo $detalle['descuento']; ?>%</td>
                            <td style='font-weight:bold; color:#28a745;'>
                                S/ <?php echo number_format($detalle['subtotal'], 2); ?>
                            </td>
                            <td>
                                <form action='getProductoLista.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='indiceProducto' value='<?php echo $index; ?>'>
                                    <input type='submit' name='btnEliminarProducto' value='🗑️ Eliminar'
                                           style='background:#dc3545; color:white; border:none;
                                   padding:6px 12px; cursor:pointer; border-radius:4px; font-weight:bold;'>
                                </form>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan='8' style='text-align:center; padding:30px; color:#999; font-style:italic;'>
                            ℹ️ No hay productos agregados. Use el buscador para agregar productos.
                        </td>
                    </tr>
                <?php endif; ?>

                <!-- FILA DE TOTAL -->
                <tr style='background:#28a745; color:white; font-weight:bold; font-size:1.2em;'>
                    <td colspan='6' style='text-align:right; padding-right:15px;'>TOTAL GENERAL:</td>
                    <td style='font-size:1.3em;'>S/ <?php echo number_format($proformaActual['total'], 2); ?></td>
                    <td></td>
                </tr>
            </table>

            <!-- BOTONES DE ACCIÓN FINAL -->
            <div style='margin-top:30px; text-align:center; padding:20px; background:#f8f9fa; border-radius:5px;'>

                <!-- BOTÓN VER RESUMEN -->
                <form action='getResumen.php' method='POST' style='display:inline;'>
                    <input type='submit' name='btnVerResumen' value='📋 VER RESUMEN'
                           style='background:#17a2b8; color:white; padding:15px 40px;
               font-size:1.2em; border:none; border-radius:5px; cursor:pointer;
               font-weight:bold; margin-right:15px;'>
                </form>

                <form action='../../securityModule/getPanel.php' method='POST' style='display:inline;'>
                    <button type='submit'
                            style='background:#6c757d; color:white; padding:15px 40px;
                            border:none; border-radius:5px; cursor:pointer;
                            font-size:1.2em; font-weight:bold;'>
                        ❌ CANCELAR
                    </button>
                </form>
            </div>
        </div>

        <?php
        $this->piePaginaShow();
    }
}
?>