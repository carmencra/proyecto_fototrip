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
    <link rel="stylesheet" href="fuente/styles/body.css">
    <link rel="stylesheet" href="fuente/styles/header.css">
    <link rel="stylesheet" href="fuente/styles/index.css">
    <link rel="stylesheet" href="fuente/styles/footer.css">

    <!-- margen main con video -->
    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="fuente/scripts/responsive_video_body.js"></script>

    <!-- flecha para subir al inicio -->
    <script src="fuente/scripts/flecha_subir.js"></script>
</head>

<body>

    <header>

        <!-- aquí 
        y en inicio, 
        pasar 
        por el .env 
        base_url -->

        <a href="">
            <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>
        </a>
        
        <nav class="menu" id="menu">
            <ul>
                <li class="active"> <a href="index.php">Inicio</a> </li>

                <!-- <li> <a href="< ?=base_url?>/opiniones">Opiniones </a> </li>

                <li> <a href="< ?=base_url?>/galeria">Galer&iacute;a </a> </li> -->

                <!-- esto llama a la función del controlador no a la vista!!! -->

                <!--   < ?=base_url? > (sin espacios) -->

                <!-- <li><a href="  (aquí lo de base url)  comentario/index">Opiniones</a></li>
                <li><a href="  (aquí lo de base url)  imagen/index">Galer&iacute;a</a></li> -->
            </ul>

        </nav> 

        <!-- <img id="usuario" src="fuente/media/images/persona.png" href="" /> -->

        <a href="" id="usuario">
            <img src="fuente/media/images/persona.png" href=""  alt="icono usuario"/>
        </a>
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

    </main>

    
    



 <?php

//RUTAS

// //ruta por defecto(listar viajes)
Router::add('GET', '/', function(){
    (new ViajeController())->listar();
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


Router::add('GET', '/login', function(){
    (new UsuarioController())->login();
});


Router::dispatch();



// //si no hay un usuario logueado, se podrá hacer el registro y el login
// if (!isset($_SESSION['usuario'])) {
//     //registrar usuario
//     Router::add('GET','usuario/register', function() {
//         (new UsuarioController())->register();
//     });
//     Router::add('POST','usuario/register', function() {
//         (new UsuarioController())->register();
//     });


//     //login usuario
//     Router::add('GET','usuario/login', function() {
//         (new UsuarioController())->login();
//     });
//     Router::add('POST', 'usuario/login', function() {
//         (new UsuarioController())->login();
//     });


//     //confirmar cuenta usuario
//     Router::add('GET', 'usuario/confirmarcuenta/:id', function($usuariotoken) {
//         (new UsuarioController())->confirmar_cuenta($usuariotoken);
//     });
// }
// //si se está logueado, se podrá ver los ponentes y cerrar sesión
// else {
//     //listar ponentes
//     Router::add('GET','ponente/listar', function() {
//         (new PonenteController())->listar();
//     });


//     //modificar datos usuario
//     Router::add('POST', 'usuario/modificar/:id', function(int $usuarioid) {
//         (new UsuarioController())->modificar($usuarioid);
//     });
//     Router::add('GET', 'usuario/modificar/:id', function(int $usuarioid) {
//         (new UsuarioController())->modificar($usuarioid);
//     });

//     Router::add('GET','usuario/modificar', function() {
//         (new UsuarioController())->modificar();
//     });
//     Router::add('POST','usuario/modificar', function() {
//         (new UsuarioController())->modificar();
//     });


//     //cerrar sesión
//     Router::add('GET','usuario/cerrar', function() {
//         (new UsuarioController())->cerrar();
//     });

//     //además, si eres admin, podrás crear y modificar ponentes
//     if (isset($_SESSION['admin'])) {
//         //crear ponente
//         Router::add('GET', 'ponente/crear', function() {
//             (new PonenteController())->crear();
//         });
//         Router::add('POST', 'ponente/crear', function() {
//             (new PonenteController())->crear();
//         });
        
        
//         //modificar ponente
//         Router::add('POST', 'ponente/modificar/:id', function(int $ponenteid) {
//             (new PonenteController())->modificar($ponenteid);
//         });
//         Router::add('GET', 'ponente/modificar/:id', function(int $ponenteid) {
//             (new PonenteController())->modificar($ponenteid);
//         });
        
//         Router::add('POST', 'ponente/modificar', function() {
//             (new PonenteController())->modificar();
//         });
//         Router::add('GET', 'ponente/modificar', function() {
//             (new PonenteController())->modificar();
//         });
        

//         //borrar ponente
//         Router::add('POST', 'ponente/delete/:id', function(int $ponenteid) {
//             (new PonenteController())->delete($ponenteid);
//         });
//     }
    
// }

// Router::dispatch(); 

?>

<!-- flecha para subir al inicio de la página -->
<a onclick="subir_inicio(); return false; "href="">
        <img src="fuente/media/images/flecha.png" id="flecha" alt="flecha para subir al inicio">
    </a>



    <footer>
        <img id="logo" src="fuente/media/images/logo.png" alt="logo fototrip"/>

        <h2>&copy; Fototrip 2023</h2>
        <p>Todos los derechos reservados</p>
        
    </footer>
    
</body>
</html>