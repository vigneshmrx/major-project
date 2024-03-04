<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/page-nav.css'; ?>
    <?php include './css/dashboard.css'; ?>
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
            location.replace("login.php");
        }
    </script>
</head>
<body>
    <div id="secondary-menu">
        <div class="menu-close-icon" onclick="secondaryMenuFun();">
            <img src="./icons/icons8-close-50_white.png" alt="">
        </div>
        <nav>
            <a href="finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href="./bookshelf.php">
                <div class="nav-items">Bookshelf</div>
            </a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="./blog.php">
                <div class="nav-items">Blog</div>
            </a>
            <a href="#">
                <div class="nav-items current-page">Dashboard</div>
            </a>
            <a href="#">
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
            <!-- <a href="#"><div class="nav-items">Log Out</div></a> -->
        </nav>
    </div>

    <div id="page-left-area">
        <div id="logo">
            ProDo
        </div>

        <hr>

        <nav>
            <a href="finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href="./bookshelf.php">
                <div class="nav-items">Bookshelf</div>
            </a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="./blog.php">
                <div class="nav-items">Blog</div>
            </a>
            <a href="#">
                <div class="nav-items current-page">Dashboard</div>
            </a>
            <a href="#">
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
            <!-- <a href="#"><div class="nav-items">Log Out</div></a> -->
        </nav>

        <hr>
    </div>

    <div id="page-right-area">

        <div class="secondary-nav-bar">
            <div class="sec-bar-ham-menu" onclick="secondaryMenuFun(true);">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            <div class="sec-bar-logo">
                ProDo
            </div>
            <div class="log-out-btn-area" onclick="logOutBoxFun();">
                <img src="./icons/icons8-logout-50.png" alt="">
            </div>
        </div>

        <div class="main-content-area">
            <div id="heading-and-action-btns">
                <div id="dashboard-greeting">

                </div>
                <div id="dashboard-main-action">
                    <input type="button" value="+ Add Blog">
                </div>
            </div>

            <div id="user-profile-info-section">
                <div class="profile-info-section-top"></div>
                <div class="profile-info-section-bottom"></div>
            </div>
        </div>
    </div>

    <script src="./js/common-script.js"></script>
    <script>
        let userName = localStorage.getItem("userName");
        let userNameArr = userName.split(" ");
        document.getElementById("dashboard-greeting").innerHTML = userNameArr[0] + "'s Dashboard"
    </script>
</body>
</html>