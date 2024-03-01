<?php

$con = null;

try {
    $con = mysqli_connect("localhost:3308//", "root", "");
} catch (Exception $e) {
    die("<script>callErr(3);</script>");
}

?>