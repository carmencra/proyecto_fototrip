<?php

namespace Controllers;
use Repositories\ViajeRepository;
use Lib\Pages;
use Controllers\ItinerarioController;
use Controllers\GastosController;
use Controllers\ImagenController;
use Controllers\ComentarioController;

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
        $objetos_viajes= [];
        foreach ($lista_viajes as $viaje) {
            $objeto= $this->pasar_objeto($viaje);
            $duracion= $this->obtener_duracion($objeto);
            $objeto->setDuracion($duracion);
            array_push($objetos_viajes, $objeto);
        }
        // return $objetos_viajes;
        $this->pages->render('viaje/listar', ['viajes' => $objetos_viajes]);
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
        // sino, manda solo el viaje vacío y la vista devuelve que no se ha encontrado
        else {
            $this->pages->render('viaje/ver', ['viaje' => $viaje]);
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

}

?>
