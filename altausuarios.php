<?php
require_once 'classes/loader.php';
$session = new Sesiones();
?>
<!DOCTYPE html>
<html>
    <?php include 'include/blog/headerblog.php' ?>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#colapsa">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img id="logoblog"  src="blogImages/Fibonacci_spiral.svg">
                </div>
                <div class="collapse navbar-collapse" id="colapsa">
                    <ul id="navegacionblog" class="nav navbar-nav">
                        <li class="active"><a href="blog.php">Home</a></li>
                        <li><a href="categorias.php">Categorías</a></li>
                        <li><a href="#">Php</a></li>
                        <li><a href="#">Acerca de Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                        <li><a href="login.php" data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </ul>
                    <form class="navbar-form navbar-right" action="" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                            <div class="input-group-btn">
                                <button class="btn btn-default" name="submit" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </nav> 
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
                                    <input type="text" name="password" class="form-control" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-sm" name="registro" href="registro.php">¿No tienes cuenta? Regístrate</a>
                    </div>
                </div>

            </div>
        </div>
        <!--Final Modal Login-->
        <div class="container-fluid">
            <div class="row">
                <!--==========Area Principal==========-->
                <div id="formAltaUsuarios" class="col-md-4 col-md-offset-4">
                    <h1>Alta de Usuarios</h1>
                    <div>
                        <form class="form-horizontal" method="post" action="altausuarios.php">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">@</div>
                                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
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
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                                    <input type="password" name="password2" class="form-control" placeholder="Confirme la Contraseña" required>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div><br>

                </div>

                <!--==========Fin del área principal==========-->
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div id="mensajes">
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
                         * Creación del usuario
                         */
                        if (isset($_POST['submit'])) {
                            $usuariosObjeto = new UsuariosControl();
                            $verificaNull = $usuariosObjeto->VerificarNull($_POST);
                            if (isset($verificaNull['error'])) {
                                $_SESSION['error'] = $verificaNull['error'];
                                echo '<script>window.location.href = "altausuarios.php";</script>';
                                die();
                            } else {
                                $verificaCampos = $usuariosObjeto->VerificaSetUsuario($_POST);
                                if (isset($verificaCampos['error'])) {
                                    $_SESSION['error'] = $verificaCampos['error'];
                                    echo '<script>window.location.href = "altausuarios.php";</script>';
                                    die();
                                }
                                $agregar = $usuariosObjeto->AgregarUsuario($verificaCampos);
                                if (isset($agregar['error'])) {
                                    $_SESSION['error'] = $agregar['error'];
                                    echo '<script>window.location.href = "altausuarios.php";</script>';
                                    die();
                                } else if (isset($agregar['exito'])) {
                                    $_SESSION['ok'] = $agregar['exito'];
                                    echo '<script>window.location.href = "altausuarios.php";</script>';
                                    die();
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--==========Fin del Row==========-->
        </div>
        <!--==========Fin del contenedor==========-->
        <?php include 'include/blog/footerblog.php' ?>
    </body>
</html>
