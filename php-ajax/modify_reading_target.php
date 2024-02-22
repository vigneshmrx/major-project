<?php
session_start();

include '../connect.php';

// $email = $_SESSION["email"];
$email = $_POST["email"];
$yearly_target_reading_count = $_POST["target_count"];

mysqli_select_db($con, "prodo_db");

$updation_query = "update users set reading_goals = $yearly_target_reading_count where email = '$email';";

$result = mysqli_query($con, $updation_query);

?>