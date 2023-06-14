<?php

namespace Controllers;
use Repositories\ImagenRepository;
use Lib\Pages;
use Utils\Utils;

class ImagenController{
    private Pages $pages;
    private ImagenRepository $repository;

    public function __construct($db) {
        $this->pages= new Pages();
        $this->repository= new ImagenRepository($db);
    }

    
    // lista las imágenes aceptadas para mostrarlas
    public function listar(): void {
        $lista_imagenes= $this->repository->listar();
        // convertimos las imagenes obtenidos en objetos de la clase Imagen
        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);

        $objetos_aceptadas= $this->obtener_aceptadas($objetos_imagenes);
        
        $this->pages->render('imagen/listar', ['imagenes' => $objetos_aceptadas]);
    }

    // obtiene los objetos Imagen del array con datos de imágenes
    public function obtener_objetos($imagenes): array {
        $objetos_imagenes= [];
        foreach ($imagenes as $imagen) {
            $objeto= $this->pasar_objeto($imagen);
            // obtenemos el país del viaje al que pertenece la imagen
            $pais_viaje= $this->repository->obtener_pais_viaje($objeto->getId_viaje());
            $objeto->setPais_viaje($pais_viaje);

            //obtenemos el usuario que ha publicado la imagen
            $email_usuario= $this->repository->obtener_usuario($objeto->getId_usuario());
            $objeto->setUsuario($email_usuario);
            
            // guardamos la imagen
            array_push($objetos_imagenes, $objeto);
        }
        return $objetos_imagenes;
    }

    // obtiene la Imagen recogida en los datos pasados
    public function pasar_objeto($array): object {
        return $this->repository->pasar_objeto($array);
    }

    // obtiene las imágenes que el admin ha aceptado
    public function obtener_aceptadas($imagenes): array {
        $aceptadas= [];
        foreach ($imagenes as $imagen) {
            if ($imagen->getAceptada() == TRUE) {
                array_push($aceptadas, $imagen);
            }
        }
        return $aceptadas;
    }
 
    // busca las imágenes que encaja con los filtros introducidos
    public function buscar(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtros= $_POST['data'];

            $imagenes_obtenidas= $this->repository->filtrar_imagenes($filtros);

            if (!empty($filtros['pais'])) {
                $imagenes_pais_comprobado= $this->comprobar_pais_imagenes($imagenes_obtenidas, $filtros['pais']);

                $objetos_imagenes= $this->obtener_objetos($imagenes_pais_comprobado);
            }
            else {
                $objetos_imagenes= $this->obtener_objetos($imagenes_obtenidas);
            }
        
            $objetos_aceptados= $this->obtener_aceptadas($objetos_imagenes);
    
            $this->pages->render('imagen/listar', ['imagenes' => $objetos_aceptados]);
        } 
    }

    // comprueba que las imágenes obtenidas coincidan con el país introducido en el buscador
    public function comprobar_pais_imagenes($imagenes, $filtro_pais): array {
        $objetos_imagen=[];
        foreach($imagenes as $datos_imagen) {
            // cogemos el id del viaje y comprobamos que el país sea el del filtro
            $imagen= $datos_imagen['imagen'];
            $id_viaje= $datos_imagen['id_viaje'];

            $filtro_pais_correcto= $this->repository->comprobar_pais_filtro($imagen, $id_viaje, $filtro_pais);

            if ($filtro_pais_correcto) {
                array_push($objetos_imagen, $datos_imagen);
            }
        }
        return $objetos_imagen;
    }

    // obtiene las imágenes que se han publicado en el viaje pasado
    public function obtener_imagenes($id_viaje): array {
        $lista_imagenes= $this->repository->obtener_imagenes($id_viaje);

        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);
        
        $objetos_aceptados= $this->obtener_aceptadas($objetos_imagenes);
    
        return $objetos_aceptados;
    }

    // recoge las imágenes para llevarlas a la administración
    public function mostrar(): void {
        $lista_imagenes= $this->repository->mostrar();
        // convertimos las imagenes obtenidos en objetos de la clase Imagen
        $objetos_imagenes= $this->obtener_objetos($lista_imagenes);

        $this->pages->render('imagen/administrar', ['imagenes' => $objetos_imagenes]);
    }

    // borra la imagen seleccionada y devuelve si hubiera un error. Redirige dependiendo del tipo de usuario.
    public function borrar(): void {
        $id= $_POST['id_imagen_a_borrar'];
        $borrada= $this->repository->borrar($id);

        if ($borrada) {
            $_SESSION['imagen_borrada']= true;
        } 
        else {
            $_SESSION['imagen_borrada']= false;
        }
        // redirige a la administración o a la página de viajes del usuario
        if (isset($_SESSION['admin'])) {
            $this->mostrar();
        }
        else {
            header("Location: ". $_ENV['BASE_URL']."misviajes");
        }
    }
    
    // recoge las imágenes  para que el admin las acepte(publique) o las descarte(elimine)
    public function listar_para_aceptar(): void {
        $imagenes= $this->repository->listar();
        $imagenes_no_aceptadas= $this->obtener_no_aceptadas($imagenes);
        $this->pages->render('imagen/aceptar', ['imagenes' => $imagenes_no_aceptadas]);
    }

    // obtiene las imágenes que no se han aceptado
    public function obtener_no_aceptadas($imagenes): array {
        $objetos_imagenes= $this->obtener_objetos($imagenes);

        $objetos_no_aceptados= [];
        foreach ($objetos_imagenes as $imagen) {
            if ($imagen->getAceptada() == FALSE) { 
                array_push($objetos_no_aceptados, $imagen);
            }
        }
        return $objetos_no_aceptados;
    }

    // acepta la imagen seleccionada(la publica)
    public function aceptar(): void {
        $imagen= $_POST['id_imagen_a_aceptar'];
        $this->repository->aceptar($imagen);
        $this->listar_para_aceptar();
    }

    // descarta la imagen seleccionada (la elimina)
    public function descartar(): void {
        $imagen= $_POST['id_imagen_a_descartar'];
        $this->repository->borrar($imagen);
        $this->listar_para_aceptar();
    }

    // recoge los viajes disponibles para seleccionar en cuál subir la imagen y lleva al formulario
    public function crear(): void {
        $viajes_disponibles= $this->obtener_viajes_disponibles();
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->pages->render('imagen/crear', ['viajes' => $viajes_disponibles]);
        }
    }

    // guarda la imagen que ha publicado el admin con los datos recogidos, comprobando que las fechas encajen con el mismo
    public function guardar_admin(): void {
        $viajes_disponibles= $this->obtener_viajes_disponibles();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos= $_POST['data'];
            $fecha_correcta= $this->comprobar_fecha_viaje($datos['viaje'], $datos['fecha']);

            if ($fecha_correcta) {
                Utils::deleteSession('err_fec');
                
                // aquí ya se guarda porque está todo correcto
                if ($this->gestionar_foto($_FILES['imagen'])) {
                    $nombre_foto= $_FILES['imagen']['name'];
                    if (isset($_SESSION['admin'])) {
                        $admin= "admin";
                    }
                    else { $admin= ""; }
                    $guardado= $this->repository->guardar($datos, $nombre_foto, $admin);       
                    if ($guardado) {
                        $_SESSION['imagen_creada']= true;
                        $this->borrar_sesiones();
                        header("Location: ". $_ENV['BASE_URL']."administrar");
                    }    
                    else {
                        $_SESSION['imagen_creada']= false;
                    }
                }
            }
            else {
                $_SESSION['err_fec']= '*La fecha no se corresponde con la del viaje';
            }
            $this->pages->render('imagen/crear', ['viajes' => $viajes_disponibles]);
        }
    }

    // publica la imagen en el viaje al que asistió el usuario, con los datos introducidos por el mismo, comprobando las fehcas 
    public function subir_imagen(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->pages->render('imagen/subir');
        }
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id_viaje_a_imagen'])) {
                $id_viaje= $_POST['id_viaje_a_imagen'];
                $_SESSION['id_viaje_a_imagen']= $id_viaje;

                //obtenemos las fechas del viaje
                $_SESSION['fechas']= $this->repository->obtener_fechas_viaje($id_viaje);

                $this->pages->render('imagen/subir');
            }

            if (isset($_POST['data'])) {
                $datos= $_POST['data'];
                $datos['viaje']= $_SESSION['id_viaje_a_imagen'];

                $fecha_correcta= $this->comprobar_fecha_viaje($datos['viaje'], $datos['fecha']);

                if ($fecha_correcta) {
                    Utils::deleteSession('err_fec');

                    if ($this->gestionar_foto($_FILES['imagen'])) {
                        $nombre_foto= $_FILES['imagen']['name'];

                        $id_usuario= $this->repository->getId_usuario($_SESSION['usuario']);

                        $guardado= $this->repository->guardar($datos, $nombre_foto, $id_usuario);  

                        if ($guardado) {
                            $_SESSION['imagen_creada']= true;
                            // borra las sesiones de errores y los datos del viaje guardado
                            $this->borrar_sesiones();
                            $this->borrar_datos_post();
                            header("Location: ". $_ENV['BASE_URL']."misviajes");
                        }  
                        else {
                            $_SESSION['imagen_creada']= false;
                        }
                    }  
                }  
                else {
                    $_SESSION['err_fec']= '*La fecha no se corresponde con la del viaje';
                }
                $this->pages->render('imagen/subir');
            }
        }
    }

    public function borrar_filtros(): void {
        // borramos campos de texto y número
        $this->borrar_datos_post();
        // borramos los valores de los select
        Utils::deleteSession('data_tipo');
        Utils::deleteSession('data_fecha');
                
        header("Location: ". $_ENV['BASE_URL']."galeria");
    }

    // borra las sesiones de error al crear la imagen 
    public function borrar_sesiones(): void {
        Utils::deleteSession('err_img');
        Utils::deleteSession('data_tipo');
        Utils::deleteSession('data_viaje');
        Utils::deleteSession('data_fecha');
    }

    // borra los datos de la imagen guardada
    public function borrar_datos_post(): void {
        if (isset($_POST['data'])) {
            unset($_POST['data']);
        }
    }


    // obtiene los viajes disponibles para publicar imágenes
    public function obtener_viajes_disponibles(): array {
        $lista_viajes= $this->repository->obtener_viajes_disponibles();
        // convertimos los viajes obtenidos en objetos de la clase Viaje
        $objetos_viajes= $this->repository->obtener_objetos_viajes($lista_viajes);
        
        return $objetos_viajes;
    }

    // comprueba que la fecha del viaje sea correcta
    public function comprobar_fecha_viaje($id_viaje, $fecha): bool {
        $fechas= $this->repository->obtener_fechas_viaje($id_viaje);

        if ($fecha >= $fechas['inicio'] && $fecha <= $fechas['fin']) {
            return true;
        }
        else {
            return false;
        }
    }

    // guarda la foto subida, si hay alguna introducida, o devuelve el error producido
    public function gestionar_foto($foto): bool {
        $nom_foto= $foto['name'];            
        $temp_foto= $foto['tmp_name'];
        $preruta= './fuente/media/images/galeria';
        $ruta_foto= $preruta.'/'.$nom_foto;

        // si no existe la carpeta, la crea
        if (!is_dir($preruta)){
            mkdir($preruta, '0777');
        }

        //si hay un fichero seleccionado, lo sube
        if (is_uploaded_file($temp_foto)) {
            move_uploaded_file($temp_foto, $ruta_foto);
            return true;
        }
        else {
            $_SESSION['err_img']= "* La imagen es obligatoria";
            return false;
        }
    }

    // obtiene las imágenes que ha publicado el usuario
    public function obtener_imagenes_usuario($id): array {
        return $this->repository->obtener_imagenes_usuario($id);
    }

    // borra las imágenes pertenecientes al viaje indicado
    public function borrar_por_viaje($id_viaje): bool {
        return $this->repository->borrar_por_viaje($id_viaje);
    }

}

?>