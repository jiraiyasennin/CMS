<section class="col-sm-2"> 
    <div id="menuSide" class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Categorias</h3>
        </div>
        <div class="panel-body">
            <table class="table-responsive">
                <?php
                /**
                 * Lista de categorías menú lateral
                 */
                $categoriasObjeto = new CategoriasControl();
                $listaCategorias = $categoriasObjeto->ListaDeCategorias();
                foreach ($listaCategorias as $key => $value):
                    if (strlen($value['nombre']) > 14) {
                        $categoria = $articulos->recortaStrings($value['nombre'], 14) . "...";
                    } else {
                        $categoria = $value['nombre'];
                    }
                    ?>
                    <tr>
                        <td><a href="blog.php?categ=<?php echo $value['nombre'] ?>"><?php echo $categoria ?></a></td>
                    </tr>
                    <?php
                endforeach;
                ?>

            </table>
        </div>
    </div>
</section>
