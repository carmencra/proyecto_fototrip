<?php

namespace Controllers;
use Repositories\ViajeRepository;
use Lib\Pages;
use Lib\Email;
use Controllers\ItinerarioController;
use Controllers\GastosController;
use Controllers\ImagenController;
use Controllers\ComentarioController;
use Utils\Utils;

class ViajeController {
    private Pages $pages;
    private ViajeRepository $repository;
    private ItinerarioController $itinerarioController;
    private GastosController $gastosController;
    private ImagenController $imagenController;
    private ComentarioController $comentarioController;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new ViajeRepository();
        $this->itinerarioController= new ItinerarioController();
        $this->gastosController= new GastosController();
        $this->imagenController= new ImagenController();
        $this->comentarioController= new ComentarioController();
    }

    public function listar() {
        $lista_viajes= $this->repository->listar();
        // convertimos los viajes obtenidos en objetos de la clase Viaje
        $objetos_viajes= $this->obtener_objetos($lista_viajes);
        
        $this->pages->render('viaje/listar', ['viajes' => $objetos_viajes]);
    }

    public function obtener_objetos($viajes) {
        $objetos_viajes= [];
        foreach ($viajes as $viaje) {
            $objeto= $this->pasar_objeto($viaje);
            $duracion= $this->obtener_duracion($objeto);
            $objeto->setDuracion($duracion);
            array_push($objetos_viajes, $objeto);
        }
        return $objetos_viajes;
    }

    public function pasar_objeto($array) {
        return $this->repository->pasar_objeto($array);
    }
    
    public function obtener_duracion($objeto_viaje) {
        return $this->repository->obtener_duracion($objeto_viaje);
    }

    public function buscar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtros= $_POST['data'];
            $viajes_obtenidos=$this->repository->filtrar_viajes($filtros); 

            // añadimos la duración de cada viaje
            foreach ($viajes_obtenidos as $viaje) {
                $duracion= $this->obtener_duracion($viaje);
                $viaje->setDuracion($duracion);
            }
            $this->pages->render('viaje/listar', ['viajes' => $viajes_obtenidos]);
        }

    }


    // aquí tengo que controlar que si el id existe te lleve al viaje y sino nada o que de un error o algo

    public function ver($id) {
        $viaje= $this->obtener_viaje($id);

        //  si se encuentra un viaje, obtiene los datos relacionados con este y los manda a la vista
        if ($viaje) {
            $itinerario= $this->itinerarioController->obtener_itinerario($id);

            $gastos= $this->gastosController->obtener_gastos($id);

            $imagenes= $this->imagenController->obtener_imagenes($id);
            
            $comentarios= $this->comentarioController->obtener_comentarios($id);
            
            $this->pages->render('viaje/ver', ['viaje' => $viaje, 'itinerario' => $itinerario, 'gastos' => $gastos, 'imagenes' => $imagenes, 'comentarios' => $comentarios ]);
        }
    }

    public function obtener_viaje($id) {
        $datos_viaje= $this->repository->obtener_viaje($id);
        if ($datos_viaje == false) {
            return false;
        }
        $viaje= $this->pasar_objeto($datos_viaje);
        $duracion= $this->obtener_duracion($viaje);
        $viaje->setDuracion($duracion);  
        
        return $viaje;
    }

    public function mostrar() {
        $lista_viajes= $this->repository->listar();
        // convertimos los viajes obtenidos en objetos de la clase Viaje
        $objetos_viajes= $this->obtener_objetos($lista_viajes);

        $this->pages->render('viaje/administrar', ['viajes' => $objetos_viajes]);
    }

    public function borrar() {
        $id= $_POST['id_viaje_a_borrar'];
        $borrado= $this->repository->borrar($id);

        if ($borrado) {
            $_SESSION['viaje_borrado']= true;
        } 
        else {
            $_SESSION['viaje_borrado']= false;
        }
        $this->mostrar();
    }

    public function inscribirse() {
        $id= $_POST['viaje_a_inscribirse'];
        $usuario= $_SESSION['usuario'];
        $inscrito= $this->repository->inscribirse($id, $usuario);
        
        if ($inscrito) {
            $_SESSION['viaje_inscrito']= true; 
            // $correo= new Email($usuario);
            // $correo->confirmar_inscripcion();
        } 
        else {
            $_SESSION['viaje_inscrito']= false;
        }
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->pages->render('viaje/crear');
        }
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // borramos sesiones de errores y redireccionamos al inicio
            $this->borra_sesiones_errores();

            $datos= $_POST['data'];
            $imagen= $_FILES['imagen'];

            $validar= $this->validar_campos($datos, $imagen);

            if ($validar) {
                $guardado= $this->repository->guardar($datos, $imagen['name']);       
                
                if ($guardado) {
                    $_SESSION['viaje_creado']= true;$this->borra_sesiones_errores();
                }    
                else {
                    $_SESSION['viaje_creado']= false;
                }
            }
            $this->pages->render('viaje/crear');
        }
    }

    public function borra_sesiones_errores() {
        Utils::deleteSession('err_pai');
        Utils::deleteSession('err_feci');
        Utils::deleteSession('err_fecf');
        Utils::deleteSession('err_pre');
        Utils::deleteSession('err_des');
        Utils::deleteSession('err_inf');
        Utils::deleteSession('err_img');
    }

    public function validar_campos($datos, $imagen): bool {
        $no_vacios= $this->valida_vacios($datos, $imagen);
        
        if ($no_vacios) {
            $correctos= $this->valida_por_campo($datos, $imagen);
            if ($correctos) {
                return true;
            }
            else {return false;}
        }
        else {return false;}
    }

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

    public function valida_pais($pais): bool {
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

    public function valida_fechas($inicio, $fin): bool {
        if ($inicio > $fin) { 
            $_SESSION['err_feci']= "*La fecha de inicio debe ser menor a la de fin";
            return false;
        }
        else  {
            return true;
        }
    }

    public function valida_descripcion($descripcion): bool {
        // si la longitud es correcta, comprueba los caracteres introducidos
        if (strlen($descripcion) >= 10 && strlen($descripcion) <= 30) {
            $pattern= "/^[a-zñáóíúéA-ZÑÁÉÍÓÚ]+(\s[a-zñáóíúéA-ZÑÁÉÍÓÚ]+)*$/";
            if (!preg_match($pattern, $descripcion)) {
                $_SESSION['err_des']= "*La descripci&oacute;n s&oacute;lo puede contener letras y espacios";
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
            if (strlen($descripcion) > 30) {
                $_SESSION['err_des']= "*La descripci&oacute;n debe tener m&aacute;ximo 30 caracteres";
                return false;   
            }
        }
    }

    public function valida_informacion($informacion): bool {
        // si la longitud es correcta, comprueba los caracteres introducidos
        if (strlen($informacion) >= 20) {
            $pattern= "/^[a-zñáóíúéA-ZÑÁÉÍÓÚ]+(\s[a-zñáóíúéA-ZÑÁÉÍÓÚ]+)*$/";
            if (!preg_match($pattern, $informacion)) {
                $_SESSION['err_inf']= "*La informaci&oacute;n s&oacute;lo puede contener letras y espacios";
                return false;
            }
            else {
                return true;
            }
        }
        else {
            $_SESSION['err_inf']= "*La informaci&oacute;n debe tener m&iacute;nimo 20 caracteres";
            return false;
        }
    }

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


}

?>
