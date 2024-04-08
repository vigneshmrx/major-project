<?php

include '../connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$blog_id_in_prodo_db = $_POST["blog_id"];
$reason_for_deleting = $_POST["deletion_message"];

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

    $get_blog_db_q = mysqli_query($con, "select Email, UserDbName, BlogId, BlogName from prodo_db.users_blog_posts_list where SNo = $blog_id_in_prodo_db;");

    $row = mysqli_fetch_assoc($get_blog_db_q);

    $db_name = $row["UserDbName"];
    $unique_blog_id = $row["BlogId"];
    $user_email = $row["Email"];
    $deleted_blog_name = $row["BlogName"];

    // echo $db_name;
    // echo $unique_blog_id;

    $delete_the_blog_from_users_db_q = mysqli_query($con, "delete from $db_name.blog_posts where SNo = $unique_blog_id");

    $delete_from_prodo_db_q = mysqli_query($con, "delete from prodo_db.users_blog_posts_list where SNo = $blog_id_in_prodo_db;");

    $mail->addAddress($user_email);

    $mail->isHTML(true);

    $mail->Subject = "Deletion of your blog";
    $mail->Body = "Dear User,<br><br>We are sorry to inform you that we had to take down your blog - $deleted_blog_name for the following reasons:<br>&nbsp;&nbsp;&nbsp;&nbsp;$reason_for_deleting.<br><br>Please make sure that your future blogs do not voilate these things so that it can stay on our platform forever,<br><br>Thank you<br>Team ProDo";

    $mail->send();

    echo "Blog deleted successfully!";
}
catch (Exception $some_exc) {
    echo "Some error occured. Please try again later!";
}

?>