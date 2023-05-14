<?php
namespace Repositories;
use Lib\BaseDatos;
use Models\Admin;
use PDO;
use PDOException;

class AdminRepository {
    private BaseDatos $db;

    function __construct() {
        $this->db= new BaseDatos();
    }

}

?>
