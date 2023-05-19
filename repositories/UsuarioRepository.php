<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Usuario;
use PDO;
use PDOException;

class UsuarioRepository {
    private BaseDatos $db;

    function __construct() {
        $this->db= new BaseDatos();
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
        $confirmado= 0; //al crear el usuario, faltará confirmar la cuenta
        $id= NULL; //la base de datos coge el siguiente porque es un campo de auto incremento

        try{
            $ins->execute();
            return true;
        }
        catch(PDOException $err){
            return false;
        }
    }

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
                var_dump("a");die();
                $result= false;
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    public function busca_mail($email): bool | object {
        $result= false;
        $sql= $this->db->prepara("SELECT * FROM usuarios WHERE email= :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);

        try {
            $sql->execute();
            if ($sql && $sql->rowCount() == 1) {
                $result= $sql->fetch(PDO::FETCH_OBJ);
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    public function confirma_cuenta($id) {
        $upd= $this->db->prepara("UPDATE usuarios set CONFIRMADO = 1 WHERE id = :id");

        $upd->bindParam(':id', $id, PDO::PARAM_BOOL);

        try{
            $upd->execute();
            return true;
        }
        catch(PDOException $err){
            return false;
        }

    }

    public function valida_clave($clave, $usuario): bool {
        $result= false;

        if ($usuario !== false) {
            $verify= password_verify($clave, $usuario->clave);
            $result= true;
        }
        return $result;
    }

    public function es_admin($email) {
        $sql= $this->db->prepara("SELECT * FROM usuarios WHERE email= :email and rol= :rol");

        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':rol', $rol, PDO::PARAM_STR);
        
        $rol= "admin";

        try {
            $sql->execute();
            if ($sql && $sql->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOEXception $err) {
            return false;
        }
    }
}

?>
