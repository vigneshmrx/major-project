<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$blog_heading = $_POST["blog_heading"];
$blog_content = $_POST["blog_content"];
$type = $_POST["type"];
$table_name = "blog_posts";
$cover_img_path = $_POST["cover_img_path"];

$query = "SELECT 1 FROM information_schema.tables WHERE table_schema = '$db_name' AND table_name = '$table_name' LIMIT 1";

// $result = $con->query($query);
$result = mysqli_query($con, $query);

if (!($result && $result->num_rows > 0)) {
    try {
        mysqli_select_db($con, $db_name);
        $create_table_q = "create table blog_posts(SNo int AUTO_INCREMENT PRIMARY KEY, BlogTitle varchar(100) not null, BlogContent LONGTEXT not null, CoverImage TEXT not null, UploadDate TIMESTAMP not null, Visibility varchar(10) not null);";

        if ((!mysqli_query($con, $create_table_q))) {
            die("Table couldn't be created");
        }

        //make updates here
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

try {
    $insert_blog_into_db = "insert into blog_posts (BlogTitle, BlogContent, CoverImage, UploadDate, Visibility) values('$blog_heading', '$blog_content', '$cover_img_path', current_timestamp(), '$visibility');";

    if (mysqli_query($con, $insert_blog_into_db)) {
        echo "Blog Uploaded Successfully";
    } else {
        echo "Couldn't upload";
    }
}
catch (Exception $blog_upload_exc) {
    die($blog_upload_exc);
}

?>