const dbName = localStorage.getItem("dbName");
const userName = localStorage.getItem("userName");
const emailID = localStorage.getItem("emailID");

//to add book to the DB
const addBooktoDB = (bookStatus) => {
    let bookName = document.getElementById("bkName");
    let bookAuthor = document.getElementById("author");

    if (bookName.value == "" || bookName.value == null || bookAuthor.value == "" || bookAuthor.value == null) {
        alert("Please enter valid details before submitting");
        return;
    }

    let bookYear = document.getElementById("bkYear");

    if (bookYear.value == "" || bookYear.value == null || bookYear.value == undefined) {
        bookYear = new Date().getFullYear();
    }

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/add_book.php",
        data: {
            book_name: bookName.value,
            book_author: bookAuthor.value,
            status: bookStatus,
            year: bookYear.value,
            db_name: dbName
        },
        success: function(response) {
            // showAlert(response);
            showAlert("The book: <i>" + bookName.value.toUpperCase() + "</i>, added successfully");
            bookName.value = "";
            bookAuthor.value = "";
            bookYear.value = "";

            if (bookStatus == "completed") {
                readingGoalModifierFun();
            }
        }
    }); //ajax call to add book to the database using php

}

//to load the to-read content area
const loadToReadContentArea = () => {
    let toReadContentAreaDiv = document.getElementsByClassName("to-read-content-area")[0];

    //ajax call to load the to read content area
    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/load_to_read_books.php",
        data: {
            db_name: dbName
        },
        success: function(response) {
            toReadContentAreaDiv.innerHTML = response;
        }
    });
}

// loadToReadContentArea();

//to load the already-read content area
const loadAlreadyReadBooks = () => {
    //this function loads already read books based on the year sleected in the drop down menu. The list of books changes if the selected year is changed (THIS IS AN IIFE FUNCTION)

    //adding year manually to #already-read-year
    let alreadyReadYearBar = document.getElementsByClassName("already-read-year")[0];
    let presentYear = new Date().getFullYear();

    let theContent = `<select id='year-select-drop-down' onchange='yearChangeFun(event)'>`;

    //setting session storage for selected year if not set

    if (sessionStorage.getItem("selected-drop-down-year") == null || sessionStorage.getItem("selected-drop-down-year") == undefined) {
        sessionStorage.setItem("selected-drop-down-year", presentYear);
    }

    let selectedDropDownYear = sessionStorage.getItem("selected-drop-down-year");

    for (let i = presentYear - 2; i <= presentYear; i++) {
        if (i == selectedDropDownYear) {
            theContent += `<option value=${i} selected>${i}</option>`; 
        } else {
            theContent += `<option value=${i}>${i}</option>`;
        }
    }

    theContent += `</select>`;

    alreadyReadYearBar.innerHTML = theContent; //the current year is automatically selected here

    $.ajax({
        type: "POST", 
        url: "../major-project/php-ajax/load_already_read_books.php",
        data: {
            selected_drop_down_year : selectedDropDownYear,
            db_name: dbName
        },
        success: function(response) {
            document.getElementsByClassName("already-read-content-area")[0].innerHTML = response;
            window.removeCache;
        }
    });
};

// loadAlreadyReadBooks();

//to show the default / updated yearly reading goal
const readingGoalModifierFun = () => {
    let goalsContentArea = document.getElementsByClassName("content-area")[0];

    //call to display the modified yearly reading goal along with progress bar
    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/reflect_yearly_reading_goals.php",
        data: {
            email: emailID,
            db_name: dbName
        },
        success: function (response) {
            goalsContentArea.innerHTML = response;
            // alert(response);
        }
    });

}

// readingGoalModifierFun();

//to change ths status of a 'to-read' book to 'completed'
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
            book_author: bookAuthor,
            db_name: dbName
        },
        success: function() {
            // location.reload();
            loadToReadContentArea();
            loadAlreadyReadBooks();
            readingGoalModifierFun();
            showAlert("Book status modified!");
        }
    }); //ajax call to change book status to 'completed' in the database
}

//to remove this book from the DB
const removeThisFromDb = (objRef) => {
    // let bookName = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
    let bookName = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
    let bookAuthor = objRef.parentElement.previousElementSibling.lastElementChild.innerHTML;

    console.log(bookName);

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/remove_book_from_db.php",
        data: {
            book_name: bookName,
            book_author: bookAuthor,
            db_name: dbName
        },
        success: function () {
            // location.reload();
            // console.log();
            loadAlreadyReadBooks();
            loadToReadContentArea();
            readingGoalModifierFun();
        }
    }); //ajax call to remove this book from the database
}

const addToReadlist = (objRef) => {
    let bookName = objRef.parentElement.previousElementSibling.firstElementChild.innerHTML;
    let bookAuthor = objRef.parentElement.previousElementSibling.lastElementChild.innerHTML;

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/add_to_readlist.php",
        data: {
            book_name: bookName,
            book_author: bookAuthor,
            db_name: dbName
        },
        success: function() {
            showAlert("Book status modified!");
            loadAlreadyReadBooks();
            loadToReadContentArea();
            readingGoalModifierFun();
        }
    })
}

//to modify the yearly reading target / goal
const modifyReadingTarget = () => {
    let targetCount = document.getElementById("bkReadingGoals");

    if (targetCount.value == null || targetCount.value == "" || targetCount.value == 0) {
        showAlert("Please enter an appropriate value before submitting");
        return;
    }

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/modify_reading_target.php",
        data: {
            target_count: targetCount.value,
            email: emailID
        },
        async: true,
        success: function(response) {
            targetCount.value = "";
            showAlert("Yearly reading goal modified successfully!");
            // alert(response);
        }, 
        error: function(error) {
            alert(error);
        }
    });
}

//Initial page loading function calls
loadToReadContentArea();
loadAlreadyReadBooks();
readingGoalModifierFun();

// let selectedYear = document.getElementById("year-select-drop-down");

const yearChangeFun = (event) => {
    sessionStorage.setItem("selected-drop-down-year", event.target.value);
    loadAlreadyReadBooks();
}

// selectedYear.addEventListener("change", (e) => {
    // console.log(this.value);
    // console.log(e.target.value);
    // sessionStorage.setItem("selected-drop-down-year", e.target.value);
    // loadAlreadyReadBooks();
    // location.reload(); // function call everytime is not working, so the only other way is refresh
    // location.reload(); 
// });


// //remove this later if needed
let leftBoxOne = document.getElementsByClassName("left-box")[0];

// leftBoxOne.style.background = "black";
// leftBoxOne.style.color = "white";
// leftBoxOne.style.fontWeight = "normal";

// let individualElementBtnAreaOne = document.getElementsByClassName("individual-element-btn-area")[0];

// individualElementBtnAreaOne.firstElementChild.style.background = "white";
// individualElementBtnAreaOne.firstElementChild.style.fontWeight = "bold";
// individualElementBtnAreaOne.firstElementChild.style.color = "black";

// firstBtn.style.background = "white";
// firstBtn.style.fontWeight = "bold";
// firstBtn.style.color = "black";

// let progressBarValueCount = document.getElementById("progress-bar-value-count");

// console.log(progressBarValueCount);