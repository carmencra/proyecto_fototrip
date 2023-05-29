<?php require_once('views/layout/header_sub_main.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../fuente/scripts/recoger_id_elemento_borrar.js"></script>

<main>
    <section class="contenido_main">

        <?php if(isset($_SESSION['comentario_borrado'])):
            if ($_SESSION['comentario_borrado'] == true) : ?>
                <script type="text/javascript">
                    alert("Se ha borrado el comentario.");
                    window.close();
                </script>
                
            <?php else: ?>
                <script type="text/javascript">
                    alert("No se ha borrado el comentario.");
                    window.close();
                </script>
            <?php endif;?>     
        <?php endif;?>

        <section class="comentarios">
            <?php foreach($comentarios as $comentario) : ?>
                <section class="comentario">
                    <h4> <?= $comentario->getUsuario(); ?> </h4>
                    <hr>

                    <p class="contenido"> <?= $comentario->getContenido(); ?> </p>
                    
                    <!-- creamos un formulario para borrar el comentario, que recoge el id por post; cada formulario tiene un id distinto, dependiendo del id del comentario -->
                    <form id="form_borrar_comentario_<?= $comentario->getId() ?>" action="<?=$_ENV['BASE_URL']?>comentario/borrar" method="POST">
                        <input type="hidden" name="id_comentario_a_borrar" value="<?= $comentario->getId()?>">
                        <input type="submit" value="Borrar">
                    </form>
                </section>

            <?php endforeach; ?>
        </section>

    </section>
   

<?php  
    use Utils\Utils;
    Utils::deleteSession('comentario_borrado');

    require_once('views/layout/footer_sub_main.php'); 
?>
