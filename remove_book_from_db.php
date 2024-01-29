<?php
session_start();

include './connect.php';

$db_name = $_SESSION["db_name"];
$book_name = $_POST["book_name"];
$author = $_POST["book_author"];

try {
    mysqli_select_db($con, $db_name);

    $remove_book_q = mysqli_query($con, "delete from bookshelf where BookName = '$book_name' and Author = '$author';");
} catch (Exception $remove_book_exception) {}

?>