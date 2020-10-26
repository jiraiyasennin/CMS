<?php

include_once 'conexion.php';

/**
 * Description of comentarios
 * Clase que controla todas las acciones relacionadas
 * con los comentarios
 * @author Dostow
 */
class comentarios extends conector {

    public function __construct() {
        parent::__construct();
    }

    public function listaComentarios($id = null) {
        if (isset($id)) {
            /**
             * Query comentarios activados
             */
            $conexion = $this->GetConector();
            $queryComentariosAct = "SELECT * FROM comentarios WHERE articulo=$id AND status='activado'";
            $statement = $conexion->prepare($queryComentariosAct);
            $statement->execute();
            $listaDeComentarios['activados'] = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (empty($listaDeComentarios)) {
                $listaDeComentarios['activados'] = null;
            }
            /**
             * Query comentarios desactivados
             */
            $queryComentariosDesac = "SELECT * FROM comentarios WHERE articulo=$id AND status='desactivado'";
            $statementDesac = $conexion->prepare($queryComentariosDesac);
            $statementDesac->execute();
            $listaDeComentarios['desactivados'] = $statementDesac->fetchAll(PDO::FETCH_ASSOC);
            if (empty($listaDeComentarios)) {
                $listaDeComentarios['desactivados'] = null;
            }
        } else {
            $conexion = $this->GetConector();
            $queryListaComentarios = "SELECT * FROM comentarios";
            $statement = $conexion->prepare($queryListaComentarios);
            $statement->execute();
            $listaDeComentarios = $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return $listaDeComentarios;
    }

    public function agregarComentario($params) {
        if (isset($params)) {
            if (filter_var($params['email'], FILTER_VALIDATE_EMAIL) == FALSE) {
                return $mensaje = ['error' => "Inserte un email válido"];
            } else {
                $email = $params['email'];
            }
            if (strlen($params['comentario']) > 500) {
                return $mensaje = ["error" => "Los comentarios no pueden tener mas de 500 letras"];
            } else {
                $comentario = $params['comentario'];
            }
            $nombre = $search = preg_replace("/[^a-zA-Z0-9\.\-\(\)\_\"]/", "", $params['nombre']);
            $articulo = preg_replace("/[^0-9\"]/", "", $params['idArticulo']);
            $conexion = $this->GetConector();
            $queryComentario = "INSERT INTO comentarios(nombre,email,comentario,articulo) VALUES(:nombre,:email,:comentario, :articulo)";
            $statement = $conexion->prepare($queryComentario);
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':comentario', $comentario);
            $statement->bindParam(':articulo', $articulo);
            $resultadoQuery = $statement->execute();
            if (!$resultadoQuery) {
                $resultadoQuery = ['error' => 'No se ha podido insertar el comentario'];
            } else {
                return $resultadoQuery;
            }
        }
    }

    public function borrarComentario($id) {
        $conexion = $this->GetConector();
        $idArticulo = preg_replace("/[^0-9\"]/", "", $id);
        $queryBorradoComentario = "DELETE FROM comentarios WHERE id=$idArticulo";
        $statement = $conexion->prepare($queryBorradoComentario);
        $resultado = $statement->execute();
        if (!$resultado) {
            $resultado = ['error' => 'No se ha podido borrar el comentario'];
        } else {
            return $resultado;
        }
    }

    public function aprobarComentario($id, $admin) {
        if (isset($id)) {
            $conexion = $this->GetConector();
            $idArticulo = preg_replace("/[^0-9\"]/", "", $id);
            $queryActivadoDesactivado = "UPDATE comentarios SET status='activado', verificador='$admin' WHERE id=$idArticulo";
            $statement = $conexion->prepare($queryActivadoDesactivado);
            $resultado = $statement->execute();
            if (!$resultado) {
                $resultado = ['error' => 'No se ha podido aprobar el comentario'];
            } else {
                return $resultado;
            }
        }
    }

    public function recortaStrings($param, $longitud = null) {
        if ($longitud == null) {
            $valorRecortado = (strlen($param) > 10) ? substr($param, 0, 10) : $param;
        } else {
            $valorRecortado = (strlen($param) > 10) ? substr($param, 0, $longitud) : $param;
        }

        return $valorRecortado;
    }

    public function contador($id) {
        if (isset($id)) {
            $conexion = $this->GetConector();
            $idArticulo = preg_replace("/[^0-9\"]/", "", $id);
            $query = "SELECT count(id) FROM comentarios WHERE articulo=$idArticulo";
            $statement = $conexion->prepare($query);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            if (!$resultado) {
                $resultado = 0;
            } else {
                $resultado = $resultado["count(id)"];
                return $resultado;
            }
        }
    }

}
