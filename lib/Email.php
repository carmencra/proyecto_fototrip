<?php

namespace Lib;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Email {
    public $email;
    public $token;

    public function __construct($email, $token) {
        $this->email= $email;
        $this->token= $token;
    }


    public function enviar_confirmacion() {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '7da852c8fd379e';
        $mail->Password = '0e5ce7df4e1fb5';

        //Recipients
        $mail->setFrom('Cursos_y_talleres@gmail.com', 'Usuarios y Ponentes');
        $mail->addAddress($this->email);
        $mail->addAddress('Cursos_y_talleres@gmail.com');
    
        //Content
        $mail->isHTML(true);                   //Set email format to HTML 
        $mail->CharSet="UTF-8";              
        $mail->Subject = 'Confirma tu cuenta';

        $contenido= "<p><strong>".$this->email."</strong>, has creado tu cuenta de cursos.</p>";

        $contenido .= "<p>Ahora confírmala clicando aquí: </p>";

        $contenido .= "<a href='http://localhost/api_proyecto/public/usuario/confirmarcuenta/".$this->token."'>Confirmar cuenta</a>";

        $mail->Body    = $contenido; 

        $mail->send();
    }

}

?>
