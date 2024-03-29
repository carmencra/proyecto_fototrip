<title>Fototrip - Ver viaje</title>

<!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
<script>
    var base_url = '<?= $_ENV['BASE_URL']?>';
    var ruta_pagina = 'detalle_viaje/'.$viaje->getId();

    if (!window.location.href.startsWith(base_url) || !window.location.href.endsWith(ruta_pagina)) {
        window.location.href = base_url + ruta_pagina;
    }
</script>

<?php require_once('views/layout/header_sub_main.php'); ?>


<section class="portada" style="background-image:url('../fuente/media/images/galeria/<?= $viaje->getImagen_principal();?>')">
    <section>
        <h1 class="titulo_portada"> <?= $viaje->getPais() ?> </h1>

        <?php 
        // si el viaje está activo;
        if ($viaje->getActivo() == true) {

            // hay un usuario, que no sea el admin;
            if(isset($_SESSION['usuario']) && !isset($_SESSION['admin'])):
                // y no está ya inscrito al viaje, podrá hacerlo 
                if(!isset($_SESSION['usuario_ya_inscrito'])) : ?>

                    <form id="form_inscribirse_<?= $viaje->getId() ?>" action="<?=$_ENV['BASE_URL']?>viaje/inscribirse" method="POST">
                        <input type="hidden" name="viaje_a_inscribirse" value="<?= $viaje->getId()?>">
                        <input type="submit" value="Inscribirse">
                    </form>
                <?php else :?> <br><br>
                    <span> (Ya inscrito) </span>
                <?php endif;
            endif; 
        }
        // si no está activo, lo dice
        else if ($viaje->getActivo() == false) : ?> <br><br>
            <span> (Viaje no activo) </span>

        <?php endif; ?>
        
       

    </section>
</section>


<main>

    <!-- si el usuario se ha intentado inscribir al viaje y ha fallado, nos muestra el mensaje -->
        <?php use Utils\Utils; 
        if(isset($_SESSION['viaje_inscrito'])):
            if ($_SESSION['viaje_inscrito'] == false) : ?>
                <script type="text/javascript">
                    alert("Ha habido un error en la inscripción del viaje.");
                    window.close();
                </script>
                
            <?php endif;
            // borra la sesión tanto si se ha inscrito como si no
            Utils::deleteSession('viaje_inscrito');
        endif;
    ?>


    <section class="detalle_viaje">
        <?= $viaje->getPais() ?>

        <section class="general">
            <h2>Informaci&oacute;n general</h2>
            <hr>

            <section class="info">
                <section>
                    <img src="../fuente/media/images/icono_precio.png" alt="precio"/> 
                    <span> &nbsp;&nbsp; <?= $viaje->getPrecio() ?> € </span> 
                </section>

                <section>
                    <img src="../fuente/media/images/icono_foto.png" alt="nivel fotográfico"/> 
                    <span> &nbsp;&nbsp; <?= $viaje->getNivel_fotografia() ?> </span>
                </section>

                <section>
                    <img src="../fuente/media/images/icono_fecha.png" alt="fecha"/> 
                    <span> &nbsp;&nbsp; <?= $viaje->getFecha_inicio() ?> / <?= $viaje->getFecha_fin() ?> </span>
                </section>

                <section>
                    <img src="../fuente/media/images/icono_fisico.png" alt="nivel físico"/> 
                    
                    <span> &nbsp;&nbsp; <?= $viaje->getNivel_fisico() ?> </span>
                </section>
            </section>

        </section>



        <section class="descripcion">
            <h2>Descripci&oacute;n del viaje</h2>
            <hr> <br>

            <span> <b>Resumen:</b> <?= $viaje->getDescripcion() ?> </span> <br><br>

            <span> <b>Informaci&oacute;n detallada:</b> <?= $viaje->getInformacion() ?></span> <br>
        </section>


        
        <section class="gastos">
            <h2>Gastos incluidos</h2>
            <hr>

            <section class="incluidos">
                <section>
                    <?php if ($gastos->getComida() == true): ?>
                        <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                    <?php else :?>
                        <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                    <?php endif;?> 

                    <span>Comida</span>
                </section>

                <section>
                    <?php if ($gastos->getTransportes() == true): ?>
                        <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                    <?php else :?>
                        <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                    <?php endif;?> 

                    <span> Transportes </span>
                </section>

                <section>
                    <?php if ($gastos->getAlojamiento() == true): ?>
                        <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                    <?php else :?>
                        <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                    <?php endif;?> 

                    <span> Alojamiento </span>
                </section>

                <section>
                    <?php if ($gastos->getSeguro() == true): ?>
                        <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                    <?php else :?>
                        <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                    <?php endif;?> 
                    
                    <span> Seguro </span>
                </section>

                <section>
                    <?php if ($gastos->getVuelos() == true): ?>
                        <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                    <?php else :?>
                        <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                    <?php endif;?> 

                    <span> Vuelos </span>
                </section>

                <section>
                    <?php if ($gastos->getGastos() == true): ?>
                            <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                        <?php else :?>
                            <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                        <?php endif;?> 
                    
                    <span> Gastos aparte </span>
                </section>

            </section>

        </section>


        
        <section class="galeria">
            <h2>Galer&iacute;a</h2>
            <hr>
        </section>

        <section class="imagenes">
            <?php foreach($imagenes as $imagen) : ?>
                <section class="imagen_viaje">
                    <img src="../fuente/media/images/galeria/<?= $imagen->getImagen();?>" class="imagen_resize" />

                    <p class="usuario"> <?= $imagen->getUsuario(); ?> </p>                        
                </section>

            <?php endforeach; ?>
        </section>



        <section class="opiniones">
            <h2>Comentarios</h2>
            <hr>
        </section>

        <section class="comentarios">
            <?php foreach($comentarios as $comentario) : ?>
                <section class="comentario" id="opinion">
                    <h5> <?= $comentario->getNombre_usuario(); ?>
                         <?= $comentario->getApellidos_usuario(); ?>
                    </h5>

                    <hr>

                    <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

                </section>
            <?php endforeach; ?>
        </section>


    </section>

<?php require_once('views/layout/footer_sub_main.php'); ?>
