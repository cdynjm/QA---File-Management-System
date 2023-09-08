<?php

include_once('db_connect.php');
global $download;

if(isset($_POST['download_id'])) {
    
    $download_id = $_POST['download_id'];

    $SQL_DOWNLOAD = "SELECT * FROM files WHERE id='$download_id'";
    $SQL_DOWNLOAD_QUERY = mysqli_query($db, $SQL_DOWNLOAD);

    if(mysqli_num_rows($SQL_DOWNLOAD_QUERY) == 1) {
        while($rows = mysqli_fetch_assoc($SQL_DOWNLOAD_QUERY)) {
            $download = $rows['file_name'];
        }
    }
    echo $download;
}

?>