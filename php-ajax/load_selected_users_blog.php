<?php

include '../connect.php';

$ff1 = $_POST["ff1"];
$ff2 = $_POST["ff2"];
$liked_db_name = $_POST["user"];

$months_array = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

try {

    $blog_content = "";

    if ($ff2 != "" && $liked_db_name != "") {

        $get_db_name_q = mysqli_query($con, "select UserDbName, Username from prodo_db.users_blog_posts_list where SNo = $ff1");

        $row = mysqli_fetch_assoc($get_db_name_q);

        $db_name = $row["UserDbName"];
        $user_name = $row["Username"];

        $get_unique_user_id_q = mysqli_query($con, "select sno from prodo_db.users_list where db_name = '$liked_db_name';");

        $row = mysqli_fetch_assoc($get_unique_user_id_q);

        $user_id = (string) $row["sno"];

        $get_the_blog = mysqli_query($con, "select * from $db_name.blog_posts where SNo = $ff2;");

        $row = mysqli_fetch_assoc($get_the_blog);

        $upload_date = $row["UploadDate"];
        $upload_date = substr($upload_date, 8, 2) . " " . $months_array[((int) substr($upload_date, 5, 2)) - 1] . ", '" . substr($upload_date, 2, 2); 

        $likes = $row["Likes"];

        $liked_by_users = $row["LikedBy"];

        $blog_content = $blog_content . '<div id="blog-heading">' . $row["BlogTitle"] . '</div><div id="blog-info-area"><div class="user-name">' . $user_name . '</div><div class="blog-upload-date">' . $upload_date . '</div></div><div id="blog-content">' . $row["BlogContent"] . '</div><div id="likes-and-views-area"><div id="likes-div" onclick="toggleLike(this);">';
    
        if (strlen($liked_by_users) > 0 && str_contains($liked_by_users, $user_id)) {
            $blog_content = $blog_content . '<img src="./icons/icons8-like-icon-filled.png" alt="">';
        } else {
            $blog_content = $blog_content . '<img src="./icons/icons8-like-icon-outlined.png" alt="">';
        }

        $blog_content = $blog_content . '<span class="money">' . $likes . '</span></div><div id="views-div"><img src="./icons/icons8-eye-48.png" alt=""><span class="money">' . $row["Views"] . '</span></div></div></div>';

    }
    else 
    {

        $get_blog_details_q = mysqli_query($con, "select Username, UserDbName as DbName, BlogId from prodo_db.users_blog_posts_list where SNo = $ff1");

        $row = mysqli_fetch_assoc($get_blog_details_q);

        $blog_id = $row["BlogId"];
        $blog_db_name = $row["DbName"];
        $user_name = $row["Username"];

        $get_the_blog_q = mysqli_query($con, "select * from $blog_db_name.blog_posts where SNo = $blog_id");

        $row = mysqli_fetch_assoc($get_the_blog_q);

        $upload_date = $row["UploadDate"];
        $upload_date = substr($upload_date, 8, 2) . " " . $months_array[((int) substr($upload_date, 5, 2)) - 1] . ", '" . substr($upload_date, 2, 2); 

        $blog_content = $blog_content . '<div id="blog-heading">' . $row["BlogTitle"] . '</div><div id="blog-info-area"><div class="user-name">' . $user_name . '</div><div class="blog-upload-date">' . $upload_date . '</div></div><div id="blog-content">' . $row["BlogContent"] . '</div></div>';
    }

    echo $blog_content;

}
catch (Exception $some_exc) {
    echo $some_exc;
}

?>