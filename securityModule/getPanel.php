<?php
// Usar el gestor de sesiones
include_once("../shared/sessionManager.php");

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar autenticación
SessionManager::requireAuth();

foreach ($_SESSION as $key => $value) {
    if ($key !== 'login' && $key !== 'autenticado' && $key !== 'privilegios') {
        unset($_SESSION[$key]);
    }
}

// Obtener privilegios
$listaPrivilegios = SessionManager::getPrivilegios();

if ($listaPrivilegios === null || empty($listaPrivilegios)) {
    include_once("../shared/pantallaMensaje.php");
    $objMensaje = new pantallaMensaje();
    $objMensaje->mensajeShow(
        1,
        "ERROR - No se pudieron cargar los privilegios del usuario",
        "<a href='../index.php'>Cerrar sesión</a>"
    );
    exit();
}

// Mostrar panel
include_once("pantallaPanelControl.php");
$objPanel = new pantallaPanelControl();
$objPanel->panelControlShow($listaPrivilegios);
?>
