<?php require_once '../classes/loader.php'; ?>
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
                    <h1>Dostow</h1>
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
                    <h1>Administrar Artículos</h1>
                    <div>
                        <form action="agregararticulo.php" method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label for="titulo">Título:</label>
                                    <input type="text" class="form-control" id="tituloarticulo" name="titulo" placeholder="titulo">
                                </div>
                                <div class="form-group">
                                    <label for="autor">Autor:</label>
                                    <input type="text" class="form-control" id="autor" name="autor" placeholder="autor">
                                </div>
                                <div class="form-group">
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
                                            <option><?php echo $data['nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="contenido">Contenido:</label>
                                    <textarea type="text" class="form-control" id="contenidoarticulo" name="contenido" placeholder="contenido"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imagen">Agregar Imagen:</label>
                                    <input type="file" class="form-control" id="imagenarticulo" name="imagen">
                                </div>
                                <input class="btn btn-primary" type="submit" name="submit" value="Añadir Artículo">
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
                             * Comienzo de la sesión
                             */
                            $session = new Sesiones();
                            /**
                             * Verificación de la variable categoria que viene del formulario
                             */
                            if ($_POST['categoria'] == null) {
                                $_SESSION['error'] = "Debe escribir el nombre de la categoría";
                                echo $session->Error();
                            } else {
                                /**
                                 * Filtrar y eliminar cualquier caracter diferente de letras
                                 *  mayúsculas o minúsculas.
                                 */
                                $filter = preg_replace("/[^a-zA-Z]/", "", $_POST['categoria']);
                                /**
                                 * Transformar el texto del input a minúsculas
                                 */
                                //Por ahora usaré este creador hasta que desarrolle la clase "Usuarios"
                                $creadorCat = "dostow";
                                $nombreCat = strtolower($filter);
                                $categoriasObjeto = new CategoriasControl();
                                /**
                                 * Verificar si la categoría existe
                                 */
                                $verificarCategoria = $categoriasObjeto->VerificaCategoria($nombreCat);

                                if ($verificarCategoria !== false) {
                                    $_SESSION['error'] = "La categoría ya existe";
                                    echo $session->Error();
                                } else {
                                    $categoriasObjeto->InsertaCategoria($nombreCat, $creadorCat);
                                    if ($categoriasObjeto) {
                                        $_SESSION['ok'] = "La categoría $nombreCat ha sido agregada";
                                        echo $session->Exito();
                                    } else {
                                        $_SESSION['error'] = "Ha habido un error al agregar la categoría";
                                        echo $session->Error();
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
        <?php include '../include/footer.php'; ?>
    </body>
</html>