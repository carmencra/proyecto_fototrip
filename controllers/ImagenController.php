<?php

namespace Controllers;
use Repositories\ImagenRepository;
use Lib\Pages;

class ImagenController{
    private Pages $pages;
    private ImagenRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new ImagenRepository();
    }

    
    public function listar() {
        $lista_imagenes= $this->repository->listar();
        // convertimos las imagenes obtenidos en objetos de la clase Imagen
        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);
        
        $this->pages->render('imagen/listar', ['imagenes' => $objetos_imagenes]);
    }

    public function obtener_objetos($imagenes) {
        $objetos_imagenes= [];
        foreach ($imagenes as $imagen) {
            $objeto= $this->pasar_objeto($imagen);
            // si la imagen está aceptada, la añade a la lista para ser mostrada;
            if ($objeto->getAceptada() == true) { //0 = true; 1= false 
                $pais_viaje= $this->obtener_pais_viaje($objeto->getId_viaje());
                $objeto->setPais_viaje($pais_viaje);
                array_push($objetos_imagenes, $objeto);
            }
        }
        return $objetos_imagenes;
    }

    public function pasar_objeto($array) {
        return $this->repository->pasar_objeto($array);
    }

    public function obtener_pais_viaje($id_viaje) {
        return $this->repository->obtener_pais_viaje($id_viaje);
    }

    public function buscar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtros= $_POST['data'];

            $imagenes_obtenidas= $this->repository->filtrar_imagenes($filtros);

            // recorremos las imágenes obtenidas, y si están aceptadas, las mostrará
            $imagenes_aceptadas= [];
            foreach ($imagenes_obtenidas as $imagen) {
                if ($imagen->getAceptada() == true) {
                    $pais_viaje= $this->obtener_pais_viaje($imagen->getId_viaje());
                    // añadimos el pais de cada imagen
                    $imagen->setPais_viaje($pais_viaje);
                    array_push($imagenes_aceptadas, $imagen);
                }
            }
            // var_dump($imagenes_aceptadas);die();
            $this->pages->render('imagen/listar', ['imagenes' => $imagenes_aceptadas]);
        } 
    }

    public function obtener_imagenes($id_viaje) {
        $lista_imagenes= $this->repository->obtener_imagenes($id_viaje);

        $objetos_imagenes= [];
        foreach ($lista_imagenes as $imagen) {
            $objeto= $this->pasar_objeto($imagen);
            // si la imagen está aceptada por el admin, la añade
            if ($objeto->getAceptada() == true) {
                array_push($objetos_imagenes, $objeto);
            }
        }
        return $objetos_imagenes;
    }

    public function mostrar() {
        $lista_imagenes= $this->repository->listar();
        // convertimos las imagenes obtenidos en objetos de la clase Imagen
        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);

        $this->pages->render('admin/imagenes', ['imagenes' => $objetos_imagenes]);
    }

    public function borrar() {
        $id= $_POST['imagen_a_borrar'];
        $borrado= $this->repository->borrar($id);

        if ($borrado) {
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
        $this->pages->render('admin/aceptar_imagenes', ['imagenes' => $imagenes_no_aceptadas]);
    }

    public function obtener_no_aceptadas($imagenes) {
        $objetos_imagenes= [];
        foreach ($imagenes as $imagen) {
            $objeto= $this->pasar_objeto($imagen);
            // añade las imágenes que todavía no han sido aceptadas
            if ($objeto->getAceptada() == false) { //0 = true; 1= false 
                $pais_viaje= $this->obtener_pais_viaje($objeto->getId_viaje());
                $objeto->setPais_viaje($pais_viaje);
                array_push($objetos_imagenes, $objeto);
            }
        }
        return $objetos_imagenes;
    }

    public function aceptar() {
        $imagen= $_POST['imagen_a_aceptar'];
        $this->repository->aceptar($imagen);
        $this->listar_para_aceptar();
    }

    public function descartar() {
        $imagen= $_POST['imagen_a_descartar'];
        $this->repository->borrar($imagen);
        $this->listar_para_aceptar();
    }

}

?>