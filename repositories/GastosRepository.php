<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Gastos;
use PDO;
use PDOException;

class GastosRepository {
    private BaseDatos $db;

    function __construct($db) {
        $this->db= $db;
    }

    //  obtiene los gastos que se corresponde con el viaje pasado
    public function obtener_gastos($id_viaje): array | bool {
        $this->db->consulta("SELECT * FROM gastos WHERE id_viaje= $id_viaje");
        return $this->db->extraer_registro();
    }

    // obtiene el objeto Gastos con los datos pasados
    public function pasar_objeto($array): object {
        $objeto_gastos= Gastos::fromArray($array);
        return $objeto_gastos;
    }

    // guarda los gastos pasados en el viaje pasado
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
            if ($ins->execute()) {
                return true;
            }
            else { return false; }
        }
        catch(PDOException $err) {
            return false;
        }
        finally {
            $ins= null;
            unset($ins); 
        }
    }

    // borra los gastos que se corresponden con el viaje borrado
    public function borrar_por_viaje($id_viaje): bool {
        $del= $this->db->prepara("DELETE FROM gastos WHERE id_viaje= $id_viaje");
        
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

}

?>
