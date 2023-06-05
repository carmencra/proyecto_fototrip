<title>Fototrip - Mis viajes</title>

<?php require_once('views/layout/header_main.php'); ?>


<main>
    <section class="contenido_main">
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
                                <form action="<?=$_ENV['BASE_URL'].'viaje/modificar&id='.$viaje->getId() ?>" method="GET">
                                    <input type="submit" value="Comentar">
                                </form> <br>

                                <!-- creamos un formulario para borrar el viaje, que recoge el id por post; cada formulario tiene un id distinto, dependiendo del id del viaje -->
                                <form id="form_borrar_viaje_<?= $viaje->getId() ?>" action="<?=$_ENV['BASE_URL']?>viaje/borrar" method="POST">
                                    <input type="hidden" name="id_viaje_a_borrar" value="<?= $viaje->getId()?>">
                                    <input type="submit" value="Subir imagen">
                                </form> <br>

                                <form action="<?=$_ENV['BASE_URL'].'viaje/modificar&id='.$viaje->getId() ?>" method="GET">
                                    <input type="submit" value="Ver más">
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
