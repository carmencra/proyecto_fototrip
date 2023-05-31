<?php
    namespace Models;

    class Imagen {
        private string $id;
        private string $id_viaje;
        private string $imagen;
        private string $id_usuario;
        private string $tipo;
        private string $aceptada;
        private string $fecha;

        private string $usuario;
        private string $pais_viaje;

        public function __construct(string $id, string $id_viaje, string $imagen, string $id_usuario, string $tipo, string $aceptada, string $fecha) {
            $this->id= $id;
            $this->id_viaje= $id_viaje;
            $this->imagen= $imagen;
            $this->id_usuario= $id_usuario;
            $this->tipo= $tipo;
            $this->aceptada= $aceptada;
            $this->fecha= $fecha;
        }
        
        
        
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
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
         * Get the value of id_usuario
         */ 
        public function getid_Usuario()
        {
                return $this->id_usuario;
        }

        /**
         * Set the value of id_usuario
         *
         * @return  self
         */ 
        public function setid_Usuario($id_usuario)
        {
                $this->id_usuario = $id_usuario;

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

        public static function fromArray(array $data): Imagen{
            return new Imagen(
                $data['id'] ?? '',
                $data['id_viaje'] ?? '',
                $data['imagen'] ?? '',
                $data['id_usuario'] ?? '',
                $data['tipo'] ?? '',
                $data['aceptada'] ?? '',
                $data['fecha'] ?? ''
            );
        }
       
    }

?>
