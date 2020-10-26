<?php
require_once '../classes/loader.php';
/**
 * Comienzo de la sesión
 */
$session = new Sesiones();
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == "admin") {
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
                    <?php include '../include/menu.php'; ?>
                    <!--==========Area Principal==========-->
                    <div class="col-sm-10">
                        <h1>Administración de Usuarios</h1>
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
                            ?>
                        </div>
                        <div id="tablaCategorias">
                            <table class="table table-striped" id="categoriasTabla">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Alta</th>
                                        <th scope="col">Activar/Borrar</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php
                                    $usuariosObjeto = new UsuariosControl();
                                    $listadoUsuarios = $usuariosObjeto->lista();
                                    /**
                                     * Extracción de los datos de los usuarios existentes
                                     */
                                    if (isset($listadoUsuarios['error'])) {
                                        $_SESSION['error'] = $listadoUsuarios['error'];
                                    } else {
                                        foreach ($listadoUsuarios as $key => $item):
                                            ?>
                                            <tr>
                                                <td><?php echo $item['id']; ?></td>
                                                <td><?php echo $item['username']; ?></td>
                                                <td><?php echo $item['email']; ?></td>
                                                <td><?php echo $item['status']; ?></td>
                                                <td><?php echo $item['alta']; ?></td>
                                                <td><a href="usuarios.php?activar=<?php echo $item['id']; ?>" onclick="return confirm('¿Está seguro que quiere activar el usuario?')"><span class='btn btn-primary'>Activar</span></a>
                                                    <a href="usuarios.php?borrar=<?php echo $item['id']; ?>" onclick="return confirm('¿Está seguro que quiere borrar el usuario?')"><span class='btn btn-danger'>Borrar</span></a></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            /**
                             * Script de activación del usuario
                             */
                            if (isset($_GET['activar'])) {
                                $usuariosObjeto = new UsuariosControl();
                                $activarUsuario = $usuariosObjeto->ActivarUsuario($_GET['activar']);
                                if ($activarUsuario == FALSE) {
                                    $_SESSION['error'] = "Ha habido un error al activar el usuario";
                                    echo '<script>window.location.href = "usuarios.php";</script>';
                                    die();
                                } else {
                                    $_SESSION['ok'] = $activarUsuario;
                                    echo '<script>window.location.href = "usuarios.php";</script>';
                                    die();
                                }
                            }
                            /**
                             * Script de borrado del usuario
                             */
                            if (isset($_GET['borrar'])) {
                                $borrarUsuario = $usuariosObjeto->BorrarUsuario($_GET['borrar']);
                                if ($borrarUsuario == FALSE) {
                                    $_SESSION['error'] = "Ha habido un error al borrar el usuario";
                                    echo '<script>window.location.href = "usuarios.php";</script>';
                                    die();
                                } else {
                                    $_SESSION['ok'] = $borrarUsuario;
                                    echo '<script>window.location.href = "usuarios.php";</script>';
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
        } else {
            $_SESSION['error'] = "Acceso no autorizado";
            header("location:panelcontrol.php");
        }
        ?>
    </body>
</html>