<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- <link rel="stylesheet" href="signup.css"> -->
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/signup.css';
    ?>
    </style>
    <script defer>
    function callErr(errorNo) {
        console.log("Call error has been called with " + errorNo);
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

                // case 4: usernameMistake();
        }
    }

    function techErr() {
        let errorMsgArea = document.getElementsByClassName("common-error")[0];
        errorMsgArea.innerHTML = "Some error occured. Please try again later";
    }

    function emailErr() {
        let usrnamArea = document.getElementsByClassName("email-error")[0];
        usrnamArea.innerHTML = "Email already in use";
    }

    function longPwdErr() {
        let pwdArea = document.getElementsByClassName("pwd-error")[0];
        pwdErr.innerHTML = "Password should be less than 30 characters";
    }

    // function usernameMistake() {
    //     let usrnamArea = document.getElementsByClassName("username-error")[0];
    //     usrnamArea.innerHTML = "Use only letters and underscores for username";
    // }

    function pwdErr() {
        let pwdArea = document.getElementsByClassName("repeat-pwd-error")[0];
        pwdArea.innerHTML = "The two passwords do not match";
    }

    function loginSuccess() {
        let errorMsgArea = document.getElementsByClassName("common-error")[0];
        errorMsgArea.innerHTML = "Registration Successful";

        setTimeout(() => {
            window.location.replace("finance.php");
        }, 1500);
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
        // $lname = $username = $passone = $passtwo = "";
    ?>

    <div class="container">
        <div class="left-area">
            <div class="greeting-area">
                Welcome to
                <span class="prodo">ProDo</span> !<br>
                Your ultimate personal productivity assistant.
            </div>
        </div>
        <div class="right-area">
            <div class="form-area">
                <form action="" method="post">
                    <div class="flex-line line" style="display: flex;">
                        <div class="fname">
                            FIRST NAME: <br>
                            <input type="text" name="f_name" id="" value="<?php echo $fname; ?>" required>
                            <!-- pattern="/^[A-Za-z\s]*$/" -->
                        </div>
                        <div class="lname">
                            LAST NAME: <br>
                            <input type="text" name="l_name" id="" value="<?php echo $lname; ?>" required>
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
                        <input type="password" name="pass_one" maxlength="30" value="<?php echo $passone; ?>" required>
                    </div>

                    <div class="line pwd-error">
                        <!-- Pwd error -->
                    </div>

                    <div class="line">
                        REPEAT PASSWORD: <br>
                        <input type="password" name="pass_two" maxlength="30" value="<?php echo $passtwo; ?>" required>
                    </div>

                    <div class="line repeat-pwd-error">
                        <!-- Password doesn't match -->
                    </div>

                    <div class="flex-line line">
                        <!-- <input type="submit" value="Login" name="login"> -->
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

        if(isset($_POST["sign_up"])) {
            include "connect.php";

            //usernmae mistake checking
            // $contains_dollar = str_contains($username, "$");
            // $contains_hiphen = str_contains($username, "-");
            // $contains_dot = str_contains($username, ".");

            // if ($contains_dollar || $contains_dot || $contains_hiphen) {
            //     echo "<script>console.log('It has reached here');</script>";
            //     die("<script>callErr(4);</script>");
            // }

            try {
                mysqli_select_db($con, "prodo_db");
            } catch (Exception $e2) {
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

                die("<script>callErr(3);</script>");
                
            }

            //hashing pwd
            $hashed_pwd = password_hash($passone, PASSWORD_DEFAULT);

            // var_dump($hashed_pwd);
            $full_name = $fname . " " . $lname;
            var_dump($full_name);

            //creating account for the user
            $adding_user_query = "insert into users_list (name, email, password, role, reading_goals) values('$full_name', '$email', '$hashed_pwd', 'reader', 0)";
            $adding_user_success = mysqli_query($con, $adding_user_query);

            $user_type = "reader";

            //creating db for the new user along with tables
            $pos_of_a = strpos($email, "@");
            $extracted_part_of_email = substr($email, 0, $pos_of_a);
            
            try {
                $db_name = $extracted_part_of_email . "_user";
                $db_name = str_replace(".", "_", $db_name);
                $create_db_query = mysqli_query($con, "create database " . $db_name);
                echo "Database created";

                //selecting the user's DB
                mysqli_select_db($con, $db_name);

                //creating bookshelf table
                try {

                    $create_bookshelf_table_q = mysqli_query($con, "create table bookshelf(SNo int AUTO_INCREMENT PRIMARY KEY, BookName varchar(40) not null, Author varchar(20) not null, Status varchar(9), Year int(4));");

                } catch (Exception $ef) {
                    echo $ef;
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
                }
    
            } catch (Exception $ee) {
                echo "Databse no";
                echo $ee;
            }

            if ($adding_user_success) {
                // $_SESSION["user_name"] = $full_name;
                // $_SESSION["db_name"] = $db_name;
                // $_SESSION["email"] = $email;
                // $_SESSION["logged_in"] = true;
                // $_SESSION["user_type"]
                echo "<script>localStorage.setItem('user-type', 'reader');</script>";
                echo "<script>localStorage.setItem('logged-in', true);</script>";

                echo "<script>localStorage.setItem('userName', '$full_name');</script>";
                echo "<script>localStorage.setItem('dbName', '$db_name');</script>";
                echo "<script>localStorage.setItem('emailID', '$email');</script>";
                
                die("<script>loginSuccess();</script>");
            } else {
                echo "<script>callErr(3)</script>";
            }
        }
    ?>
</body>

</html>