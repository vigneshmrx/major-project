<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$present_year = $_POST["present_year"];

try {
    $get_to_read_books_year = mysqli_query($con, "select distinct(Year) as DistinctYear from $db_name.bookshef where Status='to read';");

    if ($get_to_read_books_year != null || $get_to_read_books_year -> num_rows != 0) {
        $row = mysqli_fetch_assoc($get_to_read_books_year);
        $to_read_year = $row["DistinctYear"];

        if ($to_read_year < $present_year) {
            mysqli_query($con, "update $db_name.bookshelf set Year = $present_year where Status = 'to read';");
        }
    }
}
catch (Exception $some_exception) {}

?>