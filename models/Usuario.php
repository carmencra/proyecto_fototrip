<?php
    namespace Models;

    class Usuario{
        private string $email;
        private string $clave;
        private string $nombre;
        private string $apellidos;

        public function __construct(string $email, string $clave, string $nombre, string $apellidos) {
            $this->email= $email;
            $this->clave= $clave;
            $this->nombre= $nombre;
            $this->apellidos= $apellidos;
        }

        

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of clave
         */ 
        public function getClave()
        {
                return $this->clave;
        }

        /**
         * Set the value of clave
         *
         * @return  self
         */ 
        public function setClave($clave)
        {
                $this->clave = $clave;

                return $this;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of apellidos
         */ 
        public function getApellidos()
        {
                return $this->apellidos;
        }

        /**
         * Set the value of apellidos
         *
         * @return  self
         */ 
        public function setApellidos($apellidos)
        {
                $this->apellidos = $apellidos;

                return $this;
        }



        public static function fromArray(array $data): Usuario{
            return new Usuario(
                $data['email'] ?? '',
                $data['clave'] ?? '',
                $data['nombre'] ?? '',
                $data['apellidos'] ?? ''
            );
        }
       
    }

?>
