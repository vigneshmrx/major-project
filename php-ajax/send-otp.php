<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$email = $_POST["email"];

function generateOTP() {
    $otp = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    return $otp;
}

try {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'vs.prodowebapp@gmail.com';
    $mail->Password = 'rwtydtnzgcxrfosu';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('vs.prodowebapp@gmail.com');

    $otp = generateOTP();

    $mail->addAddress($email);

    $mail->isHTML(true);

    $message = "Greetings from ProDo.<br><br>Your OTP for registering in ProDo is $otp.<br><br>Thank You<br>Team ProDo";

    $mail->Subject = "OTP for registration";

    $mail->Body = $message;

    $mail->send();

    $otp = password_hash($otp, PASSWORD_DEFAULT);

    echo $otp;
}
catch (Exception $some_exc) {
    echo "0";
}


?>