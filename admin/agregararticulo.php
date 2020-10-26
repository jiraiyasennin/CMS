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
                        <h1 id='h1Articulos'>Agregar Artículos</h1>
                        <div>
                            <form id="formAgregarArticulo" class="form" action="agregararticulo.php" method="POST" enctype="multipart/form-data">
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
                                        <textarea rows="5" type="text" class="form-control" id="contenidoarticulo" name="contenido" placeholder="contenido"></textarea>
                                    </div>
                                    <div class="input-group col-sm-10 center-block">
                                        <input  id="botonArticulo" class="btn btn-primary col-sm-4 col-sm-offset-3" type="submit" name="submit" value="Añadir Artículo">
                                    </div>
                                </fieldset>
                            </form>
                        </div><br>
                        <hr>
                        <div id="mensajes">

                            <?php
                            /**
                             * Insertar nuevo comentario
                             */
                            if (isset($_POST['submit'])) {
                                $usuario = $_SESSION['usuario'];
                                /**
                                 * Verificación de las variables que vienen del formulario
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
                                    if ($_FILES !== NULL) {
                                        $verificaImagen = $verifica->VerificarInsertarImagen($_FILES);

                                        if ($verificaImagen['error'] == true) {
                                            $_SESSION['error'] = $verificaImagen['mensaje'];
                                            echo $session->Error();
                                        }
                                    }
                                    /**
                                     * Procedemos a insertar los datos del formulario en la base de datos
                                     */
                                    if (isset($verificaImagen['nombreImagen'])) {
                                        $queryInsertArticulo = $verifica->InsertarArticulo($_POST, $usuario, $verificaImagen['nombreImagen']);
                                    } else {
                                        $queryInsertArticulo = $verifica->InsertarArticulo($_POST, $creadorArt);
                                    }
                                    if ($queryInsertArticulo == false) {
                                        $_SESSION['error'] = "Ha habido un fallo al insertar el artículo";
                                        echo $session->Error();
                                    } else {
                                        $_SESSION['ok'] = " El artículo ha sido insertado correctamente";
                                        echo $session->Exito();
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div id="listaArticulos">
                            <table class="table table-striped" id="articulosTabla">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th><th scope="col">Titulo</th><th scope="col">Creador</th><th scope="col">Imagen</th><th scope="col">Contenido</th><th scope="col">Categoría</th><th scope="col">Fecha de Creación</th><th scope="col">Fecha de Modificación</th>
                                    </tr>
                                </thead> 
                                <tbody>

                                    <?php
                                    $Articulos = new ArticulosControl();
                                    $listaArticulos = $Articulos->ListaArticulos();
                                    ?>
                                    <?php foreach ($listaArticulos as $key => $value): ?>
                                        <tr>
                                            <td>
                                                <?php echo $value['id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['titulo']; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['creador']; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['imagen']; ?>
                                            </td>
                                            <td>
                                                <?php echo $Articulos->recortaStrings($value['contenido'], 20) . "..." ?>
                                            </td>
                                            <td>
                                                <?php echo $value['categoria']; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['creado']; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['actualizado']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
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