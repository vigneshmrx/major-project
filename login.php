<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style><?php include './css/common-styles.css'; ?></style>
    <style><?php include './css/signup.css'; ?></style>

    <script defer>
        window.history.forward(); 
        function noBack() { 
            window.history.forward(); 
        }
        
        function callErr(errorNo) {
            switch (errorNo) {
                case 1: userNotExist();
                        break;

                case 2: pwdErr();
                        break;

                case 3: techErr();
                        break;
            }
        }

        function techErr() {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "Some error occured. Please try again later."; 
        }   

        function userNotExist() {
            let commonMsgArea = document.getElementsByClassName("common-error")[0];
            commonMsgArea.innerHTML = "User doesn't exist";
        }

        // function usernameMistake() {
        //     let usrnamArea = document.getElementsByClassName("username-error")[0];
        //     usrnamArea.innerHTML = "Use only letters and underscores for username";
        // }

        function pwdErr() {
            let pwdArea = document.getElementsByClassName("pwd-error")[0];
            pwdArea.innerHTML = "Entered password is wrong";
        }

        function loginSuccess() {
            let commonMsgArea = document.getElementsByClassName("common-error")[0];
            commonMsgArea.innerHTML = "Login Successful!!";

            setTimeout(() => {
                window.location.replace("bookshelf.php");
            }, 1400);
        }

        // function checkPwdFun(thePwd, userName) {
        //     let enteredPwd = document.getElementsByName("pass_one")[0].value;

        //     if (enteredPwd == thePwd) {
        //         loginSuccess(userName);
        //     } else {
        //         let pwdArea = document.getElementsByClassName("pwd-error")[0];
        //         pwdArea.innerHTML = "Entered password is wrong";
        //     }
        // }
    </script>
</head>
<body>
    <?php
        $email = $passone = "";
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $passone = $_POST["pass_one"];
        }
    ?>

    <div class="container">
        <div class="left-area">
            <div class="greeting-area">
                Welcome back to <br>
                <span class="checkmate">ProDo</span>!
            </div>
        </div>
        <div class="right-area">
            <div class="form-area">
                <form action="" method="post" onsubmit="">
                    <div class="line">
                        EMAIL: <br>
                        <input type="email" name="email" value = "<?php echo $email; ?>" required>
                    </div>

                    <div class="line username-error">
                        <!-- User-name-error -->
                    </div>

                    <div class="line">
                        PASSWORD: <br>
                        <input type="password" name="pass_one" value = "<?php echo $passone; ?>"  required>
                    </div>

                    <div class="line pwd-error">
                        <!-- Pwd error -->
                    </div>
                    
                    <div class="flex-line line">
                        <!-- <input type="submit" value="Login" name="login"> -->
                        <input type="submit" value="LOG IN" name="login" id="loginBtn">
                    </div>

                    <div class="line" style="text-align: center;">
                        Don't have an account? <a href="signup.php">Sign up</a>
                    </div>

                    <div class="line common-error">
                        <!-- common error -->
                    </div>

                    
                </form>
            </div>
        </div>
    </div>

    <?php

        if(isset($_POST["login"])) {
            include "connect.php";

            //selecting the database
            try {
                mysqli_select_db($con, "prodo_db");
            } catch (Exception $e2) {
                die("<script>callErr(3);</script>");
            }

            //email checking
            $email_query = "select * from users where email='$email'";
            $email_res = mysqli_query($con, $email_query); //result is an associative array

            try {
                $row = mysqli_fetch_assoc($email_res);
                if ($row == NULL) {
                    die("<script>callErr(1);</script>");
                } else {
                    $original_pwd = $row["password"];

                    // echo "<script>checkPwdFun('$original_pwd', '$email');</script>";

                    if (password_verify($passone, $original_pwd)) {
                        $pos_of_a = strpos($email, "@");
                        $extracted_part_of_email = substr($email, 0, $pos_of_a);
                        
                        $db_name = $extracted_part_of_email . "_user";
                        $db_name = str_replace(".", "_", $db_name);

                        $full_name = $row["name"];

                        $_SESSION["user_name"] = $full_name;
                        $_SESSION["db_name"] = $db_name;
                        $_SESSION["email"] = $email;
                        echo "session is set";
                        echo "<script>loginSuccess();</script>";
                    } else {
                        echo "<script>pwdErr();</script>";
                    }
                }
                
            } catch (Exception $e) {}
        }
    ?>
</body>
</html>