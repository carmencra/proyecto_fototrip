
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

        <fieldset>
            <br>
            <p>Se ha enviado un correo de confirmaci&oacute;n a <b><?= $_SESSION['correo_a_confirmar'] ?></b>.</p>

            <p>Puede cerrar esta pestaña. Una vez confirme su cuenta, se le abrir&aacute; una nueva con la sesi&oacute;n ya iniciada.</p>
        </fieldset> <br><br><br>
    </section>
