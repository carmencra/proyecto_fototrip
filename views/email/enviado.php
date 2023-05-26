
<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu" id="menu">
        <ul>
            <li> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>

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

        <fieldset>
            <br>
            <p>Se ha enviado un correo de confirmaci&oacute;n a <b><?= $_SESSION['correo_a_confirmar'] ?></b>.</p>

            <p>Puede cerrar esta pestaña. Una vez confirme su cuenta, se le abrir&aacute; una nueva con la sesi&oacute;n ya iniciada.</p>
        </fieldset> <br><br><br>
    </section>
