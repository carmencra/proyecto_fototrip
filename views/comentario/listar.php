<title>Fototrip - Opiniones</title>

<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo_header" src="fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu">
        <ul>
            <li> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>
            <li class="active"> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>
        </ul>

        <div class="menu_usuario">
          <?php require('views/layout/menu_usuario.php'); ?>
        </div>
    </nav> 

    <!-- menú despegable -->
    <nav class="menu_despegable">
        <!-- header antes de desplegar -->
        <section class="fijo_menu">
            <a href="<?=$_ENV['BASE_URL']?>">
                <img id="logo_desp" src="fuente/media/images/logo.png" alt="logo fototrip"/>
            </a>

            <a href="" class="boton_desplegar">
                <img src="fuente/media/images/menu.png" alt="menu"/>
            </a>
        </section>
            
        <!-- menú desplegado -->
        <ul class="lista_despegable centrar">
            <li class="active"> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

            <div>
                <?php require('views/layout/menu_usuario.php'); ?>
            </div>
        </ul>
    </nav>    
    
</header>



<main>
    <section class="contenido_main">
        <?php 
        if(empty($comentarios)):
            echo "<h4>No hay comentarios.</h4>" ;
        else :?>
            <section class="comentarios">

                <?php foreach($comentarios as $comentario) : ?>
                    <section class="comentario">
                        <h4> <?= $comentario->getNombre_usuario(); ?>
                            <?= $comentario->getApellidos_usuario(); ?>
                        </h4>

                        <hr>

                        <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

                        
                        <form action="<?=$_ENV['BASE_URL'].'viaje/ver?id='.$comentario->getId_viaje()?>" method="POST">
                            <input class="ver_viaje" type="submit" value="ver <?php echo($comentario->getNombre_viaje());?>">
                        </form>
                    </section>

                <?php endforeach; ?>

            </section>

        <?php endif;?>

    </section>
    
<?php require_once('views/layout/footer_main.php'); ?>
