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
use Controllers\AdminController;
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
        //ruta por defecto(listar viajes)
        Router::add('GET', '/', function(){
            (new ViajeController())->listar();
        });



        // rutas accesibles para todos
        Router::add('GET', 'viaje_buscar', function(){
            (new ViajeController())->buscar();
        });
        Router::add('POST', 'viaje_buscar', function(){
            (new ViajeController())->buscar();
        });

        // ver los viajes, reccogiendo el id y llevando a la vista
        Router::add('POST', 'viaje/ver?id=:id', function($id) {
            (new ViajeController())->ver($id);
            
        }); 
        Router::add('GET', 'viaje/ver?id=:id', function($id) {
            (new ViajeController())->ver($id);
        }); 


        Router::add('GET', 'opiniones', function(){
            (new ComentarioController())->listar();
        });


        Router::add('GET', 'galeria', function(){
            (new ImagenController())->listar();
        });

        Router::add('GET', 'imagen_buscar', function(){
            (new ImagenController())->buscar();
        });
        Router::add('POST', 'imagen_buscar', function(){
            (new ImagenController())->buscar();
        });



        // rutas accesibles para los usuarios logueados
        if (isset($_SESSION['usuario'])) {
            Router::add('GET', 'usuario/cerrar', function(){
                (new UsuarioController())->cerrar();
            });
            
            // rutas del administrador
            if (isset($_SESSION['admin'])) {
                Router::add('GET', 'administrar', function(){
                    (new UsuarioController())->administrar();
                });

                Router::add('GET', 'viaje/crear', function(){
                    (new ViajeController())->crear();
                });
                Router::add('GET', 'administrar/viaje', function(){
                    (new ViajeController())->mostrar();
                });
                // Router::add('GET', 'viaje/borrar?id=:id', function($id){
                //     var_dump($_SESSION['viaje_a_borrar'], $_GET['id']);die();
                //     (new ViajeController())->borrar($id);
                // });
                Router::add('POST', 'viaje/borrar', function(){
                    (new ViajeController())->borrar();
                });


                Router::add('GET', 'imagen/crear', function(){
                    (new ImagenController())->crear();
                });
                Router::add('GET', 'administrar/imagen', function(){
                    (new ImagenController())->mostrar();
                });
                Router::add('GET', 'seleccionar/imagenes', function(){
                    (new ImagenController())->listar_para_aceptar();
                });
                Router::add('POST', 'imagen/aceptar', function(){
                    (new ImagenController())->aceptar();
                });
                Router::add('POST', 'imagen/descartar', function(){
                    (new ImagenController())->descartar();
                });
                Router::add('POST', 'imagen/borrar', function(){
                    (new ImagenController())->borrar();
                });

                
                Router::add('GET', 'administrar/comentario', function(){
                    (new ComentarioController())->mostrar();
                });  
                Router::add('GET', 'seleccionar/comentarios', function(){
                    (new ComentarioController())->listar_para_aceptar();
                });
                Router::add('POST', 'comentario/aceptar', function(){
                    (new ComentarioController())->aceptar();
                });
                Router::add('POST', 'comentario/descartar', function(){
                    (new ComentarioController())->descartar();
                });
                Router::add('POST', 'comentario/borrar', function(){
                    (new ComentarioController())->borrar();
                });             
            }

            else {
                // los usuarios que no sean admin, podrán inscribirse a viajes
                Router::add('POST', 'viaje/inscribirse', function() {
                    (new ViajeController())->inscribirse();
                }); 
            }

        }

        else {
            // si no hay un usuario registrado, podrá acceder al registro

            // para acceder a los formularios
            Router::add('GET', 'usuario/registrarse', function(){
                (new UsuarioController())->registrarse();
            });
            // para recoger los datos de los  formularios
            Router::add('POST', 'usuario/registro', function(){
                (new UsuarioController())->registro();
            });
            Router::add('POST', 'usuario/login', function(){
                (new UsuarioController())->login();
            });
        }
        
    
    
        // ruta accesible solo cuando el usuario esté pendiente de confirmar su cuenta
        if (isset($_SESSION['id_a_confirmar'])) {
            Router::add('GET', 'usuario/confirmarcuenta?id=:id', function($id) {
                if ($id == $_SESSION['id_a_confirmar']){
                    (new UsuarioController())->confirmar_cuenta($id);
                }
            });

            Router::add('GET', 'email_enviado', function(){
                (new UsuarioController())->llevar_email_enviado();
            });
        }

        Router::dispatch();
    ?>

    
</body>
</html>
