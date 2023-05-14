
<link rel="stylesheet" href="fuente/styles/comentario.css">

<section class="comentarios">

    <?php foreach($comentarios as $comentario) : ?>
        <section class="comentario">
            <h4> <?= $comentario->getUsuario(); ?> </h4>

            <hr>

            <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

            <form action="<?=base_url.'comentario/verviaje&id='.$comentario->getId_viaje() ?>" method="GET">
                <input class="ver_viaje" type="submit" value="ver viaje ".<?= $comentario->getNombre_viaje()?> >
            </form>
        </section>

    <?php endforeach; ?>

</section>