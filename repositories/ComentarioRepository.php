<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Comentario;
use PDO;
use PDOException;

class ComentarioRepository {
    private BaseDatos $db;

    function __construct($db) {
        $this->db= $db;
    }
    public function listar(): ?array {
        $this->db->consulta("SELECT * FROM comentarios");
        return $this->db->extraer_todos();
    }

    public function pasar_objeto($array): object {
        $objeto_coment= Comentario::fromArray($array);
        return $objeto_coment;
    }

    public function obtener_nombre_viaje($id_viaje): bool | string {
        $cons= $this->db->prepara("SELECT pais FROM viajes WHERE id=:id_viaje");

        $cons->bindParam(':id_viaje', $id_viaje);

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                return $cons->fetch()["pais"];
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

    public function obtener_nombre_usuario($email): bool | string {
        $cons= $this->db->prepara("SELECT nombre FROM usuarios WHERE email=:email");

        $cons->bindParam(':email', $email);

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                return $cons->fetch()["nombre"];
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

    public function obtener_apellidos_usuario($email): bool | string {
        $cons= $this->db->prepara("SELECT apellidos FROM usuarios WHERE email=:email");

        $cons->bindParam(':email', $email);

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                return $cons->fetch()["apellidos"];
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

    public function obtener_comentarios($id_viaje): ?array {
        $this->db->consulta("SELECT * FROM comentarios WHERE id_viaje= $id_viaje");
        return $this->db->extraer_todos();
    }

    public function obtener_comentario($id) {
        $this->db->consulta("SELECT * FROM comentarios WHERE id= $id");
        return $this->db->extraer_registro();
    }
    
    public function borrar($id) {
        $del= $this->db->prepara("DELETE FROM comentarios WHERE id= $id");
        
        try {
            $del->execute();
            if ($del && $del->rowCount() == 1) {
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
            $del= null;
            unset($del); 
        }
    }

    public function aceptar($id) {
        $upd= $this->db->prepara("UPDATE comentarios SET aceptado = true WHERE id = $id");

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


    public function guardar($id_viaje, $email, $comentario):bool {
        $ins= $this->db->prepara("INSERT INTO comentarios values (:id, :id_viaje, :usuario, :contenido, :aceptado)");
        
        $ins->bindParam(':id', $id, PDO::PARAM_STR);
        $ins->bindParam(':id_viaje', $id_viaje, PDO::PARAM_INT);
        $ins->bindParam(':usuario', $email, PDO::PARAM_STR);
        $ins->bindParam(':contenido', $comentario, PDO::PARAM_STR);
        $ins->bindParam(':aceptado', $aceptado, PDO::PARAM_STR);

        $id= NULL; //id auto_increment
        $aceptado= FALSE; //el comentario se queda a la espera de que el admin lo apruebe

        try{
            if ($ins->execute()) {
                return true;
            }
            else {return false;}
        }
        catch(PDOException $err){
            return false;
        }
        finally {
            $ins= null;
            unset($ins); 
        }
    }

    public function obtener_comentarios_usuario($email) : ?array {
        $this->db->consulta("SELECT * FROM comentarios WHERE usuario= '$email' ORDER BY aceptado DESC");
        return $this->db->extraer_todos();
    }


}

?>
