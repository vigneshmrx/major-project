<?php
    session_start();
    include '../connect.php';

    $db_name = $_POST["db_name"];
    // $db_name = "eren_user";

    mysqli_select_db($con, $db_name);

    $total_income = $spent_cat_a = $spent_cat_b = $spent_cat_c = $div_a = $div_b = $div_c = 0;

    $page_content = '<div id="income-after-expense-bx">TOTAL INCOME REMAINING <abbr title="It is the sum of the total remaining income of all the months"><img src="./icons/icons8-info-50.png" style="width: 17px; height: 17px; cursor: pointer;"></abbr><div id="af-exp-income-amt">';

    try {

        $finding_total_income_q = mysqli_query($con, "select sum(Income) as TotalIncome, Sum(Bonus) as TotalBonus from finance;");

        $row = mysqli_fetch_assoc($finding_total_income_q);
        // echo var_dump($row);

        $row["TotalIncome"] != NULL ? $total_income = $row["TotalIncome"] : "" ;

        $row["TotalBonus"] != NULL ? $total_income += $row["TotalBonus"] : "" ;

        $twenty_percent = ($total_income * 20) / 100;

        // echo $total_income;

        //finding total spent in Category A
        $finding_total_spent_cat_a_q = mysqli_query($con, "select sum(Cost) as TotalSpentA from monthly_expense where Category='A';");

        //finding total spent in Category B
        $finding_total_spent_cat_b_q = mysqli_query($con, "select sum(Cost) as TotalSpentB from monthly_expense where Category='B';");

        //finding total spent in Category C
        $finding_total_spent_cat_c_q = mysqli_query($con, "select sum(Cost) as TotalSpentC from monthly_expense where Category='C';");

        $row = mysqli_fetch_assoc($finding_total_spent_cat_a_q);
        $row["TotalSpentA"] != NULL ? $spent_cat_a = $row["TotalSpentA"] : "" ;


        $row = mysqli_fetch_assoc($finding_total_spent_cat_b_q);
        $row["TotalSpentB"] != NULL ? $spent_cat_b = $row["TotalSpentB"] : "" ;


        $row = mysqli_fetch_assoc($finding_total_spent_cat_c_q);
        $row["TotalSpentC"] != NULL ? $spent_cat_c = $row["TotalSpentC"] : "" ;

        // echo "A: " . $spent_cat_a;
        // echo "B: " . $spent_cat_b;
        // echo "C: " . $spent_cat_c;

        $finding_total_in_div_a_q = mysqli_query($con, "select sum(FiftyPercent) as FiftyPercent from finance;");
        $finding_total_in_div_b_q = mysqli_query($con, "select sum(ThirtyPercent) as ThirtyPercent from finance;");
        $finding_total_in_div_c_q = mysqli_query($con, "select sum(TwentyPercent) as TwentyPercent from finance;");

        $row = mysqli_fetch_assoc($finding_total_in_div_a_q);
        $row["FiftyPercent"] != NULL ? $div_a = $row["FiftyPercent"] : "" ;

        $row = mysqli_fetch_assoc($finding_total_in_div_b_q);
        $row["ThirtyPercent"] != NULL ? $div_b = $row["ThirtyPercent"] : "" ;

        $row = mysqli_fetch_assoc($finding_total_in_div_c_q);
        $row["TwentyPercent"] != NULL ? $div_c = $row["TwentyPercent"] : "" ;

        // echo "<br>50%: " . $div_a; 
        // echo "<br>30%: " . $div_b; 
        // echo "<br>20%: " . $div_c; 

        $total_remaining = $total_income - ($spent_cat_a + $spent_cat_b + $spent_cat_c);

        // echo "Total Remaining: " . $total_remaining;
        $total_remaining_cat_a = $div_a - $spent_cat_a;
        $total_remaining_cat_b = $div_b - $spent_cat_b;
        $total_remaining_cat_c = $div_c - $spent_cat_c;

        $page_content = $page_content . '<span class="money">' . $total_remaining . '</span></div></div>' . '<div id="income-after-expense-div-bx">REMAINING DIVISION' . '<div id="af-exp-income-div-amt"><span class="money">50%</span>: <span class="money">' . $total_remaining_cat_a . '</span> <br><span class="money">30%</span>: <span class="money">' . $total_remaining_cat_b . '</span> <br><span class="money">20%</span>: <span class="money">' . $total_remaining_cat_c . '</span></div></div>';

        // echo $page_content; 
        if ($twenty_percent != 0) {
            if ($total_remaining < $twenty_percent) {
                $page_content = $page_content . "1";
            } else {
                $page_content = $page_content . "0";
            }
        } else {
            $page_content = $page_content. "0";
        }

        echo $page_content;

        // echo "Tota A  remaining: " . $total_remaining_cat_a;

    }
    catch (Exception $some_exc) {
        echo $some_exc;
    }

?>