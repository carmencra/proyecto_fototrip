<head>
    <!-- añadimos los estilos y scripts -->
    <link rel="stylesheet" href="../fuente/styles/fototrip.css">

     <!-- margen main con video -->
     <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="../fuente/scripts/responsive_video_body.js"></script>

    <!-- flecha para subir al inicio -->
    <script src="../fuente/scripts/flecha_subir.js"></script>

    <!-- menú de usuario despegable -->
    <script src="../fuente/scripts/desplegar_menu_usuario.js"></script>
</head>


<header>
    <a href="<?=$_ENV['BASE_URL']?>">
        <img id="logo" src="../fuente/media/images/logo.png" alt="logo fototrip"/>
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
