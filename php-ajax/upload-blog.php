<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$blog_heading = $_POST["blog_heading"];
$blog_content = $_POST["blog_content"];
$type = $_POST["type"];
$table_name = "blog_posts";

$query = "SELECT 1 FROM information_schema.tables WHERE table_schema = '$db_name' AND table_name = '$table_name' LIMIT 1";

// $result = $con->query($query);
$result = mysqli_query($con, $query);

if (!($result && $result->num_rows > 0)) {
    try {
        $create_table_q = "create table blog_posts(SNo int AUTO_INCREMENT PRIMARY KEY, BlogTitle varchar(100) not null, BlogContent LONGTEXT not null, UploadDate DATETIME not null, Visibility varchar(10));";

        //make updates here
    }
}


?>