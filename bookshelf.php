<?php
session_start();

include './connect.php';

mysqli_select_db($con, $_SESSION["db_name"]);

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
    <div id="pop-up-menu-bg"></div>

    <div id="add-book-popup-pg">
        <div id="add-book-popup-box">
            <div id="add-book-heading-area">
                <div id="add-book-heading">ADD BOOK</div>
                <div id="close-pop-up-icon-area" onclick="removePopUp(this);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>
            <hr style="width: 50%; margin-bottom: 10px; background: var(--main-black); height: 5px; border: none;">
            <form action="#">
                <label for="bkName">Book Name:</label> <br>
                <input type="text" name="bkName" id="bkName" required> <br><br>
                <label for="author">Author:</label> <br>
                <input type="text" name="author" id="author" required> <br><br>
                <input type="button" value="ADD"
                    style="width: 100px; margin-left: auto; margin-right: auto; display: block"
                    onclick="addBooktoDB();">
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
            <a href="#">
                <div class="nav-items">Log Out</div>
            </a>
        </nav>

        <hr>
    </div>
    <div id="page-right-area">
        <div id="main-heading">
            <?php echo $_SESSION["user_name"]; ?>'s Bookshelf
        </div>

        <div id="underline-box"></div>

        <div id="quote-box">
        </div>

        <div class="main-content-area">
            <div class="section-one">
                <div class="section-one-left"></div>
                <div class="section-one-right">
                    <div class="right-box">
                        <div class="to-read-heading-area">
                            <!-- THis is flex -->
                            <div class="to-read-title">TO READ</div>
                            <div class="to-read-year">
                                <?php echo date("Y"); ?>
                            </div>
                        </div>

                        <div class="to-read-content-area">
                            <!-- No books added yet <br> -->
                            <?php

                            function load_to_read_books() {
                                GLOBAL $con;
                                $books_to_read_q = mysqli_query($con, "select * from bookshelf where Status = 'to read';");

                            if ($books_to_read_q->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($books_to_read_q)) {
                                    echo '<div class="book-info-box">
                                    <div class="book-info">
                                        <div class="book-info-name">' . $row['BookName'] . '</div>
                                        <div class="book-info-author">' . $row["Author"] . '</div>
                                    </div>
                                    <div class="book-info-action">
                                        <div class="done-reading-icon" onclick="changeStatusToCompleted(this);">
                                            <img src="./icons/icons8-tick-50.png" alt="" width="30">
                                        </div>
                                        <div class="remove-book-icon" onclick="removeThisFromDb(this);">
                                            <img src="./icons/icons8-close-64.png" alt="" width="30">
                                        </div>
                                    </div>
                                </div>';
                                }
                            }
                            }

                            load_to_read_books();

                            ?>
                        </div>

                        <div class="to-read-btn-area">
                            <input type="button" value="ADD BOOK" onclick="showAddBookPopUp();"
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
                            <div class="already-read-title">READ</div>
                            <div class="already-read-year">
                                <?php echo date("Y"); ?>
                            </div>
                        </div>

                        <div class="already-read-content-area">
                        <?php

                        function load_already_read_books() {
                            GLOBAL $con;
                            $books_already_read_q = mysqli_query($con, "select * from bookshelf where Status = 'completed';");

                            if ($books_already_read_q->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($books_already_read_q)) {
                                    echo '<div class="book-info-box">
                                    <div class="book-info" style="width: 95%;">
                                        <div class="book-info-name">' . $row['BookName'] . '</div>
                                        <div class="book-info-author">' . $row["Author"] . '</div>
                                    </div>
                                    <div class="book-info-action" style="width: 5%;">
                                        <div class="remove-book-icon" onclick="removeThisFromDb(this);">
                                            <img src="./icons/icons8-close-64.png" alt="" width="30">
                                        </div>
                                    </div>
                                </div>';
                                }
                            } else {
                                echo 'No books read yet';
                            }
                        }

                        load_already_read_books();

                        ?>
                    </div>
                    </div>

                    
                </div>
                <div class="section-two-right"></div>
            </div>
        </div>
    </div>


    <script src="./js/common-script.js"></script>
    <script>
    let quotesObj = [{
        "Quote": "The best and most beautiful things in this world cannot be seen or even heard, but must be felt with the heart",
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

    displayQuote(quotesObj);

    let toReadContentArea = document.getElementsByClassName("to-read-content-area")[0];
    // toReadContentArea.classList.toggle("grid-toggle"); 
    //this is to toggle grid mode for items that do not have anything added yet

    const showAddBookPopUp = () => {
        // showPopUpBg();
        popUpBgFun();

        let addBookPopupPage = document.getElementById("add-book-popup-pg");

        addBookPopupPage.style.visibility = "visible";
        addBookPopupPage.style.zIndex = 150;
    }

    const addBooktoDB = () => {
        let bookName = document.getElementById("bkName");
        let bookAuthor = document.getElementById("author");

        if (bookName.value == "" || bookName.value == null || bookAuthor.value == "" || bookAuthor.value == null) {
            alert("Please enter valid details before submitting");
            return;
        }

        $.ajax({
            type: "POST",
            url: "./add_book.php",
            data: {
                book_name: bookName.value,
                book_author: bookAuthor.value
            },
            success: function(response) {
                bookName.value = "";
                bookAuthor.value = "";
            }
        }); //ajax call to add book to the database using php

    }

    const changeStatusToCompleted = (objRef) => {
        let bookName = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
        let bookAuthor = objRef.parentElement.previousElementSibling.lastElementChild.innerHTML;

        console.log("BOOk Name: " + bookName);
        console.log("Author: " + bookAuthor);

        $.ajax({
            type: "POST",
            url: "./change_book_status.php",
            data: {
                book_name: bookName,
                book_author: bookAuthor
            },
            success: function(response) {
                console.log(response);
            }
        }); //ajax call to change book status to 'completed' in the database

        location.reload();
    }

    const removeThisFromDb = (objRef) => {}
    </script>
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