<?php

session_start();

include '../connect.php';

$db_name = $_POST["db_name"];
$status = "completed";

mysqli_select_db($con, $db_name);

$books_to_read_q = mysqli_query($con, "select * from bookshelf where Status = 'to read';");

if ($books_to_read_q->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($books_to_read_q)) {
        
        echo '<div class="book-info-box">
        <div class="book-info">
            <div class="book-info-name">' . ucwords($row["BookName"]) . '</div>
            <div class="book-info-author">' . $row["Author"] . '</div>
        </div>
        <div class="book-info-action" id="' . $row["SNo"] . '">
            <div class="edit-this-book-icon" onclick="editThisBook(this);" style="height: 30px;">
                <abbr title="Edit book">
                <img src="./icons/icons8-edit-60.png" width="30" height="30"></abbr>
            </div>
            <div class="done-reading-icon" onclick="changeBookStatus(this);" style="height: 30px;">
                <abbr title="Completed reading">
                <img src="./icons/icons8-normal-tick-60.png" alt="" width="30"></abbr>
            </div>
            <div class="remove-book-icon" onclick="removeThisFromDb(this);" style="height: 30px;">
                <abbr title="Remove book">
                <img src="./icons/icons8-close-64.png" alt="" width="30"></abbr>
            </div>
        </div>
    </div>';
    }
} else {
    echo '<div class="no-content-grid-toggle"><img src="../major-project/images/no-books-illustration.png" width="30%" class="remove-bg">NO BOOKS IN READ LIST!</div>';
}

?>