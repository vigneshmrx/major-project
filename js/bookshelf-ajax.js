const dbName = localStorage.getItem("dbName");
const userName = localStorage.getItem("userName");
const emailID = localStorage.getItem("emailID");

//to add book to the DB
const addBooktoDB = (bookStatus, objRef) => {
    let bookName = document.getElementById("bkName");
    let bookAuthor = document.getElementById("author");

    if (bookName.value == "" || bookName.value == null || bookAuthor.value == "" || bookAuthor.value == null) {
        showAlert("Please enter valid details before submitting");
        return;
    }

    let bookYear = document.getElementById("bkYear");

    if (bookYear.value == "" || bookYear.value == null || bookYear.value == undefined) {
        bookYear = new Date().getFullYear();
    } else {
        if (bookYear.value > new Date().getFullYear()) {
            showAlert("Enter an appropriated year!");
            return;
        }
    }

    let recordId = document.getElementsByClassName("add-book-form")[0].id;

    if (recordId == "none") {
        recordId = 0;
    } else {
        recordId = parseInt(recordId);
    }

    console.log("New values:\n");
    console.log(recordId, bookName.value, bookAuthor.value);

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/add_book.php",
        data: {
            book_name: bookName.value,
            book_author: bookAuthor.value,
            status: bookStatus,
            year: bookYear.value,
            db_name: dbName,
            record_id: recordId
        },
        success: function(response) {
            showAlert(response);
            bookName.value = "";
            bookAuthor.value = "";
            bookYear.value = "";

            if (recordId != 0) {
                removePopUp(document.getElementsByClassName("close-pop-up-icon-area")[0], [2, 3])
            }

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

//to load the already-read content area
const loadAlreadyReadBooks = () => {
    //this function loads already read books based on the year sleected in the drop down menu. The list of books changes if the selected year is changed (THIS IS AN IIFE FUNCTION)

    //adding year manually to #already-read-year
    let alreadyReadYearBar = document.getElementsByClassName("already-read-year")[0];
    let presentYear = new Date().getFullYear();

    let theContent = `<select id='year-select-drop-down' onchange='yearChangeFun(event)'>`;

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

//to remove this book from the DB
const removeThisFromDb = (objRef) => {
    let uniqueID = parseInt(objRef.parentElement.id);

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/remove_from_db.php",
        data: {
            db_name: dbName,
            table_name: "bookshelf",
            unique_id: uniqueID
        },
        success: function () {
            loadAlreadyReadBooks();
            loadToReadContentArea();
            readingGoalModifierFun();
            showAlert("Book deleted successfully!");
        }
    }); //ajax call to remove this book from the database
}

const changeBookStatus = (objRef) => {
    const uniqueID = parseInt(objRef.parentElement.id);

    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/change_bk_status.php",
        data: {
            db_name: dbName,
            unique_id: uniqueID
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
            removePopUp(document.getElementsByClassName("close-pop-up-icon-area")[1], [1]);
        }, 
        error: function(error) {
            alert(error);
        }
    });
}

const editThisBook = (objRef) => {
    const recUniqueId = objRef.parentElement.id;
    const bookName = objRef.parentElement.parentElement.firstElementChild.firstElementChild.innerHTML;
    const authorName = objRef.parentElement.parentElement.firstElementChild.lastElementChild.innerHTML;
    const bookStatus = objRef.parentElement.previousElementSibling.classList[1];
    const bookYear = parseInt(objRef.parentElement.previousElementSibling.classList[2]);

    console.log(recUniqueId, bookName, authorName, bookStatus, bookYear);

    showAddBookPopUp('', recUniqueId, bookName, authorName, bookStatus, bookYear);
}

//Initial page loading function calls
loadToReadContentArea();
loadAlreadyReadBooks();
readingGoalModifierFun();

const yearChangeFun = (event) => {
    sessionStorage.setItem("selected-drop-down-year", event.target.value);
    loadAlreadyReadBooks();
}

let leftBoxOne = document.getElementsByClassName("left-box")[0];