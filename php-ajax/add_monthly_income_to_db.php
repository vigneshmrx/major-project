<?php

session_start();

include '../connect.php';


$income = $_POST["income"];
$month = $_POST["month"];
$bonus = $_POST["bonus"];
$db_name = $_POST["db_name"];
$total_income = $income + $bonus;
$year = $_POST["year"];

$fifty_percent = ($total_income * 50) / 100;
$thirty_percent = ($total_income * 30) / 100;
$twenty_percent = ($total_income * 20) / 100;

mysqli_select_db($con, $db_name);

try {
    $check_if_monthly_income_exists_q = mysqli_query($con, "select * from finance where Month = '$month' and Year = $year;");
} catch (Exception $monthly_income_checking_exc) {
    echo "<script>alert($monthly_income_checking_exc);</script>";
}

if ($check_if_monthly_income_exists_q -> num_rows > 0) {

    try {
        $update_income_query = mysqli_query($con, "update finance set Income = $income, FiftyPercent = $fifty_percent, ThirtyPercent = $thirty_percent, TwentyPercent = $twenty_percent, Bonus = $bonus where Month = '$month' and Year = $year;");
    } catch (Exception $updation_exc) {
        echo "<script>alert($updation_exc);</script>";
    }

} else {
    
    try {
        $insert_income_query = mysqli_query($con, "insert into finance(Year, Month, Income, FiftyPercent, ThirtyPercent, TwentyPercent, Bonus) values($year, '$month', $income, $fifty_percent, $thirty_percent, $twenty_percent, $bonus);");
    } catch (Exception $insertion_exc) {
        echo "<script>alert($insertion_exc);</script>";
    }

}

?>