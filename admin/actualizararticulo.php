<?php
require_once '../classes/loader.php';
/**
 * Comienzo de la sesión
 */
$session = new Sesiones();
if (isset($_SESSION['usuario'])) {
    ?>
    <!DOCTYPE html>
    <!--**Página de administración de Artículos**
                   By Dostow Ugel-->
    <html>
        <?php include '../include/header.php' ?>
        <body>
            <div class="container-fluid">
                <div class="topline navbar-default">
                    <h4>SGC Versión 1.0</h4>
                </div>
                <div class="row">
                    <?php include '../include/menu.php' ?>
                    <!--==========Area Principal==========-->
                    <div class="col-sm-10">
                        <h1 id='h1Articulos'>Actualizar Artículos</h1>
                        <div>
                            <?php
                            if (!isset($_GET['editar'])) {
                                $_SESSION['error'] = "Ha habido un error al cargar la info del artículo";
                                echo $session->Error();
                            } else {
                                $id = $_GET['editar'];
                                $objetoArticulo = new ArticulosControl();
                                $infoArticulo = $objetoArticulo->articuloPorId($id);
                                foreach ($infoArticulo as $key => $value) {
                                    ?>
                                    <form id='formActualiza' class="form" action="" method="POST" enctype="multipart/form-data">
                                        <fieldset>
                                            <div class='row'>
                                                <div class="form-group col-sm-5">
                                                    <label for="titulo">Título:</label>
                                                    <input type="text" class="form-control" id="tituloarticulo" name="titulo" value="<?php echo $value['titulo'] ?>">
                                                    <input type='hidden' name='id' value="<?php echo $value['id']; ?>">
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <label for="categoria">Categoría: Actual(<?php echo $value['categoria']; ?>)</label>
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
                                            </div>
                                            <div class='row'>
                                                <div class="form-group col-sm-10">
                                                    <div class="input-group input-file">
                                                        <label class='col-sm-4'>Imagen Actual: <img  class='img-thumbnail' src='../img/<?php echo $value['imagen']; ?>'></label>
                                                        <br>
                                                        <label for="imagen" class='col-sm-6'>Agregar Imagen:</label>
                                                        <input type="file" class="form-control-file btn btn" id="imagenarticulo" name="imagen">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class="form-group col-sm-10">
                                                    <label for="contenido">Contenido:</label>
                                                    <textarea rows="10" type="text" class="form-control" id="contenidoarticulo" name="contenido"><?php echo $value['contenido']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="input-group col-sm-10 center-block">
                                                <input  id="botonArticulo" class="btn btn-primary col-sm-4 col-sm-offset-3" type="submit" name="submit" value="Actualizar Artículo">
                                            </div>
                                        </fieldset>
                                    </form>
                                    <?php
                                }
                            }
                            ?>
                        </div><br>
                        <hr>
                        <div id="mensajes">
                            <?php
                            /**
                             * Incluir los mensajes de error
                             */
                            if (isset($_POST['submit'])) {
                                /**
                                 * Verificación de las variables que vienen del formulario
                                 * Eliminar cualquier caracter no deseado
                                 * @VAR $verificarMasFiltrado Contiene todos los datos filtrados
                                 */
                                $verifica = new ArticulosControl();
                                $verificarMasFiltrado = $verifica->VerificarNullFiltro($_POST);
                                if (isset($verificarMasFiltrado['error'])) {
                                    $_SESSION['error'] = $verificarMasFiltrado['error'];
                                    echo $session->Error();
                                } else {
                                    /**
                                     * Subir la imagen si está agregada
                                     */
                                    $verificaImagen = $verifica->VerificarInsertarImagen($_FILES);
                                    if ($verificaImagen['error'] == true) {
                                        $_SESSION['error'] = $verificaImagen['mensaje'];
                                        echo $session->Error();
                                    } else {
                                        /**
                                         * Procedemos a insertar los datos del formulario en la base de datos
                                         */
                                        $queryUpdateArticulo = $verifica->ModificaArticulo($verificarMasFiltrado, $verificaImagen);
                                        if ($queryUpdateArticulo == false) {
                                            $_SESSION['error'] = "Ha habido un fallo al actualizar el artículo";
                                        } else {
                                            $_SESSION['ok'] = "El artículo ha sido modificado correctamente";
                                            echo '<script>window.location.href = "panelcontrol.php";</script>';
                                        }
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
            <?php
            include '../include/footer.php';
        }
        ?>
    </body>
</html>