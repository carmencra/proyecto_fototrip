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
        $ins= $this->db->prepara("INSERT INTO usuarios values(:email, :clave, :nombre, :apellidos, :rol)");

        $ins->bindParam(':email', $datos['email'], PDO::PARAM_STR);
        $ins->bindParam(':clave', $datos['clave'], PDO::PARAM_STR);
        $ins->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $ins->bindParam(':apellidos', $datos['apellidos'], PDO::PARAM_STR);
        $ins->bindParam(':rol', $rol, PDO::PARAM_STR);
        $rol= "usuario";

        try{
            $ins->execute();
            return true;
        }
        catch(PDOException $err){
            return false;
        }
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
