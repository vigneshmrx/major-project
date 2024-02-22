<?php
    session_start();
    include '../connect.php';

    $db_name = $_POST["db_name"];
    $selected_exp_month = $_POST["selected_exp_month"];
    $cur_year = date("Y");

    mysqli_select_db($con, $db_name);


    $finding_logged_exp_q = mysqli_query($con, "select * from monthly_expense where Month='$selected_exp_month' and YEAR(Date) = $cur_year;");

    if ($finding_logged_exp_q -> num_rows > 0) {
        while ($row = mysqli_fetch_assoc($finding_logged_exp_q)) {
            echo '<div class="exp-info-box"><div class="exp-info-date"><div class="date-box">' . $row["Date"] . '</div></div>' . '<div class="exp-info-area"><div class="exp-info-left-area">' . $row["TitleOfExpense"] . '<div class="cost-box">' . $row["Cost"] . '</div></div>' . '<div class="exp-info-right-area"><div class="modify-exp-icon" style="height: 30px;">' . '<abbr title="edit"><img src="./icons/icons8-edit-60.png" alt="" style="width: 30px;"></abbr>' . '</div>' . '<div class="remove-exp-icon" style="height: 30px;"><abbr title="delete"><img src="./icons/icons8-close-64.png" alt="" style="width: 30px;"><abbr>' . '</div></div></div></div>';
        }
    } else {
        echo 'No expense added yet!';
    }
?>