<?php
session_start();

include '../connect.php';

$db_name = $_POST["db_name"];
$unique_id = $_POST["unique_id"];
$table_name = $_POST["table_name"];

try {
    mysqli_select_db($con, $db_name);

    $remove_book_q = mysqli_query($con, "delete from $table_name where SNo = $unique_id;");
} catch (Exception $remove_book_exception) {
    echo "Some error occured. Please try again later.";
}

?>