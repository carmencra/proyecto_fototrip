<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Itinerario;
use PDO;
use PDOException;

class ItinerarioRepository {
    private BaseDatos $db;

    function __construct() {
        $this->db= new BaseDatos();
    }

    public function listar($id_viaje): ?array {
        $this->db->consulta("SELECT * FROM itinerario WHERE id_viaje= $id_viaje");
        return $this->db->extraer_todos();
    }
    
    public function pasar_objeto($array): object {
        $objeto_itinerario= Itinerario::fromArray($array);
        return $objeto_itinerario;
    }

}

?>
