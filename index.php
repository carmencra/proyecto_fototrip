<?php

require_once __DIR__.'/vendor/autoload.php';

use Controllers\ViajeController;
use Controllers\ComentarioController;
use Controllers\ImagenController;
use Controllers\UsuarioController;
use Lib\Router;
use Dotenv\Dotenv;


$dotenv= Dotenv::createImmutable(__DIR__); //para acceder al .env
$dotenv->safeLoad();


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

    <!-- recoger el id del elemento a cambiar (borrar, editar, aceptar, descartar)  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../fuente/scripts/recoger_id_elemento_cambiar.js"></script>


</head>

<body>

    <?php

    // creamos los controladores para llamarlos en las rutas y no crear uno en cada una (optimizando memoria)
        $viaje_controller= new ViajeController();
        $comentario_controller= new ComentarioController();
        $imagen_controller= new ImagenController();
        $usuario_controller= new UsuarioController();
        

        //RUTAS

    // RUTAS VIAJE
        //ruta por defecto(listar viajes)
        Router::add('GET', '/', function() use ($viaje_controller){
            ($viaje_controller)->listar();
        });

        // rutas accesibles para todos
        Router::add('GET', 'viaje_buscar', function() use ($viaje_controller){
            ($viaje_controller)->buscar();
        });
        Router::add('POST', 'viaje_buscar', function()use ($viaje_controller){
            ($viaje_controller)->buscar();
        });

        // ver los viajes, reccogiendo el id y llevando a la vista
        Router::add('POST', 'viaje/ver?id=:id', function($id) use ($viaje_controller){
            ($viaje_controller)->ver($id);
            
        }); 
        Router::add('GET', 'viaje/ver?id=:id', function($id) use ($viaje_controller){
            ($viaje_controller)->ver($id);
        }); 


        Router::add('GET', 'opiniones', function() use ($comentario_controller){
            ($comentario_controller)->listar();
        });


        Router::add('GET', 'galeria', function() use ($imagen_controller){
            ($imagen_controller)->listar();
        });

        Router::add('GET', 'imagen_buscar', function() use ($imagen_controller){
            ($imagen_controller)->buscar();
        });
        Router::add('POST', 'imagen_buscar', function() use ($imagen_controller){
            ($imagen_controller)->buscar();
        });



        // rutas accesibles para los usuarios logueados
        if (isset($_SESSION['usuario'])) {
            Router::add('GET', 'usuario/cerrar', function() use ($usuario_controller){
                ($usuario_controller)->cerrar();
            });
            
            // rutas del administrador
            if (isset($_SESSION['admin'])) {
                Router::add('GET', 'administrar', function() use ($usuario_controller){
                    ($usuario_controller)->administrar();
                });

                Router::add('GET', 'viaje/crear', function() use ($viaje_controller){
                    ($viaje_controller)->crear();
                });
                Router::add('GET', 'administrar/viaje', function() use ($viaje_controller){
                    ($viaje_controller)->mostrar();
                });
                Router::add('POST', 'viaje/borrar', function() use ($viaje_controller){
                    ($viaje_controller)->borrar();
                });

                // para llevar al formulario
                Router::add('GET', 'imagen/crear', function() use ($imagen_controller){
                    ($imagen_controller)->crear();
                }); 
                // para recoger los datos del formulario
                Router::add('POST', 'imagen/guardar', function() use ($imagen_controller){
                    ($imagen_controller)->guardar();
                });
                Router::add('GET', 'administrar/imagen', function() use ($imagen_controller){
                    ($imagen_controller)->mostrar();
                });
                Router::add('GET', 'seleccionar/imagenes', function() use ($imagen_controller){
                    ($imagen_controller)->listar_para_aceptar();
                });
                Router::add('POST', 'imagen/aceptar', function() use ($imagen_controller){
                    ($imagen_controller)->aceptar();
                });
                Router::add('POST', 'imagen/descartar', function() use ($imagen_controller){
                    ($imagen_controller)->descartar();
                });
                Router::add('POST', 'imagen/borrar', function() use ($imagen_controller){
                    ($imagen_controller)->borrar();
                });

                
                Router::add('GET', 'administrar/comentario', function() use ($comentario_controller){
                    ($comentario_controller)->mostrar();
                });  
                Router::add('GET', 'seleccionar/comentarios', function() use ($comentario_controller){
                    ($comentario_controller)->listar_para_aceptar();
                });
                Router::add('POST', 'comentario/aceptar', function() use ($comentario_controller){
                    ($comentario_controller)->aceptar();
                });
                Router::add('POST', 'comentario/descartar', function() use ($comentario_controller){
                    ($comentario_controller)->descartar();
                });
                Router::add('POST', 'comentario/borrar', function() use ($comentario_controller){
                    ($comentario_controller)->borrar();
                });             
            }

            else {
                // los usuarios que no sean admin, podrán inscribirse a viajes
                Router::add('POST', 'viaje/inscribirse', function() {
                    ($viaje_controller)->inscribirse();
                }); 
            }

        }

        else {
            // si no hay un usuario registrado, podrá acceder al registro

            // para acceder a los formularios
            Router::add('GET', 'usuario/registrarse', function() use ($usuario_controller){
                ($usuario_controller)->registrarse();
            });
            // para recoger los datos de los  formularios
            Router::add('POST', 'usuario/registro', function() use ($usuario_controller){
                ($usuario_controller)->registro();
            });
            Router::add('POST', 'usuario/login', function() use ($usuario_controller){
                ($usuario_controller)->login();
            });
        }
        
    
    
        // ruta accesible solo cuando el usuario esté pendiente de confirmar su cuenta
        if (isset($_SESSION['id_a_confirmar'])) {
            Router::add('GET', 'usuario/confirmarcuenta?id=:id', function($id) use($usuario_controller) {
                if ($id == $_SESSION['id_a_confirmar']){
                    ($usuario_controller)->confirmar_cuenta($id);
                }
            });

            Router::add('GET', 'email_enviado', function() use ($usuario_controller){
                ($usuario_controller)->llevar_email_enviado();
            });
        }

        Router::dispatch();
    ?>

    
</body>
</html>
