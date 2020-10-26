<?php

/**
 * Esta clase controla la variable de sesiones, esta mantiene los datos 
 * disponibles para cualquier página que la necesite
 */
class Sesiones {

    private $sesion;

    function __construct() {
        $this->sesion = session_start();
    }

    public function Error() {
        if (isset($_SESSION['error'])) {
            $response = "<div class='alert alert-danger' id='error'>";
            $response.=htmlentities($_SESSION['error']);
            $response.="</div>";
            $_SESSION['error'] = null;
            return $response;
        }
    }

    public function Exito() {
        if (isset($_SESSION['ok'])) {
            $response = "<div class='alert alert-success' id='ok'>";
            $response.=htmlentities($_SESSION['ok']);
            $response.="</div>";
            $_SESSION['ok'] = null;
            return $response;
        }
    }

}

?>