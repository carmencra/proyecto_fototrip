<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Comentario;
use PDO;
use PDOException;

class ComentarioRepository {
    private BaseDatos $db;

    function __construct() {
        $this->db= new BaseDatos();
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

}

?>
