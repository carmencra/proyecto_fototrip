<?php

namespace Controllers;
use Repositories\GastosRepository;
use Lib\Pages;

class GastosController{
    private Pages $pages;
    private GastosRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new GastosRepository();
    }

    public function obtener_gastos($id_viaje) {
        $gastos= $this->repository->obtener_gastos($id_viaje);
        $objeto= $this->pasar_objeto($gastos);
        return $objeto;  
    }

    public function pasar_objeto($array) {
        return $this->repository->pasar_objeto($array);
    }
    
}

?>