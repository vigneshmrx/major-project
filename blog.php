<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/page-nav.css';
    ?>
    <?php include './css/blog.css';
    ?>
    </style>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script defer>
        
    </script>
</head>

<body>
    <div id="secondary-menu">
        <div class="menu-close-icon" onclick="secondaryMenuFun();">
            <img src="./icons/icons8-close-50_white.png" alt="">
        </div>
        <nav id="secondary-menu-nav">
            <a href="./finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href="./bookshelf.php">
                <div class="nav-items">Bookshelf</div>
            </a>
            <a href="#">
                <div class="nav-items current-page">Blog</div>
            </a>
            <a href="#">
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
        </nav>
    </div>


    <div id="page-left-area">
        <div id="logo">
            ProDo
        </div>

        <hr>

        <nav id="primary-menu-nav">
            <a href="./finance.php"><div class="nav-items">Finance</div></a>
            <a href="./bookshelf.php"><div class="nav-items">Bookshelf</div></a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="#"><div class="nav-items current-page">Blog</div></a>
            <a href="#"><div class="nav-items">Settings</div></a>
            <a href="#"><div class="nav-items" onclick="logOutBoxFun();">Log Out</div></a>
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

        <!-- <div id="main-heading">
        </div> -->

        <!-- <div id="underline-box"></div>

        <div id="quote-box">
        </div> -->

        <div id="find-interesting-blogs-description">
            <h2>Discover Interesting Blogs Here</h2>
            <br><br>
            <div id="search-and-cat-area">
                <div>
                    <input type="text" name="" id="" placeholder="Search..">
                </div>
                <div class="categories">
                    <div class="individual-categories">All</div>
                    <div class="individual-categories current-category">Finance</div>
                    <div class="individual-categories">Productivity</div>
                    <div class="individual-categories">Mindfulness</div>
                    <div class="individual-categories">Meditation</div>
                </div>
            </div>
        </div>

        <div id="blog-page-heading">
            <hr>
            <div>Blogs</div>
            <hr>
        </div>

        <div class="main-content-area"></div>
    </div>

    <script src="./js/common-script.js"></script>
    <script>
        let quotesObj = [];

        // displayQuote(quotesObj);


    // let currentPageLinkElement = document.getElementsByClassName("current-page")[0];

    // if (currentPageLinkElement.previousElementSibling.tagName == "DIV") {
    //     currentPageLinkElement.previousElementSibling.style.borderBottomRightRadius = "10px";
    // }
    </script>
</body>

</html>