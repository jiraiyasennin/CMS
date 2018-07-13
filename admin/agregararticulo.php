<?php
require_once '../classes/loader.php';
/**
 * Comienzo de la sesión
 */
$session = new Sesiones();
?>
<!DOCTYPE html>
<!--**Página de administración de Artículos**
               By Dostow Ugel-->
<html>
    <?php include '../include/header.php' ?>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!--==========Area del Menú==========-->
                <div class="col-sm-2">
                    <h1>Menu</h1>
                    <ul id="menupanel" class="nav nav-pills nav-stacked">
                        <li class=""><a href="panelcontrol.php"><span class="glyphicon glyphicon-th-large"></span>Panel de Control</a></li>
                        <li class="active"><a href="agregararticulo.php"><span class="glyphicon glyphicon-plus"></span>Nuevo Post</a></li>
                        <li class=""><a href="categorias.php"><span class="glyphicon glyphicon-tags"></span>Categorías</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-user"></span>Manage Admins</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-comment"></span>Comentarios</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-list-alt"></span>Blog</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
                    </ul>
                </div>
                <!--==========Fin de área del Menú==========-->
                <!--==========Area Principal==========-->
                <div class="col-sm-10">
                    <h1 id='h1Articulos'>Administrar Artículos</h1>
                    <div>
                        <form class="form" action="agregararticulo.php" method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group col-sm-4">
                                    <label for="titulo">Título:</label>
                                    <input type="text" class="form-control" id="tituloarticulo" name="titulo" placeholder="titulo">
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="categoria">Categoría:</label>
                                    <select type="text" class="form-control" id="categoria" name="categoria">
                                        <?php
                                        /**
                                         * Listado de las categorías en el menú
                                         */
                                        $categorias = new CategoriasControl();
                                        $listadoCategorias = $categorias->ListaDeCategorias();
                                        foreach ($listadoCategorias as $key => $data) {
                                            ?>
                                            <option value='<?php echo $data['id'] ?>'><?php echo $data['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="input-group col-sm-3">
                                    <div class="input-group input-file">
                                        <label for="imagen">Agregar Imagen:</label>
                                        <input type="file" class="form-control-file btn btn" id="imagenarticulo" name="imagen">
                                    </div>
                                </div>
                                <div class="form-group col-sm-9">
                                    <label for="contenido">Contenido:</label>
                                    <textarea type="text" class="form-control" id="contenidoarticulo" name="contenido" placeholder="contenido"></textarea>
                                </div>
                                <div class="input-group col-sm-10 center-block">
                                    <input  id="botonArticulo" class="btn btn-primary col-sm-4 col-sm-offset-3" type="submit" name="submit" value="Añadir Artículo">
                                </div>
                            </fieldset>
                        </form>
                    </div><br>
                    <div id="mensajes">

                        <?php
                        /**
                         * Incluir los mensajes de error
                         */
                        if (isset($_POST['submit'])) {

                            /**
                             * Verificación de las variables que vienen del formulario
                             */
                            $verifica = new ArticulosControl();
                            $verificarMasFiltrado = $verifica->VerificarNullFiltro($_POST);
                            if (isset($verificarMasFiltrado['error'])) {
                                $_SESSION['error'] = $verificarMasFiltrado['error'];
                                echo $session->Error();
                            } else {
                                //Por ahora usaré este creador hasta que desarrolle la clase "Usuarios"
                                $creadorArt = "dostow";

                                /**
                                 * Subir la imagen si está agregada
                                 */
                                if ($_FILES !== NULL) {
                                    $verificaImagen = $verifica->VerificarInsertarImagen($_FILES);

                                    if ($verificaImagen['error'] == true) {
                                        $_SESSION['error'] = $verificaImagen['mensaje'];
                                        echo $session->Error();
                                    } else {
                                        $_SESSION['ok'] = $verificaImagen['mensaje'];
                                        echo $session->Exito();
                                    }
                                }
                                /**
                                 * Procedemos a insertar los datos del formulario en la base de datos
                                 */
                                $queryInsertArticulo = $verifica->InsertarArticulo($_POST, $creadorArt, $verificaImagen['nombreImagen']);

                                if ($queryInsertArticulo == false) {
                                    $_SESSION['error'] = "Ha habido un fallo al insertar el artículo";
                                    echo $session->Error();
                                } else {
                                    $_SESSION['ok'] = "El artículo ha sido insertado correctamente";
                                    echo $session->Exito();
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <!--==========Fin del área principal==========-->
            </div>
            <!--==========Fin del Row==========-->
        </div>
        <!--==========Fin del contenedor==========-->
        <?php include '../include/footer.php'; ?>
    </body>
</html>