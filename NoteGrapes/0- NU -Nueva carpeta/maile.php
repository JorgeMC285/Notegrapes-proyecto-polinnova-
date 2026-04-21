<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'mailer\Exception.php';
require 'mailer\PHPMailer.php';
require 'mailer\SMTP.php';

session_start();

if (isset($_SESSION['eml']) && isset($_SESSION['nom']) || isset($_POST['eml']) && isset($_POST['nom']) ) {
    //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


//Load Composer's autoloader (created by composer, not included with PHPMailer)


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0;                      //Enable verbose debug output, 2 o 0
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'notegrapes@gmail.com';                     //SMTP username
    $mail->Password   = 'amyt xpqz fnww vbzv';                  //SMTP password
    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $code = random_int(100000, 999999); //codigo de verificacion

    $to = $_SESSION['eml']; //correo del usuario registrado
    $toName = $_SESSION['nom']; //nombre del usuario registrado

    $_SESSION['code'] = $code; //guardar el código
    $codeS = $_SESSION['code'];

    //Recipients
    $mail->setFrom('notegrapes@gmail.com', 'Notegrapes');
    $mail->addAddress($to, $toName);     //Add a recipient
    

    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = '🍇 Hola '.$toName;
    $mail->Body    = 'Parece que intentas iniciar sesión en Notegrapes! <br> A continuación, te dejamos tu codigo de confirmación para que puedas iniciar sesion: <br><br> <b>'.$codeS.'</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo 'BEBE LO LOGRAMOS >:)';
    header("Location: plantillaREGISTRO.php");
    exit();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
