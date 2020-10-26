<?php
require_once 'classes/loader.php';
$session = new Sesiones();
?>
<!DOCTYPE html>
<html>
    <?php include 'include/blog/headerblog.php' ?>
    <body>
        <?php include 'include/blog/menublog.php' ?>
        <?php
        /**
         * Mensajes del script
         */
        if (isset($_SESSION['error'])) {
            echo $session->Error();
        }
        if (isset($_SESSION['ok'])) {
            echo $session->Exito();
        }
        if (isset($_SESSION['exit'])) {
            $_SESSION['ok'] = "¡Hasta pronto!";
            echo $session->Exito();
            session_unset();
            session_destroy();
        }
        ?>
        <!----------------Modal Login---------------->
        <!----------------Modal---------------->
        <div class="modal fade" id="login-modal" role="dialog">
            <div class="modal-dialog">
                <!----------------Modal content---------------->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Login</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline" method="post" action="admin/loginUsers.php">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-font"></i></div>
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre de usuario">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                                    <input type="password" name="password" class="form-control" placeholder="Contraseña">
                                </div>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-sm" name="registro" href="altausuarios.php">¿No tienes cuenta? Regístrate</a>
                    </div>
                </div>
            </div>
        </div>
        <!----------------Final Modal Login---------------->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-10"> 
                    <!----------------Area Principal---------------->
                    <?php
                    $articulos = new ArticulosControl();
                    //Query del formulario de búsqueda
                    if (isset($_GET['submit'])) {
                        $listadoArticulos = $articulos->ListaArticulos($_GET['search']);
                        //Query de paginación
                    } elseif (isset($_GET['Pag'])) {
                        // Si el valor de paginacion es negativo lo transformo en cero
                        $pagina = $_GET['Pag'];
                        if ($pagina == 0 || $pagina < 1) {
                            $postDesde = 0;
                        } else {
                            $postDesde = ($pagina * 5) - 5; //operación para ver los artículos desde el elemento 0 del array de la query
                        }
                        $listadoArticulos = $articulos->paginacion($postDesde);
                        $listadoArticulos = $listadoArticulos['listaArticulos'];
                    }
                    // Query de busqueda por categorías
                    elseif (isset($_GET["categ"])) {
                        $categoria = $_GET["categ"];
                        $listadoArticulos = $articulos->articulosCategoria($categoria);
                    }
                    // Query de carga de la web
                    else {
                        $listadoArticulos = $articulos->ListaArticulos();
                        $pagina = 1;
                    }
                    foreach ($listadoArticulos as $key => $value):
                        $short_string = (strlen($value['contenido']) > 300) ? substr($value['contenido'], 0, 300) : $value['contenido'];
                        ?>
                        <article id="indexArticles" class="thumbnail">
                            <img id="imgArticulos" class="img-rounded" src="img/<?php echo $value['imagen'] ?>">
                            <div class="caption"><h2><?php echo $value['titulo'] ?></h2></div>
                            <p><?php echo $short_string . "..." ?></p>
                            <blockquote>
                                <p id="creador">Creado por: <?php echo $value['creador'] ?></p>
                                <footer>
                                    Fecha: <?php echo $value['creado'] ?> | Categoria: <?php echo $value['categoria'] ?>
                                </footer>
                                <span class="badge" id="badge-warning">
                                    Comentarios: <?php
                                    $comentarios = new comentarios();
                                    $listaComent = $comentarios->listaComentarios();
                                    echo count($listaComent);
                                    ?>
                                </span>
                            </blockquote>
                            <div id="link"> <a href="articulos.php?id=<?php echo $value['id'] ?>"><span class="btn btn-info btn-md">Ver artículo completo</span></a></div>
                        </article>
                    <?php endforeach; ?>
                    <!----------------Area de paginación---------------->
                    <nav id="navPaginacion" aria-label="Page navigation">
                        <ul id="paginacion" class="pagination pagination-lg">
                            <?php
                            /**
                             * Botón de regreso
                             */
                            if (isset($pagina)) {
                                if ($pagina > 1) {
                                    ?>
                                    <li><a href="blog.php?Pag=<?php echo $pagina - 1; ?>"> &laquo; </a></li>
                                    <?php
                                }
                            }
                            /**
                             * Elementos li de los números
                             */
                            $articulosObjeto = new ArticulosControl();
                            $elementosLi = $articulosObjeto->paginacion();
                            for ($i = 1; $i <= $elementosLi['elementosPaginacion']; $i++):
                                if (isset($pagina)) {
                                    if ($i == $pagina) {
                                        ?>
                                        <li class="active"><a href="blog.php?Pag=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php } else {
                                            ?>
                                        <li><a href="blog.php?Pag=<?php echo $i; ?>"><?php echo $i; ?></a></li>	
                                        <?php
                                    }
                                }
                            endfor;
                            /**
                             * Botón de avanzar
                             */
                            if (isset($pagina)) {
                                if ($pagina + 1 <= $elementosLi['elementosPaginacion']) {
                                    ?>
                                    <li><a href="blog.php?Pag=<?php echo $pagina + 1; ?>"> &raquo; </a></li>
                                    <?php
                                }
                            }
                            ?>        
                        </ul>
                    </nav>
                    <!----------------Fin de área de paginación---------------->
                </div>
                <!----------------Fin área principal----------------> 
                <!----------------Area Lateral---------------->
                <?php include 'include/blog/menuderecha.php' ?>
                <!----------------Fin área Lateral---------------->
            </div>
            <!----------------Fin Row---------------->
        </div>
        <!----------------Fin Container---------------->
        <?php include 'include/blog/footerblog.php' ?>
    </body>
</html>