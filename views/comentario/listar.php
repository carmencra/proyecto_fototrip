<title>Fototrip - Opiniones</title>

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
        <section class="comentarios">

            <?php foreach($comentarios as $comentario) : ?>
                <section class="comentario">
                    <h4> <?= $comentario->getUsuario(); ?> </h4>

                    <hr>

                    <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

                    
                    <form action="<?=$_ENV['BASE_URL'].'viaje/ver?id='.$comentario->getId_viaje()?>" method="POST">
                        <input class="ver_viaje" type="submit" value="ver <?php echo($comentario->getNombre_viaje());?>">
                    </form>
                </section>

            <?php endforeach; ?>

        </section>
    </section>
    
<?php require_once('views/layout/footer_main.php'); ?>
