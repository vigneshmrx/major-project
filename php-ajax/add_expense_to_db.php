<?php
session_start();

include '../connect.php';

$exp_date = $_POST["exp_date"];
$exp_title = $_POST["exp_title"];
$exp_title = str_replace("'", "\'", $exp_title);
$cost = $_POST["cost"];
$exp_category = $_POST["exp_category"];
$unique_id = $_POST["unique_id"];
$db_name = $_POST["db_name"];
$month = $_POST["month"];

mysqli_select_db($con, $db_name);

try {

    if ($unique_id == 0) {

        $insert_exp_into_db_q = mysqli_query($con, "insert into monthly_expense (Date, Month, TitleOfExpense, Cost, Category) values('$exp_date', '$month', '$exp_title', $cost, '$exp_category');");

    } else {

        $update_exp_log_q = mysqli_query($con, "update monthly_expense set Date = '$exp_date', Month = '$month', TitleOfExpense = '$exp_title', Cost = $cost, Category = '$exp_category' where SNo = $unique_id;");

    }

} catch (Exception $insertion_into_db_q_exc) {
    echo "Some technical issue. Please try again later!";
}


?>