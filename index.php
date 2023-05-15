<?php
// si quitas este autoloader no reconoce Lib\Router
// pero creo que así no cge el .env (y era necesario para subir la bd creo)
//para coger el env es con lo del DOTENV
// require_once "autoloader.php";
// require_once './config/config.php';

require_once __DIR__.'/vendor/autoload.php';

use Controllers\ViajeController;
use Controllers\ComentarioController;
use Controllers\ImagenController;
use Controllers\UsuarioController;
use Lib\Router;
use Dotenv\Dotenv;

$dotenv= Dotenv::createImmutable(__DIR__); //para acceder al .env
$dotenv-> safeLoad();


session_start();


//header
// require_once('views/layout/header.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    
    <link rel="icon" href="fuente/media/images/logo.png" alt="logo fototrip">

    <!-- estilos -->
    <link rel="stylesheet" href="fuente/styles/fototrip.css">
    
    <!-- margen main con video -->
    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="fuente/scripts/responsive_video_body.js"></script>

    <!-- flecha para subir al inicio -->
    <script src="fuente/scripts/flecha_subir.js"></script>

    <!-- menú de usuario despegable -->
    <script src="fuente/scripts/desplegar_menu_usuario.js"></script>

</head>

<body>

    <header>
        <a href="<?=$_ENV['BASE_URL']?>">
            <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>
        </a>
        
        <nav class="menu" id="menu">
            <ul>
                <li class="active"> <a href="<?=$_ENV['BASE_URL']?>">Inicio</a> </li>

                <li> <a href="<?=$_ENV['BASE_URL']?>opiniones">Opiniones </a> </li>

                <li> <a href="<?=$_ENV['BASE_URL']?>galeria">Galer&iacute;a </a> </li>

            </ul>

        </nav> 

        <!-- <img id="usuario" src="fuente/media/images/persona.png" href="" /> -->

        <!-- <a href="" id="usuario">
            <img src="fuente/media/images/persona.png" href=""  alt="icono usuario"/>
        </a> -->

        <!-- <button onclick="despliega_usuario()" class="boton_usuario">
            <img src="fuente/media/images/persona.png" href=""  alt="icono usuario" width="45px"/>
        </button>
        <div id="menu_usuario" class="contenido_usuario">
            <a href="">1</a>
            <a href="">2</a>
            <a href="">3</a>
        </div> -->

        <div class="menu_usuario">
            <?php if (!isset($_SESSION['usuario'])): ?>
                <button onclick="despliega_usuario()" class="boton_usuario">Registro/iniciar sesi&oacute;n</button>
                    <div id="lista_usuario" class="contenido_lista">
                        <a href="<?=$_ENV['BASE_URL']?>usuario/registro">Registrarse </a>
                        <a href="<?=$_ENV['BASE_URL']?>usuario/login">Iniciar sesi&oacute;n</a>
                    </div>

            <?php else :?>
                <button onclick="despliega_usuario()" class="boton_usuario"> Usuario: nombre* <!--< ?=$_SESSION['usuario']?>--> </button>
                    <div id="lista_usuario" class="contenido_lista">
                        <a href="">Mis viajes</a>
                        <a href="">Cerrar sesi&oacute;n</a>
                    </div>
            <?php endif;?>
        </div>

        <!-- <div class="dropdown">
            <button onclick="myFunction()" class="drop-button">Dropdown</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="#">Link 1</a>
                <a href="#">Link 2</a>
                <a href="#">Link 3</a>
            </div>
        </div> -->
        
    </header>


    <section class="portada_video">
        <video src="fuente/media/videos/crimea_cortado.mp4" autoplay muted loop alt="video portada"></video>

        <section class="titulo">
            <h1>FOTO TRIP</h1>
            <h3>Viajes fotográficos</h3>

            <a href="">Saber más</a>
        </section>
    </section>
    


    <main>
        <p>bla bla bla </p> <br>

        
        <br><br><br><br>

       


<?php
    //RUTAS

// RUTAS VIAJE
    // //ruta por defecto(listar viajes)
    Router::add('GET', '/', function(){
        (new ViajeController())->listar();
    });


    
    Router::add('GET', '/viaje/buscar', function(){
        (new ViajeController())->buscar();
    });
    Router::add('POST', '/viaje/buscar', function(){
        (new ViajeController())->buscar();
    });

    Router::add('GET', '/viaje/ver:id', function(int $viaje_id) {
        (new ViajeController())->ver($viaje_id);
    });

    

    Router::add('GET', '/opiniones', function(){
        (new ComentarioController())->listar();
    });

    Router::add('GET', '/galeria', function(){
        (new ImagenController())->listar();
    });

    // para acceder al formulario
    Router::add('GET', '/usuario/registro', function(){
        (new UsuarioController())->registro();
    });

    // para recoger los datos del formulario
    Router::add('POST', '/usuario/registro', function(){
        (new UsuarioController())->registro();
    });


    // para acceder al formulario
    Router::add('GET', '/usuario/login', function(){
        (new UsuarioController())->login();
    });
    // para recoger los datos del formulario
    Router::add('POST', '/usuario/login', function(){
        (new UsuarioController())->login();
    });


    Router::dispatch();
?>

    

    <!-- flecha para subir al inicio de la página -->
    <a onclick="subir_inicio(); return false; "href="">
        <img src="fuente/media/images/flecha.png" id="flecha" alt="flecha para subir al inicio">
    </a>


    </main>

    <footer>
        <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>

        <h2>&copy; Fototrip 2023</h2>
        <p>Todos los derechos reservados</p>
        
    </footer>
    
</body>
</html>



