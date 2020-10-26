<?php

include_once 'conexion.php';

class UsuariosControl extends conector {

    function __construct() {
        parent::__construct();
    }

    public function lista() {
        $datos = $this->GetConector();
        $query = "SELECT * FROM usuarios";
        $statement = $datos->prepare($query);
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            return $resultados;
        } else {
            $resultados = ['error' => 'Ha habido un error al mostrar los datos'];
            return $resultados;
        }
    }

    public function VerificarNull($param) {
        $filtroInputs = [];
        foreach ($param as $key => $value) {
            if ($value === '') {
                $filtroInputs['error'] = "El campo $key no puede estar vacío";
                return $filtroInputs;
            }
        }
    }

    public function VerificaSetUsuario($post) {
        if (isset($post)) {
            $resultado['nombre'] = preg_replace("/[^a-zA-Z0-9,\_\-\"]/", "", $post['nombre']);
            if (filter_var($post['email'], FILTER_VALIDATE_EMAIL) == FALSE) {
                return $resultado = ['error' => "Inserte un email válido"];
            } else {
                $resultado['email'] = $post['email'];
            }
            if (isset($post['password']) && $post['password2']) {
                $password1 = hash('sha512', $post['password']);
                $password2 = hash('sha512', $post['password2']);
                if ($password1 !== $password2) {
                    return $resultado = ['error' => "Los passwords son diferentes"];
                } else {
                    $resultado['password'] = $password1;
                    return $resultado;
                }
            } else {
                return $resultado = ['error' => "Los campos de password no pueden estar vacíos"];
            }
        } else {
            $resultado['error'] = "No se han detectado datos para introducir";
            return $resultado;
        }
    }

    public function AgregarUsuario($param) {
        if (isset($param)) {
            $datos = $this->GetConector();
            $query = "INSERT INTO usuarios(username,email,password)VALUES(:nombre,:email,:password)";
            $statement = $datos->prepare($query);
            $statement->bindParam(':nombre', $param['nombre']);
            $statement->bindParam(':email', $param['email']);
            $statement->bindParam(':password', $param['password']);
            $ejecuta = $statement->execute();
            if ($ejecuta) {
                $resultado['exito'] = "El usuario ha sido agregado correctamente";
                return $resultado;
            } else {
                $resultado['error'] = "Ha habido un error al agregar al usuario";
                return $resultado;
            }
        } else {
            $resultado['error'] = "Los datos no han sido introducidos correctamente";
        }
    }

    public function loginUsuario($param) {
        if (isset($param['nombre']) && $param['password']) {
            $nombre = $param['nombre'];
            $password = hash('sha512', $param['password']);
            $conexion = $this->GetConector();
            $query = "SELECT * FROM usuarios where username='$nombre' AND password='$password' AND status='ON'";
            $statement = $conexion->prepare($query);
            $statement->execute();
            if ($statement->rowCount() > 0) {
                $resultado['true'] = $nombre;
                return $resultado;
            } else {
                $resultado = FALSE;
                return $resultado;
            }
        } else {
            $resultado = ['error' => 'Error al introducir los datos, vuelva a intentarlo'];
            return $resultado;
        }
    }

    public function ActivarUsuario($id) {
        $conexion = $this->GetConector();
        $query = "UPDATE usuarios SET status='ON' WHERE id=$id";
        $statement = $conexion->prepare($query);
        $statement->execute();
        if ($statement) {
            $mensaje = "El usuario ha sido activado";
            return $mensaje;
        } else {
            return FALSE;
        }
    }

    public function BorrarUsuario($id) {
        $conexion = $this->GetConector();
        $query = "DELETE FROM usuarios WHERE id=$id";
        $statement = $conexion->prepare($query);
        $statement->execute();
        if ($statement) {
            $mensaje = "El usuario ha sido borrado";
            return $mensaje;
        } else {
            return FALSE;
        }
    }

}

?>