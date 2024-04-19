<?php

include '../connect.php';

$ff1 = $_POST["ff1"];
$ff2 = $_POST["ff2"];

try {

    $get_db_name_q = mysqli_query($con, "select Username, UserDbName from prodo_db.users_blog_posts_list where SNo = $ff1");

    $row = mysqli_fetch_assoc($get_db_name_q);

    $db_name = $row["UserDbName"];

    $get_the_blog = mysqli_query($con, "select * from $db_name.blog_posts where SNo = $ff2;");

    $row = mysqli_fetch_assoc($get_the_blog);

    $content = '<div id="editable-heading-area"><input type="text" placeholder="Your Heading Here" id="editable-heading" value="' . $row["BlogTitle"] . '"></div><div id="editable-content-area" contenteditable="true">' . $row["BlogContent"] . '</div><div id="editable-category-area"><input type="text" placeholder="Your category here. Ex: anime, space..." id="editable-category" value="' . $row["Category"] . '"></div>';

    echo $content;

}
catch (Exception $someException) {
    echo "Blog could not be fetched. Please try again later!";
}


?>