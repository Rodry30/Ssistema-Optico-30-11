<?php
include_once("../shared/formulario.php");

class pantallaPanelControl extends formulario
{
    public function panelControlShow($listaPrivilegios)
    {
        // 1. Llamamos a la cabecera del padre para tener los estilos base
        $this->cabeceraShow(2);

        // Intentamos obtener el usuario de la sesión (si existe), sino ponemos "Usuario"
        $usuarioNombre = isset($_SESSION['login']) ? strtoupper($_SESSION['login']) : "USUARIO";
        ?>

        <style>
            /* Reajustamos el contenedor principal para que ocupe todo el ancho */
            .main-content {
                padding: 0 !important;
                display: block !important;
                background-color: #f4f7f6;
                height: calc(100vh - 140px); /* Ajuste para header y footer */
                overflow: hidden;
            }

            /* Contenedor Flex para separar Sidebar y Contenido */
            .dashboard-wrapper {
                display: flex;
                height: 100%;
                width: 100%;
            }

            /* --- BARRA LATERAL (SIDEBAR) --- */
            .sidebar {
                width: 260px;
                background-color: var(--primary-color); /* Azul del tema */
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
            }

            .menu-item:hover {
                background-color: rgba(255,255,255,0.1);
                padding-left: 35px; /* Efecto de desplazamiento */
                border-left: 4px solid #fff;
                color: #fff;
            }

            .menu-item img {
                margin-right: 15px;
                filter: brightness(0) invert(1); /* Vuelve blancos los iconos negros */
            }

            /* --- CONTENIDO DERECHA --- */
            .content-area {
                flex: 1;
                display: flex;
                flex-direction: column;
                overflow-y: auto;
            }

            /* --- TOP BAR (ENCABEZADO USUARIO) --- */
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

            /* Área de trabajo vacía (Dashboard) */
            .work-area {
                padding: 30px;
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
                // Iteramos los privilegios para crear enlaces
                for($i = 0; $i < count($listaPrivilegios); $i++)
                {
                    // Extraemos datos para que el código sea más legible
                    $label = $listaPrivilegios[$i]['labelPrivilegio'];
                    $path = $listaPrivilegios[$i]['pathPrivilegio'];
                    $icon = $listaPrivilegios[$i]['iconPrivilegio'];
                    ?>
                    <form action="<?php echo $path; ?>" method="POST" style="margin:0;">
                        <button type="submit" name="botonEnlace" value="1" class="menu-item" style="width:100%; background:none; border:none;">
                            <img src="../img/<?php echo $icon;?>" width="20" height="20">
                            <span><?php echo strtoupper($label); ?></span>
                        </button>
                    </form>
                    <?php
                }
                ?>

                <a href="../index.php" class="menu-item" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1);">
                    <span>CERRAR SESIÓN</span>
                </a>
            </nav>

            <div class="content-area">

                <header class="top-bar">
                    <h2>SISTEMA ÓPTICA</h2>
                    <div class="user-info">
                        <span>Bienvenido, <?php echo $usuarioNombre; ?></span>
                        <div class="user-avatar">
                            <?php echo substr($usuarioNombre, 0, 1); ?>
                        </div>
                    </div>
                </header>

                <div class="work-area">
                    <div class="welcome-card">
                        <h3 style="color: #555;">Seleccione una opción del menú lateral</h3>
                        <p>Utilice la barra de navegación izquierda para acceder a las funciones del sistema.</p>
                    </div>
                </div>

            </div>
        </div>

        <?php
        // Llamamos a NUESTRO pie de página personalizado
        $this->piePaginaShow();
    }

    // SOBRESCRIBIMOS la función piePaginaShow solo para esta pantalla
    protected function piePaginaShow()
    {
        ?>
        <style>
            .dashboard-footer {
                background-color: #333;
                color: #aaa;
                text-align: center;
                padding: 10px;
                font-size: 0.8rem;
                position: fixed; /* O static, depende de tu gusto */
                bottom: 0;
                width: 100%;
                z-index: 1000;
            }
        </style>

        </div> <footer class="dashboard-footer">
        SISTEMA DE GESTIÓN ÓPTICA v2.0 | Soporte Técnico: soporte@untels.edu.pe
    </footer>
        </body>
        </html>
        <?php
    }
}
?>