<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
    <?php 
    include './css/common-styles.css';
    include './css/page-nav.css';
    ?>
    </style>

    <style>
        body {
            background-color: var(--bg-color);
        }

        .secondary-nav-bar {
            display: flex;
        }

        #option-bar {
            display: flex;
            align-items: center;
            width: 80%;
            border: 2px solid;
            margin: auto;
            border-radius: var(--common-value);
            overflow: hidden;
        }
        
        .main-content {
            margin-top: 70px;
            width: 100%;
        }

        .main-heading {
            text-align: center;
            margin: 10px 0px 0px 0px;
            font-size: 25px;
            text-transform: uppercase;
        }

        .option-bar-options {
            width: 25%;
            text-align: center;
            padding: 10px 15px;
            cursor: pointer;
        }

        .option-bar-options:hover {
            text-decoration: underline;
        }

        .currently-selected {
            background: var(--main-black);
            color: var(--main-white);
        }

        .currently-selected:hover {
            text-decoration: none;
        }

        #dynamic-content-area {
            /* border: 2px solid; */
            margin-top: 100px;
        }

        #search-bar-area {
            /* border: 1px solid; */
            padding: 5px;
            display: inline-block;
            float: right;
            margin-top: 50px;
        }

        #search-bar-area input[type=search] {
            font-size: 15px;
            padding: 5px 10px;
            font-weight: normal;
            border-radius: var(--common-value);
            width: 300px;
        }

        #dynamic-table {
            width: 80%;
            margin: 25px auto 50px auto;
            border: 1px solid;
        }

        #dynamic-table table {
            width: 100%;
            border: 1px solid;
        }

        #dynamic-table td {
            /* border-right: 1px solid;
            border-left: 1px solid; */
            /* border-bottom: 1px solid; */
            text-align: center;
            padding: 5px 10px;
        }

        #dynamic-table th {
            padding: 15px;
            background: var(--main-black);
            color: var(--main-white);
            font-weight: normal;
        }

        .action-cell img {
            width: 27px;
            cursor: pointer;
        }

        .action-cell {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            min-width: 50px;
        }

        .action-cell img:hover {
            scale: 1.05;
        }

        .sub-headings {
            /* margin: auto; */
            margin-left: 10%;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
        }

        .nothing-to-show {
            text-align: center;
            margin: 25px 0px;
        }

        .nothing-to-show img {
            height: 70px;
        }

        .hide {
            display: none;
        }

        #mail-area {
            width: 55%;
            margin: auto;
            font-weight: bold;
            border: 2px solid;
            border-radius: var(--common-value);
            padding: 15px;
            background: var(--main-white);
            box-shadow: 15px 15px var(--main-black);
            margin-top: 15px;
        }

        .mail-flex-line {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .mail-flex-line div {
            flex: 1;
        }

        .from-div {
            margin-right: 15px;
        }

        .to-div {
            margin-left: 15px;
        }

        input[type=text],
        textarea {
            width: 100%;
            height: 28px;
            border: none;
            background: var(--secondary-white);
            border-radius: 5px;
            border-bottom: 2px solid;
            /* padding: 2px 5px; */
            padding: 5px 15px;
            margin-top: 5px;
            font-family: "Roboto Mono";
            font-size: 15px;
            font-weight: normal;
        }

        textarea {
            height: 100px;
        }

        input[type=button] {
            margin: auto;
            padding: 6px 24px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-size: 15px;
            background: var(--main-black);
            color: var(--main-white);
            font-family: "Roboto Mono";
        }

        .custom-confirm-page {
            z-index: -150;
            position: fixed;
            visibility: hidden;
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
        }

        .custom-confirm-box {
            width: 400px;
            background-color: var(--main-white);
            box-shadow: 11px 11px  var(--main-black);
            padding: var(--common-value);
            border: 2px solid var(--main-black);
            font-weight: bold;
            text-align: justify;
        }

        .confirm-btns-area {
            display: flex;
            justify-content: space-between;
        }

        .confirm-btns-area input[type=button] {
            width: 120px;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="custom-confirm-page">
        <div class="custom-confirm-box">
            <div class="custom-confirm-text">
                Are you sure you want to delete this blog? This action cannot be reversed!
            </div> <br><br>
            <div class="confirm-btns-area">
                <input type="button" value="YES" onclick="toggleEnterBlogReasonAlert(true);">
                <input type="button" value="NO" onclick="toggleBlogDeleteAlert(false, true);">
            </div>
        </div>
    </div>

    <div class="custom-confirm-page">
        <div class="custom-confirm-box">
            <div class="custom-confirm-text" style="text-align: left;">
                Please enter the reason for deletion of the blog: <br><br>
                <input type="text" name="" id="reason-for-deletion-of-blog">
            </div> <br><br>
            <div class="confirm-btns-area">
                <input type="button" value="SUBMIT" onclick="getReasonDeleteBlog();">
                <input type="button" value="CANCEL" onclick="toggleEnterBlogReasonAlert(false, true);">
            </div>
        </div>
    </div>

    <div class="secondary-nav-bar">
        <div class="sec-bar-logo">
            ProDo
        </div>
        <div class="log-out-btn-area" onclick="logOutBoxFun();">
            <abbr title="Log Out">
            <img src="./icons/icons8-logout-50.png" alt="">
            </abbr>
        </div>
    </div>

    <div class="main-content">

        <div class="main-heading">
            Prodo Admin Panel
        </div>

        <div id="underline-box"></div>

        <div id="option-bar">
            <div class="option-bar-options" id="1" onclick="optionChangeFun(this);" >Writer Requests</div>
            <div class="option-bar-options" id="2" onclick="optionChangeFun(this);" >Reported Blogs</div>
            <div class="option-bar-options" id="3" onclick="optionChangeFun(this);" >Users List</div>
            <div class="option-bar-options" id="4" onclick="optionChangeFun(this);" >Send Mail</div>
        </div>

        <div id="search-bar-area">
                <input type="search" name="" id="search-bar" placeholder="Search..." class="writer-requests-search-bar">
        </div>

        <div id="dynamic-content-area">

            <div class="sub-headings" style="">
                Send Email:
            </div>

            <div id="mail-area">
                <div class="mail-flex-line">
                    <div class="from-div">
                        From: <br>
                        <input type="text" name="" id="from-input" value="prodo@gmail.com" disabled>
                    </div>
                    <div class="to-div">
                        To: <br>
                        <input type="text" name="" id="to-input">
                    </div>
                </div>

                <div>
                    Subject: <br>
                    <input type="text" name="" id="subject-input">
                </div>

                <div style="margin-top: 25px;">
                    Message: <br>
                    <textarea name="" id="message-input" cols="30" rows="10"></textarea>
                </div>

                <div style="text-align: center; margin-top: 25px;">
                    <input type="button" value="SEND MAIL" onclick="sendEmail();" >
                </div>
            </div>
        </div>
    </div>

    <script src="./js/common-script.js"></script>
    <script>
        let currentlySelectedOptionId;

        let adminSelectedOption = sessionStorage.getItem("admin-selected-option");

        if (adminSelectedOption == null || adminSelectedOption == undefined) {
            currentlySelectedOptionId = "1";
        } else {
            currentlySelectedOptionId = adminSelectedOption;
        }

        SearchBar = document.getElementById("search-bar");

        let searchBarDiv = document.getElementById("search-bar-area");


    </script>
    <script src="./js/admin-ajax.js"></script>
</body>
</html>