<?php
    require "phpmailer/class.phpmailer.php";

	function sendmail($to, $subject, $message) {
        $mail = new PHPMailer(); // create a new object
        //$mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'REQUIRED'; // secure transfer enabled REQUIRED for GMail      ssl
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "faraza.unibo@gmail.com";
        $mail->Password = "basedidati"; // password di chi invia;
        $mail->SetFrom("faraza.unibo@gmail.com");
        $mail->Subject = $subject; //oggetto
        $mail->Body = $message; // testo
        // invia a
        $mail->AddAddress($to);
        
/*	Tolto per far scomparire messaggio di errore
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
*/
    }
?>