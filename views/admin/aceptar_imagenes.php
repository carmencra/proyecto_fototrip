<!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
<script>
    console.log(window.location.href);
    var baseUrl = 'http://localhost/fototrip/';
    var ruta_pagina = 'seleccionar/imagenes';

    if (!window.location.href.startsWith(baseUrl) || !window.location.href.endsWith(ruta_pagina)) {
        window.location.href = baseUrl + ruta_pagina;
    }
</script>

<?php require_once('views/layout/header_sub_main.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../fuente/scripts/recoger_id_elemento_borrar.js"></script>


<main>
    <section class="contenido_main">
        <?php if(isset($_SESSION['imagen_borrada'])):
            if ($_SESSION['imagen_borrada'] == true) : ?>
                <script type="text/javascript">
                    alert("Se ha borrado la imagen.");
                    window.close();
                </script>

            <?php else: ?>
                <script type="text/javascript">
                    alert("No se ha borrado la imagen.");
                    window.close();
                </script>
            <?php endif;?>     
        <?php endif;?>


        <section class="imagenes">
            <?php foreach($imagenes as $imagen) : ?>
                <section class="imagen">
                    <h4> <?= $imagen->getUsuario(); ?> </h4>

                    <hr> <br>

                    <section class="forms_imagen">
                        <form id="form_aceptar_imagen_<?= $imagen->getImagen() ?>" action="<?=$_ENV['BASE_URL']?>imagen/aceptar" method="POST">
                            <input type="hidden" name="imagen_a_aceptar" value="<?= $imagen->getImagen()?>">
                            <input type="submit" value="Aceptar">
                        </form>
                        
                        <form id="form_descartar_imagen_<?= $imagen->getImagen() ?>" action="<?=$_ENV['BASE_URL']?>imagen/descartar" method="POST">
                            <input type="hidden" name="imagen_a_descartar" value="<?= $imagen->getImagen()?>">
                            <input type="submit" value="Descartar">
                        </form>
                    </section> <br>

                    <img src="../fuente/media/images/galeria/<?= $imagen->getImagen(); ?>" width="380px" height="260px"/> <br><br>

                    <section class="datos_imagen">
                        <section> 
                            <img src="../fuente/media/images/ubicacion.png" />
                            <?= $imagen->getPais_viaje(); ?> 
                        </section>
                        
                        <section> 
                            <img src="../fuente/media/images/calendario.png" />
                            <?= $imagen->getFecha(); ?> 
                        </section>
                        
                        <section> 
                            <img src="../fuente/media/images/imagen.png" />
                            <?= $imagen->getTipo(); ?> 
                        </section>
                    </section>
                    
                </section>

            <?php endforeach; ?>

        </section>

    </section>


    <?php require_once('views/layout/footer_sub_main.php'); ?>
