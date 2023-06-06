<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Imagen;
use Models\Viaje;
use PDO;
use PDOException;

class ImagenRepository {
    private BaseDatos $db;

    function __construct($db) {
        $this->db= $db;
    }

    public function listar(): ?array {
        $this->db->consulta("SELECT * FROM imagenes");
        return $this->db->extraer_todos();
    }

    public function mostrar(): ?array {
        $this->db->consulta("SELECT * FROM imagenes ORDER BY id_usuario ASC");
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
        finally {
            $cons= null;
            unset($cons); 
        }
    }
    
    public function obtener_usuario($id_usuario):string | bool {
        $cons= $this->db->prepara("SELECT nombre, apellidos FROM usuarios WHERE id=:id_usuario");

        $cons->bindParam(':id_usuario', $id_usuario);

        $cons->execute();

        $datos= $cons->fetchAll();

        try {
            $cons->execute();
            return $datos[0]['nombre']. " ". $datos[0]['apellidos'];
        }
        catch(PDOEXception $err) {
            return false;
        }
        finally {
            $cons= null;
            unset($cons); 
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
        finally {
            $cons= null;
            unset($cons); 
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
        $consulta= "SELECT * FROM imagenes
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
        finally {
            $cons= null;
            unset($cons); 
        }
        return $result;
    }

    public function obtener_imagenes($id_viaje): ?array {
        $this->db->consulta("SELECT * FROM imagenes WHERE id_viaje= $id_viaje");
        return $this->db->extraer_todos();
    }
    
    public function borrar($id) {
        $del= $this->db->prepara("DELETE FROM imagenes WHERE id = $id");

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

    public function aceptar($id) {
        $upd= $this->db->prepara("UPDATE imagenes SET aceptada = true WHERE id = $id");

        try{
            if ($upd->execute()) {
                return true;
            }
            else {return false;}
        }
        catch(PDOException $err){
            return false;
        }
        finally {
            $upd= null;
            unset($upd); 
        }
    }

    public function obtener_viajes_disponibles(): ?array {
        $this->db->consulta("SELECT * FROM viajes WHERE activo= true");
        return $this->db->extraer_todos();
    }

    public function obtener_objetos_viajes($array): array {
        $objetos_viajes= [];
        foreach ($array as $viaje) {
            $objeto= Viaje::fromArray($viaje);
            array_push($objetos_viajes, $objeto);
        }
        return $objetos_viajes;
    }

    public function obtener_fechas_viaje($id_viaje) {
        $cons= $this->db->prepara("SELECT fecha_inicio, fecha_fin FROM viajes WHERE id=:id_viaje");

        $cons->bindParam(':id_viaje', $id_viaje);

        try {
            $cons->execute();
            $datos= $cons->fetchAll();

            $fechas=  array(
                "inicio" => $datos[0]['fecha_inicio'],
                "fin" => $datos[0]['fecha_fin']
            );
            return $fechas;
        }
        catch(PDOEXception $err) {
            return false;
        }
        finally {
            $cons= null;
            unset($cons); 
        }
    }

    public function guardar($datos, $imagen) {
        $ins= $this->db->prepara("INSERT INTO imagenes values (:id, :id_viaje, :id_usuario, :imagen, :tipo,:aceptada, :fecha)");
        
        $ins->bindParam(':id', $id, PDO::PARAM_STR);
        $ins->bindParam(':id_viaje', $id_viaje, PDO::PARAM_INT);
        $ins->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $ins->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        $ins->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $ins->bindParam(':aceptada', $aceptada, PDO::PARAM_STR);
        $ins->bindParam(':fecha', $fecha, PDO::PARAM_STR);

        $id= NULL; //id auto_increment
        $id_viaje= $datos['viaje'];
        $id_usuario= "1"; //id del admin
        $tipo= $datos['tipo'];
        $aceptada= TRUE;
        $fecha= $datos['fecha'];

        try{
            if ($ins->execute()) {
                return true;
            }
            else {return false;}
        }
        catch(PDOException $err){
            return false;
        }
        finally {
            $ins= null;
            unset($ins); 
        }
    }

    public function obtener_imagenes_usuario($id_usuario) : ?array {
        $this->db->consulta("SELECT * FROM imagenes WHERE id_usuario= $id_usuario");
        return $this->db->extraer_todos();
    }
    
    
}

?>
