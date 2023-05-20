<?php

namespace Controllers;
use Repositories\ViajeRepository;
use Lib\Pages;

class ViajeController {
    private Pages $pages;
    private ViajeRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new ViajeRepository();
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

    public function ver($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos_viaje= $this->repository->obtener_viaje($id);
            $viaje= $this->pasar_objeto($datos_viaje);
            $duracion= $this->obtener_duracion($viaje);
            $viaje->setDuracion($duracion);            

            $this->pages->render('viaje/ver', ['viaje' => $viaje]);
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            var_dump("GET");die();
        }
    }
}

?>
