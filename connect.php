<?php

$con = null;

try {
    $con = mysqli_connect("localhost", "root", "");
} catch (Exception $e) {
    die("<script>callErr(3);</script>");
}

?>