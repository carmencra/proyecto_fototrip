<?php
    namespace Models;

    class Imagen {
        private string $id_viaje;
        private string $imagen;
        private string $usuario;
        private string $tipo;
        private string $aceptada;
        private string $fecha;

        private string $pais_viaje;

        public function __construct(string $id_viaje, string $imagen, string $usuario, string $tipo, string $aceptada, string $fecha) {
            $this->id_viaje= $id_viaje;
            $this->imagen= $imagen;
            $this->usuario= $usuario;
            $this->tipo= $tipo;
            $this->aceptada= $aceptada;
            $this->fecha= $fecha;
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
         * Get the value of imagen
         */ 
        public function getImagen()
        {
                return $this->imagen;
        }

        /**
         * Set the value of imagen
         *
         * @return  self
         */ 
        public function setImagen($imagen)
        {
                $this->imagen = $imagen;

                return $this;
        }

        /**
         * Get the value of usuario
         */ 
        public function getUsuario()
        {
                return $this->usuario;
        }

        /**
         * Set the value of usuario
         *
         * @return  self
         */ 
        public function setUsuario($usuario)
        {
                $this->usuario = $usuario;

                return $this;
        }

        /**
         * Get the value of tipo
         */ 
        public function getTipo()
        {
                return $this->tipo;
        }

        /**
         * Set the value of tipo
         *
         * @return  self
         */ 
        public function setTipo($tipo)
        {
                $this->tipo = $tipo;

                return $this;
        }

        /**
         * Get the value of aceptada
         */ 
        public function getAceptada()
        {
                return $this->aceptada;
        }

        /**
         * Set the value of aceptada
         *
         * @return  self
         */ 
        public function setAceptada($aceptada)
        {
                $this->aceptada = $aceptada;

                return $this;
        }

        /**
         * Get the value of pais_viaje
         */ 
        public function getPais_viaje()
        {
                return $this->pais_viaje;
        }

        /**
         * Set the value of pais_viaje
         *
         * @return  self
         */ 
        public function setPais_viaje($pais_viaje)
        {
                $this->pais_viaje = $pais_viaje;

                return $this;
        }

        /**
         * Get the value of fecha
         */ 
        public function getFecha()
        {
                return $this->fecha;
        }

        /**
         * Set the value of fecha
         *
         * @return  self
         */ 
        public function setFecha($fecha)
        {
                $this->fecha = $fecha;

                return $this;
        }

        public static function fromArray(array $data): Imagen{
            return new Imagen(
                $data['id_viaje'] ?? '',
                $data['imagen'] ?? '',
                $data['usuario'] ?? '',
                $data['tipo'] ?? '',
                $data['aceptada'] ?? '',
                $data['fecha'] ?? ''
            );
        }
       

    }

?>
