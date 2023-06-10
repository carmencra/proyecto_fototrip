<head>
    <!-- añadimos el icono de la pestaña -->
    <link rel="icon" href="../fuente/media/images/logo.png" alt="logo fototrip">

    <!-- añadimos los estilos y scripts -->
    <link rel="stylesheet" href="../fuente/styles/fototrip.css">

     <!-- margen main con video -->
     <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="../fuente/scripts/responsive_video_body.js"></script>

    <!-- flecha para subir al inicio -->
    <script src="../fuente/scripts/flecha_subir.js"></script>

    <!-- menú de usuario despegable -->
    <script src="../fuente/scripts/desplegar_menu_usuario.js"></script>

    <!-- recoger el id del elemento a cambiar (borrar, editar, aceptar, descartar)  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../fuente/scripts/recoger_id_elemento_cambiar.js"></script>
    
    <!-- header despegable -->
    <script src="../fuente/scripts/header_responsive.js"></script>

</head>


<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo_header" src="../fuente/media/images/logo.png" alt="logo fototrip"/>
    </a>
    
    <nav class="menu">
        <ul>
            <li> <a href="<?=$_ENV['BASE_URL']?>">Viajes</a> </li>
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
                <img id="logo_desp" src="../fuente/media/images/logo.png" alt="logo fototrip"/>
            </a>

            <a href="" class="boton_desplegar">
                <img src="../fuente/media/images/menu.png" alt="menu"/>
            </a>
        </section>
            
       <!-- menú desplegado -->
       <ul class="lista_despegable">
            <li> <a href="<?=$_ENV['BASE_URL']?>">Viajes</a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>
            <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

            <div>
                <?php require('views/layout/menu_usuario_desplegado.php'); ?>
                
                <?php if(isset($_SESSION['usuario'])) { echo '( '. $_SESSION['usuario']. ' )' ; }?>  
            </div>
        </ul>
    </nav>    
    
</header>
