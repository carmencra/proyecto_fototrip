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


    public function filtrar_viajes($filtros)//: bool | object 
    {
        $pais= $filtros['pais'];
        $cons= $this->db->prepara("SELECT * FROM viajes WHERE pais LIKE '%$pais%' AND precio >= :precio_min AND precio <= :precio_max AND nivel_fisico = :exigencia AND nivel_fotografia = :nivel");

        // $cons->bindParam(':pais', $filtros['pais'], PDO::PARAM_STR);
        $cons->bindParam(':precio_min', $filtros['precio_min'], PDO::PARAM_STR);
        $cons->bindParam(':precio_max', $filtros['precio_max'], PDO::PARAM_STR);
        $cons->bindParam(':exigencia', $filtros['exigencia'], PDO::PARAM_STR);
        $cons->bindParam(':nivel', $filtros['nivel'], PDO::PARAM_STR);

        $cons->execute();

        $viajes= $cons->fetchAll();
        var_dump($viajes);die();

        // try {
        //     if ($cons && $cons->rowCount() == 1) {
        //         $result= $cons->fetch(PDO::FETCH_OBJ);
        //         var_dump($result);die();
        //         return $result;
        //     }
        //     // $cons->execute();
        //     // return $this->db->extraer_todos();
        // }
        // catch(PDOEXception $err) {
        //     return false;
        // }
    }

    // esto no lo puedo hacer porque si no hay país no puede ser where and; y bueno así en bucle, si no hay algo y pongo en el siguiente and, pues como que no
    // así que npi de cómo hacer 
    // la puta consulta esta de los cojones 
    public function crear_consulta($filtros) {
        $cons= "SELECT * FROM viajes WHERE";
        if (!empty($filtros['pais'])) {
            $cons .= " pais LIKE '%$pais%";
        }

        if (!empty($filtros['precio_min'])) {
            $cons .= " AND precio >= :precio_min";
        }

        if (!empty($filtros['precio_max'])) {
            $cons .= " AND precio <= :precio_max";
        }

        if (!empty($filtros['exigencia'])) {
            $cons .= " AND nivel_fisico = :exigencia";
        }

        if (!empty($filtros['nivel'])) {
            $cons .= " AND nivel_fotografia = :nivel";
        }
    }

        

}

?>
