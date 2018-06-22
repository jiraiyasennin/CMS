<!DOCTYPE html>
<!--
**Desarrollo de un Sistema gestor de contenidos con PHP, SQL Y BOOTSTRAP**
                        By Dostow Ugel
-->
<html>
    <?php include '../include/header.php' ?>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!--==========Area del Menú==========-->
                <div class="col-sm-2">
                    <h1>Dostow</h1>
                    <ul id="menupanel" class="nav nav-pills nav-stacked">
                        <li class="active"><a href="panelcontrol.php"><span class="glyphicon glyphicon-th-large"></span>Panel de Control</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-plus"></span>Nuevo Post</a></li>
                        <li class=""><a href="categorias.php"><span class="glyphicon glyphicon-tags"></span>Categorías</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-user"></span>Manage Admins</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-comment"></span>Comentarios</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-list-alt"></span>Blog</a></li>
                        <li class=""><a href="#"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
                    </ul>
                </div>
                <!--==========Fin de área del Menú==========-->
                <!--==========Area Principal==========-->
                <div class="col-sm-10">
                    <h1>Panel de Control</h1>
                    <h4>About</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Phasellus ultrices nisi sed sem feugiat ultrices. Ut 
                        maximus enim eget sodales hendrerit. Nunc at metus mattis,
                        mattis urna eget, rutrum leo. Fusce augue elit, consectetur
                        nec ullamcorper et, ultrices ac nisl. Pellentesque habitant 
                        morbi tristique senectus et netus et malesuada fames ac 
                        turpis egestas. In sollicitudin purus nibh, eu scelerisque
                        diam interdum eget. Morbi nec accumsan augue. Ut pellentesque
                        porttitor quam eu lobortis. Sed eu mollis urna. Vestibulum 
                        scelerisque tortor non arcu sagittis venenatis. Quisque 
                        consectetur mi eget fringilla elementum. Fusce sit amet 
                        condimentum nibh, quis auctor diam. 
                    </p>
                    <h4>About</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Phasellus ultrices nisi sed sem feugiat ultrices. Ut 
                        maximus enim eget sodales hendrerit. Nunc at metus mattis,
                        mattis urna eget, rutrum leo. Fusce augue elit, consectetur
                        nec ullamcorper et, ultrices ac nisl. Pellentesque habitant 
                        morbi tristique senectus et netus et malesuada fames ac 
                        turpis egestas. In sollicitudin purus nibh, eu scelerisque
                        diam interdum eget. Morbi nec accumsan augue. Ut pellentesque
                        porttitor quam eu lobortis. Sed eu mollis urna. Vestibulum 
                        scelerisque tortor non arcu sagittis venenatis. Quisque 
                        consectetur mi eget fringilla elementum. Fusce sit amet 
                        condimentum nibh, quis auctor diam. 
                    </p>
                </div>
                <!--==========Fin del área principal==========-->

            </div>
            <!--==========Fin del Row==========-->
        </div>
        <!--==========Fin del contenedor==========-->
        <?php include '../include/footer.php'; ?>
    </body>
</html>