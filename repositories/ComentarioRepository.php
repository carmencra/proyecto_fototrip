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
                $result= $cons->fetch()["pais"];
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }
}

?>
