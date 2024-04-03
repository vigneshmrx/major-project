<?php

include '../connect.php';

$ff1 = $_POST["ff1"];
$ff2 = $_POST["ff2"];
$user_has_liked = $_POST["user_has_liked"];
$already_existing_likes = $_POST["already_existing_likes"];
$liked_user_db_name = $_POST["liked_user"];

try {
    $get_db_name_q = mysqli_query($con, "select UserDbName from prodo_db.users_blog_posts_list where SNo = $ff1");

    $row = mysqli_fetch_assoc($get_db_name_q);

    $db_name = $row["UserDbName"];

    // if ($user_has_liked == true) {
    //     echo "IT's true";
    // } else {
    //     echo $user_has_liked;
    // }

    $get_unique_user_id_q = mysqli_query($con, "select sno from prodo_db.users_list where db_name = '$liked_user_db_name';");

    $row = mysqli_fetch_assoc($get_unique_user_id_q);

    $like_toggled_users_unique_id = $row["sno"];

    if ($user_has_liked == "yes") {
        $already_existing_likes++;

        

        $like_updation_q = "update $db_name.blog_posts set Likes = (Likes + 1), LikedBy = CONCAT(LikedBy, '$like_toggled_users_unique_id,') where SNo = $ff2";

        if (mysqli_query($con, $like_updation_q)) {
            
            echo '<img src="./icons/icons8-like-icon-filled.png" alt=""><span class="money">' . $already_existing_likes . '</span>';

        } else {
            die();
        }

    } else {

        $already_existing_likes--;

        $like_updation_q = "update $db_name.blog_posts set Likes = (Likes - 1), LikedBy = REPLACE(LikedBy, '$like_toggled_users_unique_id,', '') where SNo = $ff2;";

        if (mysqli_query($con, $like_updation_q)) {

            echo '<img src="./icons/icons8-like-icon-outlined.png" alt=""><span class="money">' . $already_existing_likes . '</span>';

        } else {
            die();
        }

    }
}
catch (Exception $some_exc) {
    echo $some_exc;
}


?>