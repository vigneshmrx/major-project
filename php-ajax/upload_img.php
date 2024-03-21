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

    // var_dump($_FILES["file"]);
    // var_dump($_POST["folder_name"]);
    
    try {
        move_uploaded_file($_FILES["file"]["tmp_name"], $directory_path . "/" . $_FILES["file"]["name"]);

        // if (move_uploaded_file($_FILES["file"]["tmp_name"], $directory_path . "/" . $_FILES["file"]["name"])) {
        //     echo "Image uploaded successful";
        // } else {
        //     echo "Image coulnd't be uploaded";
        // }
        
    } catch (Exception $image_upload_exc) {
        echo $image_upload_exc;
    }
}
catch (Exception $some_exc) {
    echo $some_exc;
}



?>