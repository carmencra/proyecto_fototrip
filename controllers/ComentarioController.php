<?php

namespace Controllers;
use Repositories\ComentarioRepository;
use Lib\Pages;

class ComentarioController{
    private Pages $pages;
    private ComentarioRepository $repository;

    public function __construct($db) {
        $this->pages= new Pages();
        $this->repository= new ComentarioRepository($db);
    }

    public function listar() {
        $lista_coments= $this->repository->listar();
        // convertimos los comentarios obtenidos en objetos de la clase Comentario
        $objetos_coments= $this->obtener_objetos($lista_coments);

        $objetos_aceptados= $this->obtener_aceptados($objetos_coments);        
        
        $this->pages->render('comentario/listar', ['comentarios' => $objetos_aceptados]);
    }

    public function obtener_objetos($comentarios) {
        $objetos_coments= [];
        foreach ($comentarios as $coment) {
            $objeto= $this->pasar_objeto($coment);

            // añadimos el nombre del viaje
            $nombre_viaje= $this->repository->obtener_nombre_viaje($objeto->getId_viaje());
            $objeto->setNombre_viaje($nombre_viaje);
            
            // añadimos el nombre del usuario
            $nombre_usuario= $this->repository->obtener_nombre_usuario($objeto->getUsuario());
            $objeto->setNombre_usuario($nombre_usuario);
            
            // añadimos los apellidos del
            $apellidos_usuario= $this->repository->obtener_apellidos_usuario($objeto->getUsuario());
            $objeto->setApellidos_usuario($apellidos_usuario);

            array_push($objetos_coments, $objeto);
        }
        return $objetos_coments;
    }

    public function obtener_aceptados($comentarios) {
        $aceptados= [];
        foreach ($comentarios as $imagen) {
            if ($imagen->getAceptado() == TRUE) {
                array_push($aceptados, $imagen);
            }
        }
        return $aceptados;
    }

    public function pasar_objeto($array) {
        return $this->repository->pasar_objeto($array);
    }

    public function obtener_nombre_viaje($id_viaje) {
        return $this->repository->obtener_nombre_viaje($id_viaje);
    }

    public function obtener_comentarios($id_viaje) {
        $lista_comentarios= $this->repository->obtener_comentarios($id_viaje);

        $objetos_comentarios= $this->obtener_objetos($lista_comentarios);
        
        $objetos_aceptados= $this->obtener_aceptados($objetos_comentarios);   

        return $objetos_aceptados;
    }

    public function mostrar() {
        $lista_comentarios= $this->repository->listar();
        // convertimos los comentarios obtenidos en objetos de la clase comentario
        $objetos_comentarios= $this->obtener_objetos($lista_comentarios);

        $this->pages->render('comentario/administrar', ['comentarios' => $objetos_comentarios]);
    }

    public function borrar() {
        $id= $_POST['id_comentario_a_borrar'];
        $borrado= $this->repository->borrar($id);

        if ($borrado) {
            $_SESSION['comentario_borrado']= true;
        } 
        else {
            $_SESSION['comentario_borrado']= false;
        }
        $this->mostrar();
    }
    
    public function listar_para_aceptar() {
        $comentarios= $this->repository->listar();
        $comentarios_no_aceptados= $this->obtener_no_aceptados($comentarios);
        $this->pages->render('comentario/aceptar', ['comentarios' => $comentarios_no_aceptados]);
    }

    public function obtener_no_aceptados($comentarios) {
        $objetos_coments= [];
        foreach ($comentarios as $comentario) {
            $objeto= $this->pasar_objeto($comentario);
            // añade los comentarios que todavía no han sido aceptados
            if ($objeto->getAceptado() == false) { 
                // añadimos el nombre del viaje
                $nombre_viaje= $this->repository->obtener_nombre_viaje($objeto->getId_viaje());
                $objeto->setNombre_viaje($nombre_viaje);
                
                // añadimos el nombre del usuario
                $nombre_usuario= $this->repository->obtener_nombre_usuario($objeto->getUsuario());
                $objeto->setNombre_usuario($nombre_usuario);
                
                // añadimos los apellidos del
                $apellidos_usuario= $this->repository->obtener_apellidos_usuario($objeto->getUsuario());
                $objeto->setApellidos_usuario($apellidos_usuario);
                array_push($objetos_coments, $objeto);
            }
        }
        return $objetos_coments;
    }

    public function aceptar() {
        $comentario= $_POST['comentario_a_aceptar'];
        $this->repository->aceptar($comentario);
        $this->listar_para_aceptar();
        // header("Location: ". $_ENV['BASE_URL'].'seleccionar/imagenes');
        
    }

    public function descartar() {
        $comentario= $_POST['comentario_a_descartar'];
        $this->repository->borrar($comentario);
        $this->listar_para_aceptar();
    }

    public function guardar() {
        $datos= $_POST['data'];
        $id_viaje= $datos['id_viaje_a_comentar'];

        $validar= $this->validar($datos['comentario']);

        if ($validar) {
            $guardar= $this->repository->guardar($id_viaje, $_SESSION['usuario'], $datos['comentario']);
            if ($guardar) {
                $_SESSION['comentario_guardado']= true;
            }
            else {
                $_SESSION['comentario_guardado']= false;
            }
            
            header("Location: ". $_ENV['BASE_URL'].'misviajes');
        }
        var_dump($data['comentario']);die();
    }

    public function validar($comentario):bool {
        if (empty($comentario)) {
            $_SESSION['err_com']= "*El comentario debe estar relleno";
            return false;
        }
        else {
            // quitamos los espacios del principio y final
            $comentario= trim($comentario);
            // comprobamos la longitud del comentario
            if (strlen($comentario) < 4) {
                $_SESSION['err_com']= "*El comentario debe tener m&iacute;nimo 4 caracteres";
                return false;
            }
            else {return true;}
        }
    }

    public function obtener_comentarios_usuario($email) {
        return $this->repository->obtener_comentarios_usuario($email);
    }


}

?>