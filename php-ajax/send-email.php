<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$to = $_POST["to_email"];
$subject = $_POST["subject"];
$message = $_POST["message"];
$header = "From: Team ProDo";

try {

    // if (mail($to, $subject, $message, $header)) {
    //     echo "Email Sent Successfully!!";
    // } else {
    //     echo "Email counldn't be sent";
    // }

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'vs.prodowebapp@gmail.com';
    $mail->Password = 'rwtydtnzgcxrfosu';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('vs.prodowebapp@gmail.com');

    $mail->addAddress($to);

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body = $message;

    $mail->send();

    echo "Email Sent Successfully!";
}
catch (Exception $some_exc) {
    echo $some_exc;
}

?>
