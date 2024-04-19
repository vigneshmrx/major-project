<?php

include '../connect.php';

$ff1 = $_POST["ff1"];

try {
    $get_blog_q = mysqli_query($con, "select UserDbName as DbName, BlogId from prodo_db.users_blog_posts_list where SNo = $ff1");

    $row = mysqli_fetch_assoc($get_blog_q);

    $db_name = $row["DbName"];
    $blog_unique_id = $row["BlogId"];

    $update_report_no_in_common_db_q = "update prodo_db.users_blog_posts_list set Reports = Reports + 1 where SNo = $ff1";

    $update_report_no_in_users_db_q = mysqli_query($con, "update $db_name.blog_posts set Reports = Reports + 1 where SNo = $blog_unique_id");

    if (mysqli_query($con, $update_report_no_in_common_db_q)) {
        echo "Blog reported successfully!";
    } else {
        echo "An error occured. Please try again later.";
    }
}
catch (Exception $some_exc) {
    echo 'An error occured. Please try again later.';
}

?>