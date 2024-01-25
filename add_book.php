<?php
session_start();

include './connect.php';

$book_name = $_POST["book_name"];
$book_author = $_POST["book_author"];
$current_year = date("Y");

mysqli_select_db($con, $_SESSION["db_name"]);

$check_if_already_exists_q = mysqli_query($con, "select * from bookshelf where BookName = '$book_name' and Author = '$book_author';");

if ($check_if_already_exists_q -> num_rows == 0) {
    try {
        $insert_book_info_to_table_q = mysqli_query($con, "insert into bookshelf(BookName, Author, Status, Year) values('$book_name', '$book_author', 'to read', $current_year);");
    } catch (Exception $not_able_to_insert) {}
} else {}


?>