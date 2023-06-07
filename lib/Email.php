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
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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
        $contenido= "<p style='color: #2CCBCB; font-size: 24px;'><b>BIENVENIDO A FOTOTRIP</b></p>";

        $contenido .= "<b>Verifica tu cuenta para empezar a inscribirte en nuestros viajes: </b><br>";

        $contenido .= "<p><a href=".$_ENV['BASE_URL']."confirmar_cuenta/".$id.">Confirmar cuenta</a></p>";

        $contenido .= "<br><br><p> (Si no reconoces esta acción, por favor, ignora este correo.)</p>";

        $mail->Body    = $contenido; 

        $mail->send();
        return ;
    }


    
    public function enviar_inscripcion($viaje) {
        $mail = new PHPMailer(true);

        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'carmenpruebas.13@gmail.com';                     //SMTP username
        $mail->Password   = 'kebsqwwjrsftzkzb';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('carmenpruebas.13@gmail.com', 'FOTOTRIP - Viajes Fotograficos');
        // $mail->addAddress($this->email);     //Add a recipient
        $mail->addAddress('carmenpruebas.13@gmail.com');
        
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Te has inscrito al viaje de '.$viaje->getPais();

        //cuerpo del correo: envío de datos del viaje
        
        $contenido= "<p style='color: #2CCBCB; font-size: 24px;'><b>DESDE FOTOTRIP TE INFORMAMOS DE QUE: </b></p>";

        $contenido .= "Te acabas de inscribir en el viaje a: <b style='font-size: 18px'>".$viaje->getPais(). "</b><br>". $viaje->getDescripcion() ."<br><br><br>";

        $contenido .= "Te recordamos que este viaje tendrá lugar entre: <br>";

        $contenido .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

        $contenido .= "<b>". $viaje->getFecha_inicio() ."</b> y <b>". $viaje->getFecha_fin(). "</b><br><br>";

        $contenido .= "<a href=".$_ENV['BASE_URL']."misviajes>Pulsa aquí para ver tus viajes con nosotros</a> <br><br>";

        $contenido .= "Gracias por elegir <b style='color: #2CCBCB; font-size: 22px;'>  FOTOTRIP</b>, <br> ¡esperamos que disfrutes tu viaje y que no se te olvide comentar y subir imágenes del mismo!";

        $mail->Body    = $contenido; 

        $mail->send();
        return ;
    }

}

?>
