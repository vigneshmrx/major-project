<?php

session_start();

include '../connect.php';

// $db_name = $_SESSION["db_name"];
$db_name = $_POST["db_name"];
$unique_id = $_POST["unique_id"];
// $book_status = $_POST["book_status"];
// $book_name = $_POST["book_name"];
// $author = $_POST["book_author"];

try {
    mysqli_select_db($con, $db_name);

    $get_the_record = mysqli_query($con, "select Status from bookshelf where SNo = $unique_id;");

    $row = mysqli_fetch_assoc($get_the_record);

    if ($row["Status"] == "to read") {
        $book_status = "completed";
    } else {
        $book_status = "to read";
    }

    if ($book_status == "to read") {

        $cur_year = date("Y");

        $add_book_to_readlist_q = mysqli_query($con, "update bookshelf set Status='$book_status', Year=$cur_year where SNo = $unique_id");

    } else {

        $add_book_to_completed_list_q = mysqli_query($con, "update bookshelf set Status = '$book_status' where SNo = $unique_id;");

    }

    
} catch (Exception $status_updation_exception) {
    echo $status_updation_exception;
}

?>