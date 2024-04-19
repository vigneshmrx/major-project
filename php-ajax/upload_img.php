<?php

$folder_name = $_POST["folder_name"];

$directory_path = "../images/user-images/" . $folder_name;

echo $directory_path;

try {
    if (!file_exists($directory_path)) {
        echo "Inside directory thingy";
        if (mkdir($directory_path)) {
            echo "Direcotry created successfully";
        } else {
            echo "Directory coulnd't be created";
        }
    }
    
    try {
        move_uploaded_file($_FILES["file"]["tmp_name"], $directory_path . "/" . $_FILES["file"]["name"]);
        
    } catch (Exception $image_upload_exc) {
        echo 'Some error occured. Please try again later.';
    }
}
catch (Exception $some_exc) {
    echo 'Some error occured. Please try again later.';
}



?>