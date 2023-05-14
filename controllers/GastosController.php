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

    
}

?>