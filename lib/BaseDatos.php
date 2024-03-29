<?php

namespace Lib;
use PDO;
use PDOException;

class BaseDatos {
    public PDO $conexion;
    private mixed $resultado;

    function __construct() {
        $this->servidor = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->base_datos = $_ENV['DB_DATABASE'];
        
        $this->conexion = $this->conectar();

        // actualizamos los viajes si hay alguno que no esté activo
        $this->actualizar_viajes();

    }

    private function conectar(): PDO {
        try{
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );

            $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos};charset=utf8",$this->usuario, $this->pass, $opciones);

            return $conexion;
        }
        catch(PDOException $e){
            echo 'No se puede conectar a la base de datos. Detalle: '.$e->getMessage();
            exit;
        }
    }

    public function consulta(string $consultaSQL): void {
        $this->resultado= $this->conexion->query($consultaSQL);
    }

    public function extraer_registro(): mixed {
        return ($fila= $this->resultado->fetch(PDO::FETCH_ASSOC))? $fila:false;
    }

    public function extraer_todos(): array {
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prepara($pre) {
        return $this->conexion->prepare($pre);
    }

    public function actualizar_viajes() {
        $fecha_hoy= date('Y-m-d');
        
        $sql = "UPDATE viajes SET activo= false WHERE fecha_inicio <= '$fecha_hoy'";
        $this->consulta($sql);
    }

}
?>
