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


        

        <section class="mis_viajes">
            <div class="titulo_mi">
                <h1>Mis viajes <br><br> <hr> </h1>  
                 
                <?php if (empty($viajes)) : ?> <br>
                    <div class="vacio">
                        <p>No te has inscrito a ning&uacute;n viaje.</p>
                        <p>Cuando te inscribas a alguno, aparecer&aacute; aqu&iacute;.</p>
                    </div>
                <?php else :?>
            </div> <br>

                <section class="display">
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
        </section>


        <section class="mis_imagenes">
            <div class="titulo_mi">
                <h1>Mis im&aacute;genes <br><br> <hr> </h1>  
                 
                <?php if (empty($imagenes)) : ?>
                    <div class="vacio">
                        <p>No has publicado ninguna imagen.</p>
                        <p>Cuando publiques alguna, aparecer&aacute; aqu&iacute;.</p>
                    </div>
                <?php else :?>
            </div> <br>

                <section class="imagenes">
                    <?php foreach($imagenes as $imagen) : ?>

                        <section class="imagen">
                            <img src="fuente/media/images/galeria/<?= $imagen->getImagen(); ?>" width="380px" height="260px"/> <br><br>

                            <section class="datos_imagen">
                                <section> 
                                    <img src="fuente/media/images/ubicacion.png" />
                                    <?= $imagen->getPais_viaje(); ?> 
                                </section>
                                
                                <section> 
                                    <img src="fuente/media/images/calendario.png" />
                                    <?= $imagen->getFecha(); ?> 
                                </section>
                                
                                <section> 
                                    <img src="fuente/media/images/imagen.png" />
                                    <?= $imagen->getTipo(); ?> 
                                </section>
                            </section>

                            <?php if ($imagen->getAceptada() == FALSE): ?>
                                <p>( Pendiente de aceptaci&oacute;n )</p>
                            <?php endif; ?>
                        </section>
                    
                    <?php endforeach; ?>
                </section>

            <?php endif; ?>
        </section>


        <section class="mis_comentarios">
            <div class="titulo_mi">
                <h1>Mis comentarios <br><br> <hr> </h1>  
                 
                <?php if (empty($comentarios)) : ?>
                    <div class="vacio">
                        <p>No has publicado ning&uacute;n comentario.</p>
                        <p>Cuando publiques alguno, aparecer&aacute; aqu&iacute;.</p>
                    </div>
                <?php else :?>
            </div> <br>
            
                <section class="comentarios">
                    <?php foreach($comentarios as $comentario) : ?>
                        
                    <section class="comentario">
                        <h4> Viaje a: <span class="destino"> <?= $comentario->getNombre_viaje(); ?> </span></h4>
                        <hr>
                        
                        <p class="contenido"> <?= $comentario->getContenido(); ?> </p>
                    </section>

                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </section>


        <?php endif; ?>
    </section>


<?php
     use Utils\Utils;
     Utils::deleteSession('comentario_guardado');
 
require_once('views/layout/footer_main.php'); 
?>
