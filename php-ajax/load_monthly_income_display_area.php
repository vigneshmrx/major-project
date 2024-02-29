<?php

session_start();

include '../connect.php';

date_default_timezone_set("Asia/Kolkata");

// mysqli_select_db($con, $_SESSION["db_name"]);

$current_month = date("F");
$current_year = date("Y");
$db_name = $_POST["db_name"];

mysqli_select_db($con, $db_name);

$this_month_income_q = mysqli_query($con, "select * from finance where Year = $current_year and Month = '$current_month';");

if ($this_month_income_q -> num_rows > 0) {
    $row = mysqli_fetch_assoc($this_month_income_q);

    $this_month_income = $row["Income"] + $row["Bonus"];
    $fifty_percent_of_income = $row["FiftyPercent"];
    $thirty_percent_of_income = $row["ThirtyPercent"];
    $twenty_percent_of_income = $row["TwentyPercent"];
} else {
    $this_month_income = $thirty_percent_of_income = $fifty_percent_of_income = $twenty_percent_of_income = 0;
}

echo '<div id="monthly-income-bx">' . 'MONTHLY INCOME' . '<div id="m-income-amt"><span class="money">' . $this_month_income . '</span></div>' . '<div class="individual-element-btn-area"><input type="button" value="MODIFY" onclick="showModifyIncomeBox();" style="font-size: 12px; padding: 5px 10px;" ></div></div>' . '<div id="monthly-income-div-bx">' . 'INCOME DIVISION <abbr title="The 50-30-20 Rule"><img src="./icons/icons8-info-50.png" style="width: 17px; height: 17px; cursor: pointer;" onclick="showIncomeRuleInfoBx();"></abbr>' . '<div id="m-income-div-amt">' . '<span class="money">50%</span>: <span class="money">' . $fifty_percent_of_income . '</span> <br><span class="money">30%</span>: <span class="money">' . $thirty_percent_of_income . '</span> <br><span class="money">20%</span>: <span class="money">' . $twenty_percent_of_income . '</span> </div>';

// function addZeros($theNumber) {
//     $length = strlen($theNumber);

//     $num_with_comma = "";

//     if ($length > 3 && $length < 6) {
//         $num_with_comma = strsp
//     }
// }


?>