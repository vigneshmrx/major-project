<?php
session_start();

if (!isset($_SESSION["logged_in"])) {
    header("location: login.php");
}

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

    <style>
        .main-content-area {
            /* max-height: 75vh; */
            /* height: 77%; */
        }

        .individual-element-btn-area {
            height: 100%;
            /* border: 1px solid; */
        }
    </style>
</head>

<body>
    <div id="secondary-menu">
        <div class="menu-close-icon" onclick="secondaryMenuFun();">
            <img src="./icons/icons8-close-50_white.png" alt="">
        </div>
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
    </div>

    <div id="show-info-popup-pg">
        <div id="show-info-popup-bx">
            <div id="show-info-heading-area" style="position: fixed; right: calc(15% + 25px); display: inline;">
                <div class="close-pop-up-icon-area" onclick="removePopUp(this);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>

            <!-- <hr class="popup-box-hr"> -->

            <div id="info-area">
                <h1><center>The 50-30-20 Rule</center></h1><br>
                <p>The 50-30-20 rule splits expenses into just three categories. It also offers recommendations on how much money to use for each. With some basic information, you can get on the road to financial well-being.</p> <br>

                <p>The 50-30-20 rule recommends putting 50% of your money toward needs, 30% toward wants, and 20% toward savings. The savings category also includes money you will need to realize your future goals.</p><br><br>

                <h2>Needs: 50%</h2><br>
                <p>About half of your budget should go toward needs. These are expenses that must be met no matter what, such as: <br><br>
                    <ul>
                        <li>Utility bills</li>
                        <li>Rent or mortgage payments</li>
                        <li>Health care</li>
                        <li>Groceries</li>
                    </ul> <br>

                    If you can honestly say “I can’t live without it,” you have identified a need. Minimum required payments on a credit card or a loan also belong in this category. 
                </p><br><br>

                <h2>Wants: 30%</h2><br>
                <p>You subscribe to a streaming service to watch your favorite show, not because you need the subscription to live. Wants are things you enjoy that you spend money on by choice, such as:
                    <br><br>
                    <ul>
                        <li>Subscriptions</li>
                        <li>Supplies for hobbies</li>
                        <li>Restaurant meals</li>
                        <li>Vacations</li>
                    </ul>
                </p><br><br>

                <h2>Savings: 20%</h2><br>
                <p>The remaining 20% of your budget should go toward the future. You may put money in an emergency fund, contribute to a retirement account, or save toward a down payment on a home. You can even use this money to invest in stocks or bonds which may yeild good returns in the future. Paying down debt beyond the minimum payment amount belongs in this category, too.</p><br><br>

                <p style="font-size: 10px;">Source: unfcu.org</p>
            </div>
        </div>
    </div>

    <div id="modify-income-popup-pg">
        <div id="modify-income-popup-box">
            <div id="modify-income-heading-area">
                <div id="modify-income-heading">MODIFY INCOME</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, [5]);">
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
                                    break;
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

    <div id="log-expense-popup-pg">
        <div id="log-expense-popup-bx">
            <div id="log-expense-heading-area">
            <div class="log-expense-heading">LOG EXPENSES</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, [4, 5]);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>

            <hr class="popup-box-hr">

            <form action="#" class="expLogForm">
                <label for="expenseDate">Date of Spending:</label> <br>
                <input type="date" name="expenseDate" id="expenseDate"> <br><br>

                <label for="expenseTitle">Details:</label>
                <input type="text" name="expenseTitle" id="expenseTitle" placeholder="ex: Bought Jet Airways NSE"> <br><br>

                <label for="expenseCost">Cost:</label>
                <input type="number" name="expenseCost" id="expenseCost"> <br><br>

                <label for="category">Category:</label>
                <div id="expense-category-div">
                    <input type="radio" name="cat" id="A" value="A">A (50%) &nbsp;
                    <input type="radio" name="cat" id="B" value="B" checked>B (30%) &nbsp;
                    <input type="radio" name="cat" id="C" value="C">C (20%)
                </div> <br>

                <input type="button" value="LOG EXPENSE" id="logExpenseBtn"
                    style="width: 150px; margin-left: auto; margin-right: auto; display: block;"
                    onclick="addExpenseToDb();">
            </form>
        </div>
    </div>

    <div id="show-full-details-pg">
        <div id="show-full-details-bx">
            <!-- <div id="dowload-icon">
                <abbr title="Download as pdf">
                <img src="./icons/icons8-download-24.png" alt="" width="32" height="32">
                </abbr>
            </div> -->
            <div id="show-full-details-heading-area">
                <div id="show-full-details-heading">FULL DETAILS</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, []);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>

            <hr class="popup-box-hr" style="width: 40%;" onclick="contentToPdf('expense');">

            <div class="show-full-details-content-area">
            </div>

            <div id="dowload-pdf" onclick="downloadPdf('expense');">
                <abbr title="Download as pdf">
                    <img src="./icons/icons8-download-24.png" alt="" width="32" height="32">
                </abbr>
            </div>
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

        <div id="main-heading">
            
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
                    </div>

                    <div id="income-after-expense-area">
                        <!-- <div id="income-after-expense-bx">
                            REMAINING INCOME

                            <div id="af-exp-income-amt">
                                <span class="money">15220</span>
                            </div>
                        </div>
                        <div id="income-after-expense-div-bx">
                            AFTER SPENDING DIVISION

                            <div id="af-exp-income-div-amt">
                            <span class="money">50%</span>: <span class="money">7610</span> <br>
                            <span class="money">30%</span>: <span class="money">4566</span> <br>
                            <span class="money">20%</span>: <span class="money">3044</span>
                            </div>
                        </div> -->
                    </div>

                    <div class="calendar-box"> <!-- style="padding: 0px;" -->
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

                <div class="right-section">
                    <div id="exp-notes-area">
                        <div id="exp-track-box">
                            <div id="exp-track-header">
                                
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

                            <div id="exp-track-footer">
                                <div class="individual-element-btn-area" style="height: auto;"> <!-- style="display: flex; justify-content: flex-start; align-items: end;" -->
                                    <input type="button" value="ADD EXPENSE" style="font-size: 12px; padding: 5px 10px;" onclick="showLogExpensePopup();">
                                </div>

                                <div class="show-more-details" onclick="showFullDetailsBx('expense');">
                                    See Detailed Expense Log
                                    <img src="./icons/icons8-right-arrow-50_black.png" alt="" class="show-more-details-arrow">
                                </div>
                            </div>
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

        //show heading
        document.getElementById("main-heading").innerHTML = localStorage.getItem("userName") + "'s Finance Manager";
        

        const showModifyIncomeBox = () => {
            console.log("CAlled");
            popUpBgFun();

            let modifyIncomePopupPage = document.getElementById("modify-income-popup-pg");

            modifyIncomePopupPage.style.visibility = "visible";
            modifyIncomePopupPage.style.zIndex = 150;
        }

        const showLogExpensePopup = (recUniqueId, expDate, expDesc, cost, expCategory) => {
            popUpBgFun();

            let logExpensePopupPage  = document.getElementById("log-expense-popup-pg");

            logExpensePopupPage.style.visibility = "visible";
            logExpensePopupPage.style.zIndex = 150;

            if (recUniqueId != null) {
                document.getElementById("expenseDate").value = expDate;

                document.getElementById("expenseTitle").value = expDesc;

                document.getElementById("expenseCost").value = cost;

                document.getElementsByClassName("expLogForm")[0].id = recUniqueId;

                let radioBtnArray = Array.from(document.querySelectorAll("input[name='cat']"));

                radioBtnArray.forEach((btn) => {
                    if (btn.id == expCategory) {
                        btn.checked = true;
                        return;
                    }
                });
            } else {
                document.getElementsByClassName("expLogForm")[0].id = "0";
            }
        }

        Array.from(document.querySelectorAll("input[name='cat']")).forEach((ele) => {
            ele.addEventListener("click", () => {
                console.log(ele);
            })
        })

        const showIncomeRuleInfoBx = () => {
            popUpBgFun();

            let showInfoPopupPg = document.getElementById("show-info-popup-pg");

            showInfoPopupPg.style.visibility = "visible";
            showInfoPopupPg.style.zIndex = 150;
        }
    </script>
    <script src="./js/calendar.js"></script>
</body>

</html>