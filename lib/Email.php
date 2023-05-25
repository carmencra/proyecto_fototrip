<?php

namespace Lib;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Email {
    public $email;

    public function __construct($email) {
        $this->email= $email;
    }


    public function enviar_confirmacion($id) {
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
        
        $contenido= "<p style='color: #2CCBCB'><b>BIENVENIDO A FOTOTRIP</b></p>";

        $contenido .= "<b>Verifica tu cuenta para empezar a inscribirte en los viajes de fototrip: </b><br>";

        $contenido .= "<br><p><a href='http://localhost/fototrip/usuario/confirmarcuenta?id=".$id."'>Confirmar cuenta</a></p>";
        $contenido .= "<br><br><p>Si no reconoces esta acción, por favor, ignora este correo.</p>";

        $mail->Body    = $contenido; 

        $mail->send();
        return ;
    }

}

?>
