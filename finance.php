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

    <div id="modify-income-popup-pg">
        <div id="modify-income-popup-box">
            <div id="modify-income-heading-area">
                <div id="modify-income-heading">MODIFY INCOME</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>

            <hr class="popup-box-hr">

            <form action="#">
                <label for="monthIncome">Current Month Income:</label> <br>
                <input type="number" name="monthIncome" id="monthIncome"> <br><br>

                <label for="selectedMonth">Select Month:</label>
                <select name="selectedMonth" id="selectedMonth" style="width: 100%; padding: 5px 10px; margin-top: 5px; margin-bottom: 10px; border: none; border-bottom: 2px solid; border-radius: 5px; color: black;font-weight: bold; font-size: 15px; background: var(--secondary-white);">
                        <?php 
                            $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                            $current_month = date("F");

                            //for auto selecting the current month
                            foreach($months as $month) {
                                if ($month == $current_month) {
                                    echo "<option value='$month' selected>$month</option>";
                                } else {
                                    echo "<option value='$month'>$month</option>";
                                }
                            }
                        ?>
                </select> <br><br>
                
                <label for="bonus">Bonus / Extra (if any):</label> <br>
                <input type="number" id="bonus" name="bonus"> <br><br>

                <input type="button" value="MODIFY" id="submitModifiedIncomeBtn" style="width: 100px; margin-left: auto; margin-right: auto; display: block;" onclick="addNewIncomeToDb();">
            </form>
        </div>
    </div>

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
            <div class="nav-items" onclick="logOutBoxFun();">Log Out</div>
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
                        <!-- <div id="monthly-income-bx">
                            MONTHLY INCOME 

                            <div id="m-income-amt">
                                15K
                            </div>

                            <div class="individual-element-btn-area">
                                <input type="button" value="MODIFY INCOME" onclick="showModifyIncomeBox();"
                                style="font-size: 12px; padding: 5px 10px;" >
                            </div>
                        </div>
                        <div id="monthly-income-div-bx">
                            INCOME DIVISION

                            <div id="m-income-div-amt">
                                50%: 7.5K <br>
                                30%: 4.5K <br>
                                20%: 3K
                            </div>
                        </div> -->
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
                                50%: + 7.5K <br>
                                30%: + 4.5K <br>
                                20%: + 3K
                            </div>
                        </div>
                    </div> <br>

                    <div class="calendar-box" style="padding: 5px;">
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

                    <!-- <div id="graph-box"></div>  -->
                </div>

                <div class="right-section">
                    <div id="exp-notes-area">
                        <div id="exp-track-box">
                            <div id="exp-track-header">
                                <div>NOTE MONTHLY EXPENSES</div>
                                <div><?php echo strtoupper(date("M")) . " - " . date("Y"); ?></div>
                            </div>

                            <div id="exp-track-content">
                                <div class="exp-info-box">
                                    <div class="exp-info-date">
                                        <div class="date-box">06-02-24 TUE</div>
                                    </div>
                                    <div class="exp-info-area">
                                        <div class="exp-info-left-area">
                                            Bought JET AIRWAYS 25Q @55.6

                                            <div class="cost-box">
                                                2.3k
                                            </div>
                                        </div>
                                        <div class="exp-info-right-area">
                                            <div class="modify-exp-icon" style="height: 30px;">
                                                <abbr title="edit"><img src="./icons/icons8-edit-60.png" alt="" style="width: 30px;"></abbr>
                                            </div>
                                            <div class="remove-exp-icon" style="height: 30px;">
                                                <abbr title="delete"><img src="./icons/icons8-close-64.png" alt="" style="width: 30px;"><abbr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="exp-info-box">
                                    <div class="exp-info-date">
                                        <div class="date-box">06-02-24 TUE</div>
                                    </div>
                                    <div class="exp-info-area">
                                        <div class="exp-info-left-area">
                                            Bought JET AIRWAYS 25Q @55.6

                                            <div class="cost-box">
                                                2.3k
                                            </div>
                                        </div>
                                        <div class="exp-info-right-area">
                                            <div class="modify-exp-icon" style="height: 30px;">
                                                <abbr title="edit"><img src="./icons/icons8-edit-60.png" alt="" style="width: 30px;"></abbr>
                                            </div>
                                            <div class="remove-exp-icon" style="height: 30px;">
                                                <abbr title="delete"><img src="./icons/icons8-close-64.png" alt="" style="width: 30px;"><abbr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="exp-info-box">
                                    <div class="exp-info-date">
                                        <div class="date-box">06-02-24 TUE</div>
                                    </div>
                                    <div class="exp-info-area">
                                        <div class="exp-info-left-area">
                                            Bought JET AIRWAYS 25Q @55.6

                                            <div class="cost-box">
                                                2.3k
                                            </div>
                                        </div>
                                        <div class="exp-info-right-area">
                                            <div class="modify-exp-icon" style="height: 30px;">
                                                <abbr title="edit"><img src="./icons/icons8-edit-60.png" alt="" style="width: 30px;"></abbr>
                                            </div>
                                            <div class="remove-exp-icon" style="height: 30px;">
                                                <abbr title="delete"><img src="./icons/icons8-close-64.png" alt="" style="width: 30px;"><abbr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="exp-info-box">
                                    <div class="exp-info-date">
                                        <div class="date-box">06-02-24 TUE</div>
                                    </div>
                                    <div class="exp-info-area">
                                        <div class="exp-info-left-area">
                                            Bought JET AIRWAYS 25Q @55.6

                                            <div class="cost-box">
                                                2.3k
                                            </div>
                                        </div>
                                        <div class="exp-info-right-area">
                                            <div class="modify-exp-icon" style="height: 30px;">
                                                <abbr title="edit"><img src="./icons/icons8-edit-60.png" alt="" style="width: 30px;"></abbr>
                                            </div>
                                            <div class="remove-exp-icon" style="height: 30px;">
                                                <abbr title="delete"><img src="./icons/icons8-close-64.png" alt="" style="width: 30px;"><abbr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div id="exp-track-footer"> -->
                            <div class="individual-element-btn-area" style="height: 6%; display: flex; justify-content: flex-start; align-items: end;">
                                <input type="button" value="ADD EXPENSE" style="font-size: 12px; padding: 5px 10px;">
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id="pop-up-menu-bg"></div> -->

    <script src="./js/common-script.js"></script>
    <script src="./js/finance-ajax.js"></script>
    <script>
        let quotesObj = [
            {"Quote" : "Gold cometh gladly and in increasing quantity to any man who will put by not less than one-tenth of his earnings to create an estate for his future and that of his family.", "By" : "The First Law of Gold"}, 
            {"Quote" : "Gold clingeth to the protection of the cautious owner who invests in under the advice of men wise in its handling.", "By" : "The Third Law of Gold"}, 
            {"Quote" : "Spending money to show people how much money you have is the fastest way to have less money.", "By" : "The Psychology of Money"}, 
            {"Quote" : "Gold flees the man who would force it to impossible earnings or who followeth the alluring advice of tricksters and schemers or who trust it to his own inexperience and romantic desires in investment.", "By" : "The Fifth Law of Gold"}];

        
            //to display quote
        displayQuote(quotesObj, "financePage");
        

        const showModifyIncomeBox = () => {
            console.log("CAlled");
            popUpBgFun();

            let modifyIncomePopupPage = document.getElementById("modify-income-popup-pg");

            modifyIncomePopupPage.style.visibility = "visible";
            modifyIncomePopupPage.style.zIndex = 150;
        }

    </script>
    <script src="./js/calendar.js"></script>
</body>

</html>