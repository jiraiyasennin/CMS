<?php
/**
 * Clase de conexión a la base de datos
 */

class conector {

    private $conexion;

    function __construct() {
        /**
         * Extraer un array con los datos de la conexión con la función
         * parse_ini_file
         */
        $db = parse_ini_file("../config/config.ini");

        try {
            $this->conexion = new PDO("{$db['type']}:host={$db['host']};dbname={$db['name']};port={$db['port']}", $db['user'], $db['pass']);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function GetConector() {

        return $this->conexion;
    }

}

?>