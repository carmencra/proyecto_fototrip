<title>Fototrip - Administrar viajes</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<main>
    <section class="contenido_main">

        <?php if(isset($_SESSION['viaje_borrado'])):
            if ($_SESSION['viaje_borrado'] == true) : ?>
                <script type="text/javascript">
                    alert("Se ha borrado el viaje.");
                    window.close();
                </script>

            <?php else: ?>
                <script type="text/javascript">
                    alert("No se ha borrado el viaje.");
                    window.close();
                </script>
            <?php endif;?>     
        <?php endif;?>

        
        <!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
        <script>
            var base_url = '<?= $_ENV['BASE_URL']?>';
            var ruta_pagina = 'administrar/viaje';

            if (!window.location.href.startsWith(base_url) || !window.location.href.endsWith(ruta_pagina)) {
                window.location.href = base_url + ruta_pagina;
            }
        </script>

        <?php 
        if(empty($viajes)):
            echo "<h4>No hay viajes.</h4>" ;
        else :?>
        
            <section class="admin_viajes">
                <?php foreach ($viajes as $viaje) :?>

                    <section class="viaje_admin">  
                        <h1> <?= $viaje->getId(); ?>. <?= $viaje->getPais(); ?> </h1> <hr> <br>  
                        
                        <section class="seccion_viaje">
                            <img src="../fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>" class="img_admin_viaje" />
                            
                            <section class="forms">
                                <!-- creamos un formulario para borrar el viaje, que recoge el id por post; cada formulario tiene un id distinto, dependiendo del id del viaje -->
                                <form id="form_borrar_viaje_<?= $viaje->getId() ?>" action="<?=$_ENV['BASE_URL']?>viaje/borrar" method="POST">
                                    <input type="hidden" name="id_viaje_a_borrar" value="<?= $viaje->getId()?>">
                                    <input type="submit" value="Borrar" class="boton_resaltar">
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

        <?php endif;?>

    </section>


    <?php  
        use Utils\Utils;
        Utils::deleteSession('viaje_borrado');

        require_once('views/layout/footer_sub_main.php'); 
    ?>
