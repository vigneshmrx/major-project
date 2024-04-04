<?php

include '../connect.php';

$email_id = $_POST["email"];
$links = $_POST["links"];
$user_name = $_POST["user_name"];

try {

    $make_writer_request_q = "insert into prodo_db.writer_requests (UserName, EmailId, WorksLinks) values ('$user_name', '$email_id', '$links');";

    if (mysqli_query($con, $make_writer_request_q)) {
        echo "Request sent successfully. Please wait patiently for your response!";
    } else {
        echo "Some error occured. Please try again later!";
    }

}
catch (Exception $some_exc) {
    echo "Some error occured. Please try again later!";
}

?>