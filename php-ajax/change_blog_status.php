<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$blog_status = $_POST["blog_status"];
$blog_id = $_POST["blog_id"];

mysqli_select_db($con, $db_name);

try {
    if ($blog_status == "delete") {
    
        $delete_blog_q = "delete from blog_posts where SNo = $blog_id";

        if (mysqli_query($con, $delete_blog_q)) {

            mysqli_query($con, "delete from prodo_db.users_blog_posts_list where UserDbName = '$db_name' and BlogId = $blog_id");


            echo "Blog deleted successfully!";
        } else {
            die("Some error occured. Please try again later!");
        }

    } else {

        $get_current_visibility_status = mysqli_query($con, "select * from blog_posts where SNo = $blog_id");

        $row = mysqli_fetch_assoc($get_current_visibility_status);

        if ($row["Visibility"] == "hidden") {
            $visibility = "visible";
        } else {
            $visibility = "hidden";
        }

        $change_blog_status_q = "update blog_posts set Visibility='$visibility' where SNo = $blog_id";

        if (mysqli_query($con, $change_blog_status_q)) {
            echo "Blog Status Changed successfully!";

            mysqli_query($con, "update prodo_db.users_blog_posts_list set Visibility = '$visibility' where UserDbName = '$db_name' and BlogId = $blog_id;");
            
        } else {
            die("Some error occured. Please try again later!");
        }
    }
}
catch (Exception $some_exc) {
    echo $some_exc;
}

?>
