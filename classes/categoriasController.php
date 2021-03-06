<?php

/**
 * Los métodos se explican ellos mismos por el nombre que tienen
 */
include_once 'conexion.php';

class CategoriasControl extends conector {

    function __construct() {
        parent::__construct();
    }

    public function ListaDeCategorias() {
        $datos = $this->GetConector();
        $query = "SELECT * FROM categorias";
        $resultadoQuery = $datos->prepare($query);
        $resultadoQuery->execute();
        $resultado = $resultadoQuery->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function VerificaCategoria($categoria) {
        $datos = $this->GetConector();
        $query = "SELECT nombre FROM categorias WHERE nombre=:nombre";
        $statement = $datos->prepare($query);
        $statement->bindParam(':nombre', $categoria);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function InsertaCategoria($nombreCat, $creadorCat) {
        $datos = $this->GetConector();
        $query = "INSERT INTO categorias(nombre, creador) VALUES (:nombre, :creador)";
        $statement = $datos->prepare($query);
        $statement->bindParam(':nombre', $nombreCat);
        $statement->bindParam(':creador', $creadorCat);
        $resultado = $statement->execute();
        return $resultado;
    }

    public function BorraCategoria($categoria) {
        if (isset($categoria)) {
            $conexion = $this->GetConector();
            $idCategoria = preg_replace("/[^0-9\"]/", "", $categoria);
            $QueryBorrado = "DELETE FROM categorias WHERE id=$idCategoria";
            $statement = $conexion->prepare($QueryBorrado);
            $resultado = $statement->execute();
        }
        return $resultado;
    }

}

?>