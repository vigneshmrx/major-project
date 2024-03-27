<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$section_name = $_POST["section_name"];

mysqli_select_db($con, $db_name);

try {
    
    switch ($section_name) {
        case "posts": $get_q = mysqli_query($con, "select count(*) as NoOfRows from blog_posts where Visibility='visible';");
                    break;

        case "archives": $get_q = mysqli_query($con, "select count(*) NoOfRows from blog_posts where Visibility='hidden';");
                    break;

        case "views": $get_q = mysqli_query($con, "select sum(Views) NoOfRows from blog_posts;");
                    break;

        case "likes": $get_q = mysqli_query($con, "select sum(Likes) NoOfRows from blog_posts;");
                    break;
    }

    $row = mysqli_fetch_assoc($get_q);

    echo $row["NoOfRows"];

}
catch (Exception $some_exc) {
    echo "0";
}



?>