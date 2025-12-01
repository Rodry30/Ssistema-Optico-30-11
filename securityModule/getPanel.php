<?php
// Usar el gestor de sesiones
include_once("../shared/sessionManager.php");

// Verificar autenticación
SessionManager::requireAuth();

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
