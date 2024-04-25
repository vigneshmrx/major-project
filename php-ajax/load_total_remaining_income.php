<?php
    session_start();
    include '../connect.php';

    $db_name = $_POST["db_name"];
    // $db_name = "eren_user";

    function returnRoundedAmt($amt) {
        $new_amt;
        $amt = (string) $amt;
        $len = strlen($amt);
        if ($len > 9) {
            $after_nine = $len - 9;
            $new_amt = substr($amt, 0, $after_nine);
            $new_amt = $new_amt . "." . substr($amt, $after_nine);
            $new_amt = round($new_amt, 2);
            //echo $new_amt;
            
            if (substr($new_amt, $after_nine  + 1, 1) == "0" && substr($new_amt, $after_nine, 1) == "0") {
                $flag = 1;
                // echo "In HERE";
                $new_amt = substr($new_amt, $after_nine) . "B";
            } else {
                $new_amt = $new_amt . "B";
            }
            
            // return $new_amt;
        } else if ($len > 6) {
            $after_six = $len - 6;
            $new_amt = substr($amt, 0, $after_six);
            $new_amt = $new_amt . "." . substr($amt, $after_six);
            $new_amt = round($new_amt, 2);

            if (substr($new_amt, $after_six  + 1, 1) == "0" && substr($new_amt, $after_six, 1) == "0") {
                $flag = 1;
                // echo "In HERE";
                $new_amt = substr($new_amt, $after_six) . "M";
            } else {
                $new_amt = $new_amt . "M";
            }
        } else if ($len > 3) {
            $after_three = $len - 3;
            $new_amt = substr($amt, 0, $after_three);
            $new_amt = $new_amt . "." . substr($amt, $after_three);
            $new_amt = round($new_amt, 2);

            if (substr($new_amt, $after_three  + 1, 1) == "0" && substr($new_amt, $after_three, 1) == "0") {
                $flag = 1;
                // echo "In HERE";
                $new_amt = substr($new_amt, $after_three) . "K";
            } else {
                $new_amt = $new_amt . "K";
            }
        }
        if ($new_amt == null) {
            return $amt;
        } else {
            return $new_amt;
        }
    }

    mysqli_select_db($con, $db_name);

    $total_income = $spent_cat_a = $spent_cat_b = $spent_cat_c = $div_a = $div_b = $div_c = 0;

    $page_content = '<div id="income-after-expense-bx">TOTAL INCOME REMAINING <abbr title="It is the sum of the total remaining income of all the months"><img src="./icons/icons8-info-50.png" style="width: 17px; height: 17px; cursor: pointer;"></abbr><div id="af-exp-income-amt">';

    try {

        $finding_total_income_q = mysqli_query($con, "select sum(Income) as TotalIncome, Sum(Bonus) as TotalBonus from finance;");

        $row = mysqli_fetch_assoc($finding_total_income_q);

        $row["TotalIncome"] != NULL ? $total_income = $row["TotalIncome"] : "" ;

        $row["TotalBonus"] != NULL ? $total_income += $row["TotalBonus"] : "" ;

        $twenty_percent = ($total_income * 20) / 100;

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

        $finding_total_in_div_a_q = mysqli_query($con, "select sum(FiftyPercent) as FiftyPercent from finance;");
        $finding_total_in_div_b_q = mysqli_query($con, "select sum(ThirtyPercent) as ThirtyPercent from finance;");
        $finding_total_in_div_c_q = mysqli_query($con, "select sum(TwentyPercent) as TwentyPercent from finance;");

        $row = mysqli_fetch_assoc($finding_total_in_div_a_q);
        $row["FiftyPercent"] != NULL ? $div_a = $row["FiftyPercent"] : "" ;

        $row = mysqli_fetch_assoc($finding_total_in_div_b_q);
        $row["ThirtyPercent"] != NULL ? $div_b = $row["ThirtyPercent"] : "" ;

        $row = mysqli_fetch_assoc($finding_total_in_div_c_q);
        $row["TwentyPercent"] != NULL ? $div_c = $row["TwentyPercent"] : "" ;

        $total_remaining = $total_income - ($spent_cat_a + $spent_cat_b + $spent_cat_c);

        $total_remaining_cat_a = $div_a - $spent_cat_a;
        $total_remaining_cat_b = $div_b - $spent_cat_b;
        $total_remaining_cat_c = $div_c - $spent_cat_c;

        $flag_val;

        if ($twenty_percent != 0) {
            if ($total_remaining < $twenty_percent) {
                // $page_content = $page_content . "1";
                $flag_val = "1";
            } else {
                // $page_content = $page_content . "0";
                $flag_val = "0";
            }
        } else {
            // $page_content = $page_content. "0";
            $flag_val = "0";
        }

        // $total_remaining = returnRoundedAmt($total_remaining);
        $total_remaining = number_format($total_remaining);
        $total_remaining_cat_a = number_format($total_remaining_cat_a);
        $total_remaining_cat_b = number_format($total_remaining_cat_b);
        $total_remaining_cat_c = number_format($total_remaining_cat_c);

        $page_content = $page_content . '<span class="money">' . $total_remaining . '</span></div></div>' . '<div id="income-after-expense-div-bx">REMAINING DIVISION' . '<div id="af-exp-income-div-amt"><span class="money">50%</span>: <span class="money">' . $total_remaining_cat_a . '</span> <br><span class="money">30%</span>: <span class="money">' . $total_remaining_cat_b . '</span> <br><span class="money">20%</span>: <span class="money">' . $total_remaining_cat_c . '</span></div></div>' . $flag_val;

        // echo $page_content; 
        

        echo $page_content;

    }
    catch (Exception $some_exc) {
        echo $some_exc;
    }

?>