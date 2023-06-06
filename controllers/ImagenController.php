<?php

namespace Controllers;
use Repositories\ImagenRepository;
use Lib\Pages;
use Utils\Utils;

class ImagenController{
    private Pages $pages;
    private ImagenRepository $repository;

    public function __construct($db) {
        $this->pages= new Pages();
        $this->repository= new ImagenRepository($db);
    }

    
    public function listar() {
        $lista_imagenes= $this->repository->listar();
        // convertimos las imagenes obtenidos en objetos de la clase Imagen
        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);

        $objetos_aceptadas= $this->obtener_aceptadas($objetos_imagenes);
        
        $this->pages->render('imagen/listar', ['imagenes' => $objetos_aceptadas]);
    }

    public function obtener_objetos($imagenes) {
        $objetos_imagenes= [];
        foreach ($imagenes as $imagen) {
            $objeto= $this->pasar_objeto($imagen);
            // obtenemos el país del viaje al que pertenece la imagen
            $pais_viaje= $this->repository->obtener_pais_viaje($objeto->getId_viaje());
            $objeto->setPais_viaje($pais_viaje);

            //obtenemos el usuario que ha publicado la imagen
            $email_usuario= $this->repository->obtener_usuario($objeto->getId_usuario());
            $objeto->setUsuario($email_usuario);
            
            // guardamos la imagen
            array_push($objetos_imagenes, $objeto);
        }
        return $objetos_imagenes;
    }

    public function pasar_objeto($array) {
        return $this->repository->pasar_objeto($array);
    }

    public function obtener_aceptadas($imagenes) {
        $aceptadas= [];
        foreach ($imagenes as $imagen) {
            if ($imagen->getAceptada() == TRUE) {
                array_push($aceptadas, $imagen);
            }
        }
        return $aceptadas;
    }
 
    public function buscar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtros= $_POST['data'];

            $imagenes_obtenidas= $this->repository->filtrar_imagenes($filtros);

            $objetos_imagenes= $this->obtener_objetos($lista_imagenes);
        
            $objetos_aceptados= $this->obtener_aceptadas($objetos_imagenes);
    
            $this->pages->render('imagen/listar', ['imagenes' => $objetos_aceptados]);
        } 
    }

    public function obtener_imagenes($id_viaje) {
        $lista_imagenes= $this->repository->obtener_imagenes($id_viaje);

        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);
        
        $objetos_aceptados= $this->obtener_aceptadas($objetos_imagenes);
    
        return $objetos_aceptados;
    }

    public function mostrar() {
        $lista_imagenes= $this->repository->mostrar();
        // convertimos las imagenes obtenidos en objetos de la clase Imagen
        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);

        $this->pages->render('imagen/administrar', ['imagenes' => $objetos_imagenes]);
    }

    public function borrar() {
        $id= $_POST['id_imagen_a_borrar'];
        $borrada= $this->repository->borrar($id);

        if ($borrada) {
            $_SESSION['imagen_borrada']= true;
        } 
        else {
            $_SESSION['imagen_borrada']= false;
        }
        $this->mostrar();
    }
    
    public function listar_para_aceptar() {
        $imagenes= $this->repository->listar();
        $imagenes_no_aceptadas= $this->obtener_no_aceptadas($imagenes);
        $this->pages->render('imagen/aceptar', ['imagenes' => $imagenes_no_aceptadas]);
    }

    public function obtener_no_aceptadas($imagenes) {
        $objetos_imagenes= [];
        foreach ($imagenes as $imagen) {
            $objeto= $this->repository->pasar_objeto($imagen);
            // añade las imágenes que todavía no han sido aceptadas
            if ($objeto->getAceptada() == false) { //0 = true; 1= false 
                // obtenemos el país del viaje al que pertenece la imagen
                $pais_viaje= $this->repository->obtener_pais_viaje($objeto->getId_viaje());
                $objeto->setPais_viaje($pais_viaje);

                //obtenemos el usuario que ha publicado la imagen
                $usuario= $this->repository->obtener_usuario($objeto->getId_usuario());
                $objeto->setUsuario($usuario);

                array_push($objetos_imagenes, $objeto);
            }
        }
        return $objetos_imagenes;
    }

    public function aceptar() {
        $imagen= $_POST['id_imagen_a_aceptar'];
        $this->repository->aceptar($imagen);
        $this->listar_para_aceptar();
    }

    public function descartar() {
        $imagen= $_POST['id_imagen_a_descartar'];
        $this->repository->borrar($imagen);
        $this->listar_para_aceptar();
    }

    public function crear() {
        $viajes_disponibles= $this->obtener_viajes_disponibles();
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->pages->render('imagen/crear', ['viajes' => $viajes_disponibles]);
        }
    }

    public function guardar() {
        $viajes_disponibles= $this->obtener_viajes_disponibles();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos= $_POST['data'];
            $fecha_correcta= $this->comprobar_fecha_viaje($datos['viaje'], $datos['fecha']);

            if ($fecha_correcta) {
                Utils::deleteSession('err_fec');
                
                // aquí ya se guarda porque está todo correcto
                if ($this->gestionar_foto($_FILES['imagen'])) {
                    $nombre_foto= $_FILES['imagen']['name'];
                    $guardado= $this->repository->guardar($datos, $nombre_foto);       
                    if ($guardado) {
                        $_SESSION['imagen_creada']= true;
                        $this->borrar_sesiones();
                    }    
                    else {
                        $_SESSION['imagen_creada']= false;
                    }
                }
            }
            else {
                $_SESSION['err_fec']= '*La fecha no se corresponde con la del viaje';
            }
            $this->pages->render('imagen/crear', ['viajes' => $viajes_disponibles]);
        }
    }

    public function borrar_sesiones() {
        Utils::deleteSession('err_img');
        Utils::deleteSession('data_tipo');
        Utils::deleteSession('data_viaje');
        Utils::deleteSession('data_fecha');
    }


    public function obtener_viajes_disponibles() {
        $lista_viajes= $this->repository->obtener_viajes_disponibles();
        // convertimos los viajes obtenidos en objetos de la clase Viaje
        $objetos_viajes= $this->repository->obtener_objetos_viajes($lista_viajes);
        
        return $objetos_viajes;
    }

    public function comprobar_fecha_viaje($id_viaje, $fecha): bool {
        $fechas= $this->repository->obtener_fechas_viaje($id_viaje);

        if ($fecha >= $fechas['inicio'] && $fecha <= $fechas['fin']) {
            return true;
        }
        else {
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
            move_uploaded_file($temp_foto, $ruta_foto);
            return true;
        }
        else {
            $_SESSION['err_img']= "* La imagen es obligatoria";
            return false;
        }
    }


    public function obtener_imagenes_usuario($id) {
        return $this->repository->obtener_imagenes_usuario($id);
    }

}

?>