<?php
class Database extends PDO
{
    public function __construct()
    {
        /* Aquí hay que usar la ruta donde se encuentre el archivo con las credenciales*/
        $iniData = parse_ini_file(".Credentials/db.php.ini");
        $host=$iniData["host"];
        $dbname=$iniData["dbname"];
        $user=$iniData["user"];
        $pass=$iniData["pass"];
        $dsn = "mysql:host=$host;dbname=$dbname";

        /**
         *  El array $options es muy importante para tener un PDO bien configurado
         *
         *  1. PDO::ATTR_PERSISTENT: sirve para usar conexiones persistentes
         *      se puede establecer a true si se quiere usar este tipo de conexión.
         *      Ver: https://es.stackoverflow.com/a/50097/29967
         *      En la práctica, el uso de conexiones persistentes ha dado algunos problemas
         *  2. PDO::ATTR_EMULATE_PREPARES: Se usa para desactivar emulación de consultas preparadas
         *      forzando el uso real de consultas preparadas.
         *      Es muy importante establecerlo a false para prevenir Inyección SQL.
         *      Ver: https://es.stackoverflow.com/a/53280/29967
         *  3. PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION También muy importante para un correcto manejo de las excepciones.
         *      Si no se usa bien, cuando hay algún error este se podría escribir en el log revelando datos como la contraseña !!!
         *  4. PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'": establece el juego de caracteres a utf8,
         *      evitando caracteres extraños en pantalla.
         *      Ver: https://es.stackoverflow.com/a/59510/29967
         *      Esto se puede hacer también agregando esto a $dsn: charset=utf8 ...
         */

        $options = array(
            PDO::ATTR_PERSISTENT => FALSE,
            PDO::ATTR_EMULATE_PREPARES => FALSE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        );

        try {
            /*
                *Intentar la conexión llamando al constructor del padre que no es otro que PDO
            */
            parent::__construct($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            /* Escribir posibles excepciones en el error_log o en pantalla */
            error_log($this->error = $e->getMessage(),0);
        }
    }
}
?>