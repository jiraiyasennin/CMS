<?php
require_once '../classes/loader.php';
/**
 * Comienzo de la sesión
 */
$session = new Sesiones();
if (isset($_SESSION['usuario'])) {
    ?>
    <!DOCTYPE html>
    <!--
    **Desarrollo de un Sistema gestor de contenidos con PHP, SQL Y BOOTSTRAP**
                            By Dostow Ugel
    -->
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
                        <h1 class="titulopanel">Panel de Control</h1>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo $session->Error();
                        }
                        if (isset($_SESSION['ok'])) {
                            echo $session->Exito();
                        }
                        if (isset($_GET['logout']) == true) {
                            $_SESSION['exit'] = true;
                            header('Location:../blog.php', true, 301);
                        }
                        ?>
                        <table id='tablaPanel' class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Titulo</th>
                                    <th>Autor</th>
                                    <th>Fecha</th>
                                    <th>Imagen</th>
                                    <th>Categoría</th>
                                    <th>Comentarios</th>
                                    <th>Acciones</th>
                                    <th>Ver Artículo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $articulos = new ArticulosControl();
                                $articulospanel = $articulos->ListaArticulos();
                                $comentarios = new comentarios();
                                foreach ($articulospanel as $key => $value):
                                    ?>
                                    <tr>
                                        <td><?php echo $value['id']; ?></td>
                                        <td><?php echo $articulos->recortaStrings($value['titulo'], 50) . "..."; ?></td>
                                        <td><?php echo $value['creador']; ?></td>
                                        <td><?php echo $articulos->recortaStrings($value['creado']); ?></td>
                                        <td><img src='../img/<?php echo $value['imagen']; ?>'></td>
                                        <td><?php echo $value['categoria']; ?></td>
                                        <td><?php echo $comentarios->contador($value['id']); ?></td>
                                        <td>
                                            <a href='actualizararticulo.php?editar=<?php echo $value['id']; ?>'><span class='btn btn-warning'>Editar</span></a>
                                            <a href='panelcontrol.php?borrar=<?php echo $value['id']; ?>'onclick="return confirm('¿Seguro quiere borrar el artículo?')"> <span class='btn btn-danger'>Borrar</span></a>
                                        </td>
                                        <td><a href='../articulos.php?id=<?php echo $value['id']; ?>' target='_blank'>
                                                <span class='btn btn-info'>Ver Artículo</span></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php
                        /**
                         * Script de borrado
                         */
                        if (isset($_GET['borrar'])) {
                            $borrar = $articulos->BorraArticulo($_GET['borrar']);
                            if ($borrar) {
                                $_SESSION['ok'] = "Artículo borrado correctamente";
                                echo '<script>window.location.href = "panelcontrol.php";</script>';
                                die();
                            } else {
                                $_SESSION['error'] = "Hubo un problema al borrar el artículo";
                                echo '<script>window.location.href = "panelcontrol.php";</script>';
                                die();
                            }
                        }
                        ?>
                    </div>
                    <!--==========Fin del área principal==========-->
                </div>
                <!--==========Fin del Row==========-->
            </div>
            <!--==========Fin del contenedor==========-->
            <?php
            include '../include/footer.php';
        } else {
            $_SESSION['error'] = "Acceso no autorizado";
            header("location:../blog.php");
        }
        ?>
    </body>
</html>