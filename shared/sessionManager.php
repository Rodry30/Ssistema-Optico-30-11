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

        // Limpia variables de sesión
        $_SESSION = [];

        // Si se usa cookie de sesión, eliminarla en el cliente
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destruye la sesión del servidor
        session_unset();
        session_destroy();

        // Regenerar id por si acaso
        if (session_status() == PHP_SESSION_NONE) {
            // nada
        } else {
            session_regenerate_id(true);
        }
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
