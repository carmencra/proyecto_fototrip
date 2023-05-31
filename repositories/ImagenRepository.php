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

    public function mostrar(): ?array {
        $this->db->consulta("SELECT * FROM imagenes ORDER BY usuario ASC");
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
        $cons= $this->db->prepara($consulta);
        
        try {
            if ($cons->execute()) {
                $imagenes= $cons->fetchAll();

                //pasamos todas las imágenes obtenidos a objetos Imagen
                $objetos_imagen=[];
                foreach($imagenes as $datos_imagen) {
                    // cogemos el id del viaje y comprobamos que el país sea el del filtro
                    $imagen= $datos_imagen['imagen'];
                    $id_viaje= $datos_imagen['id_viaje'];
                    
        
                    $filtro_pais_correcto = $this->comprobar_pais_filtro($imagen, $id_viaje, $filtros['pais']);
        
                    if ($filtro_pais_correcto) {
                        $obj_imagen= Imagen::fromArray($datos_imagen);
                        array_push($objetos_imagen, $obj_imagen);
                    }
                    
                }
                return $objetos_imagen;
            }
            else {
                return false;
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
            // el país no lo controlo porque lo hago en otra función aparte, ya que es una consulta externa al viaje de la imagen
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
        $cons= "SELECT * FROM imagenes ";
 
        foreach ($filtros_limpios as $filtro => $valor){
            if($filtro !== array_key_first($filtros_limpios)) { //si no es la primera posición añade el and a la consulta
            }    

            switch ($filtro) {
                case "tipo":
                    $cons .= " WHERE tipo = '$valor'";
                    break;
                case "fecha":
                    if ($valor == "recientes") {
                        $cons .= " ORDER BY fecha DESC";
                    }
                    if ($valor == "antiguas") {
                        $cons .= " ORDER BY fecha ASC";
                    }
            }
        }
        return $cons;
    }

    // comprueba que existe una imagen con el nombre e id_viaje, que se corresponde con el país filtrado
    public function comprobar_pais_filtro($imagen, $id_viaje, $pais) {
        $consulta= "SELECT *
        FROM imagenes
        JOIN viajes ON imagenes.id_viaje = viajes.id
        WHERE imagenes.id_viaje = $id_viaje 
        AND imagenes.imagen = '$imagen'
        AND viajes.pais LIKE '%$pais%'"; 

        $cons= $this->db->prepara($consulta);
        
        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                $result= true;
            }
            else {
                $result= false;
            }
        }
        catch(PDOEXception $err) {
            $result= false;
        }
        return $result;
    }

    public function obtener_imagenes($id_viaje): ?array {
        $this->db->consulta("SELECT * FROM imagenes WHERE id_viaje= $id_viaje");
        return $this->db->extraer_todos();
    }

    public function obtener_imagen($imagen) {
        $this->db->consulta("SELECT * FROM imagense WHERE imagen= $imagen");
        return $this->db->extraer_registro();
    }
    
    public function borrar($imagen) {
        $del= $this->db->prepara("DELETE FROM imagenes WHERE imagen= '$imagen'");
        
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
    }

    public function aceptar($imagen) {
        $upd= $this->db->prepara("UPDATE imagenes SET aceptada = true WHERE imagen = '$imagen'");

        try{
            if ($upd->execute()) {
                return true;
            }
            else {return false;}
        }
        catch(PDOException $err){
            return false;
        }
    }
    
}

?>
