<?php

include '../connect.php';

$db_name = $_POST["db_name"];
$present_year = $_POST["present_year"];

$years_string = "";

try {
    $distinct_year_q = mysqli_query($con, "select distinct(Year) as DistinctYear from $db_name.bookshelf where Year != $present_year order by Year");

    while ($row = mysqli_fetch_assoc($distinct_year_q)) {
        $years_string = $years_string . $row["DistinctYear"] . ",";
    }

    echo $years_string;
}
catch (Exception $some_exc) {
    echo $years_string;
}

?>