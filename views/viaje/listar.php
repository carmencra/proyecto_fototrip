<title>Fototrip - Inicio</title>

<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo_header" src="fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu">
        <ul>
            <li class="active"> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>
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
        <ul class="lista_despegable">
            <li class="active"> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

            <div>
                <?php require('views/layout/menu_usuario_desplegado.php'); ?>
                
                <?php if(isset($_SESSION['usuario'])) { echo '( '. $_SESSION['usuario']. ' )' ; }?>  
            </div>

        </ul>
    </nav>    
    
</header>
  

<section class="portada" style="background-image:url('fuente/media/images/portada.jpg')">
    <section>
        <h1 class="titulo_portada">FOTO TRIP</h1>
        <h3>Viajes fotográficos</h3>
    </section>
</section>


<main>

    <section class="buscador_viajes">
        <?php
            // recogemos si hay alguna cookie de filtros existente
            if (isset($_COOKIE['data_exigencia'])) {
                $opcion_exigencia= $_COOKIE['data_exigencia'];
            }
            else {
                $opcion_exigencia = ""; 
                // Valor predeterminado si no hay cookie
            } 
            if (isset($_COOKIE['data_nivel'])) {
                $opcion_nivel= $_COOKIE['data_nivel'];
            }
            else {
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
            <input type="number" name="data[precio_min]" id="min" value="<?php if (isset($_POST['data']['precio_min']))echo $_POST['data']['precio_min'];?>" min="1" oninput="this.value= !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null"/> €
        </section>

        <section>
            <label for="precio_max">Precio m&aacute;x: </label>
            <input type="number" name="data[precio_max]" id="max" value="<?php if (isset($_POST['data']['precio_max']))echo $_POST['data']['precio_max'];?>" min="1" oninput="this.value= !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null"> €
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

            <input type="submit" value="Buscar" id="boton" class="boton_resaltar">
        </form>

    </section>

    <?php 
        if(empty($viajes_activos)):
            echo "<h4>No hay viajes.</h4>" ;
        else :?>

        <section class="viajes">

            <?php foreach($viajes_activos as $viaje) : ?>
                <section class="viaje">
                    <img src="fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>"class="img_viaje"/> <br>

                    <p class="precio"><b> <?= $viaje->getPrecio(); ?> € </b></p>

                    <h1 class="pais"> <?= $viaje->getPais(); ?> </h1>

                    <p> <?= $viaje->getFecha_inicio(); ?> / <?= $viaje->getFecha_fin(); ?>
                        ( <?= $viaje->getDuracion(); ?> d&iacute;as )
                    </p>

                    <p> <?= $viaje->getDescripcion(); ?> </p>

                    <form action="<?=$_ENV['BASE_URL'].'detalle_viaje/'.$viaje->getId()?>" method="POST">
                        <input type="submit" value="Ver más" class="ver_mas boton_resaltar">
                    </form>

                </section>

            <?php endforeach; ?>

        </section>

    <?php endif; ?>

    <?php if(!empty($viajes_no_activos)): ?>
        <h2 id="otros_viajes">Otros viajes realizados: <br> <hr> </h2>  

        <section class="viajes">

            <?php foreach($viajes_no_activos as $viaje) : ?>
                <section class="viaje">
                    <img src="fuente/media/images/galeria/<?= $viaje->getImagen_principal(); ?>"class="img_viaje"/> <br>

                    <p class="precio"><b> <?= $viaje->getPrecio(); ?> € </b></p>

                    <h1 class="pais"> <?= $viaje->getPais(); ?> </h1>

                    <p> <?= $viaje->getFecha_inicio(); ?> / <?= $viaje->getFecha_fin(); ?>
                        ( <?= $viaje->getDuracion(); ?> d&iacute;as )
                    </p>

                    <p> <?= $viaje->getDescripcion(); ?> </p>

                    <form action="<?=$_ENV['BASE_URL'].'detalle_viaje/'.$viaje->getId()?>" method="POST">
                        <input type="submit" value="Ver más" class="ver_mas boton_resaltar">
                    </form>

                </section>

            <?php endforeach; ?>

            </section>
    
    <?php endif; ?>

    <?php require_once('views/layout/footer_main.php'); ?>
