<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Usuario;
use PDO;
use PDOException;

class UsuarioRepository {
    private BaseDatos $db;

    function __construct($db) {
        $this->db= $db;
    }

    // guarda el nuevo usario registrado en la base de datos
    public function registro($datos): bool {
        $ins= $this->db->prepara("INSERT INTO usuarios values(:email, :clave, :nombre, :apellidos, :rol, :confirmado, :id)");

        $ins->bindParam(':email', $datos['email'], PDO::PARAM_STR);
        $ins->bindParam(':clave', $datos['clave'], PDO::PARAM_STR);
        $ins->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $ins->bindParam(':apellidos', $datos['apellidos'], PDO::PARAM_STR);
        $ins->bindParam(':rol', $rol, PDO::PARAM_STR);
        $ins->bindParam(':confirmado', $confirmado, PDO::PARAM_STR);
        $ins->bindParam(':id', $id, PDO::PARAM_STR);

        $rol= "usuario";
        $confirmado= false; //al crear el usuario, faltará confirmar la cuenta
        $id= NULL; //la base de datos coge el siguiente porque es un campo de auto incremento

        try{
            $ins->execute();
            return true;
        }
        catch(PDOException $err){
            return false;
        }
        finally {
            $ins= null;
            unset($ins); 
        }
    }

    // obtiene el id del usuario que se corresponde con el id pasado
    public function obtener_id($email): int | bool {
        $cons= $this->db->prepara("SELECT id FROM usuarios WHERE email=:email");

        $cons->bindParam(':email', $email);

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                $id= $cons->fetch()['id'];
                $result = $id;
            }
            else {
                $result= false;
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
        return $result;
    }

    // busca si el email ya está registrado
    public function busca_mail($email): bool | object {
        $result= false;
        $cons= $this->db->prepara("SELECT * FROM usuarios WHERE email= :email");
        $cons->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                $result= $cons->fetch(PDO::FETCH_OBJ);
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
        return $result;
    }

    // confirma la cuenta del usuario cuyo id se le pasa a la función
    public function confirma_cuenta($id): bool {
        $upd= $this->db->prepara("UPDATE usuarios set CONFIRMADO = true WHERE id = $id");

        try{
            if ($upd->execute()) {
                return true;
            }
            else {return false;}
        }
        catch(PDOException $err){
            return false;
        }
        finally {
            $upd= null;
            unset($upd); 
        }
    }

    // verifica la clave introducida con la existente en la bd
    public function valida_clave($clave, $usuario): bool {
        if ($usuario !== false) {
            $verify= password_verify($clave, $usuario->clave);
            if ($verify) {
                return true;
            }
            else {return false;}
        }
        else {return false;}
    }

    public function obtener_nombre($email): string | bool {
        $cons= $this->db->prepara("SELECT nombre FROM usuarios WHERE email=:email");

        $cons->bindParam(':email', $email);

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                $id= $cons->fetch()['nombre'];
                $result = $id;
            }
            else {
                $result= false;
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
        return $result;
    }

    // devuelve si el usuario logueado es admin o no
    public function es_admin($email): bool {
        $cons= $this->db->prepara("SELECT id FROM usuarios WHERE email= :email and rol= :rol");

        $cons->bindParam(':email', $email, PDO::PARAM_STR);
        $cons->bindParam(':rol', $rol, PDO::PARAM_STR);
        
        $rol= "admin";

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOEXception $err) {
            return false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
    }

    // devuelve si el email pasado es un usuario ya confirmado o no
    public function esta_confirmado($email): bool {
        $cons= $this->db->prepara("SELECT id FROM usuarios WHERE email= :email and confirmado= :confirmado");

        $cons->bindParam(':email', $email, PDO::PARAM_STR);
        $cons->bindParam(':confirmado', $confirmado, PDO::PARAM_STR);
        
        $confirmado= true;

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOEXception $err) {
            return false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
    }

    // obtiene los ids de los viajes a los que el usuario pasado está inscrito
    public function obtener_id_viajes_inscritos($email): ?array {
        $this->db->consulta("SELECT id_viaje FROM inscritos WHERE email= '$email'");
        return $this->db->extraer_todos();
    }

    // inscribe en el viaje pasado al usuario logueado
    public function inscribirse($id, $usuario): bool {
        $ins= $this->db->prepara("INSERT INTO inscritos VALUES ('$usuario', $id)");

        try {
            $ins->execute();
            if ($ins && $ins->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOEXception $err) {
            return false;
        }
        finally {
            $ins= null;
            unset($ins); 
        }
    }

    // comprueba si el usuario está ya inscrito al viaje pasado
    public function inscrito_a_ese_viaje($usuario, $id_viaje): bool {
        $cons= $this->db->prepara("SELECT email FROM inscritos WHERE email= :email and id_viaje= :id_viaje");

        $cons->bindParam(':email', $usuario, PDO::PARAM_STR);
        $cons->bindParam(':id_viaje', $id_viaje, PDO::PARAM_STR);
        

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOEXception $err) {
            return false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
    }
}

?>
