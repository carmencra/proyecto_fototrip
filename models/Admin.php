<?php
    namespace Models;

    class Admin{
        private string $email;
        private string $clave;

        public function __construct(string $email, string $clave) {
            $this->email= $email;
            $this->clave= $clave;
        }


        public static function fromArray(array $data): Admin{
            return new Admin(
                $data['email'] ?? '',
                $data['clave'] ?? ''
            );
        }
       
    }

?>
