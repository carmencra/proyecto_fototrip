<title>Fototrip - Mis viajes</title>

<?php require_once('views/layout/header_main.php'); ?>

<main>
    <section class="contenido_main">
        <?php use Utils\Utils;
            
            if(isset($_SESSION['comentario_guardado'])):
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

        <?php if(isset($_SESSION['usuario_ya_comentario']) && $_SESSION['usuario_ya_comentario']== true) : ?>
            <script type="text/javascript">
                alert("¡Ya has comentado este viaje!. Puedes verlo más abajo.");
                window.close();
            </script>
             
             <?php Utils::deleteSession('usuario_ya_comentario');

        endif;?>

        

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
                                <img src="./fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>"/>
                                
                                <section class="forms">
                                    
                                <!-- solo se podrán añadir comentarios e imágenes si el viaje ya ha tenido lugar -->
                                    <?php if ($viaje->getActivo() == FALSE) : ?>
                                        <form action="<?=$_ENV['BASE_URL']?>viaje/comentar" method="POST">
                                            <input type="hidden" name="id_viaje_a_comentar" value="<?= $viaje->getId()?>">
                                            <input type="submit" value="Comentar" class="boton_resaltar">
                                        </form> <br>

                                        <form action="<?=$_ENV['BASE_URL']?>viaje/imagen" method="POST">
                                            <input type="hidden" name="id_viaje_a_imagen" value="<?= $viaje->getId()?>">
                                            <input type="submit" value="Subir imagen" class="boton_resaltar">
                                        </form> <br>
                                    <?php endif; ?>

                                    <form action="<?=$_ENV['BASE_URL'].'detalle_viaje/'.$viaje->getId()?>" method="POST">
                                        <input type="submit" value="Ver más" class="ver_mas boton_resaltar">
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

                            <?php if ($viaje->getActivo() == true) : ?>
                                <p class="info_publicar">( Podr&aacute;s publicar im&aacute;genes y comentarios sobre el viaje cuando este se haya realizado. )</p>
                            <?php endif; ?>
                        
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
                            <img src="fuente/media/images/galeria/<?= $imagen->getImagen(); ?>" class="imagen_resize"/> <br><br>

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

                            <br>

                            <form id="form_borrar_imagen_<?= $imagen->getId() ?>" action="<?=$_ENV['BASE_URL']?>imagen/borrar" method="POST" class="borrar">
                                <input type="hidden" name="id_imagen_a_borrar" value="<?= $imagen->getId()?>">
                                <input type="submit" value="Borrar" class="boton_resaltar">
                            </form> 

                            <?php if ($imagen->getAceptada() == FALSE): ?>
                                <p class="aceptacion">( Pendiente de aceptaci&oacute;n )</p>
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
                        <h5> Viaje a: <span class="destino"> <?= $comentario->getNombre_viaje(); ?> </span>
                            <?php if ($comentario->getAceptado() == FALSE): ?>
                                <span class="aceptacion">( Pendiente de aceptaci&oacute;n )</span>
                            <?php endif; ?>
                        </h5>
                        <hr>
                        
                        <p class="contenido"> <?= $comentario->getContenido(); ?> </p>
                      
                        <br>
                    
                        <form id="form_borrar_comentario_<?= $comentario->getId() ?>" action="<?=$_ENV['BASE_URL']?>comentario/borrar" method="POST">
                            <input type="hidden" name="id_comentario_a_borrar" value="<?= $comentario->getId()?>">
                            <input type="submit" value="Borrar" class="boton_resaltar">
                        </form> <br>

                    </section>                    

                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
        </section>


        <?php endif; ?>
    </section>


<?php
     Utils::deleteSession('comentario_guardado');
 
require_once('views/layout/footer_main.php'); 
?>
