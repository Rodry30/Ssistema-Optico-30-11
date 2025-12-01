<?php
include_once("./shared/formulario.php");

class formAutenticarUsuario extends formulario
{
    public function formAutenticarUsuarioShow()
    {
        $this->cabeceraShow(1);
        ?>

        <div class="card">
            <h2>Iniciar Sesión</h2>

            <form action="./securityModule/getUsuario.php" method="POST">

                <div class="form-group">
                    <label for="txtLogin">Usuario</label>
                    <input name="txtLogin" id="txtLogin" type="text" class="form-control" placeholder="Ingrese su usuario" required>
                </div>

                <div class="form-group">
                    <label for="txtPassword">Contraseña</label>
                    <input name="txtPassword" id="txtPassword" type="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="divider"></div>

                <div class="form-group">
                    <input name="btnAceptar" id="btnAceptar" type="submit" value="INGRESAR" class="btn">
                </div>

            </form>
        </div>

        <?php
        $this->piePaginaShow();
    }
}
?>