<?php

namespace Controllers;
use Repositories\ComentarioRepository;
use Lib\Pages;

class ComentarioController{
    private Pages $pages;
    private ComentarioRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new ComentarioRepository();
    }

    public function listar() {
        $lista_coments= $this->repository->listar();
        $objetos_coments= [];
        foreach ($lista_coments as $coment) {
            $objeto= $this->pasar_objeto($coment);
            $nombre_viaje= $this->obtener_nombre_viaje($objeto->getId_viaje());
            $objeto->setNombre_viaje($nombre_viaje);
            array_push($objetos_coments, $objeto);
        }
        // return $objetos_coments;
        $this->pages->render('comentario/listar', ['comentarios' => $objetos_coments]);
    }

    public function pasar_objeto($array) {
        return $this->repository->pasar_objeto($array);
    }

    public function obtener_nombre_viaje($id_viaje) {
        return $this->repository->obtener_nombre_viaje($id_viaje);
    }

    public function obtener_comentarios($id_viaje) {
        $lista_comentarios= $this->repository->obtener_comentarios($id_viaje);

        $objetos_comentarios= [];
        foreach ($lista_comentarios as $comentario) {
            $objeto= $this->pasar_objeto($comentario);
            array_push($objetos_comentarios, $objeto);
        }
        return $objetos_comentarios;
    }
    
}

?>