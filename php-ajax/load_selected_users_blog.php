<?php

include '../connect.php';

$ff1 = $_POST["ff1"];
$ff2 = $_POST["ff2"];

$months_array = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");



try {
    // $get_db_name_q = mysqli_query($con, "select db_name, name from prodo_db.users_list where SNo = $ff1");

    // $row = mysqli_fetch_assoc($get_db_name_q);

    // $db_name = $row["db_name"];
    // $user_name = $row["name"];

    // Changes made here

    $get_db_name_q = mysqli_query($con, "select UserDbName, Username from prodo_db.users_blog_posts_list where SNo = $ff1");

    $row = mysqli_fetch_assoc($get_db_name_q);

    $db_name = $row["UserDbName"];
    $user_name = $row["Username"];

    // changes ends here

    // echo $db_name;

    $get_the_blog = mysqli_query($con, "select * from $db_name.blog_posts where SNo = $ff2;");

    $row = mysqli_fetch_assoc($get_the_blog);

    // echo $row["BlogTitle"];

    $upload_date = $row["UploadDate"];
    $upload_date = substr($upload_date, 8, 2) . " " . $months_array[((int) substr($upload_date, 5, 2)) - 1] . ", '" . substr($upload_date, 2, 2); 

    $likes = $row["Likes"];
    // if ($likes == "") {
    //     $likes = 0;
    // }

    $blog_content = '<div id="blog-heading">' . $row["BlogTitle"] . '</div><div id="blog-info-area"><div class="user-name">' . $user_name . '</div><div class="blog-upload-date">' . $upload_date . '</div></div><div id="blog-content">' . $row["BlogContent"] . '</div><div id="likes-and-views-area"><div id="likes-div"><img src="./icons/icons8-like-icon-outlined.png" alt=""><span class="money">' . $likes . '</span></div><div id="views-div"><img src="./icons/icons8-eye-48.png" alt=""><span class="money">' . $row["Views"] . '</span></div></div></div>';

    echo $blog_content;

}
catch (Exception $some_exc) {
    echo $some_exc;
}

?>