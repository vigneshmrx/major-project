<?php

$con = null;

try {
    $con = mysqli_connect("localhost:3307//", "root", "");
} catch (Exception $e) {
    die("<script>callErr(3);</script>");
}

?>