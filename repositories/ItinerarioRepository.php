<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Itinerario;
use PDO;
use PDOException;

class ItinerarioRepository {
    private BaseDatos $db;

    function __construct() {
        $this->db= new BaseDatos();
    }

}

?>
