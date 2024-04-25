<?php


$otp_hash = $_POST["value"];
$user_entered_otp = $_POST["user_entered_otp"];

try {

    if (password_verify($user_entered_otp, $otp_hash)) {
        echo "1";
    } else {
        echo "0";
    }
} catch (Exception $some_exc) {
    // echo "0";
    echo $some_exc;
}

?>