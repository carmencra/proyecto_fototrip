<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu" id="menu">
        <ul>
            <li> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>

            <li class="active"> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>

            <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

        </ul>

    </nav> 

    <div class="menu_usuario">
        <?php if (!isset($_SESSION['usuario'])): ?>
            <button onclick="despliega_usuario()" class="boton_usuario">Registro/inicio sesi&oacute;n</button>
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
        <section class="comentarios">

            <?php foreach($comentarios as $comentario) : ?>
                <section class="comentario">
                    <h4> <?= $comentario->getUsuario(); ?> </h4>

                    <hr>

                    <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

                    
                    <form action="<?=$_ENV['BASE_URL'].'comentario/ver_viaje&id='.$comentario->getId_viaje() ?>" method="GET">
                        <input class="ver_viaje" type="submit" value="ver viaje ".<?= $comentario->getNombre_viaje()?> >
                    </form>
                </section>

            <?php endforeach; ?>

        </section>
    </section>