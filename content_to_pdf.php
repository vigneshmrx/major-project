<?php

include './connect.php';

date_default_timezone_set("Asia/Kolkata");

$content = '<html><head><style>
@import url("https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap");

@page {
    margin-top: 100px;
    margin-bottom: 70px;
}

header {
    postition: fixed;
    right: 0px;
    left: 0px;
    text-align: right;
    height: 60px;
    margin-top: -60px;
}

body {
    font-family: "Roboto Mono", sans-serif;
}

.show-full-details-content-area {
    padding: 10px;
    font-size: 12px;
}

.heading {
    text-align: center;
    text-decoration: underline;
    font-size: 25px;
}

#full-details-table {
    width: 100%;
    margin: auto;
    text-align: center;
    background-color: #fff;
    border: 2px solid;
    border-top: 0px;
}

#full-details-table td, th {
    padding: 10px;
}

#full-details-table td {
    border-bottom: 1px solid;
}

#full-details-table th {
    background-color: #000;
    color: #fff;
    text-transform: uppercase;  
    font-weight: normal;
    font-size: 15px;
    padding: 5px 10px;
}

#full-details-table tr {
    border-bottom: 2px solid;
}

.five {
    width: 5%;
}

.ten {
    width: 10%;
}

.fifteen {
    width: 15%;
}

.thirty {
    width: 30%;
}

.thirty-five {
    width: 35%;
}

.forty {
    width: 40%;
}

</style>
</head>
<body>
<header>Created on ' . getdate()["weekday"] . ', ' . date("Y-m-d") . '
</header>
<div class="show-full-details-content-area">';

require_once "./vendor/autoload.php";

use Dompdf\Dompdf;

try {

    $dompdf = new Dompdf();

    $dompdf->set_option('isRemoteEnabled', true);

    $db_name = $_REQUEST["param1"];
    $data_name = $_REQUEST["param2"];

    mysqli_select_db($con, $db_name);

    $count = 1;
    if ($data_name == "books") {

        $content = $content . '<div class="heading">BOOKSHELF</div><br><table id="full-details-table" cellspacing="0"><tr><th>SNo</th><th>Year</th><th>Book Name</th><th>Author</th><th>Status</th></tr>';

        $get_books_q = mysqli_query($con, "select * from bookshelf order by Year");

        
        while ($row = mysqli_fetch_assoc($get_books_q)) {

            $status = $row["Status"];

            if ($status == "completed") {
                $status = "Completed";
            } else {
                $status = "Unread/Incomplete";  
            }

            $content = $content . '<tr><td class="ten">' . $count . '</td><td class="ten">' . $row["Year"] . '</td><td class="thirty-five">' . $row["BookName"] . '</td><td class="thirty">' . $row["Author"] . '</td><td class="fifteen">' . $status . '</td></tr>';

            $count++;
        }
    } else {
        $content = $content . '<div class="heading">FINANCE LOG</div><br><table id="full-details-table" cellspacing="0"><tr><th>SNo</th><th>Date</th><th>Month</th><th>Category</th><th>Description</th><th>Cost</th></tr>';

        $get_expense_log_q = mysqli_query($con, "select * from monthly_expense order by Date;");

        // $count = 1;  
        while ($row = mysqli_fetch_assoc($get_expense_log_q)) {
            $cat = $row["Category"];

            if ($cat == "A") {
                $cat = $cat . " (50%)";
            } else if ($cat == "B") {
                $cat = $cat . " (30%)";
            } else {
                $cat = $cat . " (20%)";
            }

            $date = substr($row["Date"], 8, 2) . '-' . substr($row["Date"], 5, 3) . substr($row["Date"], 0, 4);

            $content = $content . '<tr><td class="five">' . $count . '</td><td class="fifteen">' . $date . '</td><td class="fifteen">' . $row["Month"] . '</td><td class="ten">' . $cat . '</td><td class="forty">' . $row["TitleOfExpense"] . '</td><td class="fifteen">' . $row["Cost"] . '</td></tr>';

            $count++;
        }
    }

    $content = $content . '</table></div></body></html>';

    // $contentt = $db_name;
    // $contentt = $data_name;

    $dompdf->loadHtml($content);

    $dompdf->render();

    if ($data_name == "books") {
        $dompdf->stream("bookshelf.pdf");
    } else {
        $dompdf->stream("finance_log.pdf");
    }

    
} catch (Exception $some_exception) {
    // echo "<script>alert($some_exception);</script>";
    echo $some_exception;
}

?>

?>