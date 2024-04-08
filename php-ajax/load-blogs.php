<?php

include '../connect.php';

// $already_read_db = array();
$category = $_POST["category"];

// $user_name = $_POST["user_name"];

$content = '';

$months_array = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

try {
    mysqli_select_db($con, "prodo_db");

    $get_all_blogs_q = mysqli_query($con, "select * from users_blog_posts_list order by SNo desc;");

    while ($row = mysqli_fetch_assoc($get_all_blogs_q)) {
        $db_name = $row["UserDbName"];
        $blog_id_in_users_db = $row["BlogId"];
        $visibility = $row["Visibility"];

        if ($visibility == "visible") {

            mysqli_select_db($con, $db_name);

            $get_visible_blogs_from_db_q = mysqli_query($con, "select * from blog_posts where SNo = $blog_id_in_users_db;");

            $row_two = mysqli_fetch_assoc($get_visible_blogs_from_db_q);

                $upload_date = $row_two["UploadDate"];

                $upload_date = substr($upload_date, 8, 2) . " " . $months_array[((int) substr($upload_date, 5, 2)) - 1] . ", '" . substr($upload_date, 2, 2); 

                $content = $content . '<div class="blog-box ' . $row["SNo"] . '" id="' . $row_two["SNo"] . '"><div class="on-hover-extras"><div class="like-and-views"><div><img src="./icons/icons8-like-icon.png" alt=""><span class="money">' . $row_two["Likes"] . '</span></div><div><img src="./icons/icons8-eye-48.png" alt=""><span class="money">' . $row_two["Views"] . '</span></div></div></div>' . '<div class="blog-img" style="background: url(' . $row_two["CoverImage"] . '); background-size: cover; background-position: center;" onclick="showSelectedBlog(this);"></div><div class="blog-title">' . $row_two["BlogTitle"] . '</div><div class="blog-secondary-info"><span class="category">' . $row_two["Category"] . '</span></div><div class="blog-by-line">' . $row["Username"] . ' | ' . $upload_date . '</div></div>';
        } else {
            continue;
        }
    }


    echo $content;
}
catch (Exception $some_exc) {
    echo "Unable to fetch blogs";
}

?>