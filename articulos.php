<?php
require_once 'classes/loader.php';
$session = new Sesiones();
/**
 * Inicio de script
 */
if (isset($_GET['id'])) {
    global $idArticulo;
    $idArticulo = $_GET['id'];
} else {
    header("Location:blog.php");
}
/**
 * Script datos del formulario
 * 
 */
if (isset($_POST['submit'])) {
    $_POST['idArticulo'] = $idArticulo;
    $comentarioObjeto = new comentarios();
    $insertaComentario = $comentarioObjeto->agregarComentario($_POST);
    if (isset($insertaComentario['error'])) {
        $_SESSION['error'] = $insertaComentario['error'];
    } else {
        $_SESSION['ok'] = "El comentario ha sido insertado correctamente";
    }
}
?>
<!DOCTYPE html>
<html>
    <?php include 'include/blog/headerblog.php' ?>
    <body>
        <?php include 'include/blog/menublog.php' ?>
        <!--Modal Login-->
        <!-- Modal -->
        <div class="modal fade" id="login-modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
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
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre de usuario" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
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
        <!--Final Modal Login-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-10"><!--Area Principal-->
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
                    /**
                     * Cargar información del artículo
                     */
                    $articuloporid = new ArticulosControl();
                    $articulo = $articuloporid->articuloPorId($idArticulo);
                    if ($idArticulo !== null) {
                        foreach ($articulo as $key => $value):
                            ?>
                            <article id = "indexArticles" class = "thumbnail">
                                <img id='imgArticulos' class = "img-rounded" src = "img/<?php echo $value['imagen'] ?>">
                                <div class = "caption"><h2><?php echo $value['titulo'] ?></h2></div>
                                <p><?php echo $value['contenido'] ?></p>
                                <blockquote>
                                    <p id="creador">Creado por: <?php echo $value['creador'] ?></p>
                                    <footer>
                                        Fecha: <?php echo $value['creado'] ?> | Categoria: <?php echo $value['categoria'] ?>
                                    </footer>
                                </blockquote>
                            </article>
                            <?php
                        endforeach;
                    }else {
                        $_SESSION['error'] = "El artículo no existe o se ha generado un error en la búsqueda";
                        echo $session->Error();
                    }
                    /**
                     * Info comentarios
                     */
                    $comentarioObjeto = new comentarios();
                    $lista = $comentarioObjeto->listaComentarios($idArticulo);
                    if (isset($lista['activados']) && $lista['activados'] !== NULL) {
                        foreach ($lista['activados'] as $key => $value):
                            ?>
                            <section id = "comentarios" class = "thumbnail">
                                <i id="usericon" class="glyphicon glyphicon-user"></i>
                                <span><?php echo $value['nombre']; ?></span>
                                <p id='textComentario' ><?php echo $value['comentario']; ?></p>
                                <blockquote>
                                    <footer>
                                        Fecha: <?php echo $value['fecha']; ?>
                                    </footer>
                                </blockquote>
                            </section>
                            <?php
                        endforeach;
                    }
                    ?>
                    <section id="formComentario" class="thumbnail" >
                        <H3>Agrega tu comentario</H3>
                        <form class="form-inline" method="post" action="articulos.php?id=<?php echo $idArticulo ?>">
                            <div class="form-group">
                                <label class="sr-only">Email</label>
                                <div class="input-group">
                                    <div class="input-group-addon">@</div>
                                    <input type="text" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="sr-only">Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-font"></i></div>
                                    <input type="text" name="nombre" class="form-control" placeholder="nombre">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputAmount">Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-align-justify"></i></i></div>
                                    <textarea class="form-control" rows="3" name="comentario"></textarea>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </section>
                </div><!--Fin área principal-->
                <!--Area Lateral-->
                <?php
                $articulos = new ArticulosControl();
                include_once 'include/blog/menuderecha.php'
                ?>
                <!--Fin área Lateral-->
            </div><!--Fin Row-->
        </div><!--Fin Container-->
        <?php include 'include/blog/footerblog.php' ?>
    </body>
</html>