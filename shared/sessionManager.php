<?php

class SessionManager
{
    public static function isAuthenticated()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['login']) &&
            isset($_SESSION['autenticado']) &&
            $_SESSION['autenticado'] === true;
    }

    /**
     * Redirige al login si no está autenticado
     */
    public static function requireAuth()
    {
        if (!self::isAuthenticated()) {
            header("Location: " . self::getBasePath() . "/index.php");
            exit();
        }
    }

    /**
     * Obtiene el login del usuario
     * @return string|null
     */
    public static function getLogin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['login']) ? $_SESSION['login'] : null;
    }

    /**
     * Obtiene los privilegios del usuario
     * @return array|null
     */
    public static function getPrivilegios()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['privilegios']) ? $_SESSION['privilegios'] : null;
    }

    /**
     * Cierra la sesión
     */
    public static function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
    }

    /**
     * Obtiene la ruta base del proyecto
     * @return string
     */
    private static function getBasePath()
    {
        // Ajusta según tu estructura
        return "..";
    }
}
?>
