<?php

require_once '../classes/loader.php';
/**
 * Comienzo de la sesión
 */
$session = new Sesiones();
if (isset($_POST['submit'])) {
    $objetoUser = new UsuariosControl();
    $login = $objetoUser->loginUsuario($_POST);
    if ($login['true']) {
        $_SESSION['usuario'] = $login['true'];
        $_SESSION['ok'] = "Bienvenido " . $login['true'];
        header("location:panelcontrol.php");
    } else {
        $_SESSION['error'] = "El usuario o el password no existe";
        header("location:" . $_SERVER["HTTP_REFERER"]);
    }
}
?>