<?php
class formulario
{
    protected function cabeceraShow($tipo)
    {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SISTEMA ÓPTICA</title>
            <style>
                /* --- VARIABLES DE COLOR (AZUL Y BLANCO) --- */
                :root {
                    --primary-color: #0056b3; /* Azul fuerte profesional */
                    --primary-hover: #004494;
                    --bg-color: #f4f7f6;      /* Blanco humo para el fondo */
                    --white: #ffffff;
                    --text-color: #333333;
                    --border-color: #e0e0e0;
                    --shadow: 0 4px 12px rgba(0,0,0,0.1);
                }

                /* --- ESTILOS GENERALES --- */
                body {
                    font-family: system-ui, -apple-system, sans-serif;
                    background-color: var(--bg-color);
                    color: var(--text-color);
                    margin: 0;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    min-height: 100vh;
                }

                /* --- HEADER / BANNER --- */
                .header-container {
                    background-color: var(--white);
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                    padding: 1rem;
                    text-align: center;
                    border-top: 5px solid var(--primary-color);
                }

                .header-container img {
                    max-width: 100%;
                    height: auto;
                    max-height: 100px; /* Ajusta esto según tu logo */
                    object-fit: contain;
                }

                /* --- CONTENIDO PRINCIPAL --- */
                .main-content {
                    flex: 1; /* Empuja el footer hacia abajo */
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 2rem;
                }

                /* --- TARJETAS (Para el formulario) --- */
                .card {
                    background-color: var(--white);
                    padding: 2.5rem;
                    border-radius: 12px;
                    box-shadow: var(--shadow);
                    width: 100%;
                    max-width: 400px;
                    text-align: center;
                }

                .card h2 {
                    color: var(--primary-color);
                    margin-top: 0;
                    margin-bottom: 1.5rem;
                    font-size: 1.5rem;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }

                /* --- FORMULARIOS E INPUTS --- */
                .form-group {
                    margin-bottom: 1.2rem;
                    text-align: left;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 0.5rem;
                    font-weight: 600;
                    color: #555;
                    font-size: 0.9rem;
                }

                .form-control {
                    width: 100%;
                    padding: 12px;
                    border: 1px solid var(--border-color);
                    border-radius: 6px;
                    box-sizing: border-box; /* Importante para el padding */
                    transition: border-color 0.3s;
                    font-size: 1rem;
                }

                .form-control:focus {
                    outline: none;
                    border-color: var(--primary-color);
                    box-shadow: 0 0 0 3px rgba(0, 86, 179, 0.1);
                }

                /* --- BOTONES --- */
                .btn {
                    background-color: var(--primary-color);
                    color: var(--white);
                    padding: 12px 20px;
                    border: none;
                    border-radius: 6px;
                    font-size: 1rem;
                    font-weight: bold;
                    cursor: pointer;
                    width: 100%;
                    transition: background-color 0.3s;
                }

                .btn:hover {
                    background-color: var(--primary-hover);
                }

                /* --- FOOTER --- */
                footer {
                    text-align: center;
                    padding: 1rem;
                    background-color: var(--primary-color);
                    color: var(--white);
                    font-size: 0.9rem;
                    margin-top: auto;
                }

                /* HR Estilizado */
                .divider {
                    border: 0;
                    height: 1px;
                    background: #e0e0e0;
                    margin: 20px 0;
                }
            </style>
        </head>
        <body>
        <?php
        if($tipo == 1)
            $rutabanner = "./img/banner.png";
        else
            $rutabanner = "../img/banner.png";
        ?>

        <header class="header-container">
            <img src="<?php echo $rutabanner ?>" alt="Banner Óptica">
        </header>

        <div class="main-content">
        <?php
    }

    protected function piePaginaShow()
    {
        ?>
        </div> <footer>
        <div>UNTELS 2025 -- @Todos los derechos reservados</div>
    </footer>
        </body>
        </html>
        <?php
    }
}
?>