<?php
session_start();

include '../connect.php';

$exp_date = $_POST["exp_date"];
$exp_title = $_POST["exp_title"];
$cost = $_POST["cost"];
$exp_category = $_POST["exp_category"];
$unique_id = $_POST["unique_id"];
$db_name = $_POST["db_name"];
$month = $_POST["month"];

// mysqli_select_db($con, $_SESSION["db_name"]);
mysqli_select_db($con, $db_name);

// $check_if_already_exists_q = mysqli_query($con, "select * from monthly_expense where Date=$exp_date and TitleOfExpense = '$exp_title'");

//if unique_id is 0, then inserting new one, else updating previous one
if ($unique_id == 0) {
    try {

        $insert_exp_into_db_q = mysqli_query($con, "insert into monthly_expense (Date, Month, TitleOfExpense, Cost, Category) values('$exp_date', '$month', '$exp_title', $cost, '$exp_category');");
        
    } 
    catch (Exception $insertion_of_expense_exc) {
        echo $insertion_of_expense_exc;
    }
} 
else {
    try {

        $update_exp_log_q = mysqli_query($con, "update monthly_expense set Date = '$exp_date', Month = '$month' TitleOfExpense = '$exp_title', Cost = $cost, Category = '$exp_category' where SNo = $unique_id;");

    } catch (Exception $updation_of_expense_exc) {
        echo $updation_of_expense_exc;
    }
}


?>