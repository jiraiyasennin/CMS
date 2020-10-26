<?php
require_once '../classes/loader.php';
/**
 * Comienzo de la sesión
 */
$session = new Sesiones();
if (isset($_SESSION['usuario'])) {
    ?>
    <!DOCTYPE html>
    <!--**Página de administración de las categorías**
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
                        <h1>Agregar Categorías</h1>
                        <div>
                            <form class="form-inline" action="categorias.php" method="POST">
                                <fieldset>
                                    <div class="input-group  col-xs-3">
                                        <div class="input-group-addon"><i class="glyphicon glyphicon-font"></i></div>
                                        <input type="text" id="nombrecategoria" name="categoria" class="form-control" placeholder="Nombre de la categoría">
                                    </div>
                                    <input class="btn btn-primary" type="submit" name="submit" value="Añadir Categoría">
                                </fieldset>
                            </form>
                        </div><br>
                        <div id="mensajes">
                            <hr>
                            <?php
                            /**
                             * Incluir los mensajes de error
                             */
                            if (isset($_SESSION['error'])) {
                                echo $session->Error();
                            }
                            if (isset($_SESSION['ok'])) {
                                echo $session->Exito();
                            }
                            /**
                             * Procedimiento de creación de la categoría
                             */
                            if (isset($_POST['submit'])) {
                                /**
                                 * Verificación de la variable categoria que viene del formulario
                                 */
                                if ($_POST['categoria'] == null) {
                                    $_SESSION['error'] = "Debe escribir el nombre de la categoría";
                                } else {
                                    /**
                                     * Filtrar y eliminar cualquier caracter diferente de letras
                                     *  mayúsculas o minúsculas.
                                     */
                                    $filter = preg_replace("/[^a-zA-Z]/", "", $_POST['categoria']);
                                    /**
                                     * Transformar el texto del input a minúsculas
                                     */
                                    $nombreCat = strtolower($filter);
                                    $creadorCat = $_SESSION['usuario'];
                                    $categoriasObjeto = new CategoriasControl();
                                    /**
                                     * Verificar si la categoría existe
                                     */
                                    $verificarCategoria = $categoriasObjeto->VerificaCategoria($nombreCat);
                                    if ($verificarCategoria !== false) {
                                        $_SESSION['error'] = "La categoría ya existe";
                                    } else {
                                        $categoriasObjeto->InsertaCategoria($nombreCat, $creadorCat);
                                        if ($categoriasObjeto) {
                                            $_SESSION['ok'] = "La categoría $nombreCat ha sido agregada";
                                            echo '<script>window.location.href = "categorias.php";</script>';
                                            die();
                                        } else {
                                            $_SESSION['error'] = "Ha habido un error al agregar la categoría";
                                            echo '<script>window.location.href = "categorias.php";</script>';
                                            die();
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
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Creador</th>
                                        <th scope="col">Fecha de Creación</th>
                                        <th scope="col">Fecha de Modificación</th>
                                        <th scope="col">Borrar</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php
                                    $categoriasObjeto = new CategoriasControl();
                                    $listadoCategorias = $categoriasObjeto->ListaDeCategorias();
                                    /**
                                     * Extracción de los datos de las categorías existentes
                                     */
                                    foreach ($listadoCategorias as $categorias => $item):
                                        ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td><?php echo $item['nombre']; ?></td>
                                            <td><?php echo $item['creador']; ?></td>
                                            <td><?php echo $item['creado']; ?></td>
                                            <td><?php echo $item['actualizado']; ?></td>
                                            <td><a href="categorias.php?borrar=<?php echo $item['id']; ?>" onclick="return confirm('¿Está seguro que quiere borrar el artículo?')"><span class='btn btn-danger'>Borrar</span></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php
                            if (isset($_GET['borrar'])) {
                                $categoria = $item['nombre'];
                                $categoriasObjeto = new CategoriasControl();
                                $borraCategoria = $categoriasObjeto->BorraCategoria($_GET['borrar']);
                                if (!$borraCategoria) {
                                    $_SESSION['error'] = "Ha habido un error al borrar la categoría";
                                    echo '<script>window.location.href = "categorias.php";</script>';
                                    die();
                                } else {
                                    $_SESSION['ok'] = "La categoría $categoria ha sido borrada";
                                    echo '<script>window.location.href = "categorias.php";</script>';
                                    die();
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