<?php 
//LIBRERIA USADA: "PHPMailer"
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function enviarCorreo($nom, $eml, $conect){
    //Zona horaria
        date_default_timezone_set("America/Mexico_City"); 
    //Verificacion de datos
        if(empty($nom) || empty($eml)){
            echo "<script>alert('No se pudo enviar el correo, faltan datos');</script>";
            return false;
        }

        require 'mailer\Exception.php';
        require 'mailer\PHPMailer.php';
        require 'mailer\SMTP.php';

        $mail = new PHPMailer(true);

        try {
        //Configuracion del servidor SMTP
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;                                       //Enable verbose debug output, 2 o 0
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'notegrapes@gmail.com';                 //SMTP username
            $mail->Password   = 'amyt xpqz fnww vbzv';                  //SMTP password
            $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $code = random_int(100000, 999999);         //codigo de verificacion (6 digitos)
            $hashCode = password_hash($code, PASSWORD_DEFAULT); //encriptar codigo de verificacion
            $exp  = date("Y-m-d H:i:s", time() + 300);  //fecha de expiracion (5min)

            $to     = $eml; //correo del usuario registrado
            $toName = $nom; //nombre del usuario registrado

        //Mandar a la base de datos usuario temporal
            $comand = "INSERT INTO tempusers (correo, codigo, vencimiento) VALUES ('$eml', '$hashCode', '$exp');";
            $resul  = mysqli_query($conect, $comand);

        //Recipiente
            $mail->setFrom('notegrapes@gmail.com', 'Notegrapes');
            $mail->addAddress($to, $toName);     //Add a recipient
    

            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Contenido del correo
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = '🍇 Hola '.$toName;
            $mail->Body    = 'Parece que intentas iniciar sesión en Notegrapes! <br> A continuación, te dejamos tu codigo de confirmación para que puedas iniciar sesion: <br><br> <b>'.$code.'</b>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //header("Location: formul.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        //echo "<br> 3- esto se hizo en mail.php";
        return true;
    }
?>