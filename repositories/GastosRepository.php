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

}

?>
