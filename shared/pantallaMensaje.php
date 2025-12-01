<?php
include_once("formulario.php");

class pantallaMensaje extends formulario
{
    public function mensajeShow($tipo, $mensaje, $enlace)
    {
        $this->cabeceraShow(2);
        switch($tipo)
        {
            case 1: $titulo = "MENSAJE DE ERROR"; break;
            case 2: $titulo = "MENSAJE DE ADVERTENCIA"; break;
            case 3: $titulo = "MENSAJE DE EXITO"; break;
            default: $titulo = "MENSAJE DEL SISTEMA"; break;
        }
        ?>
        <div style="text-align: center; padding: 20px;">
            <p>
                <strong><?php echo $titulo; ?></strong>
            </p>
            <p>
                <?php echo $mensaje;?>
            </p>
            <p>
                <?php echo $enlace;?>
            </p>
        </div>
        <br>
        <?php  // <--- AQUÍ ESTABA EL ERROR (antes decía <?)
        $this->piePaginaShow();
    }
}
?>