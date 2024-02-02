<?php
    session_start();
    include './connect.php';

    mysqli_select_db($con, $_SESSION["db_name"]);

    // GLOBAL $con;

    // $cur_year = date("Y");

    $selected_drop_down_year = $_POST["selected_drop_down_year"];
    $books_already_read_q = mysqli_query($con, "select * from bookshelf where Status = 'completed' and Year = $selected_drop_down_year;");

    if ($books_already_read_q->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($books_already_read_q)) {

            // if (strlen($row["BookName"]) >= 45) {
            //     $book_name_updated = substr($row["BookName"], 0, 45) . "...";
            // } else {
            //     $book_name_updated = $row["BookName"];
            // }

            echo '<div class="book-info-box">
            <div class="book-info" style="width: 95%;">
                <div class="book-info-name">' . $row["BookName"] . '</div>
                <div class="book-info-author">' . $row["Author"] . '</div>
            </div>
            <div class="book-info-action" style="width: 5%;">
                <div class="remove-book-icon" onclick="removeThisFromDb(this);" style="height: 30px;">
                    <img src="./icons/icons8-close-64.png" alt="" width="30" height="30">
                </div>
            </div>
        </div>';
        }
    } else {
        echo 'No books read yet!!';
    }


// load_already_read_books();

?>