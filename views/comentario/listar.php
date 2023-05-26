
<?php require_once('views/layout/header_main.php'); ?>

<main>
    <section class="contenido_main">
        <section class="comentarios">

            <?php foreach($comentarios as $comentario) : ?>
                <section class="comentario">
                    <h4> <?= $comentario->getUsuario(); ?> </h4>

                    <hr>

                    <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

                    
                    <form action="<?=$_ENV['BASE_URL'].'viaje/ver?id='.$comentario->getId_viaje()?>" method="POST">
                        <input class="ver_viaje" type="submit" value="ver <?php echo($comentario->getNombre_viaje());?>">
                    </form>
                </section>

            <?php endforeach; ?>

        </section>
    </section>
    
<?php require_once('views/layout/footer_main.php'); ?>
