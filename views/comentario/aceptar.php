<title>Fototrip - Administrar comentarios</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<main>
    <section class="contenido_main">
        <?php if(isset($_SESSION['comentario_borrado'])):
            if ($_SESSION['comentario_borrado'] == true) : ?>
                <script type="text/javascript">
                    alert("Se ha borrado el comentario.");
                    window.close();
                </script>

            <?php else: ?>
                <script type="text/javascript">
                    alert("No se ha borrado el comentario.");
                    window.close();
                </script>
            <?php endif;?>     
        <?php endif;?>
        
        <!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
        <script>
            var base_url = 'http://localhost/fototrip/';
            var ruta_pagina = 'seleccionar/comentarios';

            if (!window.location.href.startsWith(base_url) || !window.location.href.endsWith(ruta_pagina)) {
                window.location.href = base_url + ruta_pagina;
            }
        </script>

        <?php 
        if(empty($comentarios)):
            echo "<h4>No hay comentarios.</h4>" ;
        else :?>

            <section class="comentarios">
                <?php foreach($comentarios as $comentario) : ?>
                    <section class="comentario">
                        <h4> <?= $comentario->getUsuario(); ?> </h4>
                        <hr>

                        <p class="contenido"> <?= $comentario->getContenido(); ?> </p>
                        
                        <section class="forms_comentario">
                            <form id="form_aceptar_comentario_<?= $comentario->getId() ?>" action="<?=$_ENV['BASE_URL']?>comentario/aceptar" method="POST">
                                <input type="hidden" name="comentario_a_aceptar" value="<?= $comentario->getId()?>">
                                <input type="submit" value="Aceptar" class="boton_resaltar">
                            </form>
                            
                            <form id="form_descartar_comentario_<?= $comentario->getId() ?>" action="<?=$_ENV['BASE_URL']?>comentario/descartar" method="POST">
                                <input type="hidden" name="comentario_a_descartar" value="<?= $comentario->getId()?>">
                                <input type="submit" value="Descartar" class="boton_resaltar">
                            </form>
                        </section> 

                    </section>

                <?php endforeach; ?>

            </section>

        <?php endif;?>
        
    </section>


<?php require_once('views/layout/footer_sub_main.php'); ?>
