<?php

/**
 * Clase de conexión a la base de datos
 */
class conector {

    /**
     * Variables de conexión a la base de datos
     * Cambiar por los valores de su base de datos
     */
    private $conexion;
    private $host = "localhost";
    private $dbname = "cms";
    //private $user = "id6730118_strange"; Web
    //private $password = 'Biedronka2017@@'; Web
	private $user = "strange";
	private $password = 'strange';
    private $port = 3306;
    private $type = "mysql";

    function __construct() {

        try {
            $this->conexion = new PDO("{$this->type}:host={$this->host};dbname={$this->dbname};port={$this->port}", $this->user, $this->password);
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
