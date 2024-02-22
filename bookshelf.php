<?php
session_start();

include './connect.php';

if (!isset($_SESSION["logged_in"])) {
    header("location: login.php");
}
// echo $_SESSION["db_name"];
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
    <style>
    <?php include './css/bookshelf.css';
    ?>
    </style>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const gridToggle = () => {
        let toReadContentArea = document.getElementsByClassName("to-read-content-area")[0];
        toReadContentArea.classList.toggle("grid-toggle");
        //this is to toggle grid mode for items that do not have anything added yet
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
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, 'book-box', [2, 3]);">
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
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, 'target-box', [1]);">
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
            <div class="sec-bar-ham-menu" onclick="secondaryMenuFun();">
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
            <?php echo $_SESSION["user_name"]; ?>'s Bookshelf
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

                        <div class="individual-element-btn-area">
                            <input type="button" value="ADD BOOK" onclick="showAddBookPopUp('two');"
                                style="font-size: 12px; padding: 5px 10px;">
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
    }, , {
        "Quote": "Fools learn from experience. I prefer to learn from the experience of others",
        "By": "Otto Van Bismarck"
    }, {
        "Quote": "The easiest way to learn from mistakes is to read books. The next option is to commit them yourself.",
        "By": "Ankur Warikoo"
    }];

    //to display quote
    displayQuote(quotesObj, "bookshelfPage");

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

            // bkYearInputField.style.display = "none";
            // bkYearInputField.previousElementSibling.previousElementSibling.style.display = "none";
            // bkYearInputField.previousElementSibling.style.display = "none";
            // bkYearInputField.nextElementSibling.nextElementSibling.style.display = "none";
            // bkYearInputField.nextElementSibling.style.dislay = "none";

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

    // const showAddBookPopUpTwo = () => {
    //     popUpBgFun();


    // }

    // const addBooktoDB = (bookStatus) => {
    //     let bookName = document.getElementById("bkName");
    //     let bookAuthor = document.getElementById("author");

    //     if (bookName.value == "" || bookName.value == null || bookAuthor.value == "" || bookAuthor.value == null) {
    //         alert("Please enter valid details before submitting");
    //         return;
    //     }

    //     let bookYear = document.getElementById("bkYear");

    //     if (bookYear.value == "" || bookYear.value == null || bookYear.value == undefined) {
    //         bookYear = new Date().getFullYear();
    //     }

    //     $.ajax({
    //         type: "POST",
    //         url: "./add_book.php",
    //         data: {
    //             book_name: bookName.value,
    //             book_author: bookAuthor.value,
    //             status: bookStatus,
    //             year: bookYear.value
    //         },
    //         success: function() {
    //             showAlert("The book: <i>" + bookName.value + "</i>, added successfully");
    //             bookName.value = "";
    //             bookAuthor.value = "";
    //             bookYear.value = "";
    //         }
    //     }); //ajax call to add book to the database using php

    // }

    // const loadToReadContentArea = () => {
    //     let toReadContentAreaDiv = document.getElementsByClassName("to-read-content-area")[0];

    //     //ajax call to load the to read content area
    //     $.ajax({
    //         type: "POST",
    //         url: "./load_to_read_books.php",
    //         success: function(response) {
    //             toReadContentAreaDiv.innerHTML = response;
    //         }
    //     });
    // }

    // loadToReadContentArea();

    // const changeStatusToCompleted = (objRef) => {
    //     let bookName = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
    //     let bookAuthor = objRef.parentElement.previousElementSibling.lastElementChild.innerHTML;

    //     console.log("BOOk Name: " + bookName);
    //     console.log("Author: " + bookAuthor);

    //     $.ajax({
    //         type: "POST",
    //         url: "./change_book_status.php",
    //         data: {
    //             book_name: bookName,
    //             book_author: bookAuthor
    //         },
    //         success: function() {
    //             location.reload();
    //         }
    //     }); //ajax call to change book status to 'completed' in the database
    // }

    // const removeThisFromDb = (objRef) => {
    //     // let bookName = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
    //     let bookName = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
    //     let bookAuthor = objRef.parentElement.previousElementSibling.lastElementChild.innerHTML;

    //     console.log(bookName);

    //     $.ajax({
    //         type: "POST",
    //         url: "./remove_book_from_db.php",
    //         data: {
    //             book_name: bookName,
    //             book_author: bookAuthor
    //         },
    //         success: function () {
    //             location.reload();
    //             // console.log();
    //         }
    //     }); //ajax call to change book status to 'completed' in the database
    // }

    // const modifyReadingTarget = () => {
    //     let targetCount = document.getElementById("bkReadingGoals");

    //     if (targetCount.value == null || targetCount.value == "") {
    //         alert("Please enter the required details before submitting");
    //         return;
    //     }

    //     $.ajax({
    //         type: "POST",
    //         url: "./modify_reading_target.php",
    //         data: {
    //             target_count: targetCount.value
    //         },
    //         async: true,
    //         success: function(response) {
    //             targetCount.value = "";
    //             showAlert("Yearly reading goal modified successfully!");
    //             // alert(response);
    //         }, 
    //         error: function(error) {
    //             alert(error);
    //         }
    //     });
    // }

    const showModifyReadingTargetBox = () => {
        popUpBgFun();

        let modifyReadingTargetBox = document.getElementById("modify-read-goals-popup-pg");

        modifyReadingTargetBox.style.visibility = "visible";
        modifyReadingTargetBox.style.zIndex = 150;
    }

    // const readingGoalModifierFun = () => {
    //     let goalsContentArea = document.getElementsByClassName("content-area")[0];

    //     //call to display the modified yearly reading goal along wiht progress bar
    //     $.ajax({
    //         type: "POST",
    //         url: "./reflect_yearly_reading_goals.php",
    //         success: function (response) {
    //             goalsContentArea.innerHTML = response;
    //             // alert(response);
    //         }
    //     });

    // }

    // readingGoalModifierFun();


    // const loadAlreadyReadBooks = () => {
    //     //this function loads already read books based on the year sleected in the drop down menu. The list of books changes if the selected year is changed (THIS IS AN IIFE FUNCTION)

    //     //adding year manually to #already-read-year
    //     let alreadyReadYearBar = document.getElementsByClassName("already-read-year")[0];
    //     let presentYear = new Date().getFullYear();

    //     let theContent = `<select id='year-select-drop-down'>`;

    //     //setting session storage for selected year if not set

    //     if (sessionStorage.getItem("selected-drop-down-year") == null || sessionStorage.getItem("selected-drop-down-year") == undefined) {
    //         sessionStorage.setItem("selected-drop-down-year", presentYear);
    //     }

    //     let selectedDropDownYear = sessionStorage.getItem("selected-drop-down-year");

    //     for (let i = presentYear - 2; i <= presentYear; i++) {
    //         if (i == selectedDropDownYear) {
    //             theContent += `<option value=${i} selected>${i}</option>`; 
    //         } else {
    //             theContent += `<option value=${i}>${i}</option>`;
    //         }
    //     }

    //     theContent += `</select>`;

    //     alreadyReadYearBar.innerHTML = theContent; //the current year is automatically selected here

    //     $.ajax({
    //         type: "POST", 
    //         url: "./load_already_read_books.php",
    //         data: {
    //             selected_drop_down_year : selectedDropDownYear
    //         },
    //         success: function(response) {
    //             document.getElementsByClassName("already-read-content-area")[0].innerHTML = response;
    //         }
    //     });
    // };

    // loadAlreadyReadBooks();


    //year change event listener for already read books
    // let selectedYear = document.getElementById("year-select-drop-down");

    // selectedYear.addEventListener("change", (e) => {
    //     // console.log(this.value);
    //     console.log(e.target.value);
    //     sessionStorage.setItem("selected-drop-down-year", e.target.value);
    //     loadAlreadyReadBooks(); // function call everytime is not working, so the only other way is refresh
    //     // location.reload(); 
    // });

    </script>
    <script src="./js/calendar.js"></script>
</body>

</html>



<!-- 
    
book info box ------------------    
<div class="book-info-box">
    <div class="book-info">
        <div class="book-info-name">Do Epic Shit</div>
        <div class="book-info-author">
            Ankur Warikoo
        </div>
    </div>
    <div class="book-info-action">
        <div class="done-reading-icon">
            <img src="./icons/icons8-tick-50.png" alt="" width="30">
        </div>
        <div class="remove-book-icon">
            <img src="./icons/icons8-close-64.png" alt="" width="30">
        </div>
    </div>
</div> 
book info box ------------------  

-->