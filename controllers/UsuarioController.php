<?php

namespace Controllers;
use Repositories\UsuarioRepository;
use Lib\Pages;
use Lib\Email;
use Utils\Utils;
use Models\Viaje;

class UsuarioController{
    private Pages $pages;
    private UsuarioRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new UsuarioRepository();
    }

    public function registrarse() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //borramos las sesiones de errores para que no haya anteriores
            $this->borra_sesiones_errores();
            $this->pages->render('usuario/registrarse');
        }
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //borramos las sesiones de errores para que no haya anteriores
            $this->borra_sesiones_errores();
            $this->pages->render('usuario/registrarse');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //cada vez que se le da a registrarse, borramos las antiguas sesiones de errores
            $this->borra_sesiones_errores();
            $datos= $_POST['data'];

            if ($this->valida_campos($datos)) {
                //se cofidica la contraseña
                $datos['clave']= password_hash($datos['clave'],PASSWORD_BCRYPT,['cost'=>4]);

                $registro= $this->repository->registro($datos);
                
                if ($registro) {
                    $correo= new Email($datos['email']);
                    $id_correo= $this->repository->obtener_id($datos['email']);
                    $correo->enviar_confirmacion($id_correo);
                    $_SESSION['id_a_confirmar']= $id_correo;
                    $_SESSION['correo_a_confirmar']= $datos['email'];
                    // $this->pages->render('email/enviado', ['email' => $datos['email']]);
                    
                    header("Location: ". $_ENV['BASE_URL'].'email_enviado');
                }
                else {
                    $this->pages->render('usuario/registrarse');
                    $_SESSION['err_reg']= true;
                }
            }
            else {
                $this->pages->render('usuario/registrarse');
            }

        }

    }

    public function llevar_email_enviado() {
        $this->pages->render('email/enviado');
    }

    // confirma la cuenta del usuario tras clicar en el enlace del correo enviado
    public function confirmar_cuenta($id): none | bool {
        $confirmado= $this->repository->confirma_cuenta($id);

        if ($confirmado) {
            $_SESSION['usuario']= $_SESSION['correo_a_confirmar'];

            // borramos sesiones de errores y redireccionamos al inicio
            $this->borra_sesiones_errores();
            Utils::deleteSession('correo_a_confirmar');
            Utils::deleteSession('id_a_confirmar');

            header("Location: ". $_ENV['BASE_URL']);
            // return true;
        }
        else {
            return false;
        }
    }    
    

    // borra las sesiones de errores del registro
    public function borra_sesiones_errores() {
        Utils::deleteSession('err_reg');
        Utils::deleteSession('err_nom');
        Utils::deleteSession('err_cla');
        Utils::deleteSession('err_ema');
        Utils::deleteSession('err_ape');
        Utils::deleteSession('err_log');
    }

    // valida todo el formulario (vacíos, caracteres correctos...)
    public function valida_campos($datos): bool {
        if ($this->valida_vacios($datos)) {
            if($this->valida_por_campo($datos)) {
                return true;
            }
            else {
                return false;}
        }
        else {
            return false;
        }
    }

    // valida que ningún campo esté vacío, pues todos son obligatorios
    public function valida_vacios($datos): bool {
        $result= false;
        if (empty($datos['nombre'])) {
            $_SESSION['err_nom']= "*El nombre debe estar relleno";
            $result= false;
        }
        if (empty($datos['apellidos'])) {
            $_SESSION['err_ape']= "*Los apellidos deben estar rellenos";
            $result= false;;
        }
        if (empty($datos['email'])) {
            $_SESSION['err_ema']= "*El email debe estar relleno";
            $result= false;
        }
        if (empty($datos['clave'])) {
            $_SESSION['err_cla']= "*La clave debe estar rellena";
            $result= false;
        }
        else {
            $result= true;
        }
        return $result;
    }


    // valida que cada campo tenga longitud y caracteres correctos
    public function valida_por_campo($datos): bool {
        $email_validado= $this->valida_email($datos['email']);
        $clave_validado= $this->valida_clave($datos['clave']);
        $nombre_validado= $this->valida_nombre($datos['nombre']);
        $apellidos_validado= $this->valida_apellidos($datos['apellidos']);

        // var_dump($datos['nombre'], $nombre_validado);
        // var_dump($datos['apellidos'], $apellidos_validado);
        // die();

        if ($email_validado && $clave_validado && $nombre_validado && $apellidos_validado) {
            return true;
        }
        else {
            return false;
        }
    }

    // valida que el email no esté ya registrado
    public function valida_email($email): bool {
        if (!$this->repository->busca_mail($email)) {
            return true;
        }
        else {
            $_SESSION['err_ema']= "*El email ya está registrado";
            return false;
        }
    }

    // valida longitud de contraseña
    public function valida_clave($clave): bool {
        if(strlen($clave) >= 8 && strlen($clave) <= 20) {
            // se crea un pattern que requiera al menos uno de cada: mayúscula, minúscula (incluyendo ñ), número, caracter especial
            // para incuir al carácter especial, descartamos números (d), letras (p{L};  incluyen ñ y tildes) y espacios en blanco
            $pattern= "/^(?=.*[A-ZÑ])(?=.*[a-zñ])(?=.*[0-9])(?=.*[^\p{L}\d\s]).*$/u";
            if (preg_match($pattern, $clave)) {
                return true;
            }
            else {
                $_SESSION['err_cla']= "*La contraseña debe tener minúscula, mayúscula, número y carácter especial";
                return false;
            }
        }
        else {
            if(strlen($clave) < 8) {
                $_SESSION['err_cla']= "*La clave debe tener más de 7 caracteres";
                return false;
            }
            if (strlen($clave) > 20) {
                $_SESSION['err_cla']= "*La clave debe tener menos de 21 caracteres";
                return false;
            }
        }
    }

    public function valida_nombre($nombre): bool {
        // si la longitud es correcta, comprueba los caracteres introducidos
        if (strlen($nombre) >= 3 && strlen($nombre) <= 15) {
            // $pattern= "([a-zñáóíúéA-ZÑÁÉÍÓÚ])+([\s][a-zñáóíúéA-ZÑÁÉÍÓÚ]+)*";
            $pattern = "/^[a-zñáóíúéA-ZÑÁÉÍÓÚ]+(\s[a-zñáóíúéA-ZÑÁÉÍÓÚ]+)*$/";
            if (!preg_match($pattern, $nombre)) {
                $_SESSION['err_nom']= "*El nombre sólo puede contener letras y espacios";
                return false;
            }
            else {
                return true;
            }
        }
        else {
            if (strlen($nombre) < 3) {
                $_SESSION['err_nom']= "*El nombre debe tener más de 2 caracteres";
                return false;
            }
            if (strlen($nombre) > 15) {
                $_SESSION['err_nom']= "*El nombre debe tener menos de 16 caracteres";
                return false;   
            }
        }
    }

    public function valida_apellidos($apellidos): bool {
        // si la longitud es correcta, comprueba los caracteres introducidos
        if (strlen($apellidos) >= 3 && strlen($apellidos) <= 25) {
            // // $pattern= "([a-zñáóíúéA-ZÑÁÉÍÓÚ])+([\s][a-zñáóíúéA-ZÑÁÉÍÓÚ]+)*";
            $pattern = "/^[a-zñáóíúéA-ZÑÁÉÍÓÚ]+(\s[a-zñáóíúéA-ZÑÁÉÍÓÚ]+)*$/";
            if (!preg_match($pattern, $apellidos)) {
                $_SESSION['err_ape']= "*Los apellidos sólo pueden contener letras y espacios";
                return false;   
            } 
            else {
                return true;
            }
        }
        else {
            if (strlen($apellidos) < 3) {
                $_SESSION['err_ape']= "*Los apellidos deben tener más de 2 caracteres";                
                return false;   
            }
            if (strlen($apellidos) > 25) {   
                $_SESSION['err_ape']= "*Los apellidos deben tener menos de 26 caracteres";
                return false;   
            }
        }
    }



    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //borramos las sesiones de errores para que no haya anteriores
            $this->borra_sesiones_errores();
            $this->pages->render('usuario/registrarse');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            //cada vez que se le da a loguearse, borramos las antiguas sesiones de errores
            $this->borra_sesiones_errores();
            $datos= $_POST['data'];

            if ($this->valida_email_clave_vacios($datos)) {
                $usuario= $this->repository->busca_mail($datos['email']);
                
                if ($usuario !== false) {
                    $clave= $datos['clave'];
                    
                    // comprueba que la contraseña del usuario es correcta
                    if ($this->repository->valida_clave($clave, $usuario)) {
                        // si está confirmado, podrá iniciar sesión
                        if ($this->repository->esta_confirmado($datos['email'])) {
                            $_SESSION['usuario']= $datos['email'];
                            // se comprueba si es admin
                            if ($this->repository->es_admin($datos['email'])) {
                                $_SESSION['admin']= true;
                                header("Location: ". $_ENV['BASE_URL'].'administrar');
                            
                            }
                            else {
                                header("Location: ". $_ENV['BASE_URL']);
                            }
                        }
                        else {
                            $_SESSION['err_log']= true;
                            $this->pages->render('usuario/registrarse');
                        }

                    }
                    else {
                        $_SESSION['err_cla']= "*Contraseña incorrecta";
                        $this->pages->render('usuario/registrarse');
                    }
                }
                else {
                    $_SESSION['err_ema']= "*Ese correo no está registrado";
                    $this->pages->render('usuario/registrarse');
                }
            }
            else {                
                $this->pages->render('usuario/registrarse');
            }
        }
    }

    // valida que ni el email ni la clave estén vacíos
    public function valida_email_clave_vacios($datos): bool {
        if (!empty($datos['email']) && !empty($datos['clave'])) {
            return true;
        }
        else {
            if (empty($datos['email'])) {
                $_SESSION['err_ema']= "*El email debe estar relleno";
            }
            if (empty($datos['clave'])) {
                $_SESSION['err_cla']= "*La clave debe estar rellena";
            }
            return false;
        }
    }


    //cierra la sesión del usuario logueado
    public function cerrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            session_destroy();
            // Utils::deleteSession('usuario');
            header("Location: ". $_ENV['BASE_URL']);
        }
    }


    // lleva al índice de administrar (solo para el admin de la página)
    public function administrar() {
        $this->pages->render('usuario/administrar');
    }

    public function mis_viajes() {   
        $viajes= $this->obtener_viajes($_SESSION['usuario']); 
        
        $this->pages->render('usuario/mis_viajes', ['viajes' => $viajes]);
    }

    public function obtener_viajes($email): ?array {
        $id_viajes= $this->repository->obtener_id_viajes_inscritos($_SESSION['usuario']);  

        $viajes= [];
        foreach($id_viajes as $id) {
            $viaje= $this->repository->obtener_viaje($id['id_viaje']);
            $objeto_viaje= Viaje::fromArray($viaje);
            array_push($viajes, $objeto_viaje);
        }
        return $viajes;
    }
 

}


?>