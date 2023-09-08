<?php
    session_start();
    $userid = $_SESSION['id'];
    if($userid == 0) { header('Location: login');}
    else { header('Location: dashboard'); }
?>