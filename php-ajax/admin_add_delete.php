<?php

include '../connect.php';

$admin_id = $_POST["admin_id"];
$action = $_POST["action"];

try {
    if ($action == "delete") {
    
        $delete_admin_q = "delete from prodo_db.admin_table where SNo = $admin_id";

        if (mysqli_query($con, $delete_admin_q)) {
            die("Admin deleted successfully");
        } else {
            die("Some error occured. Please try again later.");
        }

    }
    else
    {

        $get_admin_q = mysqli_query($con, "select * from prodo_db.admin_table where Email = '$admin_id'");

        if ($get_admin_q -> num_rows > 0) {
            die("Admin with the provided email already exists.");
        } else {
            $add_email_q = "insert into prodo_db.admin_table (Name, Email, Password, JoinDate) values ('', '$admin_id', '', '');";

            if (mysqli_query($con, $add_email_q)) {
                die("Admin added successfully!");
            } else {
                die("Some error occured. Please try again later.");
            }
        }

    }
}
catch (Exception $some_exc) {
    echo "Some error occured. Please try again later.";
}



?>