
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
        <!--  si no hay usuario, muestra el registro -->
        <?php if (!isset($_SESSION['usuario'])): ?>
            <button class="boton_usuario">
                <a href="<?=$_ENV['BASE_URL']?>usuario/registrarse">Registro</a>
            </button>
            


        <?php elseif (isset($_SESSION['usuario'])) :
            // si es el admin, muestra la pantalla de administrar
            if (isset($_SESSION['admin'])): ?>
                <button onclick="despliega_usuario()" class="boton_usuario"> <?=$_SESSION['usuario']?> </button>
                    <div id="lista_usuario" class="contenido_lista">
                        <a href="<?=$_ENV['BASE_URL']?>admin/administrar">Administrar</a>
                        <a href="<?=$_ENV['BASE_URL']?>usuario/cerrar">Salir</a>
                    </div>
            <!-- si es un usuario normal, muestra ver sus viajes y cerrar sesión -->
            <?php else :?>
                <button onclick="despliega_usuario()" class="boton_usuario"> <?=$_SESSION['usuario']?> </button>
                    <div id="lista_usuario" class="contenido_lista">
                        <a href="">Mis viajes</a>
                        <a href="<?=$_ENV['BASE_URL']?>usuario/cerrar">Salir</a>
                    </div>
            <?php endif;?>
        <?php endif;?>
    </div>
    
</header>
  
<!-- <section class="portada_video">
    <video src="fuente/media/videos/crimea_cortado.mp4" autoplay muted loop alt="video portada"></video>

    <section class="titulo">
        <h1>FOTO TRIP</h1>
        <h3>Viajes fotográficos</h3>

        <a href="">Saber más</a>
    </section>
</section> -->
    


<section class="portada" style="background-image:url('fuente/media/images/portada.jpg')">
    <section>
        <h1 class="titulo_portada">FOTO TRIP</h1>
        <h3>Viajes fotográficos</h3>

        <a href="">Saber más</a>
    </section>
</section>


<main>

    <section class="buscador_viajes">
            <?php
                // recogemos si hay alguna cookie de filtros existente
                if (isset($_COOKIE['data_exigencia'])) {
                    $opcion_exigencia= $_COOKIE['data_exigencia'];
                } else {
                    $opcion_exigencia = ""; 
                    // Valor predeterminado si no hay cookie
                } 
                if (isset($_COOKIE['data_nivel'])) {
                    $opcion_nivel= $_COOKIE['data_nivel'];
                } else {
                    $opcion_nivel = ""; 
                    // Valor predeterminado si no hay cookie
                }
                
                // guardamos los valores de filtros en las cookies
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $opcion_exigencia = $_POST['data']['exigencia'];
                    setcookie("data_exigencia", $opcion_exigencia);
                    
                    $opcion_nivel = $_POST['data']['nivel'];
                    setcookie("data_nivel", $opcion_nivel);
                }
            ?>
        <form action="<?=$_ENV['BASE_URL']?>viaje_buscar" method="POST" enctype="multipart/form-data">
        <section>
            <label for="pais">Pa&iacute;s: </label>
            <input type="text" name="data[pais]" id="pais" value="<?php if (isset($_POST['data']['pais']))echo $_POST['data']['pais'];?>"/>
        </section>

        <section>
            <label for="precio_min">Precio m&iacute;n: </label>
            <input type="text" name="data[precio_min]" id="min" value="<?php if (isset($_POST['data']['precio_min']))echo $_POST['data']['precio_min'];?>"/> €
        </section>

        <section>
            <label for="precio_max">Precio m&aacute;x: </label>
            <input type="text" name="data[precio_max]" id="max" value="<?php if (isset($_POST['data']['precio_max']))echo $_POST['data']['precio_max'];?>"/> €
        </section>

        <section>
            <label for="exigencia">Exigencia f&iacute;sica: </label>
            <select name="data[exigencia]">
                <option value="indiferente" <?php if ($opcion_exigencia == "indiferente") echo "selected"; ?>> Indiferente </option>
                <option value="muy_facil" <?php if ($opcion_exigencia == "muy_facil") echo "selected"; ?>> Muy f&aacute;cil </option>
                <option value="novato" <?php if ($opcion_exigencia == "novato") echo "selected"; ?>> Novato </option>
                <option value="medio" <?php if ($opcion_exigencia == "medio") echo "selected"; ?>> Medio </option>
                <option value="alto" <?php if ($opcion_exigencia == "alto") echo "selected"; ?>> Alto </option>
                <option value="experto" <?php if ($opcion_exigencia == "experto") echo "selected"; ?>> Experto </option>
            </select>
        </section>

        <section>
            <label for="nivel">Nivel fotograf&iacute;a:  </label>
            <select name="data[nivel]">
                <option value="indiferente" <?php if ($opcion_nivel == "indiferente") echo "selected"; ?>> Indiferente </option>
                <option value="muy_facil" <?php if ($opcion_nivel == "muy_facil") echo "selected"; ?>> Muy f&aacute;cil </option>
                <option value="novato" <?php if ($opcion_nivel == "novato") echo "selected"; ?>> Novato </option>
                <option value="medio" <?php if ($opcion_nivel == "medio") echo "selected"; ?>> Medio </option>
                <option value="alto" <?php if ($opcion_nivel == "alto") echo "selected"; ?>> Alto </option>
                <option value="experto" <?php if ($opcion_nivel == "experto") echo "selected"; ?>> Experto </option>
            </select>
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
    
    <?php require_once('views/layout/footer_main.php'); ?>
