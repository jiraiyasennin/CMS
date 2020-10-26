<!--==========Area del Menú==========-->
<div class="col-sm-2">
    <ul id="menupanel" class="nav nav-pills nav-stacked">
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/CMS/admin/panelcontrol.php" ? "active" : ""); ?>"><a href="panelcontrol.php"><span class="glyphicon glyphicon-th-large"></span>Panel de Control</a></li>
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/CMS/admin/agregararticulo.php" ? "active" : ""); ?>"><a href="agregararticulo.php"><span class="glyphicon glyphicon-plus"></span>Nuevo Post</a></li>
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/CMS/admin/agregararticulo.php" ? "active" : ""); ?>"><a href="categorias.php"><span class="glyphicon glyphicon-plus"></span>Categorias</a></li>
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/CMS/admin/usuarios.php" ? "active" : ""); ?>"><a href="usuarios.php"><span class="glyphicon glyphicon-user"></span>Usuarios</a></li>
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/CMS/admin/comentarios.php" ? "active" : ""); ?>"><a href="comentarios.php"><span class="glyphicon glyphicon-comment"></span>Comentarios</a></li>
        <li class=""><a href="../blog.php" target="_blank"><span class="glyphicon glyphicon-list-alt"></span>Blog</a></li>
        <li class=""><a href="panelcontrol.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
    </ul>
</div>
<!--==========Fin de área del Menú==========-->
