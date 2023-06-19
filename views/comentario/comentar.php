<title>Fototrip - Comentar</title>


<?php require_once('views/layout/header_sub_main.php'); ?>

<!-- si se ha intentado guardar un comentario, muestra si ha ocurrido algún error, si se completa, lo indica en la página de administrar  -->
<?php use Utils\Utils;
    if(isset($_SESSION['comentario_guardado']) && $_SESSION['comentario_guardado'] == false): ?>
        <script type="text/javascript">
            alert("Ha habido un error al guardar el comentario.");
            window.close();
        </script>
    
        <?php
        Utils::deleteSession('comentario_guardado');
     endif;
?>

<main>
    <section class="contenido_main">
        <form action="<?=$_ENV['BASE_URL']?>comentario/guardar" method="POST" class="form_crear">
            <h1>Comentar viaje 
                <?php if (gettype($viaje) == 'array'): echo $viaje['pais'];
                else: echo $viaje->getPais(); endif;?>
            </h1>    
            <hr> <br>

            <textarea name="data[comentario]" id="coment"><?php if (isset($_POST['data']['comentario'])) echo $_POST['data']['comentario']; ?></textarea>
            <br><span style="color:red"> <?php if(isset($_SESSION['err_com'])) echo $_SESSION['err_com']?> </span>

            <br><br>

            <input type="hidden" name="data[id_viaje_a_comentar]" value= <?php if (gettype($viaje) == 'array'): echo $viaje['id'];
                else: echo $viaje->getId(); endif; ?> >
            <input type="hidden" name="data[pais_viaje_a_comentar]" value= <?php if (gettype($viaje) == 'array'): echo $viaje['pais'];
                else: echo $viaje->getPais(); endif; ?> >

            <input type="submit" value="comentar" class="crear">
        </form>


    </section>

<?php require_once('views/layout/footer_sub_main.php'); ?>
