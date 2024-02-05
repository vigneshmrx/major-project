<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance</title>
    <style>
    <?php include './css/common-styles.css';
    ?>
    </style>
    <style>
    <?php include './css/page-nav.css';
    ?>
    </style>
    <style>
    <?php include './css/finance.css';
    ?>
    </style>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div id="page-left-area">
        <div id="logo">
            <!-- <lord-icon src="https://cdn.lordicon.com/abwrkdvl.json" trigger="in" delay="1500" state="in-growth"
                style="width:40px;height:40px; ">
            </lord-icon> -->
            ProDo
        </div>

        <hr>

        <nav>
            <a href="#">
                <div class="nav-items current-page">Finance</div>
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
                <div class="nav-items">Settings</div>
            </a>
            <div class="nav-items" onclick="logOutboxFun();">Log Out</div>
            <!-- <a href="#"><div class="nav-items">Log Out</div></a> -->
        </nav>

        <hr>
    </div>

    <div id="page-right-area">
        <div id="main-heading">
            <?php echo $_SESSION["user_name"]; ?>'s Finance Manager
        </div>

        <div id="underline-box"></div>

        <div id="quote-box">
        </div>

        <div class="main-content-area">

            <div class="finance-flex-section">

                <div class="left-section">
                    <div id="monthly-income-area">
                        <div id="monthly-income-bx">
                            MONTHLY INCOME 

                            <div id="m-income-amt">
                                15K
                            </div>

                            <div class="individual-element-btn-area">
                                <input type="button" value="MODIFY INCOME" onclick=""
                                style="font-size: 12px; padding: 5px 10px;">
                            </div>
                        </div>
                        <div id="monthly-income-div-bx">
                            INCOME DIVISION

                            <div id="m-income-div-amt">
                                50%: 7.5K <br>
                                30%: 4.5K <br>
                                20%: 3K
                            </div>
                        </div>
                    </div> <br>

                    <div id="income-after-expense-area">
                        <div id="income-after-expense-bx">
                            AFTER SPENDING

                            <div id="af-exp-income-amt">
                                15K
                            </div>
                        </div>
                        <div id="income-after-expense-div-bx">
                            AFTER SPENDING DIVISION

                            <div id="af-exp-income-div-amt">
                                50%: 7.5K <br>
                                30%: 4.5K <br>
                                20%: 3K
                            </div>
                        </div>
                    </div> <br>

                    <div class="calendar-box">
                        <div class="calendar">
                            <div class="calendar-header">
                                <span class="month-picker" id="month-picker">April</span>
                                <div class="year-picker">
                                    <span class="year-change" id="prev-year">
                                        <pre><</pre>
                                    </span>
                                    <span id="year">2022</span>
                                    <span class="year-change" id="next-year">
                                        <pre>></pre>
                                    </span>
                                </div>
                            </div>
                            <div class="calendar-body">
                                <div class="calendar-week-day">
                                    <div>Sun</div>
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                </div>
                                <div class="calendar-days">
                                </div>
                            </div>

                            <div class="month-list">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right-section"></div>
            </div>
        </div>
    </div>

    <!-- <div id="pop-up-menu-bg"></div> -->

    <script src="./js/common-script.js"></script>
    <script>
        let quotesObj = [
            {"Quote" : "Gold cometh gladly and in increasing quantity to any man who will put by not less than one-tenth of his earnings to create an estate for his future and that of his family.", "By" : "The First Law of Gold"}, 
            {"Quote" : "Gold clingeth to the protection of the cautious owner who invests in under the advice of men wise in its handling.", "By" : "The Third Law of Gold"}, 
            {"Quote" : "Spending money to show people how much money you have is the fastest way to have less money.", "By" : "The Psychology of Money"}, 
            {"Quote" : "Gold flees the man who would force it to impossible earnings or who followeth the alluring advice of tricksters and schemers or who trust it to his own inexperience and romantic desires in investment.", "By" : "The Fifth Law of Gold"}];

        
            //to display quote
        displayQuote(quotesObj, "financePage");
        


    </script>
    <script src="./js/calendar.js"></script>
</body>

</html>