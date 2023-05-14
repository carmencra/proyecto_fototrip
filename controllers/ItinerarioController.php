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

    
}

?>