<?php
    session_start();
    include '../connect.php';

    $db_name = $_POST["db_name"];

    // mysqli_select_db($con, $_SESSION["db_name"]);
    mysqli_select_db($con, $db_name);

    // GLOBAL $con;

    // $cur_year = date("Y");

    $selected_drop_down_year = $_POST["selected_drop_down_year"];
    $books_already_read_q = mysqli_query($con, "select * from bookshelf where Status = 'completed' and Year = $selected_drop_down_year;");

    if ($books_already_read_q->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($books_already_read_q)) {

            echo '<div class="book-info-box">
            <div class="book-info" style="width: 95%;">
                <div class="book-info-name">' . ucwords($row["BookName"]) . '</div>
                <div class="book-info-author">' . $row["Author"] . '</div>
            </div>
            <div class="book-info-action" id="' . $row["SNo"] . '">
                <div class="add-to-readlist-icon" onclick="changeBookStatus(this);" style="height: 30px;">
                    <abbr title="Add to Read List">
                    <img src="./icons/icons8-redo-50.png" width="30" height="30"></abbr>
                </div>
                <div class="remove-book-icon" onclick="removeThisFromDb(this);" style="height: 30px;">
                    <abbr title="Remove book">
                    <img src="./icons/icons8-close-64.png" alt="" width="30" height="30"></abbr>
                </div>
            </div>
        </div>';
        }
    } else {
        echo '<div class="no-content-grid-toggle"><img src="../major-project/images/no-books-illustration.png" width="30%" class="remove-bg">NO BOOKS READ THIS YEAR!</div>';
    }


// load_already_read_books();

?>