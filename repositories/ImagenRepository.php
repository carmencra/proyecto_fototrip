<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Imagen;
use PDO;
use PDOException;

class ImagenRepository {
    private BaseDatos $db;

    function __construct() {
        $this->db= new BaseDatos();
    }

    public function listar(): ?array {
        $this->db->consulta("SELECT * FROM imagenes");
        return $this->db->extraer_todos();
    }

    public function pasar_objeto($array): object {
        $objeto_imagen= Imagen::fromArray($array);
        return $objeto_imagen;
    }

    public function obtener_pais_viaje($id_viaje): string | bool {
        $cons= $this->db->prepara("SELECT pais FROM viajes WHERE id=:id_viaje");

        $cons->bindParam(':id_viaje', $id_viaje);

        $cons->execute();

        $datos= $cons->fetchAll();

        try {
            $cons->execute();
            return $datos[0]['pais'];
        }
        catch(PDOEXception $err) {
            return false;
        }
    }


    // devuelve las imágenes que encajan con los filtros de búsqueda introducidos   
    public function filtrar_imagenes($filtros): bool | array {
        $limpios= $this->limpia_filtros($filtros);
        $consulta= $this->crea_consulta($limpios);
        
        var_dump($consulta);die();
        $cons= $this->db->prepara($consulta);
        $cons->execute();

        $imagenes= $cons->fetchAll();

        //pasamos todas las imágenes obtenidos a objetos Imagen
        $objetos_imagen=[];
        foreach($imagenes as $datos_imagen) {
            $obj_imagen= Imagen::fromArray($datos_imagen);
            array_push($objetos_imagen, $obj_imagen);
        }

        try{
            if ($cons->execute()) {
                return $objetos_imagen;
            }
        }
        catch(PDOException $err){
            return false;
        }
    }

    
    // elimina de los filtros todos aquellos que no estén rellenos o sean indiferentes, por lo que no suponen ninguna condición añadida
    public function limpia_filtros($filtros): array {
        $filtros_limpios= [];

        foreach ($filtros as $filtro => $valor) {
            // si el país está vacío, no lo añade
            if ($filtro == "pais" && !empty($valor)) {
                $filtros_limpios[$filtro]= $valor;
            }

            // si el tipo o la fecha son indiferentes, no los añade
            if ($filtro == "tipo" || $filtro == "fecha") {
                if ($valor != "indiferente") {
                    $filtros_limpios[$filtro]= $valor;
                }
            }
        }
        return $filtros_limpios;
    }

    
    // crea la consulta dependiendo de los filtros que haya rellenos
    public function crea_consulta($filtros_limpios): string {
        // si no hay ningún filtro, devuelve todas las imágenes
        if (empty($filtros_limpios)) {
            $cons= "SELECT * FROM imagenes";
        }
        // si hay filtros, añade las condiciones de estos
        else {
            $cons= "SELECT * FROM imagenes WHERE ";
        }
 
        foreach ($filtros_limpios as $filtro => $valor){
            if($filtro !== array_key_first($filtros_limpios)) { //si no es la primera posición añade el and a la consulta
                if ($filtro !== "fecha")
                // además, la fecha será distinta porque es una ordenación, no una condición añadida
                $cons .= " AND ";
            }    

            switch ($filtro) {
                case "pais":
                    $cons .= "pais LIKE '%$valor%'";
                    break;
                case "tipo":
                    $cons .= "tipo = '$valor'";
                    break;
                case "fecha":
                    if ($valor= "recientes") {
                        $cons .= " ORDER BY fecha DESC";
                        break;
                    }
                    else if ($valor= "antiguas") {
                        $cons .= " ORDER BY fecha ASC";
                    }
            }
        }
        return $cons;
    }

}

?>
