
<?php require_once('views/layout/header_sub_main.php'); ?>


<main>
    <section class="contenido_main">
        
        <section class="admin_viajes">
            <?php foreach ($viajes as $viaje) :?>

                <section class="viaje_admin">  
                    <h1> <?= $viaje->getId(); ?>. <?= $viaje->getPais(); ?> </h1> <hr> <br>  
                    
                    <section class="seccion_viaje">
                        <img src="../fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>" width="250px" height="150px" />
                        
                        <section class="contenido">
                            <span> <?= $viaje->getDescripcion(); ?> </span>
                            <span> <?= $viaje->getPrecio(); ?> € </span>
                            <span> <?= $viaje->getFecha_inicio(); ?> / <?= $viaje->getFecha_fin(); ?></span>
                            
                            <span> Fotograf&iacute;a: <?= $viaje->getNivel_fotografia(); ?> </span>
                            <span> F&iacute;sico: <?= $viaje->getNivel_fisico(); ?> </span>
                        </section>
    
                        <section class="forms">
                            <form action="<?=$_ENV['BASE_URL'].'viaje/modificar&id='.$viaje->getId() ?>" method="GET">
                                <input type="submit" value="Modificar">
                            </form> <br>
    
                            <form action="<?=$_ENV['BASE_URL'].'viaje/borrar&id='.$viaje->getId() ?>" method="GET">
                                <input type="submit" value="Borrar">
                            </form>
                        </section>

                    </section>
                    
                </section>
                
            <?php endforeach; ?>

        </section>
    </section>
</main>

<?php require_once('views/layout/footer_sub_main.php'); ?>
