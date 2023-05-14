<?php
    namespace Models;

    class Gastos{
        private string $id_viaje;
        private string $comida;
        private string $alojamiento;
        private string $vuelos;
        private string $transportes;
        private string $seguro;
        private string $gastos;

        public function __construct(string $id_viaje, string $comida, string $alojamiento, string $vuelos, string $transportes, string $seguro, string $gastos) {
            $this->id_viaje= $id_viaje;
            $this->comida= $comida;
            $this->alojamiento= $alojamiento;
            $this->vuelos= $vuelos;
            $this->transportes= $transportes;
            $this->seguro= $seguro;
            $this->gastos= $gastos;
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
         * Get the value of comida
         */ 
        public function getComida()
        {
                return $this->comida;
        }

        /**
         * Set the value of comida
         *
         * @return  self
         */ 
        public function setComida($comida)
        {
                $this->comida = $comida;

                return $this;
        }

        /**
         * Get the value of alojamiento
         */ 
        public function getAlojamiento()
        {
                return $this->alojamiento;
        }

        /**
         * Set the value of alojamiento
         *
         * @return  self
         */ 
        public function setAlojamiento($alojamiento)
        {
                $this->alojamiento = $alojamiento;

                return $this;
        }

        /**
         * Get the value of vuelos
         */ 
        public function getVuelos()
        {
                return $this->vuelos;
        }

        /**
         * Set the value of vuelos
         *
         * @return  self
         */ 
        public function setVuelos($vuelos)
        {
                $this->vuelos = $vuelos;

                return $this;
        }

        /**
         * Get the value of transportes
         */ 
        public function getTransportes()
        {
                return $this->transportes;
        }

        /**
         * Set the value of transportes
         *
         * @return  self
         */ 
        public function setTransportes($transportes)
        {
                $this->transportes = $transportes;

                return $this;
        }

        /**
         * Get the value of seguro
         */ 
        public function getSeguro()
        {
                return $this->seguro;
        }

        /**
         * Set the value of seguro
         *
         * @return  self
         */ 
        public function setSeguro($seguro)
        {
                $this->seguro = $seguro;

                return $this;
        }

        /**
         * Get the value of gastos
         */ 
        public function getGastos()
        {
                return $this->gastos;
        }

        /**
         * Set the value of gastos
         *
         * @return  self
         */ 
        public function setGastos($gastos)
        {
                $this->gastos = $gastos;

                return $this;
        }



        public static function fromArray(array $data): Gastos{
            return new Gastos(
                $data['id_viaje'] ?? '',
                $data['comida'] ?? '',
                $data['alojamiento'] ?? '',
                $data['vuelos'] ?? '',
                $data['transportes'] ?? '',
                $data['seguro'] ?? '',
                $data['gastos'] ?? ''
            );
        }

    }

?>
