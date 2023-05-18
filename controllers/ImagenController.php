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

    // esto tendré que hacerlo con la imagen en sí, pero todavía no sé si guardarla en firebase o en local o qué cojones
    public function listar() {
        $lista_imagenes= $this->repository->listar();
        $objetos_imagenes= [];
        foreach ($lista_imagenes as $imagen) {
            $objeto= $this->pasar_objeto($imagen);
            // si la imagen está aceptada, la añade a la lista para ser mostrada;
            if ($objeto->getAceptada() == "0") { //0 = true; 1= false 
                $pais_viaje= $this->obtener_pais_viaje($objeto->getId_viaje());
                $objeto->setPais_viaje($pais_viaje);
                array_push($objetos_imagenes, $objeto);
            }
        }
        // return $objetos_imagenes;
        $this->pages->render('imagen/listar', ['imagenes' => $objetos_imagenes]);
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
                if ($imagen->getAceptada() == "1") {
                    $pais_viaje= $this->obtener_pais_viaje($imagen->getId_viaje());
                    // añadimos el pais de cada imagen
                    $imagen->setPais_viaje($pais_viaje);
                    array_push($imagenes_aceptadas, $imagen);
                }
            }
            $this->pages->render('imagen/listar', ['imagenes' => $imagenes_aceptadas]);
        } 

    }
    
}

?>