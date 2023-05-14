<?php

namespace Repositories;
use Lib\BaseDatos;
use Models\Viaje;
use PDO;
use PDOException;

class ViajeRepository {
    private BaseDatos $db;

    public function __construct() {
        $this->db= new BaseDatos();
    }

    public function listar(): ?array {
        $this->db->consulta("SELECT * FROM viajes");
        return $this->db->extraer_todos();
    }

    public function pasar_objeto($array): object {
        $objeto_viaje= Viaje::fromArray($array);
        return $objeto_viaje;
    }

    public function obtener_duracion($viaje): bool | int {
        $cons= $this->db->prepara("SELECT TIMESTAMPDIFF (DAY, fecha_inicio, fecha_fin) as diferencia FROM viajes WHERE id= :id");

        $cons->bindParam(':id', $id);

        $id= $viaje->getId();

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                $diferencia= $cons->fetch()["diferencia"];
                $result = $diferencia + 1; //al ser la diferencia, no incluye el mismo día
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

        

}

?>
