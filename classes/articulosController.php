<?php

include_once 'conexion.php';

class ArticulosControl extends conector {

    /**
     * Clase que controla todas las operaciones relacionadas con artículos
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Lista todos los artículos de la base de datos ya sea recibiendo
     * un parámetro de búsqueda o sin él
     * @return type Array asociativo
     */
    public function ListaArticulos($param = null) {
        $datos = $this->GetConector();
        if (isset($param)) {
            $search = preg_replace("/[^a-zA-Z0-9\.\-\:\"]/", "", $param);
            $query = "SELECT * from productosycategorias where creado LIKE '%$search%' OR titulo LIKE '%$search%' OR  contenido LIKE '%$search%' OR creador LIKE '%$search%' OR categoria LIKE '%$search%' ORDER BY creado DESC";
            $resultadoQuery = $datos->prepare($query);
            $resultadoQuery->execute();
            $listaArticulos = $resultadoQuery->fetchAll(PDO::FETCH_ASSOC);
            return $listaArticulos;
        } else {
            $query = "SELECT * from productosycategorias ORDER BY creado DESC LIMIT 0,5";
            $resultadoQuery = $datos->prepare($query);
            $resultadoQuery->execute();
            $listaArticulos = $resultadoQuery->fetchAll(PDO::FETCH_ASSOC);
            return $listaArticulos;
        }
    }

    public function articulosCategoria($param) {
        $conexion = $this->GetConector();
        if (isset($param)) {
            $query = "SELECT * FROM productosycategorias WHERE categoria='$param' ORDER BY id desc";
            $resultadoQuery = $conexion->prepare($query);
            $resultadoQuery->execute();
            $listaArticulos = $resultadoQuery->fetchAll(PDO::FETCH_ASSOC);
            return $listaArticulos;
        }
    }

    /**
     * Método de paginación de la página
     * @param type $param Integer
     * @return type
     */
    public function paginacion($param = NULL) {
        if (isset($param)) {
            $conexion = $this->GetConector();
            $query = "SELECT * from productosycategorias ORDER BY creado DESC LIMIT $param,5";
            $resultadoQuery = $conexion->prepare($query);
            $resultadoQuery->execute();
            $result['listaArticulos'] = $resultadoQuery->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $conexion = $this->GetConector();
            $countArticulos = "SELECT COUNT(*)FROM productosycategorias";
            $resultadoQueryCount = $conexion->prepare($countArticulos);
            $resultadoQueryCount->execute();
            $count = $resultadoQueryCount->fetch(PDO::FETCH_ASSOC);
            $count = array_shift($count);
            $result['elementosPaginacion'] = ceil($count / 5);
            return $result;
        }
    }

    public function articuloPorId($id) {
        $datos = $this->GetConector();
        if (isset($id)) {
            $query = "SELECT * from productosycategorias where id=$id";
            $resultadoQuery = $datos->prepare($query);
            $resultadoQuery->execute();
            $articulo = $resultadoQuery->fetchAll(PDO::FETCH_ASSOC);
            return $articulo;
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

    /**
     * Determina que la imagen exista o no
     * Verifica si existe en el directorio otra imagen con el mismo nombre
     * Filtra por extensión o tipo de imagen que se necesite
     * @param type $param Recibe la variable $_FILES
     * @return string
     */
    public function VerificarInsertarImagen($param) {
        $directorioRaizImagenes = "../img/";
        $imagenSubida = basename($_FILES['imagen']['name']);
        $rutaDeImagen = $directorioRaizImagenes . $imagenSubida;
        /**
         * $imagenOk
         * Variable de verificación del proceso 
         */
        $imagenOk = 1;
        /**
         * $mensaje = []
         * Array donde irán los mensajes de error ó de ok
         * el primer elemento sera false o true
         * el segundo elemento será el mensaje de respuesta
         */
        $mensaje = [];


        /**
         * Verificar si la imagen existe en el directorio
         * si existe agregarle la fecha para diferenciarla
         */
        if (file_exists($_FILES["imagen"]["tmp_name"]) || is_uploaded_file($_FILES["imagen"]["tmp_name"])) {

            /**
             * Verificar si la imagen es válida
             */
            $file = getimagesize($_FILES["imagen"]["tmp_name"]);
            $image_type = $file[2];

            if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
                $imagenOk = 1;
                /**
                 * Separamos el string del nombre de archivo
                 */
                $explode = explode(".", $imagenSubida);
                /*
                 * Agregamos la fecha al nombre
                 */
                $imagenSubida = implode(time() . ".", $explode);

                /* Definimos la ruta del archivo con el nuevo nombre */
                $rutaDeImagen = $directorioRaizImagenes . $imagenSubida;
                /**
                 * Procedimiento para subir la imagen
                 */
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDeImagen)) {
                    $mensaje['error'] = false;
                    $mensaje['mensaje'] = "La imagen ha sido subida correctamente.";
                    $mensaje['nombreImagen'] = $imagenSubida;
                    return $mensaje;
                } else {
                    $mensaje['error'] = true;
                    $mensaje['mensaje'] = "Lo sentimos, el archivo no se ha podido subir, inténtelo de nuevo";
                    return $mensaje;
                }
            } else {
                $mensaje['error'] = true;
                $mensaje['mensaje'] = "Lo sentimos, sólo están admitidos archivos JPG, JPEG, PNG y GIF.";
                return $mensaje;
            }
        } else {
            $mensaje['imageNull'] = NULL;
            $mensaje['error'] = false;
            return $mensaje;
        }
    }

    /**
     * Filtra y elimina cualquier caracter diferente de letras
     * mayúsculas o minúsculas y algunos símbolos.
     * Verificar si algún campo está vacío.
     * @param type $param Recibe la varianle global POST del formulario
     * @return type Array Devuelve todos los valores del formulario ya filtrados
     */
    public function VerificarNullFiltro($param) {

        $filtroInputs = [];

        foreach ($param as $key => $value) {
            if ($key !== 'contenido') {
                if ($value === '') {
                    $filtroInputs['error'] = "El campo $key no puede estar vacío";
                    return $filtroInputs;
                } else {
                    $filtroInputs[$key] = preg_replace("/[^a-zA-Z\.\,\(\)\-\;\_\'\´\"]/", "", $value);
                }
            } else if ($key == 'contenido') {
                if ($value === '') {
                    $filtroInputs['error'] = "El campo $key no puede estar vacío";
                    return $filtroInputs;
                } else {
                    $filtroInputs[$key] = $value;
                }
            }
        }
        return $filtroInputs;
    }

    /**
     * 
     * @param type $post La variable global POST que viene del formulario
     * @param type $creador
     * @param type $imagen Esta variable viene del método VerificarInsertarImagen($param)
     * @return Si la consulta es exitosa true de lo contrario false
     */
    public function InsertarArticulo($post, $creador, $imagen = null) {
        $titulo = $post['titulo'];
        $categoria = $post['categoria'];
        $contenido = $post['contenido'];
        $conexion = $this->GetConector();
        $query = "INSERT INTO articulos(titulo,creador, imagen, contenido, categoria) VALUES (:titulo, :creador, :imagen, :contenido, :categoria)";
        $statement = $conexion->prepare($query);
        $statement->bindParam(':titulo', $titulo);
        $statement->bindParam(':creador', $creador);
        $statement->bindParam(':imagen', $imagen);
        $statement->bindParam(':contenido', $contenido);
        $statement->bindParam(':categoria', $categoria);
        $resultado = $statement->execute();
        return $resultado;
    }

    public function ModificaArticulo($post, $imagen = null) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $contenido = $_POST['contenido'];
        $conexion = $this->GetConector();
        if (isset($imagen['nombreImagen'])) {
            $query = "UPDATE articulos SET titulo=:titulo, categoria=:categoria, contenido=:contenido, imagen=:imagen WHERE id='$id'";
            $statement = $conexion->prepare($query);
            $statement->bindParam(':titulo', $titulo);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':contenido', $contenido);
            $statement->bindParam(':imagen', $imagen['nombreImagen']);
            $resultado = $statement->execute();
            return $resultado;
        } else {
            $query = "UPDATE articulos SET titulo=:titulo, categoria=:categoria, contenido=:contenido WHERE id='$id'";
            $statement = $conexion->prepare($query);
            $statement->bindParam(':titulo', $titulo);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':contenido', $contenido);
            $resultado = $statement->execute();
            return $resultado;
        }
    }

    public function BorraArticulo($id) {
        $conexion = $this->GetConector();
        $queryBorrarArchivoImagen = "SELECT imagen FROM articulos WHERE id=$id";
        $statementImagen = $conexion->prepare($queryBorrarArchivoImagen);
        $statementImagen->execute();
        $imagen = $statementImagen->fetchAll(PDO::FETCH_ASSOC);
        $imagenBorrar = $imagen[0]['imagen'];
        if ($imagenBorrar !== NULL) {
            $borrarImagen = unlink("../img/$imagenBorrar");
        }
        $queryBorrado = "DELETE FROM articulos WHERE id= :id";
        $statement = $conexion->prepare($queryBorrado);
        $statement->bindParam(':id', $id);
        $resultado = $statement->execute();
        return $resultado;
    }

}

?>