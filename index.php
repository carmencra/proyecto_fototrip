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

<?php
    //RUTAS

// RUTAS VIAJE
    // //ruta por defecto(listar viajes)
    Router::add('GET', '/', function(){
        (new ViajeController())->listar();
    });


    
    Router::add('GET', 'viaje/buscar', function(){
        (new ViajeController())->buscar();
    });
    Router::add('POST', 'viaje/buscar', function(){
        (new ViajeController())->buscar();
    });

    Router::add('GET', 'viaje/ver:id', function(int $viaje_id) {
        (new ViajeController())->ver($viaje_id);
    });

    

    Router::add('GET', 'opiniones', function(){
        (new ComentarioController())->listar();
    });



    Router::add('GET', 'galeria', function(){
        (new ImagenController())->listar();
    });

    Router::add('GET', 'imagen/buscar', function(){
        (new ImagenController())->buscar();
    });
    Router::add('POST', 'imagen/buscar', function(){
        (new ImagenController())->buscar();
    });

    // para acceder al formulario
    Router::add('GET', 'usuario/registro', function(){
        (new UsuarioController())->registro();
    });

    // para recoger los datos del formulario
    Router::add('POST', 'usuario/registro', function(){
        (new UsuarioController())->registro();
    });


    // para acceder al formulario
    Router::add('GET', 'usuario/login', function(){
        (new UsuarioController())->login();
    });
    // para recoger los datos del formulario
    Router::add('POST', 'usuario/login', function(){
        (new UsuarioController())->login();
    });

    Router::add('GET', 'usuario/cerrar', function(){
        (new UsuarioController())->cerrar();
    });
    
    Router::add('GET', 'usuario/confirmarcuenta/:id', function($email){
        (new UsuarioController())->confirmar_cuenta($email);
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



