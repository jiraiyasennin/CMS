<?php

include 'conexion.php';

class CategoriasControl extends conector {

    function __construct() {
        parent::__construct();
    }

    public function InsertaCategoria($nombreCat, $creadorCat) {
        $datos= $this->GetConector();
        $query= "INSERT INTO categorias(nombre, creador) VALUES (:nombre, :creador)";
        $statement= $datos->prepare($query);
        $nombre= "%{$nombreCat}%";
        $creador= "%{$creadorCat}%";
        $statement->bindParam(':nombre', $nombre);
        $statement->bindParam(':creador', $creador);
        $statement->execute();
        return $statement;
    }

    public function ModificaCategoria($categoria) {
        return $resultado;
    }

    public function BorraCategoria($categoria) {
        return $resultado;
    }

}
?>