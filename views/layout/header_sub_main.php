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
