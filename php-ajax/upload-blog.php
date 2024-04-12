<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$blog_heading = $_POST["blog_heading"];
$blog_content = $_POST["blog_content"];
$type = $_POST["type"];
$table_name = "blog_posts";
$cover_img_path = $_POST["cover_img_path"];
$blog_category = $_POST["blog_category"];
$ff2 = $_POST["ff2"];
$user_name = $_POST["user_name"];
$user_email = $_POST["email"];

date_default_timezone_set("Asia/Kolkata");

$query = "SELECT 1 FROM information_schema.tables WHERE table_schema = '$db_name' AND table_name = '$table_name' LIMIT 1";

// $result = $con->query($query);
$result = mysqli_query($con, $query);

if (!($result && $result->num_rows > 0)) {
    try {
        mysqli_select_db($con, $db_name);
        $create_table_q = "create table blog_posts(SNo int AUTO_INCREMENT PRIMARY KEY, BlogTitle varchar(100) not null, BlogContent LONGTEXT not null, CoverImage TEXT not null, Category varchar(150) not null, UploadDate char(10) not null, Visibility varchar(10) not null, Likes int(5) not null, LikedBy LONGTEXT not null, Views int(5) not null, Reports int(2) not null);";

        if ((!mysqli_query($con, $create_table_q))) {
            die("Table couldn't be created");
        }
    }
    catch (Exception $table_creation_exc) {
        die($table_creation_exc);
    }
}

if ($type == "upload") {
    $visibility = "visible";    
} else {
    $visibility = "hidden";
}

mysqli_select_db($con, $db_name);

$blog_content = str_replace("'", "\'", $blog_content);
$blog_heading = str_replace("'", "\'", $blog_heading);
$blog_category = str_replace("'", "\'", $blog_category);

try {

    if ($ff2 == "") {
        $curDate = date("Y-m-d");

        $insert_blog_into_db = "insert into blog_posts (BlogTitle, BlogContent, CoverImage, Category, UploadDate, Visibility, Likes, LikedBy, Views, Reports) values('$blog_heading', '$blog_content', '$cover_img_path', '$blog_category', '$curDate', '$visibility', 0, '', 0, 0);";

        if (mysqli_query($con, $insert_blog_into_db)) {

            $get_just_uploaded_blog_details = mysqli_query($con, "select SNo, Category from blog_posts order by SNo desc;");

            $row = mysqli_fetch_assoc($get_just_uploaded_blog_details);

            $just_uploaded_blog_id = $row["SNo"];
            $just_uploaded_blog_category = $row["Category"];

            mysqli_query($con, "insert into prodo_db.users_blog_posts_list (Username, Email, UserDbName, BlogId, BlogName, Category, Visibility) values('$user_name', '$user_email', '$db_name', $just_uploaded_blog_id, '$blog_heading', '$just_uploaded_blog_category', '$visibility');");


            echo "Blog Uploaded Successfully";
        } else {
            echo "Couldn't upload";
        }
    }
    else {
        $update_the_blog_q = "update blog_posts set BlogTitle = '$blog_heading', BlogContent = '$blog_content', Category = '$blog_category', CoverImage = '$cover_img_path', Visibility = '$visibility' where SNo = $ff2;";

        if (mysqli_query($con, $update_the_blog_q)) {
            echo "Blog updated successfully!";
        } else {
            echo "Some error occured. Please try updating later!";
        }

        mysqli_query($con, "update prodo_db.users_blog_posts_list set BlogName = '$blog_heading', Category = '$blog_category', Visibility = '$visibility' where BlogId = $ff2 and UserDbName = '$db_name'");
    }
}
catch (Exception $blog_upload_exc) {
    die($blog_upload_exc);
}

?>