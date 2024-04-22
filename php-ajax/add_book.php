<?php
session_start();

include '../connect.php';

$book_name = $_POST["book_name"];
$book_author = $_POST["book_author"];
$status = $_POST["status"];
$db_name = $_POST["db_name"];
$record_id = $_POST["record_id"];
$book_name = str_replace("'", "\'", $book_name);
$book_author = str_replace("'", "\'", $book_author);

if (isset($_POST["year"])) {
    $year = $_POST["year"];
} else {
    $year = date("Y");
}

mysqli_select_db($con, $db_name);

try {
    if ($record_id != 0) {
        $update_book_q = mysqli_query($con, "update bookshelf set BookName = '$book_name', Author = '$book_author', Year = $year where SNo = $record_id;");
        die("Book updated successfully!");
    } else {
        $check_if_already_exists_q = mysqli_query($con, "select * from bookshelf where BookName = '$book_name' and Author = '$book_author';");
        if ($check_if_already_exists_q -> num_rows == 0) {
            $insert_book_info_to_table_q = mysqli_query($con, "insert into bookshelf(BookName, Author, Status, Year) values('$book_name', '$book_author', '$status', $year);");
            die("Book added successfully!");
        } else {
            die("The book already exists!");
        }
    }
} catch (Exception $not_able_to_insert) {
    die("Some error occured. Please try again later.");
}

?>