
<?php require_once('views/layout/header_sub_main.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $("#form_borrar_viaje").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var id_viaje = $("#id_viaje_a_borrar").val();
    
    var result = confirm("¿Quieres borrar este viaje?");

    if (result) {
        this.submit();
    } 
  });
});
</script>


<main>
    <section class="contenido_main">
        
        <section class="admin_viajes">
            <?php foreach ($viajes as $viaje) :?>

                <section class="viaje_admin">  
                    <h1> <?= $viaje->getId(); ?>. <?= $viaje->getPais(); ?> </h1> <hr> <br>  
                    
                    <section class="seccion_viaje">
                        <img src="../fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>" width="250px" height="150px" />
                        
                        <section class="forms">
                            <form action="<?=$_ENV['BASE_URL'].'viaje/modificar&id='.$viaje->getId() ?>" method="GET">
                                <input type="submit" value="Modificar">
                            </form> <br>

                            <form id="form_borrar_viaje" action="<?=$_ENV['BASE_URL']?>viaje/borrar" method="POST">
                                <input type="hidden" id="id_viaje_a_borrar" name="id_viaje_a_borrar" value="<?= $viaje->getId()?>">
                                <input type="submit" value="Borrar">
                            </form>

                            <!-- <button id="borrar_viaje" data-id="< ?= $viaje->getId();?>">Borrar viaje</button> -->

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
</main>

<?php require_once('views/layout/footer_sub_main.php'); ?>
