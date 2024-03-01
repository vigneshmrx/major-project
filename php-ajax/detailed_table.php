<?php

session_start();

include '../connect.php';

$page_name = $_POST["page_name"];
$db_name = $_POST["db_name"];

mysqli_select_db($con, $db_name);

$page_content = '<table id="full-details-table" cellspacing="0">';

if ($page_name == "expense") {

    try {
        $get_exp_data_q = mysqli_query($con, "select * from monthly_expense order by Date;");

        if ($get_exp_data_q -> num_rows > 0) {
            $count = 1;

            $page_content = $page_content . '<tr><th>SNo</th><th>Date</th><th>Month</th><th>Category</th><th>Description</th><th>Cost</th></tr>';

            while ($row = mysqli_fetch_assoc($get_exp_data_q)) {
                $cat = $row["Category"];

                if ($cat == "A") {
                    $cat = $cat . " (50%)";
                } else if ($cat == "B") {
                    $cat = $cat . " (30%)";
                } else {
                    $cat = $cat . " (20%)";
                }

                $page_content = $page_content . '<tr><td class="five">' . $count . '</td><td class="fifteen">' . $row["Date"] . '</td><td class="fifteen">' . $row["Month"] . '</td><td class="ten">' . $cat . '</td><td class="forty">' . $row["TitleOfExpense"] . '</td><td class="fifteen">' . $row["Cost"] . '</td></tr>';

                $count++;
            }
        } else {
            die("<div style='width: 100%; margin-top: 7%; display: flex; justify-content: center; align-items: center; font-weight: bold; flex-direction: column;'><img src='../major-project/images/no-expense-illustration.png' width='25%'>EXPENSE LOG IS EMPTY!!</div>");
        }
    } 
    catch (Exception $get_exp_data_exc) {
        echo $get_exp_data_exc;
    }
} 
else {
    
    try {
        $get_books_q = mysqli_query($con, "select * from bookshelf order by Year;");

        if ($get_books_q -> num_rows > 0) {
            $count = 1;

            $page_content = $page_content . '<tr><th>SNo</th><th>Year</th><th>Book Name</th><th>Author</th><th>Status</th></tr>';

            while ($row = mysqli_fetch_assoc($get_books_q)) {
                $status = $row["Status"];

                if ($status == "to read") {
                    $status = "Unread/Incomplete";
                } else {
                    $status = "Completed"; 
                }

                $page_content = $page_content . '<tr><td class="ten">' . $count . '</td><td class="ten">' . $row["Year"] . '</td><td class="thirty-five">' . $row["BookName"] . '</td><td class="thirty">' . $row["Author"] . '</td><td class="fifteen">' . $status . '</td></tr>';

                $count++;
            }
        } else {
            die("<div style='width: 100%; margin-top: 8%; display: flex; justify-content: center; align-items: center; font-weight: bold; flex-direction: column;    ' id='no-books-to-display'><img src='../major-project/images/no-books-illustration.png' width='30%' class='remove-bg'>BOOK LOG IS EMPTY!!</div>");
        }

    } catch (Exception $get_books_exc) {
        echo $get_books_exc;
    }
}

$page_content = $page_content . "</table>";
echo $page_content;

?>