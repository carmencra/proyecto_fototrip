<?php

namespace Controllers;
use Repositories\ViajeRepository;
use Lib\Pages;
use Lib\Email;
use Controllers\GastosController;
use Controllers\ImagenController;
use Controllers\ComentarioController;
use Utils\Utils;

class ViajeController {
    private Pages $pages;
    private ViajeRepository $repository;
    private GastosController $gastos_controller;
    private ImagenController $imagen_controller;
    private ComentarioController $comentario_controller;

    public function __construct($db) {
        $this->pages= new Pages();
        $this->repository= new ViajeRepository($db);
        $this->gastos_controller= new GastosController($db);
        $this->imagen_controller= new ImagenController($db);
        $this->comentario_controller= new ComentarioController($db);
    }

    /**
     * This function lists active and inactive trips by converting them into objects and rendering them
     * on a page.
     */
    public function listar(): void {
        $lista_viajes= $this->repository->listar();
        // convertimos los viajes obtenidos en objetos de la clase Viaje
        $objetos_viajes= $this->obtener_objetos($lista_viajes);

        $viajes_activos= $this->obtener_activos($objetos_viajes);
        $viajes_no_activos= $this->obtener_no_activos($objetos_viajes);
        
        $this->pages->render('viaje/listar', ['viajes_activos' => $viajes_activos, 'viajes_no_activos' => $viajes_no_activos]);
    }

    /**
     * This function takes an array of trips, converts them into objects, calculates their duration,
     * sets the duration property of each object, and returns an array of the resulting objects.
     * 
     * @param viajes an array of data representing different trips or journeys.
     * @return an array of objects created from the input array of "viajes".
     */
    public function obtener_objetos($viajes): array {
        $objetos_viajes= [];
        foreach ($viajes as $viaje) {
            $objeto= $this->pasar_objeto($viaje);
            $duracion= $this->obtener_duracion($objeto);
            $objeto->setDuracion($duracion);
            array_push($objetos_viajes, $objeto);
        }
        return $objetos_viajes;
    }

    // coge los datos del viaje y llama al repositorio para convertirlo a objeto de tipo Viaje
    public function pasar_objeto($array): object {
        return $this->repository->pasar_objeto($array);
    }
    
    // llama al repositorio para obtener la duración del Viaje
    public function obtener_duracion($objeto_viaje): int {
        return $this->repository->obtener_duracion($objeto_viaje);
    }

    // obtiene los viajes que estén activos (a los que se puede inscribirse)
    public function obtener_activos($objetos_viaje): array {
        $activos= [];
        foreach ($objetos_viaje as $viaje) {
            if ($viaje->getActivo() == TRUE) { 
                array_push($activos, $viaje);
            }
        }
        return $activos;
    }
    
    // obtiene los viajes no activos, es decir, que ya se realizaron
    public function obtener_no_activos($objetos_viaje): array {
        $no_activos= [];
        foreach ($objetos_viaje as $viaje) {
            if ($viaje->getActivo() == FALSE) { 
                array_push($no_activos, $viaje);
            }
        }
        return $no_activos;
    }

    /**
     * This PHP function filters and displays a list of active and inactive trips based on user input.
     */
    public function buscar(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtros= $_POST['data'];
            $viajes_obtenidos= $this->repository->filtrar_viajes($filtros); 
            // var_dump($viajes_obtenidos);die();
            $objetos_viajes= $this->obtener_objetos($viajes_obtenidos);

            $viajes_activos= $this->obtener_activos($objetos_viajes);
            $viajes_no_activos= $this->obtener_no_activos($objetos_viajes);

            $this->pages->render('viaje/listar', ['viajes_activos' => $viajes_activos, 'viajes_no_activos' => $viajes_no_activos]);
        }
    }

    // ver el detalle del viaje, se distinguirá si el usuario se puede inscribir o no
    public function ver($id) {
        //  si existe el viaje, obtiene los datos del mismo, sino no muestra nada por pantalla
        if ($this->repository->existe_viaje($id)) {
            
            $viaje= $this->obtener_viaje($id);
            //comprobamos si el usuario actual está inscrito al viaje para poder inscribirse sólo si no
            if (isset($_SESSION['usuario'])) {
                $inscrito= $this->repository->viaje_inscrito_usuario($_SESSION['usuario'], $id);
                if ($inscrito) {
                    $_SESSION['usuario_ya_inscrito']= true;
                }
                else {
                    Utils::deleteSession('usuario_ya_inscrito');
                }
            }
            $gastos= $this->gastos_controller->obtener_gastos($id);

            $imagenes= $this->imagen_controller->obtener_imagenes($id);
            
            $comentarios= $this->comentario_controller->obtener_comentarios($id);
            
            $this->pages->render('viaje/ver', ['viaje' => $viaje, 'gastos' => $gastos, 'imagenes' => $imagenes, 'comentarios' => $comentarios ]);
             
        }     
    }

    /**
     * This PHP function obtains a trip's data, calculates its duration, and returns the trip object.
     * 
     * @param id The parameter "id" is the identifier of a specific trip that needs to be retrieved
     * from the repository.
     * @return an object of the class "Viaje" with its duration set. If the "obtener_viaje" method of
     * the "repository" returns false, then the function returns false.
     */
    public function obtener_viaje($id): object {
        $datos_viaje= $this->repository->obtener_viaje($id);
        if ($datos_viaje == false) {
            return false;
        }
        $viaje= $this->pasar_objeto($datos_viaje);
        $duracion= $this->obtener_duracion($viaje);
        $viaje->setDuracion($duracion);  
        
        return $viaje;
    }

    // muestra los viajes para el administrador
    public function mostrar(): void {
        $lista_viajes= $this->repository->listar();
        // convertimos los viajes obtenidos en objetos de la clase Viaje
        $objetos_viajes= $this->obtener_objetos($lista_viajes);

        $this->pages->render('viaje/administrar', ['viajes' => $objetos_viajes]);
    }

    /**
     * This function deletes a travel and all its related elements from the database.
     */
    public function borrar(): void {
        $id= $_POST['id_viaje_a_borrar'];

        // borramos los elementos que dependen del viaje
        $this->gastos_controller->borrar_por_viaje($id);
        $this->comentario_controller->borrar_por_viaje($id);
        $this->imagen_controller->borrar_por_viaje($id);
        $this->repository->borrar_inscritos_viaje($id);

        // borramos el viaje en sí
        $borrado= $this->repository->borrar($id);

        if ($borrado) {
            $_SESSION['viaje_borrado']= true;
        } 
        else {
            $_SESSION['viaje_borrado']= false;
        }
        $this->mostrar();
    }

    // lleva al formulario de crear viaje
    public function crear(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->pages->render('viaje/crear');
        }
    }

    /**
     * This function saves data from a form submission, validates the input, saves the data to a
     * repository, and saves associated expenses to a separate controller.
     */
    public function guardar(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // borramos sesiones de errores y redireccionamos al inicio
            $this->borra_sesiones_errores();

            $datos= $_POST['data'];
            $imagen= $_FILES['imagen'];

            $validar= $this->validar_campos($datos, $imagen);

            $gastos= [];
            if (!empty($_POST['gastos'])) {
                foreach($_POST['gastos'] as $gasto){
                    // Añadimos los gastos seleccionados
                    $gastos[$gasto]= true;
                }
            }

            if ($validar) {
                $guardado= $this->repository->guardar($datos, $imagen['name']);     
                
                if ($guardado) {
                    // guardamos los gastos del viaje
                    $id_viaje= $this->repository->obtener_id_ultimo_viaje();
                    $guardar_gastos= $this->gastos_controller->guardar($id_viaje, $gastos);

                    // si se guardan los gastos y la imagen del viaje, lo guarda
                    if ($guardar_gastos) {
                        Utils::deleteSession('error_gastos');

                        // guardamos la imagen principal del viaje
                        $guardar_imagen= $this->imagen_controller->guardar_principal($id_viaje, $datos['fecha_inicio'], $imagen['name'], $datos['tipo']);

                        if ($guardar_imagen) {
                            Utils::deleteSession('error_imagen');

                            $_SESSION['viaje_creado']= true;
                            // borra las sesiones de errores y los datos del viaje guardado
                            $this->borra_sesiones_errores();
                            $this->borrar_datos_post();
                            header("Location: ". $_ENV['BASE_URL']."administrar");
                        }
                        else {
                            // si no se guarda bien la imagen, se borran los gastos creados y el viaje porque está incompleto
                            $id_viaje= $this->repository->obtener_id_ultimo_viaje();
                            $this->gastos_controller->borrar_por_viaje($id_viaje);
                            $this->repository->borrar($id_viaje);
                            $_SESSION['viaje_creado']= false;
                            $_SESSION['error_imagen']= true;
                        }
                    }
                    else {
                        // si no se guardan bien los gastos, se borra el viaje porque está incompleto
                        $id_viaje= $this->repository->obtener_id_ultimo_viaje();
                        $this->repository->borrar($id_viaje);
                        $_SESSION['viaje_creado']= false;
                        $_SESSION['error_gastos']= true;
                    }
                }    
                // si no es error ni de los gastos ni de la imagen, es del viaje en sí
                else {
                    Utils::deleteSession('error_gastos');
                    Utils::deleteSession('error_imagen');
                    $_SESSION['viaje_creado']= false;
                }
            }
            $this->pages->render('viaje/crear');
        }
    }

    public function borrar_filtros(): void {
        // borramos campos de texto y número
        $this->borrar_datos_post();
        // borramos los valores de los select
        Utils::deleteSession('data_exigencia');
        Utils::deleteSession('data_nivel');
                
        header("Location: ". $_ENV['BASE_URL']);
    }

    // borra las sesiones de errores al guardar el viaje 
    public function borra_sesiones_errores(): void {
        Utils::deleteSession('err_pai');
        Utils::deleteSession('err_feci');
        Utils::deleteSession('err_fecf');
        Utils::deleteSession('err_via');
        Utils::deleteSession('err_pre');
        Utils::deleteSession('err_des');
        Utils::deleteSession('err_inf');
        Utils::deleteSession('err_img');
    }

    // borra los datos del viaje guardada
    public function borrar_datos_post(): void {
        if (isset($_POST['data'])) {
            unset($_POST['data']);
        }
    }

    // valida que todos los campos necesarios para la creación del viaje, estén validados correctamente
    public function validar_campos($datos, $imagen): bool {
        $no_vacios= $this->valida_vacios($datos, $imagen);
        
        if ($no_vacios) {
            $correctos= $this->valida_por_campo($datos, $imagen);

            if ($correctos) {
                
                $viaje_pais_fechas_existe= $this->viaje_pais_fechas_existe($datos);

                if (!$viaje_pais_fechas_existe) {
                    return true;
                }
                else { return false; }
            }
            else { return false; }
        }
        else { return false; }
    }

    // valida que no haya ningún campo vacío
    public function valida_vacios($datos, $imagen): bool {
        $result= false;
        if (empty($datos['pais'])) {
            $_SESSION['err_pai']= "*El pa&iacute;s debe estar relleno";
            $result= false;
        }
        if (empty($datos['fecha_inicio'])) {
            $_SESSION['err_feci']= "*La fecha de inicio debe estar rellena";
            $result= false;
        }
        if (empty($datos['fecha_fin'])) {
            $_SESSION['err_fecf']= "*La fecha de fin debe estar rellena";
            $result= false;
        }
        if (empty($datos['precio'])) {
            $_SESSION['err_pre']= "*El precio debe estar relleno";
            $result= false;
        }
        if (empty($datos['descripcion'])) {
            $_SESSION['err_des']= "*La descripci&oacute;n debe estar rellena";
            $result= false;
        }
        if (empty($datos['informacion'])) {
            $_SESSION['err_inf']= "*La informaci&oacute;n debe estar rellena";
            $result= false;
        }
        if (!is_uploaded_file($imagen['tmp_name'])) {
            $_SESSION['err_img']= "*Debes seleccionar una imagen";
            $result= false;
        }
        else {
            $result= true;
        }
        return $result;
    }

    // valida los valores introducidos en cada campo, según las necesidades del mismo
    public function valida_por_campo($datos, $imagen): bool {
        $pais_validado= $this->valida_pais($datos['pais']);
        $fechas_validadas= $this->valida_fechas($datos['fecha_inicio'], $datos['fecha_fin']);
        $descripcion_validado= $this->valida_descripcion($datos['descripcion']);
        $informacion_validado= $this->valida_informacion($datos['informacion']);
        $imagen_validado= $this->gestionar_foto($imagen);

        if ($pais_validado && $fechas_validadas && $descripcion_validado && $informacion_validado && $imagen_validado) {
            return true;
        }
        else {
            return false;
        }
    }

    // valida la longitud del país y, si es correcta, que solo sean letras y espacios
    public function valida_pais($pais): bool {
        // quitamos los espacios del principio y final
        $pais= trim($pais);
        // si la longitud es correcta, comprueba los caracteres introducidos
        if (strlen($pais) >= 4 && strlen($pais) <= 20) {
            $pattern= "/^[a-zñáóíúéA-ZÑÁÉÍÓÚ]+(\s[a-zñáóíúéA-ZÑÁÉÍÓÚ]+)*$/";
            if (!preg_match($pattern, $pais)) {
                $_SESSION['err_pai']= "*El pais sólo puede contener letras y espacios";
                return false;
            }
            else {
                return true;
            }
        }
        else {
            if (strlen($pais) < 4) {
                $_SESSION['err_pai']= "*El pais debe tener mínimo 4 caracteres";
                return false;
            }
            if (strlen($pais) > 20) {
                $_SESSION['err_pai']= "*El pais debe tener máximo 20 caracteres";
                return false;   
            }
        }
    }

    // valida que la fecha de inicio sea superior a la de hoy; y que sea menor a la de fin
    public function valida_fechas($inicio, $fin): bool {
        $fecha_hoy= new \DateTime();

        $fecha_inicio= \DateTime::createFromFormat('Y-m-d', $inicio);
        if ($fecha_inicio <= $fecha_hoy ) {
            $_SESSION['err_feci']= '*La fecha de inicio debe ser mayor a la fecha actual';
            return false;
        }
        else {
            if ($inicio > $fin) { 
                $_SESSION['err_feci']= "*La fecha de inicio debe ser menor a la de fin";
                return false;
            }
            else  {
                return true;
            }
        }
    }

    // valida la longitud de la descripción y, si es correcta, que no tenga números
    public function valida_descripcion($descripcion): bool {
        // quitamos los espacios del principio y final
        $descripcion= trim($descripcion);
        // si la longitud es correcta, comprueba los caracteres introducidos
        if (strlen($descripcion) >= 10 && strlen($descripcion) <= 50) {
            $pattern = "/^[\p{L}.,;:¡!¿?'\-\s]+$/u"; //letras (incluidas ñ y tildes), espacios y signos de puntuación

            if (!preg_match($pattern, $descripcion)) {
                $_SESSION['err_des']= "*La descripci&oacute;n s&oacute;lo puede contener letras, espacios y signos de puntuaci&oacute;n";
                return false;
            }
            else {
                return true;
            }
        }
        else {
            if (strlen($descripcion) < 10) {
                $_SESSION['err_des']= "*La descripci&oacute;n debe tener m&iacute;nimo 10 caracteres";
                return false;
            }
            if (strlen($descripcion) > 50) {
                $_SESSION['err_des']= "*La descripci&oacute;n debe tener m&aacute;ximo 30 caracteres";
                return false;   
            }
        }
    }

    // valida la longitud de la información y, si es correcta, que no tenga números
    public function valida_informacion($informacion): bool {
        // quitamos los espacios del principio y final
        $informacion= trim($informacion);
        // si la longitud es correcta, comprueba los caracteres introducidos
        if (strlen($informacion) >= 100) {
            $pattern = "/^[\p{L}.,;:¡!¿?'\-\s]+$/u"; //letras (incluidas ñ y tildes), espacios y signos de puntuación
            if (!preg_match($pattern, $informacion)) {
                $_SESSION['err_des']= "*La informaci&oacute;n s&oacute;lo puede contener letras, espacios y signos de puntuaci&oacute;n";
                return false;
                return false;
            }
            else {
                return true;
            }
        }
        else {
            $_SESSION['err_inf']= "*La informaci&oacute;n debe tener m&iacute;nimo 100 caracteres";
            return false;
        }
    }

    // guarda la foto subida en su correspondiente carpeta. Controla si hay algún error
    public function gestionar_foto($foto): bool {
        $nom_foto= $foto['name'];            
        $temp_foto= $foto['tmp_name'];
        $preruta= './fuente/media/images/galeria';
        $ruta_foto= $preruta.'/'.$nom_foto;

        // si no existe la carpeta, la crea
        if (!is_dir($preruta)){
            mkdir($preruta, '0777');
        }

        //si hay un fichero seleccionado, lo sube
        if (is_uploaded_file($temp_foto)) {
            if (move_uploaded_file($temp_foto, $ruta_foto)) {
                return true;
            }
            else {
                $_SESSION['err_img']= "*Ha habido un error al subir la foto";
                return false;
            }
        }
    }

    // comprueba que no exista ya un viaje al destino y las dechas introducidas
    public function viaje_pais_fechas_existe($datos): bool {
        $pais= $datos['pais'];
        $fecha_inicio= $datos['fecha_inicio'];
        $fecha_fin= $datos['fecha_fin'];

        $viaje_ya_existe= $this->repository->viaje_pais_fechas_existe($pais, $fecha_inicio, $fecha_fin);
        if ($viaje_ya_existe) {
            $_SESSION['err_via']= "*Ya hay un viaje ahí en esas fechas";
            return true;
        }
        else { return false; }
    }

    // recoge el id del viaje a comentar, comprueba que el usuario no lo haya comentado ya y lo lleva al formulario
    public function comentar(): void {
        $id= $_POST['id_viaje_a_comentar'];
        $viaje_ya_comentado= $this->comentario_controller->usuario_ya_comenta_viaje($_SESSION['usuario'], $id);

        if (!$viaje_ya_comentado) {
            $datos_viaje= $this->repository->obtener_viaje($id);
            $viaje= $this->pasar_objeto($datos_viaje);
            $this->pages->render('comentario/comentar', ['viaje' => $viaje]);
        }
        else {
            $_SESSION['usuario_ya_comentario']= true;
            header("Location: ". $_ENV['BASE_URL']. "misviajes");
        }
    }


}

?>
