<?php

namespace Controllers;
use Repositories\AdminRepository;
use Lib\Pages;

class AdminController{
    private Pages $pages;
    private AdminRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new AdminRepository();
    }

    
}

?>