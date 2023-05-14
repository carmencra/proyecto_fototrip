<?php
    namespace Models;

    class Itinerario{
        private string $id_viaje;
        private string $dia;
        private string $descripcion;

        public function __construct(string $id_viaje, string $dia, string $descripcion) {
            $this->id_viaje= $id_viaje;
            $this->dia= $dia;
            $this->descripcion= $descripcion;
        }



        /**
         * Get the value of id_viaje
         */ 
        public function getId_viaje()
        {
                return $this->id_viaje;
        }

        /**
         * Set the value of id_viaje
         *
         * @return  self
         */ 
        public function setId_viaje($id_viaje)
        {
                $this->id_viaje = $id_viaje;

                return $this;
        }

        /**
         * Get the value of dia
         */ 
        public function getDia()
        {
                return $this->dia;
        }

        /**
         * Set the value of dia
         *
         * @return  self
         */ 
        public function setDia($dia)
        {
                $this->dia = $dia;

                return $this;
        }

        /**
         * Get the value of descripcion
         */ 
        public function getDescripcion()
        {
                return $this->descripcion;
        }

        /**
         * Set the value of descripcion
         *
         * @return  self
         */ 
        public function setDescripcion($descripcion)
        {
                $this->descripcion = $descripcion;

                return $this;
        }



        public static function fromArray(array $data): Itinerario{
            return new Itinerario(
                $data['id_viaje'] ?? '',
                $data['dia'] ?? '',
                $data['descripcion'] ?? ''
            );
        }
       
    }

?>
