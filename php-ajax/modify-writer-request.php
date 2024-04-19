<?php

include '../connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$request_id = $_POST["request_id"];
$user_email = $_POST["user_email"];
$action_no = $_POST["action_no"];




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

    $mail->addAddress($user_email);

    $mail->isHTML(true);

    if ($action_no == 1) {

        $accept_request_q = "update prodo_db.writer_requests set Status = 'Accepted' where SNo = $request_id and EmailId = '$user_email';";

        if (mysqli_query($con, $accept_request_q)) {

            $mail->Subject = "Approval of Writer Request";

            $mail->Body = "Dear User,<br><br>We are pleased to inform you that your request for being a blog writer is accepted. You can now write your own blogs. Make sure to be kind to the readers and do not use explicit language.<br><br>Thank You!<br>Team ProDo!";

            $change_user_status_q = mysqli_query($con, "update prodo_db.users_list set role='writer' where email='$user_email';");

            echo "Writer Request Accepted";

        }

        $mail->send();

    } 
    else if ($action_no == 2) 
    {

        $reject_request_q = "update prodo_db.writer_requests set Status = 'Rejected' where SNo = $request_id and EmailId = '$user_email';";

        if (mysqli_query($con, $reject_request_q)) {

            $mail->Subject = "Rejection of Writer Request";

            $mail->Body = "Dear User<br>We are sad to inform you that your request for being a blog writer is rejected. This may be because of multiple reasons including the links provided by you maybe broken or your old writings contain explicit content which we would not like on our platform. Please try again later.<br><br>Thank You!<br>Team ProDo";

            echo "Writer Request Rejected";

        }

        $mail->send();

    }
    else if ($action_no == 3) {

        $delete_this_request_q = "delete from prodo_db.writer_requests where SNo = $request_id and EmailId = '$user_email';";

        if (mysqli_query($con, $delete_this_request_q)) {
            die("Request deleted successfully!");
        }

    }
    
}
catch (Exception $some_exc) {
    die("An error occured. Please try again later!");
}
?>