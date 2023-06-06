<?php

namespace Repositories;
use Lib\BaseDatos;
use Models\Viaje;
use PDO;
use PDOException;

class ViajeRepository {
    private BaseDatos $db;

    public function __construct($db) {
        $this->db= $db;
    }

    public function listar(): ?array {
        $this->db->consulta("SELECT * FROM viajes");
        return $this->db->extraer_todos();
    }

    public function pasar_objeto($array): object {
        $objeto_viaje= Viaje::fromArray($array);
        return $objeto_viaje;
    }

    // obtiene la duración de cada viaje, cogiendo la diferencia entre la fecha de inicio y de fin (y sumándole uno para incluir el mismo día inicial)
    public function obtener_duracion($viaje): bool | int {
        $cons= $this->db->prepara("SELECT TIMESTAMPDIFF (DAY, fecha_inicio, fecha_fin) as diferencia FROM viajes WHERE id= :id");

        $cons->bindParam(':id', $id);

        $id= $viaje->getId();

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                $diferencia= $cons->fetch()["diferencia"];
                return $diferencia + 1; //al ser la diferencia, no incluye el mismo día
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

    // devuelve los viajes encajan con los filtros de búsqueda introducidos
    public function filtrar_viajes($filtros): bool | array {
        $limpios= $this->limpia_filtros($filtros);
        $consulta= $this->crea_consulta($limpios);

        $cons= $this->db->prepara($consulta);
        $cons->execute();

        $viajes= $cons->fetchAll();

        //pasamos todos los viajes obtenidos a objetos Viaje
        $objetos_viaje=[];
        foreach($viajes as $datos_viaje) {
            $obj_viaje= Viaje::fromArray($datos_viaje);
            array_push($objetos_viaje, $obj_viaje);
        }

        try{
            if ($cons->execute()) {
                return $objetos_viaje;
            }
        }
        catch(PDOException $err){
            return false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
    }

    // elimina de los filtros todos aquellos que no estén rellenos
    public function limpia_filtros($filtros): array {
        $filtros_limpios= [];
        foreach ($filtros as $filtro => $valor) {
            if (!empty($valor) && $filtro != "exigencia" && $filtro != "nivel") {
                $filtros_limpios[$filtro]= $valor;
            }            
            if ($filtro == "exigencia" || $filtro == "nivel") {
                if ($valor != "indiferente") {
                    $filtros_limpios[$filtro]= $valor;
                }
            }
        }
        return $filtros_limpios;
    }

    // crea la consulta dependiendo de los filtros que haya rellenos
    public function crea_consulta($filtros_limpios): string {
        // si no hay ningún filtro, devuelve todos los viajes
        if (empty($filtros_limpios)) {
            $cons= "SELECT * FROM viajes";
        }
        // si hay filtros, añade las condiciones de estos
        else {
            $cons= "SELECT * FROM viajes WHERE ";
        }

        foreach ($filtros_limpios as $filtro => $valor){
            if($filtro !== array_key_first($filtros_limpios)) { //si no es la primera posición añade el and a la consulta
                $cons .= " AND ";
            }    

            switch ($filtro) {
                case "pais":
                    $cons .= "pais LIKE '%$valor%'";
                    break;
                case "precio_min":
                    $cons .= "precio >= '$valor'";
                    break;
                case "precio_max":
                    $cons .= "precio <= '$valor'";
                    break;
                case "exigencia":
                    $cons .= "nivel_fisico = '$valor'";
                    break;
                case "nivel":
                    $cons .= "nivel_fotografia = '$valor'";
                    break;
            }
        }
        return $cons;
    }

    public function obtener_viaje($id) {
        $this->db->consulta("SELECT * FROM viajes WHERE id= $id");
        return $this->db->extraer_registro();
    }
    
    public function borrar($id) {
        $del= $this->db->prepara("DELETE FROM viajes WHERE id= $id");
        
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

    public function inscribirse($id, $usuario): bool {
        $ins= $this->db->prepara("INSERT INTO inscritos VALUES ($id, '$usuario')");

        try {
            $ins->execute();
            if ($ins && $ins->rowCount() == 1) {
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
            $ins= null;
            unset($ins); 
        }
    }

    public function guardar($datos, $imagen): bool {
        $ins= $this->db->prepara("INSERT INTO viajes values(:id, :pais, :fecha_inicio, :fecha_fin, :precio, :descripcion, :nivel_fotografia, :nivel_fisico, :activo, :imagen_principal, :informacion)");

        $ins->bindParam(':id', $id, PDO::PARAM_STR);
        $ins->bindParam(':pais', $datos['pais'], PDO::PARAM_STR);
        $ins->bindParam(':fecha_inicio', $datos['fecha_inicio'], PDO::PARAM_STR);
        $ins->bindParam(':fecha_fin', $datos['fecha_fin'], PDO::PARAM_STR);
        $ins->bindParam(':precio', $datos['precio'], PDO::PARAM_STR);
        $ins->bindParam(':descripcion', $datos['descripcion'], PDO::PARAM_STR);
        $ins->bindParam(':nivel_fotografia', $datos['nivel'], PDO::PARAM_STR);
        $ins->bindParam(':nivel_fisico', $datos['exigencia'], PDO::PARAM_STR);
        $ins->bindParam(':activo', $activo, PDO::PARAM_STR);
        $ins->bindParam(':imagen_principal', $imagen, PDO::PARAM_STR);
        $ins->bindParam(':informacion', $datos['informacion'], PDO::PARAM_STR);

        $id= NULL; //la base de datos coge el siguiente porque es un campo de auto incremento
        $activo= TRUE; 

        try {
            $ins->execute();
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

    public function obtener_id_ultimo_viaje() {
        $cons= $this->db->prepara("SELECT MAX(id) FROM viajes");

        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                return $cons->fetch()["MAX(id)"];
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


}

?>
