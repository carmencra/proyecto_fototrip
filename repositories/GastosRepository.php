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

    public function guardar($id_viaje, $gastos): bool {
        $ins= $this->db->prepara("INSERT INTO gastos values(:id_viaje, :comida, :alojamiento, :vuelos, :transportes, :seguro, :gastos)");

        $ins->bindParam(':id_viaje', $id_viaje, PDO::PARAM_STR);
        $ins->bindParam(':comida', $gastos['comida'], PDO::PARAM_STR);
        $ins->bindParam(':alojamiento', $gastos['alojamiento'], PDO::PARAM_STR);
        $ins->bindParam(':vuelos', $gastos['vuelos'], PDO::PARAM_STR);
        $ins->bindParam(':transportes', $gastos['transportes'], PDO::PARAM_STR);
        $ins->bindParam(':seguro', $gastos['seguro'], PDO::PARAM_STR);
        $ins->bindParam(':gastos', $gastos['gastos'], PDO::PARAM_STR);

        try {
            return true;
        }
        catch(PDOException $err) {
            return false;
        }
        finally {
            $ins= null;
            unset($ins); 
        }
    }

}

?>
