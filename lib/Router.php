<?php
namespace Lib;

class Router {

    private static array $routes = [];
    //para ir añadiendo los métodos y las rutas en el tercer parámetro.

    public static function add(string $method, string $action, Callable $controller):void{
        $action = trim($action, '/');
       
        self::$routes[$method][$action] = $controller;
    }
   
    public static function dispatch():void {
        $method = $_SERVER['REQUEST_METHOD']; 

        $action = preg_replace("/\/fototrip\//",'',$_SERVER['REQUEST_URI']);
       //$_SERVER['REQUEST_URI'] almacena la cadena de texto que hay después del nombre del host en la URL
        $action = trim($action, '/');


        $param = null;
        $p= preg_match('/[0-9]+$/', $action, $match);

       
        if(!empty($match)){
            
            $param = $match[0];

            $action=preg_replace('/'.$match[0].'/',':id',$action);//quitamos la primera parte que se repite siempre (fototrip)
        }

          $fn = self::$routes[$method][$action] ?? null;

        if($fn) {
            $callback = self::$routes[$method][$action];

            echo call_user_func($callback, $param);
        }
        else {
            echo ResponseHttp::statusMessage(404,'Pagina no encontrada');
          
        }
    }

}

?>
