<?php

namespace Controllers;
use Repositories\UsuarioRepository;
use Lib\Pages;

class UsuarioController{
    private Pages $pages;
    private UsuarioRepository $repository;

    public function __construct() {
        $this->pages= new Pages();
        $this->repository= new UsuarioRepository();
    }

    public function registro() {
        $this->pages->render('usuario/registro');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos= $_POST['data'];
            
            //se cofidica la contraseña
            $datos['clave']= password_hash($datos['clave'],PASSWORD_BCRYPT,['cost'=>4]);

            if ($this->valida_campos($datos)) {
                $registro= $this->repository->registro($datos);
                
                if ($registro) {
                
                    if ($this->repository->es_admin($datos['email'])) {
                        // crear sesión de admin
                    }
                    // llevar a inicio
                }
                else {
                    // crear sesión de error de registro 
                }
            }

        }

    }

    // valida todo el formulario (vacíos, caracteres correctos...)
    public function valida_campos($datos) {
        if ($this->valida_vacios($datos)) {
            if($this->valida_por_campo($datos)) {
                return true;
            }
            else {return false;}
        }
        else {return false;}
    }

    // valida que ningún campo esté vacío, pues todos son obligatorios
    public function valida_vacios($datos) {
        if (empty($datos['nombre'])) {
           return false;
        }
        if (empty($datos['apellidos'])) {
           return false;;
        }
        if (empty($datos['email'])) {
           return false;
        }
        if (empty($datos['clave'])) {
           return false;
        }
    }


    // valida que cada campo tenga longitud y caracteres correctos
    public function valida_por_campo($datos) {
        if (!$this->valida_email($datos['email'])) {
            // crear sesión error
        }
        //  validar clave, 
        //  apellidos 
        //  y nombre 
        //  con no sé qué ahora mismo la verdad;
    }

    // valida que el email no esté ya registrado
    public function valida_email($email) {
        if (!$this->repository->busca_mail($email)) {
            return true;
        }
        else {
            return false;
        }
    }



    public function login() {
        $this->pages->render('usuario/login');
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datos= $_POST['data'];

            if ($this->valida_email_clave_vacios($datos)) {
                $usuario= $this->repository->busca_mail($datos['email']);
                
                if ($usuario !== false) {
                    $clave= $datos['clave'];
                    
                    if (this->repository->valida_clave($clave, $usuario)) {

                        if ($this->repository->es_admin($datos['email'])) {
                            // sesión de admin
                        }
                        // completar la sesión
                        // llevar a inicio
    
                    }
                    else {
                        // poner la sesión de contraseña incorrecta
                    }
                }
                else {
                    // poner la sesión de que ese correo no existe
                }
            }
            else {
                // poner sesión de campos vacío
            }

            // $this->repository->login();
        }
    }

    public function valida_email_clave_vacios($datos) {
        if (!empty($datos['email']) && !empty($datos['clave'])) {
            return true;
        }
        else {return false;}
    }
 

}


?>