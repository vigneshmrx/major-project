<?php

include '../connect.php';

$passone = $_POST["password"];
$email = $_POST["email"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
//hashing pwd
$hashed_pwd = password_hash($passone, PASSWORD_DEFAULT);

$full_name = $fname . " " . $lname;

//creating db for the new user along with tables
$pos_of_a = strpos($email, "@");
$extracted_part_of_email = substr($email, 0, $pos_of_a);

date_default_timezone_set('Asia/Kolkata');
$db_name = $extracted_part_of_email . "_" . (int) date("i") . (int) date("H") . (int) date("d") . "_user";
$db_name = str_replace(".", "_", $db_name);

mysqli_select_db($con, "prodo_db");

//creating account for the user
$adding_user_query = "insert into users_list (name, email, password, role, reading_goals, join_date, db_name) values('$full_name', '$email', '$hashed_pwd', 'reader', 0, current_timestamp(), '$db_name')";
$adding_user_success = mysqli_query($con, $adding_user_query);

$user_type = "reader";

try {
    $create_db_query = mysqli_query($con, "create database " . $db_name);

    //selecting the user's DB
    mysqli_select_db($con, $db_name);

    //creating bookshelf table
    try {
        $create_bookshelf_table_q = mysqli_query($con, "create table bookshelf(SNo int AUTO_INCREMENT PRIMARY KEY, BookName varchar(60) not null, Author varchar(30) not null, Status varchar(10) not null, Year int(4) not null);");
    } catch (Exception $ef) {
        // die("Error");/
        die($ef);
    }

    //creating finance table
    try {
        $create_finance_table_q = mysqli_query($con, "create table finance(SNo int AUTO_INCREMENT PRIMARY KEY, Year int(4) not null, Month varchar(15) not null, Income double not null, FiftyPercent double not null, ThirtyPercent double not null, TwentyPercent double not null, Bonus double not null);");
        //creating monthly_expense table
        try {
            $create_monthly_expense_tab_q = mysqli_query($con, "create table monthly_expense(SNo int AUTO_INCREMENT PRIMARY KEY, Date date not null, Month varchar(15) not null, TitleOfExpense varchar(200) not null, Cost double not null, Category char(2) not null);");
        } catch (Exception $monthly_expense_exc) {
            echo $monthly_expense_exc;
        }
    } catch (Exception $finance_creation_exc) {
        echo $finance_creation_exc;
        die("Error");
    }
} catch (Exception $ee) {
    die($ee);
    // die("Error");
}

if ($adding_user_success) {
    // echo "<script>localStorage.setItem('user-type', 'reader');</script>";
    // echo "<script>localStorage.setItem('logged-in', true);</script>";

    $today_date = date("Y") . "-" . date("m") . "-" . date("d");

    // echo "<script>localStorage.setItem('userName', '$full_name');</script>";
    // echo "<script>localStorage.setItem('dbName', '$db_name');</script>";
    // echo "<script>localStorage.setItem('emailID', '$email');</script>";
    // echo "<script>localStorage.setItem('joinDate', '$today_date');</script>";

    echo $full_name . "," . $db_name . "," . $email . "," . $today_date. ",";
    
    die("Success");
} else {
    echo "Error";
}

?>