<?php
    namespace Models;

    class Comentario {
        private string $id_viaje;
        private string $usuario;
        private string $contenido;

        private string $nombre_viaje;

        public function __construct(string $id_viaje, string $usuario, string $contenido) {
            $this->id_viaje= $id_viaje;
            $this->usuario= $usuario;
            $this->contenido= $contenido;
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

        
        public static function fromArray(array $data): Comentario{
            return new Comentario(
                $data['id_viaje'] ?? '',
                $data['usuario'] ?? '',
                $data['contenido'] ?? ''
            );
        }
       
    }

?>
