<?php
session_start();

include '../connect.php';

// $email = $_SESSION["email"];
$email = $_POST["email"];
$db_name = $_POST["db_name"];

mysqli_select_db($con, "prodo_db");

$get_users_reading_goal = mysqli_query($con, "select reading_goals from users_list where email='$email';");

$row = mysqli_fetch_assoc($get_users_reading_goal);

//getting the reading_goal of the user, default is 0, if modified otherwise
$yearly_reading_goal = $row["reading_goals"];


// mysqli_select_db($con, $_SESSION["db_name"]);
mysqli_select_db($con, $db_name);

$present_year = date("Y");

$get_count_of_completed_books_this_year = mysqli_query($con, "select * from bookshelf where Status = 'completed' and Year = $present_year");

// $row = mysqli_fetch_assoc($get_count_of_completed_books_this_year);

$completed_books_count = $get_count_of_completed_books_this_year -> num_rows;
// echo var_dump($get_count_of_completed_books_this_year);

// echo "goal: $yearly_reading_goal, completed count: $completed_books_count";

if ($yearly_reading_goal == 0) {
    $width_of_progress_bar = 0;
} else {
    $width_of_progress_bar = round($completed_books_count / $yearly_reading_goal * 100);
}



echo "YEARLY GOALS: " . "<div id='goals-counter'> $completed_books_count / $yearly_reading_goal </div>" . 
    "PROGRESS: " . "<div id='goal-progress-bar-area'>" . "<div id='progress-bar'>" . 
    "<div id='progress-bar-value' style='width: $width_of_progress_bar%;'>" . "</div></div>" . 
    "<div id='progress-bar-value-count'>" . ($width_of_progress_bar >= 10 ? $width_of_progress_bar : ($width_of_progress_bar == 0 ? 0 : "0" . $width_of_progress_bar)) . "%" . "</div></div>";
?>



<!-- ($width_of_progress_bar >= 10? $width_of_progress_bar : "0" . $width_of_progress_bar) . "%" . "</div></div>"; -->