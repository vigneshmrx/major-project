<?php

include '../connect.php';

$change_type = $_POST["change_type"];
$email = $_POST["email"];

try {
    if ($change_type == 1) {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $full_name = $first_name . " " . $last_name;
    
        $update_user_name_q = mysqli_query($con, "update prodo_db.users_list set name = '$full_name' where email = '$email';");
    
        if ($update_user_name_q) {
            die("Name changed successfully!");
        }
    }
    else if ($change_type == 2) {
        $password = $_POST["pass"];

        $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

        $update_pwd_q = mysqli_query($con, "update prodo_db.users_list set password = '$hashed_pwd' where email = '$email';");

        if ($update_pwd_q) {
            die("Password changed successfully!");
        }
    }
}
catch (Exception $some_exc) {
    echo "Some error occured. Please try again later!";
}

?>