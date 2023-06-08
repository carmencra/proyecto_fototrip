<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo_header" src="fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu">
        <ul>
            <li> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>
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
            <div class="usuario_activo"> <?php if(isset($_SESSION['usuario'])){ echo '( '. $_SESSION['usuario'].' )'; } ?>  </div>
            <li> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

            <div>
                <?php require('views/layout/menu_usuario_desplegado.php'); ?>
            </div>
        </ul>
    </nav>    
    
</header>