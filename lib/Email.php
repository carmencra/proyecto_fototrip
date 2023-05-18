<?php

namespace Lib;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/OAuthTokenProvider.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


class Email {
    public $email;

    public function __construct($email, $token) {
        $this->email= $email;
        $this->token= $token;
    }


    public function enviar_confirmacion() {
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'carmenpruebas.13@gmail.com';                     //SMTP username
        $mail->Password   = 'kebsqwwjrsftzkzb';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('carmenpruebas.13@gmail.com', 'FOTOTRIP - Viajes Fotograficos');
        // $mail->addAddress($email);     //Add a recipient
        $mail->addAddress('carmenpruebas.13@gmail.com');
        
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Confirma tu cuenta de fototrip';

        //cuerpo del correo: solicitud de confirmación de correo
        $contenido= "<b style='color:red, size:24px'>Verifica tu cuenta para empezar a registrarte en los viajes de fototrip></b>";

        $contenido .= "<a href='http://localhost/fototrip/usuario/confirmarcuenta/".$this->token."'>Confirmar cuenta</a>";
        
        $contenido .= "<p>Bienvenido a fototrip</p>";

        $contenido .= "<p>Si no reconoces esta acción, por favor, ignora este correo</p>";

        $mail->Body    = $contenido; 

        $mail->send();
    }

}

?>
