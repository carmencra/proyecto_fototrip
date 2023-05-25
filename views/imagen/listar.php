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



<main>
    <section class="contenido_main">

        <section class="buscador_imagenes">
            <form action="<?=$_ENV['BASE_URL']?>imagen_buscar" method="POST" enctype="multipart/form-data">

            <section>
                <label for="pais">Pa&iacute;s </label>
                <input type="text" name="data[pais]" id="pais" value="<?php if (isset($_POST['data']['pais']))echo $_POST['data']['pais'];?>"/>
            </section>

            <section>
                <label for="tipo">Tipo: </label>

                <select name="data[tipo]" value="<?php if (isset($_SESSION['data']['tipo']))echo $_SESSION['data']['tipo'];?>">
                    <option value="indiferente"> Indiferente </option>
                    <option value="naturaleza"> Naturaleza </option>
                    <option value="construcciones"> Construcciones </option>
                    <option value="animales"> Animales </option>
                    <option value="personas"> Personas </option>
                </select>
            </section>
                
            <section>
                <label for="fecha">Fecha </label>
            
                <select name="data[fecha]" value="<?php if (isset($_SESSION['data']['fecha']))echo $_SESSION['data']['fecha'];?>">
                    <option value="indiferente"> Indiferente </option>
                    <option value="recientes"> M&aacute;s recientes </option>
                    <option value="antiguas"> M&aacute;s antiguas </option>
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
