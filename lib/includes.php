<?php 
$_SERVER['SERVER_NAME'];
$_SERVER['HTTP_HOST']; 
getenv('HTTP_HOST');

date_default_timezone_set("Asia/Singapore");

if(empty($_SESSION['id'])) { ?>
    <script>
        document.location.href = "login"; 
    </script> <?php
}
$USERID = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--@include ... links & script tags-->
    <link rel="shortcut icon" type="image/png" href="assets/icons/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <link rel="stylesheet" type="text/css" href="css/print-page.css" media="print">

    <link rel="stylesheet" type="text/css" href=" https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css">
    
    <script src="https://kit.fontawesome.com/fcdde7325c.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b3a3a25b87.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js"></script>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!--@include ... meta-tags-->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--@include ...-->

    </script>

    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/app.vue"></script>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <script src="http://cdn.jsdelivr.net/vue/2.0.3/vue.js"></script>
    <script src="https://unpkg.com/vue@2.1.4/dist/vue.js"></script>
    
</head>

<title>QA - FMS</title>
<body>
    <div class="container" id="printableArea">
        <div class="header">
            <span class="label">
                {{ headerLabel }}
            </span>
            <span class="logo">
                <img src="assets/icons/user-logo.png">
            </span>
            <?php if($_SESSION['AUTH_USER'] == "ADMIN") { ?>
                <span class="text">
                    {{ accountType1 }}
                </span>
            <?php } ?>
            <?php if($_SESSION['AUTH_USER'] == "USER") { ?>
                <span class="text">
                    {{ accountType2 }}
                </span>
            <?php } ?>
        </div>
        <div class="sub-header">
            <span class="search-bar">
                <input placeholder="Search..." id="user_search">
            </span>
            <span class="text"><i class="fa-solid fa-filter"></i> {{ searchFilter }}</span>
            <select name="filter_options" id="filter_option">
                <option value="Document">{{ option1 }}</option>
                <option value="Description">{{ option2 }}</option>
                <option value="Date">{{ option3 }}</option>
                <option value="Keywords">{{ option4 }}</option>
            </select>
            <?php if($_SESSION['AUTH_USER'] == "ADMIN") { ?>
            <button id="upload-pop-up">
                <span class="icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span>{{ subHeaderLabel1 }}</span>
            </button>
            <?php } ?>
            <?php if($_SESSION['AUTH_USER'] == "ADMIN") { ?>
            <button id="new-folder">
                <span class="icon"><i class="fa-solid fa-folder-plus"></i></span>
                <span>{{ subHeaderLabel2 }}</span>
            </button>
            <?php } ?>
            <button id="print" onclick="printPageArea('areaID')">
                <span class="icon"><i class="fa-solid fa-print"></i></span>
                <span>{{ subHeaderLabel3 }}</span>
            </button>
          <!--  <input type=button onclick="window.open('assets/resources/pdf/Capstone-Project-2-FINAL.pdf'); return true;" value="Open"> -->
        </div>
        <div class="sidebar">
            <div class="logo">
                <img src="assets/icons/slsu.png">
            </div>
            <div class="label">
                <label>{{ sidebarLabel }}</label>
            </div>
            <div class="sidebar-buttons">
                <li class="active-dashboard">
                    <span class="icon"><i class="fa-solid fa-computer"></i></span>
                    <span class="text"><a href="dashboard">{{ sidebarBTN1 }}</a></span>
                </li>
                <li class="active-file-manager">
                    <form method="POST" action="server.php">
                        <span class="icon"><i class="fa-solid fa-folder-tree"></i></span>
                        <input type='text' name='set_folderID' value=0 hidden/>
                        <span class="text"><input type='submit' name="file_manager" value="File Manager"/></span>
                    </form>
                </li>
                <?php if(!empty($_SESSION['AUTH_USER'])) { ?>
                    <li>
                        <span class="icon"><i class="fa-flip-horizontal fa-solid fa-right-to-bracket"></i></span>
                        <span class="text"><button class="log-out">{{ sidebarBTN2 }}</button></span>
                    </li>
                <?php } ?>
            </div>
        </div>

        <div class="upload-pop-up">
            <!-- Status message -->
            <div class="statusMsg"></div>
            <form id="fupForm" enctype="multipart/form-data">
                <h3>{{ uploadHeader }}</h3>

                <label>{{ uploadLabel1 }}</label><br>
                <input placeholder="Document Title" name='title' required><br>
                
                <label>{{ uploadLabel2 }}</label><br>
                <textarea placeholder="Description" name='description' required></textarea><br>

                <label>{{ uploadLabel3 }}</label><br>
                <input id='date' value="<?php echo date('Y-m-d');?>"name='date' required readonly><br>

                <label>{{ uploadLabel4 }}</label><br>
                <input type="text" placeholder="Keywords" name="keywords">

                <label>{{ uploadLabel5 }}</label><br>
                <input type="file" class="form-control" id="file" name="file" accept=".pdf, .docx, .pptx, .xlxs" required/><br>
                <input name='folderID' value="<?php echo $_SESSION['folder_id']; ?>" hidden>
                <button type="submit" class="submitBtn">Upload</button>
                <button class="cancel-btn" id="close-upload-pop-up">Cancel</button>
            </form>
        </div>

        <div class="new-folder">
            <!-- Status message -->
            <div class="statusMsg"></div>
                <h3>{{ folderHeader }}</h3>

                <label>{{ folderLabel }}</label><br>
                <input placeholder="Folder Name" id='folder-name' required><br>
                <input id='folder-id' value="<?php echo $_SESSION['folder_id']; ?>" hidden>
                <button class="create-folder">{{ folderCreate }}</button>
                <button class="cancel-btn">{{ folderCancel }}</button>
        </div>


        <div class="log-in" id='log-in'>
            <section id="content">
                <form id='logAUTH'>
                    <h1>Administrator</h1>
                    <div>
                        <input type="text" placeholder="Username" required="" id="username" name="username" />
                    </div>
                    <div>
                        <input type="password" placeholder="Password" required="" id="password" name="password"/>
                    </div>
                    <div class="responseError"></div>
                    <div>
                        <button type="submit"><span class="icon">Log In</button>
                    </div>
                </form>
            </section>
        </div>
        <?php if($_SESSION['AUTH_USER'] == "ADMIN") { ?>
            <div class="context-menu">
                <form method="POST">
                    <input name="document_id" class="menu-id" hidden>
                    <p class="title-document"></p>
                    <button id="delete-btn" type="submit" name="delete_document">
                        <span class="icon"><i class="fa-solid fa-trash"></i></span>
                        <span class="text">Delete</span>
                    </button><br>
                </form>
                <input class="download" hidden>
                <button id="delete-btn" class="download-btn">
                    <span class="icon"><i class="fa-solid fa-download"></i></span>
                    <span class="text">Download</span>
                </button>
            </div>
        <?php } ?>

        <?php if($_SESSION['AUTH_USER'] == "ADMIN") { ?>
            <div class="context-menu-folder">
                <form method="POST">
                    <input name="folder_id" class="folder-id" hidden>
                    <p class="folder-name"></p>
                    <button id="delete-btn" type="submit" name="delete_folder">
                        <span class="icon"><i class="fa-solid fa-trash"></i></span>
                        <span class="text">Delete</span>
                    </button><br>
                </form>
                <button id="rename-btn">
                <input class="rename-id" hidden>
                    <span class="icon"><i class="fa-solid fa-file-signature"></i></span>
                    <span class="text">Rename</span>
                </button>
            </div>
        <?php } ?>

        <?php 
        
        if(isset($_POST['delete_document'])) {
            $document_id = $_POST['document_id'];
            include("db_connect.php");
            $SQL_DELETE = "DELETE FROM files WHERE id='$document_id'";
            mysqli_query($db, $SQL_DELETE);
        }

        if(isset($_POST['delete_folder'])) {
            $folder_id = $_POST['folder_id'];
            include("db_connect.php");
            $SQL_DELETE = "DELETE FROM folders WHERE id='$folder_id' OR parent_id='$folder_id'";
            mysqli_query($db, $SQL_DELETE);
            $SQL_DELETE_FROM_FILES = "DELETE FROM files WHERE folder_id='$folder_id'";
            mysqli_query($db, $SQL_DELETE_FROM_FILES);
        }

        ?>

        <div class="footer" id="exclude-footer">
            <!--
                <div class="prev-next">
                    <span class="label">Page</span>
                    <button><i class="fa-solid fa-chevron-left"></i></button>
                    <span class="text">1</span>
                    <button><i class="fa-solid fa-chevron-right"></i></button>
                </div> 
             -->
            <p>Southern Leyte State University | Developed By: Jemuel Cadayona © 2023</p>
        </div>

        <div id='areaID'>