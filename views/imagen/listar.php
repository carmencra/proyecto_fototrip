
<section class="imagenes">

    <?php foreach($imagenes as $imagen) : ?>
        <section class="imagen">
            <h4> <?= $imagen->getUsuario(); ?> </h4>

            <hr>

            <p class="imagen_imagen"> <?= $imagen->getImagen(); ?> </p>

            <p> <?= $imagen->getDatos_viaje()["pais"]; ?> </p>
            
            <p> <?= $imagen->getDatos_viaje()["fecha_inicio"]; ?> -  <?= $imagen->getDatos_viaje()["fecha_fin"]; ?></p>
            
            <p> <?= $imagen->getTipo(); ?> </p>
            
        </section>

    <?php endforeach; ?>

</section>