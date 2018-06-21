<!--Clase de conexión a la base de datos-->
<?php

class conector {

    private $conexion;

    function __construct() {
        /**
         * Extraer un array con los datos dela conexión con la función
         * parse_ini_file
         */
        $db = parse_ini_file("../config/config.ini");

        try {
            $this->conexion = new PDO("{$db['type']}:host={$db['host']};port={$db['port']}", $db['user'], $db['pass']);
            echo "<li>Conexión con la BD: <span class='ok'>OK</span></li>";
        } catch (PDOException $e) {
            echo "<li>Conexión con la BD: <span class='error'>Error de conexión</span></li>";
        }
    }

    public function GetConector() {

        return $this->conexion;
    }

}
?>
