<?php
session_start();

include './connect.php';

$db_name = $_SESSION["db_name"];
$book_name = $_POST["book_name"];
$author = $_POST["book_author"];

try {
    mysqli_select_db($con, $db_name);

    $change_book_status_q = mysqli_query($con, "update bookshelf set Status='completed' where BookName = '$book_name' and Author = '$author';");
} catch (Exception $status_updation_exception) {
    echo $status_updation_exception;
}

?>