<?php
    namespace Models;

    class Comentario {
        private string $id;
        private string $id_viaje;
        private string $usuario;
        private string $contenido;
        private string $aceptado;

        private string $nombre_viaje;
        private string $nombre_usuario;
        private string $apellidos_usuario;

        public function __construct(string $id, string $id_viaje, string $usuario, string $contenido, string $aceptado) {
            $this->id= $id;
            $this->id_viaje= $id_viaje;
            $this->usuario= $usuario;
            $this->contenido= $contenido;
            $this->aceptado= $aceptado;
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
         * Get the value of contenido
         */ 
        public function getContenido()
        {
                return $this->contenido;
        }

        /**
         * Set the value of contenido
         *
         * @return  self
         */ 
        public function setContenido($contenido)
        {
                $this->contenido = $contenido;

                return $this;
        }

        /**
         * Get the value of nombre_viaje
         */ 
        public function getNombre_viaje()
        {
                return $this->nombre_viaje;
        }

        /**
         * Set the value of nombre_viaje
         *
         * @return  self
         */ 
        public function setNombre_viaje($nombre_viaje)
        {
                $this->nombre_viaje = $nombre_viaje;

                return $this;
        }
        
        /**
         * Get the value of aceptado
         */ 
        public function getAceptado()
        {
                return $this->aceptado;
        }

        /**
         * Set the value of aceptado
         *
         * @return  self
         */ 
        public function setAceptado($aceptado)
        {
                $this->aceptado = $aceptado;

                return $this;
        }
        
        /**
         * Get the value of nombre_usuario
         */ 
        public function getNombre_usuario()
        {
                return $this->nombre_usuario;
        }

        /**
         * Set the value of nombre_usuario
         *
         * @return  self
         */ 
        public function setNombre_usuario($nombre_usuario)
        {
                $this->nombre_usuario = $nombre_usuario;

                return $this;
        }

        /**
         * Get the value of apellidos_usuario
         */ 
        public function getApellidos_usuario()
        {
                return $this->apellidos_usuario;
        }

        /**
         * Set the value of apellidos_usuario
         *
         * @return  self
         */ 
        public function setApellidos_usuario($apellidos_usuario)
        {
                $this->apellidos_usuario = $apellidos_usuario;

                return $this;
        }
        
        public static function fromArray(array $data): Comentario{
            return new Comentario(
                $data['id'] ?? '',
                $data['id_viaje'] ?? '',
                $data['usuario'] ?? '',
                $data['contenido'] ?? '',
                $data['aceptado'] ?? ''
            );
        }

    }

?>
