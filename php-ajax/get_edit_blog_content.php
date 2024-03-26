<?php

include '../connect.php';

$ff1 = $_POST["ff1"];
$ff2 = $_POST["ff2"];

try {

    $get_db_name_q = mysqli_query($con, "select db_name, name from prodo_db.users_list where SNo = $ff1");

    $row = mysqli_fetch_assoc($get_db_name_q);

    $db_name = $row["db_name"];

    $get_the_blog = mysqli_query($con, "select * from $db_name.blog_posts where SNo = $ff2;");

    $row = mysqli_fetch_assoc($get_the_blog);

    // echo $row["BlogTitle"] . "<br>" . $row["BlogContent"];
    $content = '<div id="editable-heading-area"><input type="text" placeholder="Your Heading Here" id="editable-heading" value="' . $row["BlogTitle"] . '"></div><div id="editable-content-area" contenteditable="true">' . $row["BlogContent"] . '</div><div id="editable-category-area"><input type="text" placeholder="Your category here. Ex: anime, space..." id="editable-category" value="' . $row["Category"] . '"></div>';

    echo $content;

}
catch (Exception $someException) {
    echo "Some error occured. Please try again later";
}


?>