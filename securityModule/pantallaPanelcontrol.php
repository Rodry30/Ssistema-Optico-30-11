<?php
include_once("../shared/formulario.php");

class pantallaPanelControl extends formulario
{
    public function panelControlShow($listaPrivilegios)
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Llamar a la cabecera
        $this->cabeceraShow(0);

        // Obtener el usuario de la sesión
        $usuarioNombre = isset($_SESSION['login']) ? strtoupper($_SESSION['login']) : "USUARIO";
        ?>

        <style>
            .main-content {
                padding: 0 !important;
                display: block !important;
                background-color: #f4f7f6;
                min-height: calc(100vh - 140px);
                overflow: hidden;
            }

            .dashboard-wrapper {
                display: flex;
                height: 100%;
                width: 100%;
                min-height: calc(100vh - 140px);
            }

            .sidebar {
                width: 260px;
                background-color: var(--primary-color);
                color: white;
                display: flex;
                flex-direction: column;
                padding-top: 20px;
                box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            }

            .sidebar-title {
                text-align: center;
                font-size: 1.2rem;
                font-weight: bold;
                margin-bottom: 30px;
                border-bottom: 1px solid rgba(255,255,255,0.2);
                padding-bottom: 15px;
            }

            .menu-item {
                display: flex;
                align-items: center;
                padding: 15px 25px;
                color: rgba(255,255,255,0.9);
                text-decoration: none;
                transition: background 0.3s, padding-left 0.3s;
                border-left: 4px solid transparent;
                cursor: pointer;
                text-align: left;
            }

            .menu-item:hover {
                background-color: rgba(255,255,255,0.1);
                padding-left: 35px;
                border-left: 4px solid #fff;
                color: #fff;
            }

            .menu-item img {
                margin-right: 15px;
                filter: brightness(0) invert(1);
            }

            .content-area {
                flex: 1;
                display: flex;
                flex-direction: column;
                overflow-y: auto;
            }

            .top-bar {
                background-color: white;
                padding: 0 30px;
                height: 70px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .top-bar h2 {
                margin: 0;
                color: var(--primary-color);
                font-size: 1.5rem;
            }

            .user-info {
                display: flex;
                align-items: center;
                font-weight: 600;
                color: #555;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                background-color: var(--primary-color);
                color: white;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin-left: 10px;
                font-size: 1.2rem;
            }

            .work-area {
                padding: 30px;
                flex: 1;
            }

            .welcome-card {
                background: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                text-align: center;
            }
        </style>

        <div class="dashboard-wrapper">

            <nav class="sidebar">
                <div class="sidebar-title">MENÚ PRINCIPAL</div>

                <?php
                // Validar que haya privilegios
                if (!empty($listaPrivilegios) && is_array($listaPrivilegios)) {
                    foreach($listaPrivilegios as $privilegio) {
                        $label = isset($privilegio['labelPrivilegio']) ? $privilegio['labelPrivilegio'] : 'Sin nombre';
                        $path = isset($privilegio['pathPrivilegio']) ? $privilegio['pathPrivilegio'] : '#';
                        $icon = isset($privilegio['iconPrivilegio']) ? $privilegio['iconPrivilegio'] : 'default.png';
                        ?>
                        <form action="<?php echo htmlspecialchars($path); ?>" method="POST" style="margin:0;">
                            <button type="submit" name="botonEnlace" value="1" class="menu-item"
                                    style="width:100%; background:none; border:none; font-size:0.9rem;">
                                <img src="../img/<?php echo htmlspecialchars($icon); ?>" width="20" height="20" alt="">
                                <span><?php echo strtoupper(htmlspecialchars($label)); ?></span>
                            </button>
                        </form>
                        <?php
                    }
                } else {
                    ?>
                    <div style="padding: 20px; color: rgba(255,255,255,0.7); text-align: center;">
                        No hay privilegios disponibles
                    </div>
                    <?php
                }
                ?>

                <a href="logout.php" class="menu-item" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1);">
                    <span>🚪 CERRAR SESIÓN</span>
                </a>
            </nav>

            <div class="content-area">

                <header class="top-bar">
                    <h2>SISTEMA ÓPTICA</h2>
                    <div class="user-info">
                        <span>Bienvenido, <?php echo htmlspecialchars($usuarioNombre); ?></span>
                        <div class="user-avatar">
                            <?php echo substr($usuarioNombre, 0, 1); ?>
                        </div>
                    </div>
                </header>

                <div class="work-area">
                    <div class="welcome-card">
                        <h3 style="color: #555; margin-top: 0;">👋 Bienvenido al Panel de Control</h3>
                        <p style="color: #777;">Seleccione una opción del menú lateral para comenzar a trabajar.</p>
                        <p style="color: #999; font-size: 0.9rem; margin-top: 20px;">
                            Usuario activo: <strong><?php echo htmlspecialchars($usuarioNombre); ?></strong>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <?php
        $this->piePaginaShow();
    }

    protected function piePaginaShow()
    {
        ?>
        <style>
            .dashboard-footer {
                background-color: #333;
                color: #aaa;
                text-align: center;
                padding: 15px;
                font-size: 0.85rem;
            }
        </style>

        <footer class="dashboard-footer">
            SISTEMA DE GESTIÓN ÓPTICA v2.0 | Soporte Técnico: soporte@untels.edu.pe
        </footer>
        </body>
        </html>
        <?php
    }
}
?>