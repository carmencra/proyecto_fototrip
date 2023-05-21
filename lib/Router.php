<?php
namespace Lib;
// para almacenar las rutas que configuremos desde el archivo indexold.php
// use Controllers\PaginasController;

class Router {

    private static array $routes = [];
    //para ir añadiendo los métodos y las rutas en el tercer parámetro.

    public static function add(string $method, string $action, Callable $controller):void{
        $action = trim($action, '/');
       
        self::$routes[$method][$action] = $controller;
    }
   
    // Este método se encarga de obtener el sufijo de la URL que permitirá seleccionar
    // la ruta y mostrar el resultado de ejecutar la función pasada al metodo add para esa ruta
    // usando call_user_func()

// una que coge parámetros
    // public static function add(string $method, string $action, Callable $controller): void {
    //     $action = trim($action, '/');
        
    //     // Verifica si la ruta tiene parámetros
    //     if (strpos($action, '{') !== false) {
    //         // Reemplaza los parámetros en la ruta por su formato correspondiente
    //         $action = preg_replace('/\{(\w+)\}/', ':$1', $action);
    //     }
    
    //     self::$routes[$method][$action] = $controller;
    // }
    

// una que coge parámetros
    // public static function dispatch():void {
    //     $method = $_SERVER['REQUEST_METHOD']; 
    //     $action = preg_replace("/\/fototrip\//",'',$_SERVER['REQUEST_URI']);
    //     $action = trim($action, '/');
    
    //     $param = null;
    //     $matches = [];
    //     // Busca el valor del parámetro en la URL utilizando la expresión regular
    //     if (preg_match_all('/\{(\w+)\}/', $action, $matches)) {
    //         $param = $_GET[$matches[1][0]] ?? null;
    //         // Remueve el parámetro de la URL antes de buscar la ruta
    //         $action = preg_replace('/\/\{(\w+)\}/', '', $action);
    //     }
    
    //     $fn = self::$routes[$method][$action] ?? null;
    
    //     if(!$fn && !$param) {
    //         // Si no se encontró ninguna ruta con parámetros y no se pasó ningún parámetro,
    //         // intenta buscar una ruta sin parámetros
    //         $fn = self::$routes[$method][$action] ?? null;
    //     }
    
    //     if($fn) {
    //         $callback = self::$routes[$method][$action];
    //         // Pasa el parámetro al callback junto con la función del controlador
    //         echo call_user_func($callback, $param);
    //     }
    //     else {
    //         echo ResponseHttp::statusMessage(404,'Pagina no encontrada');
    //     }
    // }
    
    public static function dispatch():void {
        $method = $_SERVER['REQUEST_METHOD']; 

        //$action = preg_replace("/\/proyectocursos\//",'',$_SERVER['REQUEST_URI']); 
        $action = preg_replace("/\/fototrip\//",'',$_SERVER['REQUEST_URI']);
       //$_SERVER['REQUEST_URI'] almacena la cadena de texto que hay después del nombre del host en la URL
        $action = trim($action, '/');


        $param = null;
        $p= preg_match('/[0-9]+$/', $action, $match);

       
        if(!empty($match)){
            
            $param = $match[0];

            $action=preg_replace('/'.$match[0].'/',':id',$action);//quitamos la primera parte que se repite siempre (clinicarouter)
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
