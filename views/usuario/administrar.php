<title>Fototrip - Administrar</title>

<?php require_once('views/layout/header_main.php'); ?>

<?php use Utils\Utils;
    if(isset($_SESSION['imagen_creada']) && $_SESSION['imagen_creada'] == true): ?>
        <script type="text/javascript">
            alert("Se ha guardado la imagen.");
            window.close();
        </script>
        
        <?php
        Utils::deleteSession('imagen_creada');
    endif; 
?>
<?php 
    if(isset($_SESSION['viaje_creado']) && $_SESSION['viaje_creado'] == true): ?>
        <script type="text/javascript">
            alert("Se ha guardado el viaje.");
            window.close();
        </script>
        
        <?php
        Utils::deleteSession('viaje_creado');
    endif;
?>

<main>
    <section class="contenido_main">
        <section class="admin">
            <section>
                <h2>Viajes</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>viaje/crear">Añadir</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>administrar/viaje">Borrar</a> <br><br>
                <a> ------ </a> 
            </section>

            <section>
                <h2>Comentarios</h2>
                <hr><br>
                <a> ------ </a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>administrar/comentario">Borrar</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>seleccionar/comentarios">Aceptar/descartar</a>
            </section>
            
            <section>
                <h2>Im&aacute;genes</h2>
                <hr><br>
                <a href="<?=$_ENV['BASE_URL']?>imagen/crear">Añadir</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>administrar/imagen">Borrar</a> <br><br>
                <a href="<?=$_ENV['BASE_URL']?>seleccionar/imagenes">Aceptar/descartar</a>
            </section>

        </section>
    </section>


<?php require_once('views/layout/footer_main.php'); ?>
