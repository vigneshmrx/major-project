<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$blog_type = $_POST["type"];
$user_name = $_POST["user_name"];

$months_array = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

mysqli_select_db($con, $db_name);

try {
    if ($blog_type == "uploaded") {
        $visibility = "visible";
    } else {
        $visibility = "hidden";
    }

    $get_blogs_q = "select * from blog_posts where Visibility='$visibility' order by UploadDate desc;";

    $res = mysqli_query($con, $get_blogs_q);

    if ($res -> num_rows > 0) {
        
        while ($row = mysqli_fetch_assoc($res)) {

            $cover_img_path = $row["CoverImage"];

            $upload_date = $row["UploadDate"];

            $upload_date = substr($upload_date, 8, 2) . " " . $months_array[((int) substr($upload_date, 5, 2)) - 1] . ", '" . substr($upload_date, 2, 2); 

            $content = '<div class="blog-box" id="' . $row["SNo"] . '"><div class="on-hover-extras"><div class="like-and-views"><div><img src="./icons/icons8-heart-48.png" alt=""> <span class="money">' . $row["Likes"] . '</span></div>
            <div><img src="./icons/icons8-eye-48-grey.png" alt=""> <span class="money">' . $row["Views"] . '</span></div></div><div class="archive-and-trash">';

            if ($visibility == "visible") {
                $content = $content . '<abbr title="Archive"><img src="./icons/icons8-archive-48.png" alt="" onclick="changeBlogVisibility(this);"></abbr>';
            } else {
                $content = $content . '<abbr title="Upload"><img src="./icons/upload-blog-icon-grey.png" alt="" onclick="changeBlogVisibility(this);"></abbr>';
            }

            $content = $content . '<abbr title="Delete"><img src="./icons/icons8-delete-trash-48.png" alt="" onclick="deleteBlog(this);"></abbr></div></div><div class="blog-img" style="background: url(' . $cover_img_path . '); background-size: cover; background-position: center;"></div><div class="blog-title">' . $row["BlogTitle"] . '</div><div class="blog-secondary-info"><b>Writer</b> : ' . $user_name . '<br><b>Published</b> : ' . $upload_date . '<br><b>Category</b> : <span class="category">#Something</span></div></div>';

            echo $content;

        }

    } else {
        echo '<div id="no-blog-grid-toggle">
        <img src="./images/no-blog-exists-img.png" alt="">
        NOTHING TO SEE HERE!</div>';
    }
}
catch (Exception $blog_load_exc) {
    die($blog_load_exc);
}

?>