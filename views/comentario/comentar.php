<title>Fototrip - Comentar</title>


<?php require_once('views/layout/header_sub_main.php'); ?>

<main>
    <section class="contenido_main">
        <form action="<?=$_ENV['BASE_URL']?>comentario/guardar" method="POST" class="form_crear">
            <h1>Comentar viaje <?= $viaje->getPais() ;?></h1>    
            <hr> <br>

            <textarea name="data[comentario]" id="coment"><?php if (isset($_POST['data']['comentario'])) echo $_POST['data']['comentario']; ?></textarea>
            <br><span style="color:red"> <?php if(isset($_SESSION['err_com'])) echo $_SESSION['err_com']?> </span>

            <br><br>

            <input type="hidden" name="data[id_viaje_a_comentar]" value= <?= $viaje->getId() ;?> >

            <input type="submit" value="comentar" class="crear">
        </form>


    </section>

<?php require_once('views/layout/footer_sub_main.php'); ?>
