<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
    <?php include './css/common-styles.css'; ?>
    <?php include './css/signup.css'; ?>
    </style>
    <script defer>
        function callErr(errorNo) {
            switch (errorNo) {
                case 1:
                    emailErr();
                    break;

                case 2:
                    pwdErr();
                    break;

                case 3:
                    techErr();
                    break;

                case 4: restrictedRegistration();
                        break;
            }
        }

        function techErr() {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "Some error occured. Please try again later";
        }

        function restrictedRegistration() {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "You are not allowed to register yourself!";
        }

        function emailErr() {
            let usrnamArea = document.getElementsByClassName("email-error")[0];
            usrnamArea.innerHTML = "Email already in use";
        }

        function emailMistake() {
            let usrnamArea = document.getElementsByClassName("email-error")[0];
            usrnamArea.innerHTML = "Please enter a valid email address";
        }

        function longPwdErr() {
            let pwdArea = document.getElementsByClassName("pwd-error")[0];
            pwdErr.innerHTML = "Password should be less than 30 characters";
        }

        function pwdErr() {
            let pwdArea = document.getElementsByClassName("repeat-pwd-error")[0];
            pwdArea.innerHTML = "The two passwords do not match";
        }

        function loginSuccess(type = "") {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "Registration Successful";

            if (type == "admin") {
                setTimeout(() => {
                    window.location.replace("admin.php");
                }, 1500);
            }
            else 
            {
                setTimeout(() => {
                    window.location.replace("finance.php");
                }, 1500);
            }
        }

        let loggedIn = localStorage.getItem("logged-in");
        let userType = localStorage.getItem("user-type");

        if (loggedIn != null && loggedIn != undefined && loggedIn == true) {
            if (userType == "admin") {
                window.location.href = "admin.php";
            } else {
                window.location.href = "finance.php";
            }
        }

        function togglePasswordShow() {
            let showPasswordCB = document.querySelector("input[name=checkbox]");
            let passwordAreaOne = document.querySelector("input[name=pass_one]");
            let passwordAreaTwo = document.querySelector("input[name=pass_two]");

            if (showPasswordCB.checked) {
                passwordAreaOne.type = passwordAreaTwo.type = "text";
            } else {
                passwordAreaOne.type = passwordAreaTwo.type = "password";
            }
        }
    </script>
</head>

<body>
    <?php
        $fname = $lname = $email = $passone = $passtwo = "";

        if (isset($_POST["sign_up"])) {
            $fname = $_POST["f_name"]; 
            $lname = $_POST["l_name"];
            $email = $_POST["email"];
            $passone = $_POST["pass_one"];
            $passtwo = $_POST["pass_two"];

            if (strlen($passone) >= 30) {
                die("<script>longPwdErr();</script>");
            }
        }
    ?>

    <div class="container">
        <div class="left-area">
            <div class="greeting-area">
                Welcome to
                <span class="prodo">ProDo</span> !<br>
                Your Personal Productivity System.
            </div>
        </div>
        <div class="right-area">
            <div class="form-area">
                <form action="" method="post">
                    <div class="flex-line line" style="display: flex;">
                        <div class="fname">
                            FIRST NAME: <br>
                            <input type="text" name="f_name" value="<?php echo $fname; ?>" required>
                        </div>
                        <div class="lname">
                            LAST NAME: <br>
                            <input type="text" name="l_name" value="<?php echo $lname; ?>" required>
                        </div>
                    </div>

                    <div class="line">
                        EMAIL: <br>
                        <input type="email" name="email" value="<?php echo $email; ?>" required>
                    </div>

                    <div class="line email-error">
                        <!-- User-name-error -->
                    </div>

                    <div class="line">
                        PASSWORD: <br>
                        <input type="password" name="pass_one" minlength="5" maxlength="30" value="<?php echo $passone; ?>" required>
                    </div>

                    <div class="line pwd-error">
                        <!-- Pwd error -->
                    </div>

                    <div class="line">
                        REPEAT PASSWORD: <br>
                        <input type="password" name="pass_two" minlength="5" maxlength="30" value="<?php echo $passtwo; ?>" required>
                    </div>

                    <div class="line repeat-pwd-error">
                        <!-- Password doesn't match -->
                    </div>

                    <div class="line" style="text-align: right;">
                        <input type="checkbox" name="checkbox" id="showPasswordCB" style="margin-right: 5px;" onclick="togglePasswordShow();">Show Password
                    </div><br>      

                    <div class="flex-line line">
                        <input type="submit" value="SIGN UP" name="sign_up" id="signupBtn">
                    </div>

                    <div class="line" style="text-align: center;">
                        Already have an account? <a href="login.php">Login</a>
                    </div>

                    <div class="line common-error">
                        <!-- common error -->
                    </div>


                </form>
            </div>
        </div>
    </div>

    <?php

        function emailSpellingCheck($email) {

            if (preg_match('/^[A-Za-z\._\-0-9]*[@][A-Za-z]*[\.][a-z]{2,3}$/', $email)) {
                $pos_of_a = strpos($email, "@");

                if ($email[$pos_of_a + 1] == 'o') {
                    $pos_of_outlook_if_exists = strripos($email, "outlook");

                    if ($pos_of_outlook_if_exists != false && $pos_of_outlook_if_exists - 1 == $pos_of_a) {
                        return true;
                    } else {
                        die("<script>emailMistake();</script>");
                    }
                } else if ($email[$pos_of_a + 1] == 'y') {
                    $pos_of_yahoo_if_exists = strripos($email, "yahoo");

                    if ($pos_of_yahoo_if_exists != false && $pos_of_yahoo_if_exists - 1 == $pos_of_a) {
                        return true;
                    } else {
                        die("<script>emailMistake();</script>");
                    }
                } else if ($email[$pos_of_a + 1] == 'g') {
                    $pos_of_gmail_if_exists = strripos($email, "gmail");

                    if ($pos_of_gmail_if_exists != false && $pos_of_gmail_if_exists - 1 == $pos_of_a) {
                        return true;
                    } else {
                        die("<script>emailMistake();</script>");
                    }
                }

                die("<script>emailMistake();</script>");
            } else {
                echo "Failed at preg_match";
                die("<script>emailMistake();</script>");
            }
        }

        function adminFunction($admin_email, $passone, $passtwo, $fname, $lname) {
            include "connect.php";

            emailSpellingCheck($admin_email);

            try {
                mysqli_select_db($con, "prodo_db");
            } catch (Exception $e2) {
                die("<script>callErr(3);</script>");
            }

            $admin_email_q = "select * from admin_table where Email = '$admin_email'";
            $admin_email_res = mysqli_query($con, $admin_email_q);

            $blank_existing = 0;

            try {
                $row = mysqli_fetch_assoc($admin_email_res);
                if ($row != NULL) {
                    if ($row["Email"] != NULL && $row["JoinDate"] != "0000-00-00") {
                        die("<script>callErr(1);</script>");
                    } else {
                        $blank_existing = 1;
                    }
                } else {
                    die("<script>callErr(4);</script>");
                }
            } catch (Exception $e) {}

            if ($passone != $passtwo) {
                die("<script>callErr(2);</script>");
            }

            $hashed_pwd = password_hash($passone, PASSWORD_DEFAULT);
            $full_name = $fname . " " . $lname;

            if ($blank_existing == 1) {
                date_default_timezone_set("Asia/Kolkata");
                $present_date = date("Y-m-d");
                $adding_admin_query = "update admin_table set Name = '$full_name', Password='$hashed_pwd', JoinDate = '$present_date' where Email = '$admin_email'";
            }

            try {

                $admin_adding_success = mysqli_query($con, $adding_admin_query);

                if ($admin_adding_success) {

                    echo "<script>localStorage.setItem('user-type', 'admin');</script>";
                    echo "<script>localStorage.setItem('logged-in', true);</script>";
                    echo "<script>localStorage.setItem('emailID', '$admin_email');</script>";
                    
                    die("<script>loginSuccess('admin');</script>");
                }
            }
            catch (Exception $some_exctwo) {
                die("<script>callErr(3);</script>");
            }
        }

        if(isset($_POST["sign_up"])) {
            include "connect.php";

            if (str_contains($email, ".prodoad")) {
                adminFunction($email, $passone, $passtwo, $fname, $lname);
            }

            emailSpellingCheck($email);

            try {
                mysqli_select_db($con, "prodo_db");
            } catch (Exception $e2) {
                echo $e2;
                die("<script>callErr(3);</script>");
            }

            //email checking
            $email_query = "select * from users_list where email='$email'";
            $email_res = mysqli_query($con, $email_query); //result is an associative array
            
            try {
                $row = mysqli_fetch_assoc($email_res);
                if ($row != NULL) {
                    if ($row["email"] != NULL) {
                        die("<script>callErr(1);</script>");
                    }
                }
                
            } catch (Exception $e) {}

            //password checking
            if ($passone != $passtwo) {
                die("<script>callErr(2);</script>");
            }

            try {
                mysqli_select_db($con, "prodo_db");
            } catch (Exception $e2) {
                echo $e2;
                die("<script>callErr(3);</script>");
            }

            //hashing pwd
            $hashed_pwd = password_hash($passone, PASSWORD_DEFAULT);

            $full_name = $fname . " " . $lname;

            //creating db for the new user along with tables
            $pos_of_a = strpos($email, "@");
            $extracted_part_of_email = substr($email, 0, $pos_of_a);

            date_default_timezone_set('Asia/Kolkata');
            $db_name = $extracted_part_of_email . "_" . (int) date("i") . (int) date("H") . (int) date("d") . "_user";
            $db_name = str_replace(".", "_", $db_name);

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
                    echo $ef;
                    die("<script>callErr(3)</script>");
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
                    die("<script>callErr(3)</script>");
                }
            } catch (Exception $ee) {
                echo $ee;
                die("<script>callErr(3)</script>");
            }

            if ($adding_user_success) {
                echo "<script>localStorage.setItem('user-type', 'reader');</script>";
                echo "<script>localStorage.setItem('logged-in', true);</script>";

                $today_date = date("Y") . "-" . date("m") . "-" . date("d");

                echo "<script>localStorage.setItem('userName', '$full_name');</script>";
                echo "<script>localStorage.setItem('dbName', '$db_name');</script>";
                echo "<script>localStorage.setItem('emailID', '$email');</script>";
                echo "<script>localStorage.setItem('joinDate', '$today_date');</script>";
                
                die("<script>loginSuccess();</script>");
            } else {
                echo "<script>callErr(3)</script>";
            }
        }
    ?>
</body>

</html>