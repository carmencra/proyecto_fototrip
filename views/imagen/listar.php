<title>Fototrip - Galería</title>

<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu" id="menu">
        <ul>
            <li> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>

            <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>

            <li class="active"> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

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
                        <a href="">Administrar</a>
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



<main>
    <section class="contenido_main">

        <section class="buscador_imagenes">
            <?php
                // guardamos los valores de filtros en las cookies
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $opcion_tipo = $_POST['data']['tipo'];
                    setcookie("data_tipo", $opcion_tipo);
                    
                    $opcion_fecha = $_POST['data']['fecha'];
                    setcookie("data_fecha", $opcion_fecha);
                }

                // recogemos si hay alguna cookie de filtros existente
                if (isset($_COOKIE['data_tipo'])) {
                    $opcion_tipo= $_COOKIE['data_tipo'];
                } else {
                    $opcion_tipo = ""; 
                    // Valor predeterminado si no hay cookie
                } 
                if (isset($_COOKIE['data_fecha'])) {
                    $opcion_fecha= $_COOKIE['data_fecha'];
                } else {
                    $opcion_fecha = ""; 
                    // Valor predeterminado si no hay cookie
                }
                
                
            ?>
            <form action="<?=$_ENV['BASE_URL']?>imagen_buscar" method="POST" enctype="multipart/form-data">

            <section>
                <label for="pais">Pa&iacute;s </label>
                <input type="text" name="data[pais]" id="pais" value="<?php if (isset($_POST['data']['pais']))echo $_POST['data']['pais'];?>"/>
            </section>

            <section>
                <label for="tipo">Tipo: </label>

                <select name="data[tipo]">
                    <option value="indiferente" <?php if ($opcion_tipo == "indiferente") echo "selected"; ?>> Indiferente </option>
                    <option value="naturaleza" <?php if ($opcion_tipo == "naturaleza") echo "selected"; ?>> Naturaleza </option>
                    <option value="construcciones" <?php if ($opcion_tipo == "construcciones") echo "selected"; ?>> Construcciones </option>
                    <option value="animales" <?php if ($opcion_tipo == "animales") echo "selected"; ?>> Animales </option>
                    <option value="personas" <?php if ($opcion_tipo == "personas") echo "selected"; ?>> Personas </option>
                </select>
            </section>
                
            <section>
                <label for="fecha">Fecha </label>
            
                <select name="data[fecha]" value="<?php if (isset($_COOKIE['data']['fecha']))echo $_COOKIE['data']['fecha'];?>">
                    <option value="indiferente" <?php if ($opcion_fecha == "indiferente") echo "selected"; ?>> Indiferente </option>
                    <option value="recientes" <?php if ($opcion_fecha == "recientes") echo "selected"; ?>> M&aacute;s recientes </option>
                    <option value="antiguas" <?php if ($opcion_fecha == "antiguas") echo "selected"; ?>> M&aacute;s antiguas </option>
                </select>
            </section>

                <input type="submit" value="Buscar" id="boton">
            </form>

        </section>


        <section class="imagenes">

            <?php foreach($imagenes as $imagen) : ?>
                <section class="imagen">
                    <h4> <?= $imagen->getUsuario(); ?> </h4>

                    <hr> <br>

                    <img src="fuente/media/images/galeria/<?= $imagen->getImagen(); ?>" width="380px" height="260px"/> <br><br>

                    <section class="datos_imagen">
                        <section> 
                            <img src="fuente/media/images/ubicacion.png" />
                            <?= $imagen->getPais_viaje(); ?> 
                        </section>
                        
                        <section> 
                            <img src="fuente/media/images/calendario.png" />
                            <?= $imagen->getFecha(); ?> 
                        </section>
                        
                        <section> 
                            <img src="fuente/media/images/imagen.png" />
                            <?= $imagen->getTipo(); ?> 
                        </section>
                    </section>
                    
                </section>

            <?php endforeach; ?>

        </section>
    </section>
    
    <?php require_once('views/layout/footer_main.php'); ?>
