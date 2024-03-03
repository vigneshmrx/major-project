

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
    <style>
    <?php include './css/bookshelf.css';
    ?>
    </style>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        if (localStorage.getItem("logged-in") == null || localStorage.getItem("logged-in") == false) {
            // location.replace("login.php");
            console.log("NOt logged in");
        }
    </script>
</head>

<body>
    <!-- <div id="pop-up-menu-bg"></div> -->

    <div id="secondary-menu">
        <div class="menu-close-icon" onclick="secondaryMenuFun();">
            <img src="./icons/icons8-close-50_white.png" alt="">
        </div>
        <nav>
            <a href="./finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href=".#">
                <div class="nav-items current-page">Bookshelf</div>
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

    <div id="add-book-popup-pg">
        <div id="add-book-popup-box">
            <div class="add-book-heading-area">
                <div class="add-book-heading">ADD BOOK</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, [2, 3]);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>

            <hr class="popup-box-hr">

            <form action="#">
                <label for="bkName">Book Name:</label> <br>
                <input type="text" name="bkName" id="bkName" required> <br><br>
                <label for="author">Author:</label> <br>
                <input type="text" name="author" id="author" required> <br><br>
                <label for="bkYear">Year (optional):</label> <br>
                <input type="text" name="bkYear" id="bkYear" required>
                <br><br>
                <input type="button" value="ADD" id="addBtnOne"
                    style="width: 100px; margin-left: auto; margin-right: auto; display: block;"
                    onclick="addBooktoDB('to read');">
                <input type="button" value="ADD" id="addBtnTwo"
                    style="width: 100px; margin-left: auto; margin-right: auto; display: block;"
                    onclick="addBooktoDB('completed');">
            </form>
        </div>
    </div>

    <div id="modify-read-goals-popup-pg">
        <div id="modify-read-goals-popup-box">
        <div class="modify-read-goals-heading-area">
                <div class="modify-read-goals-heading">MODIFY READING GOALS</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, [1]);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>
            <hr class="popup-box-hr">
            <br>
            
            <label for="bkReadingGoals">Set Goal / Target:</label> <br>
            <input type="number" name="bkReadingGoals" id="bkReadingGoals" required> <br><br>
            <input type="button" value="MODIFY" id="bkReadingGoalModifyBtn" onclick="modifyReadingTarget();" style="width: 100px; margin-left: auto; margin-right: auto; display: block;">
        </div>
    </div>

    <div id="show-full-details-pg">
        <div id="show-full-details-bx">
            
            <div id="show-full-details-heading-area">
                <div id="show-full-details-heading">FULL DETAILS</div>
                    <div class="close-pop-up-icon-area" onclick="removePopUp(this, []);">
                        <img src="./icons/icons8-close-32.png" alt="">
                    </div>
            </div>

            <hr class="popup-box-hr" style="width: 40%;" onclick="contentToPdf('bookshelf');">

            <div class="show-full-details-content-area">
            </div>

            <div id="download-pdf" onclick="downloadPdf('books');">
                <abbr title="Download as pdf">
                    <img src="./icons/icons8-download-24.png" alt="" width="32" height="32">
                </abbr>
            </div>
        </div>
    </div>

    <!-- <div id="add-book-popup-pg-two">
        <div id="add-book-popup-box-two">
            <div class="add-book-heading-area">
                <div class="add-book-heading">ADD BOOK</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>
        </div>
    </div> -->

    <!-- LEFT AREA - THE NAVIGATION ~~~~ -->
    <div id="page-left-area">
        <div id="logo">
            <!-- <lord-icon src="https://cdn.lordicon.com/abwrkdvl.json" trigger="in" delay="1500" state="in-growth"
                style="width:40px;height:40px; ">
            </lord-icon> -->
            ProDo
        </div>

        <hr>

        <nav>
            <a href="./finance.php">
                <div class="nav-items">Finance</div>
            </a>
            <a href="#">
                <div class="nav-items current-page">Bookshelf</div>
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
            <!-- <a href="" onclick="showLogOutBox();">
                
            </a> -->
        </nav>

        <hr>
    </div>

    <!-- RIGHT AREA - THE CONTENT ~~~~ -->
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
            <div class="section-one">


                <div class="section-one-left">
                    <div class="left-box">
                        <div class="content-area">
                            <!-- YEARLY GOALS:
                            <div id="goals-counter"> -->
                                <!-- 10 / 15 -->
                                <!-- This is filled by AJAX CALL -->
                            <!-- </div>

                            PROGRESS:
                            <div id="goal-progress-bar-area">
                                <div id="progress-bar">
                                    <div id="progress-bar-value"></div>
                                </div>
                                <div id="progress-bar-value-count">50.5%</div>
                            </div> -->
                        </div>
                        <div class="individual-element-btn-area">
                            <input type="button" value="MODIFY" style="font-size: 12px; padding: 5px 10px;" onclick="showModifyReadingTargetBox();">
                        </div>
                    </div>
                    
                </div>


                <div class="section-one-right">
                    <div class="right-box">
                        <div class="to-read-heading-area">
                            <!-- THis is flex -->
                            <div class="to-read-title">READ LIST</div>
                            <div class="to-read-year">
                                <?php echo date("Y"); ?>
                            </div>
                        </div>

                        <div class="to-read-content-area">
                            <!-- No books added yet <br> -->

                            <!-- php function : load_to_read_books(); -->
                        </div>

                        <div class="individual-element-btn-area">
                            <input type="button" value="ADD BOOK" onclick="showAddBookPopUp('one');"
                                style="font-size: 12px; padding: 5px 10px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-two">
                <div class="section-two-left">
                    <div class="left-box">
                        <div class="already-read-heading-area">
                            <!-- THis is flex -->
                            <div class="already-read-title">COMPLETED READING</div>
                            <div class="already-read-year">
                                <!-- Values inserted using JS -->
                            </div>
                        </div>

                        <div class="already-read-content-area">
                            <!-- php function : load_already_read_books() -->
                            <!-- Values here are inserted using JS + PHP (AJAX) -->
                        </div>

                        <div style="height: 15%; display: flex; justify-content: space-between; align-items: flex-end;">
                            <div class="">
                                <input type="button" value="ADD BOOK" onclick="showAddBookPopUp('two');"
                                    style="font-size: 12px; padding: 5px 10px;">
                            </div>
                            <div class="show-more-details" onclick="showFullDetailsBx('books');">
                                See More Details
                                <img src="./icons/icons8-right-arrow-50_black.png" alt="" class="show-more-details-arrow" style="margin-top: 3px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-two-right">
                    <div class="right-box" style="padding-bottom: 0px;">
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
                                <div class="calendar-days"></div>
                            </div>

                            <div class="month-list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    


    <script src="./js/common-script.js"></script>
    <script src="./js/bookshelf-ajax.js"></script>

    <script>
    let quotesObj = [{
        "Quote": "The best and most beautiful things in this world cannot be seen or even heard, but must be felt with the heart.",
        "By": "Helen keller"
    }, {
        "Quote": "No matter how busy you may think you are, you must find time for reading, or surrender yourself to self-chosen ignorance.",
        "By": "Unknown"
    }, {
        "Quote": "Wisdom is a weapon to ward off destruction; It is an inner fortress which enemies cannot destroy",
        "By": "Thirukkural 421 (200 BC)"
    }, {
        "Quote": "Work on it TODAY, not tomorrow",
        "By": "Unknown"
    }, {
        "Quote": "Fools learn from experience. I prefer to learn from the experience of others",
        "By": "Otto Van Bismarck"
    }, {
        "Quote": "The easiest way to learn from mistakes is to read books. The next option is to commit them yourself.",
        "By": "Ankur Warikoo"
    }];

    //to display quote
    displayQuote(quotesObj, "bookshelfPage");

    //show heading
    document.getElementById("main-heading").innerHTML = localStorage.getItem("userName") + "'s Bookshelf";

    let toReadContentArea = document.getElementsByClassName("to-read-content-area")[0];
    // toReadContentArea.classList.toggle("grid-toggle"); 
    //this is to toggle grid mode for items that do not have anything added yet

    const showAddBookPopUp = (btnToShow) => {
        // showPopUpBg();
        popUpBgFun();

        let addBookPopupPage = document.getElementById("add-book-popup-pg");

        addBookPopupPage.style.visibility = "visible";
        addBookPopupPage.style.zIndex = 150;

        let addBtnOne = document.getElementById("addBtnOne");
        let addBtnTwo = document.getElementById("addBtnTwo");

        let bkYearInputField = document.getElementById("bkYear");

        if (btnToShow == "one") {
            addBtnTwo.style.display = "none";

            bkYearInputField.style.display = bkYearInputField.previousElementSibling.previousElementSibling.style.display = bkYearInputField.previousElementSibling.style.display = bkYearInputField.nextElementSibling.nextElementSibling.style.display =  bkYearInputField.nextElementSibling.style.display = "none";

            if (addBtnOne.style.display == "none") {
                addBtnOne.style.display = "block";
            }

        } else {
            document.getElementById("addBtnOne").style.display = "none";

            if (addBtnTwo.style.display == "none") {
                addBtnTwo.style.display = "block";
            }

            if (bkYearInputField.style.display == "none") {
                bkYearInputField.style.display = bkYearInputField.previousElementSibling.previousElementSibling.style.display =  bkYearInputField.nextElementSibling.nextElementSibling.style.display =  bkYearInputField.nextElementSibling.style.display = "block";
            }
        }
    }


    const showModifyReadingTargetBox = () => {
        popUpBgFun();

        let modifyReadingTargetBox = document.getElementById("modify-read-goals-popup-pg");

        modifyReadingTargetBox.style.visibility = "visible";
        modifyReadingTargetBox.style.zIndex = 150;
    }

    </script>
    <script src="./js/calendar.js"></script>
</body>

</html>