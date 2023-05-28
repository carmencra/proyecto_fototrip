
<?php require_once('views/layout/header_main.php'); ?>


<main>
    <section class="contenido_main">
        <section class="admin">
            <section>
                <h2>Viajes</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>viaje/crear">Añadir</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>administrar/viaje">Editar/borrar</a>
            </section>

            <section>
                <h2>Im&aacute;genes</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>imagen/crear">Añadir</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>administrar/imagen">Editar/borrar</a>
            </section>

            <section>
                <h2>Comentarios</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>administrar/comentario">Borrar</a>
            </section>

        </section>
    </section>


<?php require_once('views/layout/footer_main.php'); ?>
