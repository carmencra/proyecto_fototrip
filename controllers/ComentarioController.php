<?php

namespace Controllers;
use Repositories\ComentarioRepository;
use Lib\Pages;
use Utils\Utils;

class ComentarioController{
    private Pages $pages;
    private ComentarioRepository $repository;

    public function __construct($db) {
        $this->pages= new Pages();
        $this->repository= new ComentarioRepository($db);
    }

    // lista todos los comentarios aceptados
    public function listar(): void {
        $lista_coments= $this->repository->listar();
        // convertimos los comentarios obtenidos en objetos de la clase Comentario
        $objetos_coments= $this->obtener_objetos($lista_coments);

        $objetos_aceptados= $this->obtener_aceptados($objetos_coments);        
        
        $this->pages->render('comentario/listar', ['comentarios' => $objetos_aceptados]);
    }

    // obtiene los objetos comentarios y añade campos necesarios de los mismos
    public function obtener_objetos($comentarios): array {
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

    // obtiene los comentarios aceptados
    public function obtener_aceptados($comentarios): array {
        $aceptados= [];
        foreach ($comentarios as $imagen) {
            if ($imagen->getAceptado() == TRUE) {
                array_push($aceptados, $imagen);
            }
        }
        return $aceptados;
    }

    // convierte en un objeto Comentario los datos pasados
    public function pasar_objeto($array): object {
        return $this->repository->pasar_objeto($array);
    }

    // obtiene el destino del viaje indicado para añadirlo al comentario
    public function obtener_nombre_viaje($id_viaje) {
        return $this->repository->obtener_nombre_viaje($id_viaje);
    }

    // obtiene los comentarios publicados sobre el viaje indicado
    public function obtener_comentarios($id_viaje): array {
        $lista_comentarios= $this->repository->obtener_comentarios($id_viaje);

        $objetos_comentarios= $this->obtener_objetos($lista_comentarios);
        
        $objetos_aceptados= $this->obtener_aceptados($objetos_comentarios);   

        return $objetos_aceptados;
    }

    // lleva al admin a la administración de comentarios
    public function mostrar(): void {
        $lista_comentarios= $this->repository->listar();
        // convertimos los comentarios obtenidos en objetos de la clase comentario
        $objetos_comentarios= $this->obtener_objetos($lista_comentarios);

        $this->pages->render('comentario/administrar', ['comentarios' => $objetos_comentarios]);
    }

    // borra el comentario selecionado y redirige según el tipo de usuario
    public function borrar(): void {
        $id= $_POST['id_comentario_a_borrar'];
        $borrado= $this->repository->borrar($id);

        if ($borrado) {
            $_SESSION['comentario_borrado']= true;
        } 
        else {
            $_SESSION['comentario_borrado']= false;
        }
         // redirige a la administración o a la página de viajes del usuario
        if (isset($_SESSION['admin'])) {
            $this->mostrar();
        }
        else {
            header("Location: ". $_ENV['BASE_URL']."misviajes");
        }
    }
    
    // lista los comentarios no aceptados para que el admin lo haga o los descarte
    public function listar_para_aceptar(): void {
        $comentarios= $this->repository->listar();
        $comentarios_no_aceptados= $this->obtener_no_aceptados($comentarios);
        $this->pages->render('comentario/aceptar', ['comentarios' => $comentarios_no_aceptados]);
    }

    // obtiene los comentarios que no han sido aceptados
    public function obtener_no_aceptados($comentarios) {
        $objetos_comentarios= $this->obtener_objetos($comentarios);

        $objetos_no_aceptados= [];
        foreach ($objetos_comentarios as $comentario) {
            if ($comentario->getAceptado() == FALSE) { 
                array_push($objetos_no_aceptados, $comentario);
            }
        }
        return $objetos_no_aceptados;
    }

    // acepta el comentario seleccionado (lo publica)
    public function aceptar(): void {
        $comentario= $_POST['comentario_a_aceptar'];
        $this->repository->aceptar($comentario);
        $this->listar_para_aceptar();
        // header("Location: ". $_ENV['BASE_URL'].'seleccionar/imagenes');
    }

    //  descarta el comentario seleccionado (lo borra)
    public function descartar(): void {
        $comentario= $_POST['comentario_a_descartar'];
        $this->repository->borrar($comentario);
        $this->listar_para_aceptar();
    }

    // guarda el comentario después de validarlo
    public function guardar(): void {
        $datos= $_POST['data'];
        $id_viaje= $datos['id_viaje_a_comentar'];
        $pais_viaje= $datos['pais_viaje_a_comentar'];

        $validar= $this->validar($datos['comentario']);

        if ($validar) {
            $guardar= $this->repository->guardar($id_viaje, $_SESSION['usuario'], $datos['comentario']);
            if ($guardar) {
                $_SESSION['comentario_guardado']= true;
                Utils::deleteSession('err_com');
                header("Location: ". $_ENV['BASE_URL'].'misviajes');
            }
            else {
                $_SESSION['comentario_guardado']= false;
            }
        }
        $datos= [];
        $datos['id']= $id_viaje; $datos['pais']= $pais_viaje;
        $this->pages->render('comentario/comentar', ['viaje' => $datos]);
    }

    // valida que no esté vacío y tenga los caracteres correctos
    public function validar($comentario): bool {
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
            else {
                $pattern = "/^[\p{L}.,;:¡!¿?'\-\s]+$/u"; //letras (incluidas ñ y tildes), espacios y signos de puntuación

                if (!preg_match($pattern, $comentario)) {
                    $_SESSION['err_com']= "*El comentario s&oacute;lo puede contener letras, espacios y signos de puntuaci&oacute;n";
                    return false;
                }
                else {
                    return true;
                }
            }
        }
    }

    // obtiene los comentarios que el usuario ha publicado
    public function obtener_comentarios_usuario($email): array {
        return $this->repository->obtener_comentarios_usuario($email);
    }

    // devuelve si el usuario ya ha comentado sobre ese viaje
    public function usuario_ya_comenta_viaje($email, $id_viaje): bool {
        return $this->repository->usuario_ya_comenta_viaje($email, $id_viaje);
    }
    
    // devuelve si ha podido borrar los comentarios del viaje indicado
    public function borrar_por_viaje($id_viaje): bool {
        return $this->repository->borrar_por_viaje($id_viaje);
    }

}

?>