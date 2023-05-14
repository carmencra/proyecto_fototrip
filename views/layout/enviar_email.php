<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/OAuthTokenProvider.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
//Load Composer's autoloader
//require './vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
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
    $mail->setFrom('carmenpruebas.13@gmail.com', 'TIENDA ZAPATOS');
    $mail->addAddress($email);     //Add a recipient
    $mail->addAddress('carmenpruebas.13@gmail.com');
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'PEDIDO '. $pedido->getId();


    //cuerpo del correo: información del pedido
    $texto= "Pedido de <b style='color:red'>". $pedido->getCoste(). "€</b>;";

    $texto .= " realizado el ". $pedido->getFecha(). ", a las ". $pedido->getHora(). ". <br><br>";

    $texto .= "Los productos pedidos son los siguientes: <br>";
    foreach($_SESSION['carrito'] as $producto => $cantidad) {
        $texto .= "Producto: ". $producto. "; cantidad: ". $cantidad. "<br>";
    }

    $texto .= "<br>El pedido será enviado a la siguiente dirección: <br>". $pedido->getDireccion(). ", ". $pedido->getLocalidad(). " (".$pedido->getProvincia().").";

    $mail->Body    = $texto; 

    
    
    $mail->send();
} 
catch (Exception $e) {
    echo "<b style='color:red'>No se ha podido enviar el email; error: {$mail->ErrorInfo} </b>";
}

