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
    <style>
        .custom-otp-verification-page {
            z-index: -150;
            position: fixed;
            visibility: hidden;
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
        }

        .custom-otp-verification-box {
            width: 400px;
            background-color: var(--main-white);
            box-shadow: 11px 11px  var(--main-black);
            padding: var(--common-value);
            border: 2px solid var(--main-black);
            font-weight: bold;
            text-align: center;
        }

        .otp-verification-btns-area {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .otp-verification-btn-area input[type=button] {
            width: 120px;
        }

        #alert {
            visibility: hidden;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer>
        setInterval(() => {
            let loggedIn = localStorage.getItem("logged-in");
                let userType = localStorage.getItem("user-type");
            if (loggedIn != null && loggedIn != undefined && loggedIn == "true") {
                if (userType == "admin") {
                    window.location.href = "admin.php";
                } else {
                    window.location.href = "finance.php";
                }
            }
        }, 100);

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

        let unique_io = "0";
        let sentCount = 0;

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

        function registrationCancelled() {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "Registration Cancelled";
            showOtpInputPopup(false);
            unique_io = "0";
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

        const showAlert = (message) => {
            let alert = document.getElementById("alert");

            let alertMessage = document.getElementById("alert-message");

            alertMessage.innerHTML = message;

            alert.style.zIndex = 300;
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.zIndex = -300;
                alert.style.display = "none";
            }, 2100);
        }

        function sendOTP(toShowOTPMessage) {
            let emailToSendOtp = document.getElementById("users-email");

            $.ajax({
                type: "POST",
                url: "./php-ajax/send-otp.php",
                data: {
                    email: emailToSendOtp.value
                },
                success: function(response) {
                    // unique_io = response;
                    unique_io = response;
                    sentCount++;
                    if (sentCount == 2) {
                        startResendOTPTimer(180);
                    } else if (sentCount > 2) {
                        showResendEmailOption();
                    }
                }
            });

            if (toShowOTPMessage != undefined && toShowOTPMessage == true) {
                showAlert("OTP sent successfully!");
            }

        }
        
        const showResendEmailOption = () => {
            if (sentCount == 1) {
                resendOTPArea.innerHTML = "<div style='cursor: pointer; text-decoration: underline;' onclick='sendOTP(true);'>RESEND OTP</div>";
                // clearInterval(intervalId);
            }
            else if (sentCount == 2) {
                resendOTPArea.innerHTML = "<div style='cursor: pointer; text-decoration: underline;' onclick='sendOTP(true);'>RESEND OTP</div>";
                // clearInterval(intervalId);
            } 
            else if (sentCount > 2) {
                resendOTPArea.innerHTML = "";
                // clearInterval(timeoutId);
            }
        }

        const startResendOTPTimer = (duration) => {
            let resendOTPArea = document.getElementById("resendOTPArea");

            let secs = duration;

            const intervalId = setInterval(() => {
                if (secs == 0) {
                    clearInterval(intervalId);
                    showResendEmailOption();
                } else {
                    resendOTPArea.innerHTML = "Resend OTP in " + secs;
                    secs--;
                }
            }, 1000);

        }

        let expiryIntervalId;

        const startOTPExpiryCountDown = () => {
            console.log("Expiry timer started");
            expiryIntervalId = setTimeout(() => {
                showAlert("Session Timeout Reached");
                cancelRegistration();
            }, 300000);
        }

        const cancelOTPExpiryCountDown = () => {
            clearTimeout(expiryIntervalId);
            console.log("Timeout cancelled");
        }

        function showOtpInputPopup(toShow) {
            let customOtpVerificationPage = document.getElementsByClassName("custom-otp-verification-page")[0];
            let alertBox = document.getElementById("alert");

            if (toShow == true) {
                customOtpVerificationPage.style.visibility = "visible";
                customOtpVerificationPage.style.zIndex = 150;
                alertBox.style.visibility = "visible";
                showAlert("Do not refresh this page!");
                // popUpBgFun();

                sendOTP();
                startResendOTPTimer(60);
                startOTPExpiryCountDown();
            } else {
                customOtpVerificationPage.style.visibility = "hidden";
                customOtpVerificationPage.style.zIndex = -150;
                document.getElementById("unique-otp-number").value = "";
                unique_io = "";
            }
            popUpBgFun();
        }

        const popUpBgFun = () => {
            let popUpBgPage = document.getElementById("pop-up-menu-bg");

            if (popUpBgPage.style.visibility == "visible") {
                popUpBgPage.style.zIndex = -100;
                popUpBgPage.style.visibility = "hidden";
            } else {
                popUpBgPage.style.zIndex = 100;
                popUpBgPage.style.visibility = "visible";
            }
        }

        let verificationRes = "";

        const verifyOTP = () => {
            let enteredOTP = document.getElementById("unique-otp-number");
            let loader = document.getElementsByClassName("dot-spinner")[0];

            if (enteredOTP.value == "" || enteredOTP.value.length < 6) {
                showAlert("Invalid OTP length");
                return;
            }

            
            //ajax to verify otp
            $.ajax({
                type: "POST",
                url: "./php-ajax/verify_otp.php",
                data: {
                    value: unique_io,
                    user_entered_otp: enteredOTP.value
                },
                success: function(response) {
                    verificationRes = response;

                    if (response == "1") {
                        showAlert("OTP Verified Successfully!");
                        showOtpInputPopup(false);
                        cancelOTPExpiryCountDown();

                        popUpBgFun();
                        loader.style.visibility = "visible";
                        loader.style.zIndex = 160;

                        const pwd = document.getElementById("pass_one");
                        const fname = document.getElementById("f_name");
                        const lname = document.getElementById("l_name");
                        const email = document.getElementById("users-email");

                        $.ajax({
                            type: "POST",
                            url: "./php-ajax/sign-the-user-up.php",
                            data: {
                                password: pwd.value,
                                email: email.value,
                                fname: fname.value,
                                lname: lname.value
                            },
                            success: function(response) {
                                if (response.substr(response.length - 7) == "Success") {
                                    loginSuccess();
                                    popUpBgFun();
                                    loader.style.visibility = "hidden";
                                    loader.style.zIndex = -150;
                                    localStorage.setItem('user-type', 'reader');
                                    localStorage.setItem('logged-in', true);

                                    email.value = "";
                                    pwd.value = "";
                                    fname.value = "";
                                    lname.value = "";
                                    document.getElementById("pass_two").value = "";

                                    let resArr = response.split(",");

                                    localStorage.setItem('userName', resArr[0]);
                                    localStorage.setItem('dbName', resArr[1]);
                                    localStorage.setItem('emailID', resArr[2]);
                                    localStorage.setItem('joinDate', resArr[3]);

                                } else {
                                    techErr();
                                }
                            }
                        });
                    } else {
                        showAlert("Invalid OTP");   
                    }
                }
            });
        }

        const cancelRegistration = () => {
            document.getElementById("f_name").value = "";
            document.getElementById("l_name").value = "";
            document.getElementById("users-email").value = "";
            document.getElementById("pass_one").value = "";
            document.getElementById("pass_two").value = "";
            cancelOTPExpiryCountDown();
            registrationCancelled();
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

    <div class="dot-spinner">
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
        <div class="dot-spinner__dot"></div>
    </div>

    <div id="alert">
        <div id="alert-message"></div>
    </div>

    <div id="pop-up-menu-bg"></div>

    <div class="custom-otp-verification-page">
        <div class="custom-otp-verification-box">
            <div class="custom-otp-verification-text">
                Please enter the OTP sent to the email:<br><br>
                <?php echo '<div style="text-decoration: underline;">' . $email . '</div>'; ?>
            </div><br><br>
            <input type="text" name="unique-otp-number" id="unique-otp-number" pattern="[0-9]{1,6}">
            <br><br>
            <div class="otp-verification-btns-area">
                <input type="button" value="SUBMIT" onclick="verifyOTP();">
                <input type="button" value="CANCEL" onclick="cancelRegistration();">
            </div>
            <div id="resendOTPArea" style="margin-top: 20px;">
            </div>
        </div>
    </div>

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
                            <input type="text" name="f_name" id="f_name" value="<?php echo $fname; ?>" required>
                        </div>
                        <div class="lname">
                            LAST NAME: <br>
                            <input type="text" name="l_name" id="l_name" value="<?php echo $lname; ?>" required>
                        </div>
                    </div>

                    <div class="line">
                        EMAIL: <br>
                        <input type="email" name="email" id="users-email" value="<?php echo $email; ?>" required>
                    </div>

                    <div class="line email-error">
                        <!-- User-name-error -->
                    </div>

                    <div class="line">
                        PASSWORD: <br>
                        <input type="password" name="pass_one" id="pass_one" minlength="5" maxlength="30" value="<?php echo $passone; ?>" required>
                    </div>

                    <div class="line pwd-error">
                        <!-- Pwd error -->
                    </div>

                    <div class="line">
                        REPEAT PASSWORD: <br>
                        <input type="password" name="pass_two" id="pass_two" minlength="5" maxlength="30" value="<?php echo $passtwo; ?>" required>
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

            //otp validation
            die("<script>showOtpInputPopup(true);</script>");
        }
    ?>
</body>

</html>