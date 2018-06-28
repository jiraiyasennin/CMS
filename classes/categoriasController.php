<?php
/**
 * Los métodos se explican ellos mismos por el nombre que tienen
 */

include 'conexion.php';

class CategoriasControl extends conector {

    function __construct() {
        parent::__construct();
    }

    public function LIstaDeCategorias() {
        $datos = $this->GetConector();
        $query = "select * from categorias";
        $statement = $datos->prepare($query);
        $resultado = $statement->execute();
        return $resultado;
    }

    public function InsertaCategoria($nombreCat, $creadorCat) {
        $datos = $this->GetConector();
        $query = "INSERT INTO categorias(nombre, creador) VALUES (:nombre, :creador)";
        $statement = $datos->prepare($query);
        $nombre = "%{$nombreCat}%";
        $creador = "%{$creadorCat}%";
        $statement->bindParam(':nombre', $nombre);
        $statement->bindParam(':creador', $creador);
        $resultado = $statement->execute();
        return $resultado;
    }

    public function ModificaCategoria($categoria) {
        return $resultado;
    }

    public function BorraCategoria($categoria) {
        return $resultado;
    }

}

?>