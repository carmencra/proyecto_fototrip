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

    public function obtener_datos_viaje($id_viaje): array | bool {
        $cons= $this->db->prepara("SELECT pais, fecha_inicio, fecha_fin FROM viajes WHERE id=:id_viaje");

        $cons->bindParam(':id_viaje', $id_viaje);

        $cons->execute();

        $datos= $cons->fetchAll();
        $datos_array= json_decode(json_encode($datos), true);

        try {
            $cons->execute();
            return $datos_array[0];
        }
        catch(PDOEXception $err) {
            return false;
        }
    }
}

?>
