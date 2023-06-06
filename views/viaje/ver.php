<title>Fototrip - Ver viaje</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../fuente/scripts/recoger_id_elemento_borrar.js"></script>

<section class="portada" style="background-image:url('../fuente/media/images/galeria/<?= $viaje->getImagen_principal();?>')">
    <section>
        <h1 class="titulo_portada"> <?= $viaje->getPais() ?> </h1>

        <!-- si hay un usuario, que no sea el admin, se podrá inscribir -->
        <?php if(isset($_SESSION['usuario']) && !isset($_SESSION['admin'])) :?>
            <form id="form_inscribirse_<?= $viaje->getId() ?>" action="<?=$_ENV['BASE_URL']?>viaje/inscribirse" method="POST">
                <input type="hidden" name="viaje_a_inscribirse" value="<?= $viaje->getId()?>">
                <input type="submit" value="Inscribirse">
            </form>
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
                    <span> &nbsp;&nbsp; <?= $viaje->getFecha_inicio() ?> - <?= $viaje->getFecha_fin() ?> </span>
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
                    <img src="../fuente/media/images/galeria/<?= $imagen->getImagen();?>" width="400px" height="260px" />

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
                    <h4> <?= $comentario->getNombre_usuario(); ?>
                         <?= $comentario->getApellidos_usuario(); ?>
                    </h4>

                    <hr>

                    <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

                </section>
            <?php endforeach; ?>
        </section>


    </section>

<?php require_once('views/layout/footer_sub_main.php'); ?>
