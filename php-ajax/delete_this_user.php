<?php

include '../connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$email = $_POST["email"];


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

    $get_db_q = mysqli_query($con, "select db_name from prodo_db.users_list where email = '$email';");

    $row = mysqli_fetch_assoc($get_db_q);

    $db_name = $row["db_name"];

    $drop_user_details_row = mysqli_query($con, "delete from prodo_db.users_list where email = '$email';");
    $drop_users_blog_if_any_q = mysqli_query($con, "delete from prodo_db.users_blog_posts_list where Email='$email' and UserDbName='$db_name'");
    
    $drop_db_q = mysqli_query($con, "drop database $db_name;");

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = "Deletion of your account";
    $mail->Body = "Dear User,<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Your account has been successfully deleted. Thank you for being a part of us!!<br><br>Team Prodo";

    $mail->send();

    echo "Account deleted successfully";
}
catch (Exception $some_exc) {
    echo "Some error occured. Please try again later";
}

?>