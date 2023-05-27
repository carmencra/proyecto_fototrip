
<?php require_once('views/layout/header_main.php'); ?>


<main>
    <section class="contenido_main">
        <section class="admin">
            <section class="admin_viaje">
                <h2>Viajes</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>viaje/crear">Añadir</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>viaje/mostrar">Editar/borrar</a>
            </section>

            <section class="admin_fotos">
                <h2>Im&aacute;genes</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>imagen/crear">Añadir</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>imagen/mostrar">Editar/borrar</a>
            </section>

            <section class="admin_comentarios">
                <h2>Comentarios</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>comentario/mostrar">Borrar</a>
            </section>

        </section>
    </section>


<?php require_once('views/layout/footer_main.php'); ?>
