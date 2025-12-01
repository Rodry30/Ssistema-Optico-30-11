<?php
class conexion
{
    // Cambiamos a 'public' para facilitar el acceso, o puedes dejarlo 'protected' si solo lo usas por herencia
    public function conectarBD()
    {
        // DATOS DE CONEXIÓN
        $servidor = "localhost:3306";
        $usuario = "root";

        // NOTA: En XAMPP por defecto la contraseña es vacía ("").
        // Si tú le pusiste "123456789" a tu MySQL, cámbialo aquí. Si no, déjalo vacío.
        $password = "";

        $database = "bd_optica";

        // NUEVA FORMA (MySQLi)
        $link = new mysqli($servidor, $usuario, $password, $database);

        // Verificar errores
        if ($link->connect_error) {
            die("Error de conexión: " . $link->connect_error);
        }

        // Caracteres especiales (tildes, ñ)
        $link->set_charset("utf8");

        // IMPORTANTE: Ahora retornamos el enlace para usarlo en las consultas
        return $link;
    }

    // Método para desconectar (opcional en scripts cortos, pero útil)
    public function desConectarBD($link)
    {
        if ($link) {
            $link->close();
        }
    }
}
?>