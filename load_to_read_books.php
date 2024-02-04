<?php

session_start();

include './connect.php';

mysqli_select_db($con, $_SESSION["db_name"]);

// function load_to_read_books() {
    // GLOBAL $con;
$books_to_read_q = mysqli_query($con, "select * from bookshelf where Status = 'to read';");

if ($books_to_read_q->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($books_to_read_q)) {

        // if (strlen($row["BookName"]) >= 45) {
        //     $book_name_updated = substr($row["BookName"], 0, 45) . "...";
        // } else {
        //     $book_name_updated = $row["BookName"];
        // }
        
        echo '<div class="book-info-box">
        <div class="book-info">
            <div class="book-info-name">' . $row["BookName"] . '</div>
            <div class="book-info-author">' . $row["Author"] . '</div>
        </div>
        <div class="book-info-action">
            <div class="done-reading-icon" onclick="changeStatusToCompleted(this);" style="height: 30px;">
                <img src="./icons/icons8-tick-50.png" alt="" width="30">
            </div>
            <div class="remove-book-icon" onclick="removeThisFromDb(this);" style="height: 30px;">
                <img src="./icons/icons8-close-64.png" alt="" width="30">
            </div>
        </div>
    </div>';
    }
} else {
    echo "No books to read!!";
}
// }

?>