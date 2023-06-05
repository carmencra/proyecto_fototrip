<title>Fototrip - Mis viajes</title>

<?php require_once('views/layout/header_main.php'); ?>

<main>
    <section class="contenido_main">
        <?php if(isset($_SESSION['comentario_guardado'])):
            if ($_SESSION['comentario_guardado'] == true) : ?>
                <script type="text/javascript">
                    alert("Tu comentario se ha guardado y está pendiente de ser aceptado.");
                    window.close();
                </script>
            <?php else: ?>
                <script type="text/javascript">
                    alert("Tu comentario no se ha podido guardar correctamente.");
                    window.close();
                </script>
            <?php endif;?>     
        <?php endif;?>


        <?php if (empty($viajes)) : ?>
            <p>No te has inscrito a ningún viaje</p>
            <p>Cuando te inscribas, aparecer&aacute; aqu&iacute;</p>
        <?php else :?>

            <section class="mis_viajes">
                <?php foreach($viajes as $viaje) : ?>
                    <section class="mi_viaje">
                        <h1> <?= $viaje->getId(); ?>. <?= $viaje->getPais(); ?> </h1> <hr> <br>  
                        
                        <section class="seccion_viaje">
                            <img src="./fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>" width="250px" height="150px" />
                            
                            <section class="forms">
                                
                            <!-- solo se podrán añadir comentarios e imágenes si el viaje ya ha tenido lugar -->
                                <?php if ($viaje->getActivo() == FALSE) : ?>
                                    <form id="form_borrar_viaje_<?= $viaje->getId() ?>" action="<?=$_ENV['BASE_URL']?>viaje/comentar" method="POST">
                                        <input type="hidden" name="id_viaje_a_comentar" value="<?= $viaje->getId()?>">
                                        <input type="submit" value="Comentar">
                                    </form> <br>

                                    <form id="form_borrar_viaje_<?= $viaje->getId() ?>" action="<?=$_ENV['BASE_URL']?>viaje/imagen" method="POST">
                                        <input type="hidden" name="id_viaje_a_imagen" value="<?= $viaje->getId()?>">
                                        <input type="submit" value="Subir imagen">
                                    </form> <br>
                                <?php endif; ?>

                                <form action="<?=$_ENV['BASE_URL'].'viaje/ver?id='.$viaje->getId()?>" method="POST">
                                    <input class="ver_mas" type="submit" value="ver más">
                                </form>
                            </section>

                        </section>

                        <section class="contenido">
                            <span> <?= $viaje->getDescripcion(); ?> </span>
                            <span> <?= $viaje->getPrecio(); ?> € </span>
                            <span> <?= $viaje->getFecha_inicio(); ?> / <?= $viaje->getFecha_fin(); ?></span>
                            
                            <span> Fotograf&iacute;a: <?= $viaje->getNivel_fotografia(); ?> </span>
                            <span> F&iacute;sico: <?= $viaje->getNivel_fisico(); ?> </span>
                    </section>
                    
                    </section>

                <?php endforeach; ?>

            </section>


        <?php endif; ?>
    </section>


<?php require_once('views/layout/footer_main.php'); ?>
