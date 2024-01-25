<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookShelf</title>
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/page-nav.css';
    ?>
    </style>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>

<body>
    <div id="nav-left-area">
        <div id="logo">
            <!-- <lord-icon src="https://cdn.lordicon.com/abwrkdvl.json" trigger="in" delay="1500" state="in-growth"
                style="width:40px;height:40px; ">
            </lord-icon> -->
            ProDo
        </div>

        <hr>

        <nav>
            <a href="./finance.php"><div class="nav-items">Finance</div></a>
            <a href="./bookshelf.php"><div class="nav-items">Bookshelf</div></a>
            <!-- <div class="nav-items"><a href="#">Finance</a></div> -->
            <!-- <div class="nav-items current-page"><a href="#">BookShelf</a></div> -->
            <a href="#"><div class="nav-items current-page">Blog</div></a>
            <a href="#"><div class="nav-items">Settings</div></a>
            <a href="#"><div class="nav-items">Log Out</div></a>
        </nav>

        <hr>
    </div>
    <div id="nav-right-area">
        <div id="main-heading">
        </div>

        <div id="underline-box"></div>

        <div id="quote-box">
        </div>
    </div>

    <script src="./js/quotes.js"></script>
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