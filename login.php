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

        function loginSuccess(type = "") {
            let commonMsgArea = document.getElementsByClassName("common-error")[0];
            commonMsgArea.innerHTML = "Login Successful!!";

            if (type == "admin") {
                setTimeout(() => {
                window.location.replace("admin.php");
                }, 1400);
            } else {
                setTimeout(() => {
                window.location.replace("finance.php");
                }, 1400);
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
                <span class="prodo">ProDo</span> !
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

        function adminFunction($admin_email, $passone) {
            include "connect.php";

            try {
                mysqli_select_db($con, "prodo_db");
            } catch (Exception $e2) {
                die("<script>callErr(3);</script>");
            }

            $admin_email_q = "select * from admin_table where Email = '$admin_email'";
            $admin_email_res = mysqli_query($con, $admin_email_q);

            try {

                $row = mysqli_fetch_assoc($admin_email_res);
                if ($row == NULL) {
                    // echo "admin inside";
                    die("<script>callErr(1);</script>");
                } else {
                    $original_pwd = $row["Password"];

                    if (password_verify($passone, $original_pwd)) {
                        echo "<script>localStorage.setItem('emailID', '$admin_email');</script>";
                        echo "<script>localStorage.setItem('user-type', 'admin');</script>"; 
                        echo "<script>localStorage.setItem('logged-in', true);</script>";

                        die("<script>loginSuccess('admin');</script>");
                    }
                    else {
                        die("<script>pwdErr();</script>");
                    }
                }

            }
            catch (Exception $some_excone) {}

        }

        if(isset($_POST["login"])) {
            include "connect.php";

            if (str_contains($email, ".prodoad")) {
                adminFunction($email, $passone);
            }

            //selecting the database
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
                        $user_type = $row["role"];

                        $join_date = substr($row["join_date"], 0, 10);

                        // $_SESSION["user_name"] = $full_name;
                        // $_SESSION["db_name"] = $db_name;
                        // $_SESSION["email"] = $email;
                        // echo "session is set";

                        // $_SESSION["logged_in"] = true

                        echo "<script>localStorage.setItem('userName', '$full_name');</script>";
                        echo "<script>localStorage.setItem('dbName', '$db_name');</script>";
                        echo "<script>localStorage.setItem('emailID', '$email');</script>";
                        echo "<script>localStorage.setItem('user-type', '$user_type');</script>"; 
                        echo "<script>localStorage.setItem('logged-in', true);</script>";
                        echo "<script>localStorage.setItem('joinDate', '$join_date');</script>";
                        
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