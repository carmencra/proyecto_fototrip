<?php
    namespace Models;

    class Viaje{
        private string $id;
        private string $pais;
        private string $fecha_inicio;
        private string $fecha_fin;
        private string $precio;
        private string $descripcion;
        private string $nivel_fotografia;
        private string $nivel_fisico;
        private string $activo;
        private string $imagen_principal;
        private string $informacion;

        private int $duracion;

        public function __construct(string $id, string $pais, string $fecha_inicio, string $fecha_fin, string $precio, string $descripcion, string $nivel_fotografia, string $nivel_fisico, string $activo, string $imagen_principal, string $informacion) {
            $this->id= $id;
            $this->pais= $pais;
            $this->fecha_inicio= $fecha_inicio;
            $this->fecha_fin= $fecha_fin;
            $this->precio= $precio;
            $this->descripcion= $descripcion;
            $this->nivel_fotografia= $nivel_fotografia;
            $this->nivel_fisico= $nivel_fisico;
            $this->activo= $activo;
            $this->imagen_principal= $imagen_principal;
            $this->informacion= $informacion;
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
         * Get the value of pais
         */ 
        public function getPais()
        {
                return $this->pais;
        }

        /**
         * Set the value of pais
         *
         * @return  self
         */ 
        public function setPais($pais)
        {
                $this->pais = $pais;

                return $this;
        }

        /**
         * Get the value of fecha_inicio
         */ 
        public function getFecha_inicio()
        {
                return $this->fecha_inicio;
        }

        /**
         * Set the value of fecha_inicio
         *
         * @return  self
         */ 
        public function setFecha_inicio($fecha_inicio)
        {
                $this->fecha_inicio = $fecha_inicio;

                return $this;
        }

        /**
         * Get the value of fecha_fin
         */ 
        public function getFecha_fin()
        {
                return $this->fecha_fin;
        }

        /**
         * Set the value of fecha_fin
         *
         * @return  self
         */ 
        public function setFecha_fin($fecha_fin)
        {
                $this->fecha_fin = $fecha_fin;

                return $this;
        }

        /**
         * Get the value of precio
         */ 
        public function getPrecio()
        {
                return $this->precio;
        }

        /**
         * Set the value of precio
         *
         * @return  self
         */ 
        public function setPrecio($precio)
        {
                $this->precio = $precio;

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

        /**
         * Get the value of nivel_fotografia
         */ 
        public function getNivel_fotografia()
        {
                return $this->nivel_fotografia;
        }

        /**
         * Set the value of nivel_fotografia
         *
         * @return  self
         */ 
        public function setNivel_fotografia($nivel_fotografia)
        {
                $this->nivel_fotografia = $nivel_fotografia;

                return $this;
        }

        /**
         * Get the value of nivel_fisico
         */ 
        public function getNivel_fisico()
        {
                return $this->nivel_fisico;
        }

        /**
         * Set the value of nivel_fisico
         *
         * @return  self
         */ 
        public function setNivel_fisico($nivel_fisico)
        {
                $this->nivel_fisico = $nivel_fisico;

                return $this;
        }

        /**
         * Get the value of activo
         */ 
        public function getActivo()
        {
                return $this->activo;
        }

        /**
         * Set the value of activo
         *
         * @return  self
         */ 
        public function setActivo($activo)
        {
                $this->activo = $activo;

                return $this;
        }
        
        /**
         * Get the value of imagen_principal
         */ 
        public function getImagen_principal()
        {
                return $this->imagen_principal;
        }

        /**
         * Set the value of imagen_principal
         *
         * @return  self
         */ 
        public function setImagen_principal($imagen_principal)
        {
                $this->imagen_principal = $imagen_principal;

                return $this;
        }

        /**
         * Get the value of informacion
         */ 
        public function getInformacion()
        {
                return $this->informacion;
        }

        /**
         * Set the value of informacion
         *
         * @return  self
         */ 
        public function setInformacion($informacion)
        {
                $this->informacion = $informacion;

                return $this;
        }

        /**
         * Get the value of duracion
         */ 
        public function getDuracion()
        {
                return $this->duracion;
        }

        /**
         * Set the value of duracion
         *
         * @return  self
         */ 
        public function setDuracion($duracion)
        {
                $this->duracion = $duracion;

                return $this;
        }


        public static function fromArray(array $data): Viaje{
            return new Viaje(
                $data['id'] ?? '',
                $data['pais'] ?? '',
                $data['fecha_inicio'] ?? '',
                $data['fecha_fin'] ?? '',
                $data['precio'] ?? '',
                $data['descripcion'] ?? '',
                $data['nivel_fotografia'] ?? '',
                $data['nivel_fisico'] ?? '',
                $data['activo'] ?? '',
                $data['imagen_principal'] ?? '',
                $data['informacion'] ?? ''
            );
        }

    }

?>
