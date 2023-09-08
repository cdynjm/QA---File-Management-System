<?php

include_once('db_connect.php');
global $rename;
global $download;

if(isset($_POST['rename_folder'])) {
    $rename_folder = $_POST['rename_folder'];

    $SQL_RENAME = "SELECT * FROM folders WHERE id='$rename_folder'";
    $SQL_RENAME_QUERY = mysqli_query($db, $SQL_RENAME);

    if(mysqli_num_rows($SQL_RENAME_QUERY) == 1) {
        while($rows = mysqli_fetch_assoc($SQL_RENAME_QUERY)) {
            $rename .= "".$rows['name']."";
        }
    }
    echo $rename;
}

if(isset($_POST['new_folder_name'])) {
    $folder_id = $_POST['rename_folder'];
    $new_folder_name = $_POST['new_folder_name'];

    $SQL_RENAME_TO_NEW = "UPDATE folders SET name='$new_folder_name' WHERE id='$folder_id'";
    mysqli_query($db, $SQL_RENAME_TO_NEW);
}

?>