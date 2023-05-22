<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Gastos;
use PDO;
use PDOException;

class GastosRepository {
    private BaseDatos $db;

    function __construct() {
        $this->db= new BaseDatos();
    }

    public function obtener_gastos($id_viaje): array | bool {
        $this->db->consulta("SELECT * FROM gastos WHERE id_viaje= $id_viaje");
        return $this->db->extraer_registro();
    }

    public function pasar_objeto($array): object {
        $objeto_gastos= Gastos::fromArray($array);
        return $objeto_gastos;
    }

}

?>
