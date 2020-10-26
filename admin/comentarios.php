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
                        <div class="container-fluid">
                            <h1 class="titulopanel">Administrar Comentarios</h1>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo $session->Error();
                            }
                            if (isset($_SESSION['ok'])) {
                                echo $session->Exito();
                            }
                            ?>
                            <table id='tablaPanel' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Autor</th>
                                        <th>Email</th>
                                        <th>Comentario</th>
                                        <th>Artículo</th>
                                        <th>Status</th>
                                        <th>Verificador</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $comentariosObjeto = new comentarios();
                                    $listaComentarios = $comentariosObjeto->listaComentarios();
                                    foreach ($listaComentarios as $key => $value):
                                        ?>
                                        <tr>
                                            <td><?php echo $value['id']; ?></td>
                                            <td><?php echo $value['nombre']; ?></td>
                                            <td><?php echo $value['email']; ?></td>
                                            <td><a href='../articulos.php?id=<?php echo $value['articulo']; ?>' target='_blank'>
                                                    <span class='btn btn-info'>Ver</span></a>
                                            </td>
                                            <td><?php echo $comentariosObjeto->recortaStrings($value['articulo']); ?></td>
                                            <td><?php echo $value['status']; ?></td>
                                            <td><?php echo $value['verificador']; ?></td>
                                            <td>
                                                <a href='comentarios.php?aprobar=<?php echo $value['id']; ?>' onclick="return confirm('¿Está seguro de aprobar el artículo?')"><span class='btn btn-success'>Aprobar</span></a>
                                                <a href='comentarios.php?borrar=<?php echo $value['id']; ?>' onclick="return confirm('¿Está seguro que quiere borrar el artículo?')"><span class='btn btn-danger'>Borrar</span></a>
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
                                $borrar = $comentariosObjeto->borrarComentario($_GET['borrar']);
                                if ($borrar) {
                                    $_SESSION['ok'] = "Comentario borrado correctamente";
                                    echo '<script>window.location.href = "comentarios.php";</script>';
                                    die();
                                } else {
                                    $_SESSION['error'] = "Hubo un problema al borrar el comentario";
                                    echo '<script>window.location.href = "comentarios.php";</script>';
                                    die();
                                }
                            }
                            /**
                             * Script de Activación
                             */
                            if (isset($_GET['aprobar'])) {
                                $aprobar = $comentariosObjeto->aprobarComentario($_GET['aprobar'], $_SESSION['usuario']);
                                if ($aprobar['error']) {
                                    $_SESSION['error'] = $aprobar['error'];
                                    echo '<script>window.location.href = "comentarios.php";</script>';
                                    die();
                                } else {
                                    $_SESSION['ok'] = "El comentario ha sido aprobado";
                                    echo '<script>window.location.href = "comentarios.php";</script>';
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