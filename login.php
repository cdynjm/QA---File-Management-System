<?php
include_once('server.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/png" href="assets/icons/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://kit.fontawesome.com/fcdde7325c.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b3a3a25b87.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QA - FMS | Login</title>
</head>
<body>
    <div class="login-content">
        <div class="img">
            <img src="assets/icons/king-fisher.png">
        </div>
        <form method='POST'>
            <img src="assets/icons/slsu.png">
            <h2 class="title">QA File Management System</h2>
            <div class="input-div one">
                <div class="i">
                    <i class="fas fa-user"></i>
                </div>
                <div class="div">
                    <input type="text" name="username" class="input" placeholder="Username">
                </div>
            </div>
            <div class="input-div pass">
                <div class="i"> 
                    <i class="fas fa-lock"></i>
                </div>
                <div class="div">
                    <input type="password" name="password" class="input" placeholder="Password">
                </div>
            </div>
            <button type="submit" class="btn" name="login"><span id='icon'><i class="fa-solid fa-right-to-bracket"></i></span><span id='text'>Login</span></button>
            <br><p>Developed By: Jemuel Cadayona<p>
            <a href="https://southernleytestateu.edu.ph/Dashboard/en/">Southern Leyte State University</a><br>
        </form>
    </div>
    <script type="text/javascript" src="js/login.js"></script>
</body>
</html>