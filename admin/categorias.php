<?php require_once '../classes/loader.php'; ?>
<!DOCTYPE html>
<!--**Página de administración de las categorías**
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
                        <li class="active"><a href="panelcontrol.php"><span class="glyphicon glyphicon-th-large"></span>Panel de Control</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-plus"></span>Nuevo Post</a></li>
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
                    <h1>Administrar Categorías</h1>
                    <div>
                        <form action="categorias.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <label for="nombrecategoria">Nombre:</label>
                                    <input type="text" class="form-control" id="nombrecategoria" name="categoria" placeholder="nombre de la categoría">
                                </div>
                                <input class="btn btn-primary" type="submit" name="submit" value="Añadir Categoría">
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
                    <div id="tablaCategorias">
                        <table class="table table-striped" id="categoriasTabla">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th><th scope="col">Nombre</th><th scope="col">Creador</th><th scope="col">Fecha de Creación</th><th scope="col">Fecha de Modificación</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                $categoriasObjeto = new CategoriasControl();
                                $listadoCategorias = $categoriasObjeto->ListaDeCategorias();

                                /**
                                 * Extracción de los datos de las categorías existentes
                                 */
                                foreach ($listadoCategorias as $categorias => $item) {
                                    echo "<tr>";
                                    echo "<td>{$item['id']}</td>";
                                    echo "<td>{$item['nombre']}</td>";
                                    echo "<td>{$item['creador']}</td>";
                                    echo "<td>{$item['creado']}</td>";
                                    echo "<td>{$item['actualizado']}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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