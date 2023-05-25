<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu" id="menu">
        <ul>
            <li class="active"> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>

            <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>

            <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

        </ul>

    </nav> 

    <div class="menu_usuario">
        <?php if (!isset($_SESSION['usuario'])): ?>
            <button onclick="despliega_usuario()" class="boton_usuario">Iniciar sesi&oacute;n</button>
                <div id="lista_usuario" class="contenido_lista">
                    <a href="<?=$_ENV['BASE_URL']?>usuario/registro">Registrarse </a>
                    <a href="<?=$_ENV['BASE_URL']?>usuario/login">Iniciar sesi&oacute;n</a>
                </div>

        <?php else :?>
            <button onclick="despliega_usuario()" class="boton_usuario"> <?=$_SESSION['usuario']?> </button>
                <div id="lista_usuario" class="contenido_lista">
                    <a href="">Mis viajes</a>
                    <a href="<?=$_ENV['BASE_URL']?>usuario/cerrar">Cerrar sesi&oacute;n</a>
                </div>
        <?php endif;?>
    </div>
    
</header>
    

    
<section class="portada_video">
    <video src="fuente/media/videos/crimea_cortado.mp4" autoplay muted loop alt="video portada"></video>

    <section class="titulo">
        <h1>FOTO TRIP</h1>
        <h3>Viajes fotográficos</h3>

        <a href="">Saber más</a>
    </section>
</section>
    


<main id="main_index">
    <section class="buscador_viajes">
        <form action="<?=$_ENV['BASE_URL']?>viaje_buscar" method="POST" enctype="multipart/form-data">
        <section>
            <label for="pais">Pa&iacute;s: </label>
            <input type="text" name="data[pais]" id="pais" value="<?php if (isset($_POST['data']['pais']))echo $_POST['data']['pais'];?>"/>
        </section>

        <section>
            <label for="precio_min">Precio m&iacute;n: </label>
            <input type="text" name="data[precio_min]" id="min" value="<?php if (isset($_POST['data']['precio_min']))echo $_POST['data']['precio_min'];?>"/>
        </section>

        <section>
            <label for="precio_max">Precio m&aacute;x: </label>
            <input type="text" name="data[precio_max]" id="max" value="<?php if (isset($_POST['data']['precio_max']))echo $_POST['data']['precio_max'];?>"/>
        </section>

        <section>
            <label for="exigencia">Exigencia f&iacute;sica: </label>
            <input type="text" name="data[exigencia]" id="fisico" value="<?php if (isset($_POST['data']['exigencia']))echo $_POST['data']['exigencia'];?>"/>
        </section>

        <section>
            <label for="nivel">Nivel fotograf&iacute;a:  </label>
            <input type="text" name="data[nivel]" id="foto" value="<?php if (isset($_POST['data']['nivel']))echo $_POST['data']['nivel'];?>"/>
        </section>

            <input type="submit" value="Buscar" id="boton">
        </form>

    </section>


    <section class="viajes">

        <?php foreach($viajes as $viaje) : ?>
            <section class="viaje">
                <img src="fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>" width="320px" height="200px"/> <br>

                <p class="precio"><b> <?= $viaje->getPrecio(); ?> € </b></p>

                <h1 class="pais"> <?= $viaje->getPais(); ?> </h1>

                <p> <?= $viaje->getFecha_inicio(); ?> / <?= $viaje->getFecha_fin(); ?>
                    ( <?= $viaje->getDuracion(); ?> d&iacute;as )
                </p>

                <p> <?= $viaje->getDescripcion(); ?> </p>

                <form action="<?=$_ENV['BASE_URL'].'viaje/ver?id='.$viaje->getId()?>" method="POST">
                    <input class="ver_mas" type="submit" value="ver más">
                </form>
            </section>

        <?php endforeach; ?>

    </section>
