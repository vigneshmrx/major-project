<?php
session_start();

include '../connect.php';

// $db_name = $_SESSION["db_name"];
$db_name = $_POST["db_name"];
// $book_name = $_POST["book_name"];
// $author = $_POST["book_author"];
$unique_id = $_POST["unique_id"];
$table_name = $_POST["table_name"];

try {
    mysqli_select_db($con, $db_name);

    $remove_book_q = mysqli_query($con, "delete from $table_name where SNo = $unique_id;");
} catch (Exception $remove_book_exception) {}

?>