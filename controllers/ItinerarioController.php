<?php

namespace Controllers;
use Repositories\ItinerarioRepository;
use Lib\Pages;

class ItinerarioController{
    private Pages $pages;
    private ItinerarioRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new ItinerarioRepository();
    }

    public function obtener_itinerario($id_viaje) {
        $lista_dias= $this->repository->listar($id_viaje);

        $objetos_itinerario= [];
        foreach ($lista_dias as $dia) {
            $objeto= $this->pasar_objeto($dia);
            array_push($objetos_itinerario, $objeto);
        }
        return $objetos_itinerario;
    }

    public function pasar_objeto($array) {
        return $this->repository->pasar_objeto($array);
    }

    
}

?>