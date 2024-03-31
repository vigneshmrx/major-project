<?php

include '../connect.php';

$ff1 = $_POST["ff1"];
$ff2 = $_POST["ff2"];

try {
    $get_db_name_q = mysqli_query($con, "select UserDbName from prodo_db.users_blog_posts_list where SNo = $ff1");

    $row = mysqli_fetch_assoc($get_db_name_q);

    $db_name = $row["UserDbName"];
    // $user_name = $row["name"];

    // $get_the_blog = mysqli_query($con, "select * from $db_name.blog_posts where SNo = $ff2;");

    $update_blog_view_count_q = mysqli_query($con, "update $db_name.blog_posts set Views = Views + 1 where SNo = $ff2");
}
catch (Exception $some_exc) {
    echo $some_exc;
}


?>