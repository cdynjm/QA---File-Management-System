<?php 

include_once 'db_connect.php'; 

if(isset($_POST['login'])) {
            /*<- VARIABLES ... ->*/
            $username = $_POST['username'];
            $password = $_POST['password'];

            /*<- CONDITIONAL STATEMENT ... ->*/
            if(!empty($username) AND ($password)) {

                /*<- SELECT DATA FROM DATABASE ... ->*/
                $sql_authenticate = "SELECT * FROM account WHERE username = '$username' AND password = '$password'";
                $sql_result = mysqli_query($db, $sql_authenticate);

                /*<- FETCH INFORMATION ... ->*/
                if(mysqli_num_rows($sql_result) == 1) {

                    /*<- LOOPING STATEMENT ... ->*/
                    while($rows_fetch = mysqli_fetch_assoc($sql_result)) {

                        /*<- START SESSION ... ->*/
                        session_start();
                        /*<- HOLDS DATA [WHICH WILL BE DISPLAYED IN THE Dashboard SIDEBAR] ... ->*/
                        $_SESSION['name'] = $rows_fetch['name'];
                        $_SESSION['id'] = $rows_fetch['id'];
                        $_SESSION['username'] = $rows_fetch['username'];
                        $_SESSION['password'] = $rows_fetch['password'];
                        $_SESSION['AUTH_USER'] = $rows_fetch['type'];

                        /*<- PAGE TRANSITION ... ->*/
                        header('Location: dashboard');
                    }
                }
                else {
                    /*<- DISPLAYS WHEN A LOG IN CREDENTIAL PROVIDED
                    DOESN'T MATCHED AT LEAST 1 ROW FROM THE DATABASE TABLE ... ->*/ ?>
                    <div id='errormsg1'>
                        <span id='error-icon'><i class="fa-regular fa-circle-xmark"></i></span><p> Invalid or Unregistered Account!</p><br>
                    <center><button onclick='invalid_errormsg()'>Retry</button></center></div>
                    <div id='errormsg-banner'></div>
                <?php }
            }

            /*<- DISPLAYS IF THE LOG IN FIELD IS EMPTY ... ->*/
            if(empty($username)) {
                if(!empty($password)) { ?>
                    <div id="errormsg2">
                        <span id='error-icon'><i class="fa-regular fa-circle-xmark"></i></span><p> Username Field is Empty!</p><br>
                    <center><button onclick="empty_username_errormsg()">Retry</button></center></div>
                    <div id="errormsg-banner"></div>
            <?php }
            }
            if(empty($password)) {
                if(!empty($username)) { ?>
                    <div id="errormsg3">
                        <span id='error-icon'><i class="fa-regular fa-circle-xmark"></i></span><p> Password Field is Empty!</p><br>
                    <center><button onclick="empty_password_errormsg()">Retry</button></center></div>
                    <div id="errormsg-banner"></div>
                <?php }
            }
            if(empty($username)) {
                if(empty($password)) { ?>
                    <div id="errormsg4">
                        <span id='error-icon'><i class="fa-regular fa-circle-xmark"></i></span><p> Empty Fields!</p><br>
                    <center><button onclick="empty_fields_errormsg()">Retry</button></center></div>
                    <div id="errormsg-banner"></div>
                <?php }
            }
            
        }
?>

<?php 

global $EMBED_SEARCH_RESULT;
global $RESPONSE_ERROR;
global $rename;
global $download;
 
// If form is submitted 
if(isset($_POST['title']) || isset($_POST['date']) || isset($_POST['description']) || isset($_POST['keywords']) || isset($_POST['file'])){ 
    session_start();
    // File upload folder 
    $uploadDir = 'assets/resources/'; 
    $extension = '';
    // Allowed file types 
    $allowTypes = array('pdf', 'doc', 'docx', 'pptx', 'xlxs'); 
    
    // Default response 
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    ); 
    
    // Get the submitted form data 
    $title = $_POST['title']; 
    $date = $_POST['date'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $userid = $_SESSION['id'];
    $folder_id = $_POST['folderID'];
    
    // Check whether submitted data is not empty 
    if(!empty($title) && !empty($description)){ 
        // Validate email 
        
            $uploadStatus = 1; 
             
            // Upload file 
            $uploadedFile = ''; 
            if(!empty($_FILES["file"]["name"])){ 
                // File path config 
                $fileName = basename($_FILES["file"]["name"]); 
                $targetFilePath = $uploadDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                 
                // Allow certain file formats to upload 
                if(in_array($fileType, $allowTypes)){ 
                    // Upload file to the server 
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                        $uploadedFile = $fileName; 
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, there was an error uploading your file.'; 
                    } 
                }else{ 
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, only '.implode('/', $allowTypes).' files are allowed to upload.'; 
                } 
            } 
             
            if($uploadStatus == 1){ 
                // Include the database config file 
                include_once 'db_connect.php'; 
                // Insert form data in the database 
                $sqlQ = "INSERT INTO files (userid, document_title, description, date, keywords, folder_id, file_name, file_type) VALUES (?,?,?,?,?,?,?,?)"; 
                $stmt = $db->prepare($sqlQ); 
                $stmt->bind_param("ssssssss", $userid, $title, $description, $date, $keywords, $folder_id, $uploadedFile, $fileType); 
                $insert = $stmt->execute(); 
                
            } 
    }
} 

if(isset($_POST['submit_authID'])) {

    include_once 'db_connect.php'; 

    $authID = $_POST['authID'];

    $SQL_AUTH = "SELECT * FROM folders WHERE id=$authID";
    $SQL_AUTH_QUERY = mysqli_query($db, $SQL_AUTH);

    if(mysqli_num_rows($SQL_AUTH_QUERY) > 0) {
        while($ROWS_AUTH_QUERY = mysqli_fetch_assoc($SQL_AUTH_QUERY)) {
            session_start();

            $_SESSION['id'] = $ROWS_AUTH_QUERY['id'];
            

            header('Location: view-folder');
        }
    }
}

if(isset($_POST['submit_updateID'])) {

    include_once 'db_connect.php'; 

    $updateID = $_POST['updateID'];

    $SQL_AUTH = "SELECT * FROM files WHERE id=$updateID";
    $SQL_AUTH_QUERY = mysqli_query($db, $SQL_AUTH);

    if(mysqli_num_rows($SQL_AUTH_QUERY) > 0) {
        while($ROWS_AUTH_QUERY = mysqli_fetch_assoc($SQL_AUTH_QUERY)) {
            session_start();

            $_SESSION['id'] = $ROWS_AUTH_QUERY['id'];
            $_SESSION['title'] = $ROWS_AUTH_QUERY['title'];
            $_SESSION['author'] = $ROWS_AUTH_QUERY['author'];
            $_SESSION['adviser'] = $ROWS_AUTH_QUERY['adviser'];
            $_SESSION['date'] = $ROWS_AUTH_QUERY['date_submission'];
            $_SESSION['abstract'] = $ROWS_AUTH_QUERY['abstract'];
            $_SESSION['keywords'] = $ROWS_AUTH_QUERY['keywords'];
            $_SESSION['file'] = $ROWS_AUTH_QUERY['file_name'];

            header('Location: update-document');
        }
    }
}

if(isset($_POST['user_search'])) {

    include_once 'db_connect.php'; 
    $cnt = 1;
    $user_search = $_POST['user_search'];
    $filter_option = '';

    $array_options = array(
        "Document",
        "Description",
        "Date",
        "Keywords"
    );

    $array_column_value = array(
        "document_title",
        "description",
        "date",
        "keywords"
    );

    for ($loop_options = 0; $loop_options <= 3; $loop_options++) {
        switch($_POST['filter_option']) {
            case $array_options[$loop_options]:
                $SEARCH = "SELECT * FROM files WHERE $array_column_value[$loop_options] LIKE '%$user_search%'";
            break;
        }
    }

    $EMBED_SEARCH_RESULT .= "
        <span class='recent-uploads' id='exclude-header'><i class='fa-solid fa-magnifying-glass'></i> Search Results</span>
        <table>
            <tr>
                <th width='5%'>No.</th>
                <th width='20%'>Documet Title</th>
                <th width='20%'>Description</th>
                <th width='15%'>Date</th>
                <th width='15%'>Keywords</th>
                <th width='13%' id='exclude-header'>Action</th>
            </tr>
    ";

    $SQL_AUTH_SEARCH = $SEARCH;
    $SQL_AUTH_SEARCH_QUERY = mysqli_query($db, $SQL_AUTH_SEARCH);

    session_start();
    
    if(mysqli_num_rows($SQL_AUTH_SEARCH_QUERY) > 0) {
        while($ROWS_AUTH_SEARCH_QUERY = mysqli_fetch_assoc($SQL_AUTH_SEARCH_QUERY)) {
            $EMBED_SEARCH_RESULT .= "
            <tr>
            <td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'><center>".$cnt."</center></td>";

            if($ROWS_AUTH_SEARCH_QUERY['file_type'] == "pdf") {
                $EMBED_SEARCH_RESULT .= "<td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'><i class='fa-solid fa-file-pdf fa-lg'></i> ".$ROWS_AUTH_SEARCH_QUERY['document_title']."</td>"; 
            }
            if($ROWS_AUTH_SEARCH_QUERY['file_type'] == "pptx") {
                $EMBED_SEARCH_RESULT .= "<td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'><i class='fa-solid fa-file-powerpoint fa-lg'></i> ".$ROWS_AUTH_SEARCH_QUERY['document_title']."</td>"; 
            }
            if($ROWS_AUTH_SEARCH_QUERY['file_type'] == "docx") {
                $EMBED_SEARCH_RESULT .= "<td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'><i class='fa-solid fa-file-word fa-lg'></i> ".$ROWS_AUTH_SEARCH_QUERY['document_title']."</td>"; 
            }
            if($ROWS_AUTH_SEARCH_QUERY['file_type'] == "xlxs") {
                $EMBED_SEARCH_RESULT .= "<td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'><i class='fa-solid fa-file-excel fa-lg'></i> ".$ROWS_AUTH_SEARCH_QUERY['document_title']."</td>"; 
            }
            $EMBED_SEARCH_RESULT .="<td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'>".$ROWS_AUTH_SEARCH_QUERY['description']."</td>
            <td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'><center>".$ROWS_AUTH_SEARCH_QUERY['date']."</center></td>
            <td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."'>".$ROWS_AUTH_SEARCH_QUERY['keywords']."</td>
            <td data-role='target' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."' data-target='File: ".$ROWS_AUTH_SEARCH_QUERY['document_title']."' id='exclude-cell'><center>
                <form method='POST' action='server.php'>
                    <span>
                        <input name='authID' value=".$ROWS_AUTH_SEARCH_QUERY['id']." hidden>
                        <button type='submit' name='submit_authID'><i class='fa-solid fa-eye'></i> View</button>
                    </span>";
            if($_SESSION['AUTH_USER'] == "ADMIN") {
            $EMBED_SEARCH_RESULT .= "<span>
                        <button data-role='document_id' data-id='".$ROWS_AUTH_SEARCH_QUERY['id']."'><i class='fa-solid fa-pen-to-square'></i> Edit</button>
                    </span>
                </center>
            </td>
        </tr>
            ";
            }
            $cnt += 1;
        }
    }
    else {
        $EMBED_SEARCH_RESULT .= "<td colspan='7'><center>No Results Found!</center></td>";
    }

    echo $EMBED_SEARCH_RESULT;
}

if(isset($_POST['update_title'])) {
    // File upload folder 
    $uploadDir = 'assets/resources/'; 
    
    // Allowed file types 
    $allowTypes = array('pdf', 'doc', 'docx', 'pptx', 'xlxs'); 
    
    // Default response 
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    );

    // Get the submitted form data 
    $update_id = $_POST['update_id'];
    $update_title = $_POST['update_title'];
    $update_description = $_POST['update_description']; 
    $update_date = $_POST['update_date'];
    $update_keywords = $_POST['update_keywords'];

    // Check whether submitted data is not empty 
    if(!empty($update_title) && !empty($update_description)){ 
        // Validate email 
        
            $uploadStatus = 1; 
             
            // Upload file 
            $uploadedFile = ''; 
            if(!empty($_FILES["file"]["name"])){ 
                // File path config 
                $fileName = basename($_FILES["file"]["name"]); 
                $targetFilePath = $uploadDir . $fileName; 
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                 
                // Allow certain file formats to upload 
                if(in_array($fileType, $allowTypes)){ 
                    // Upload file to the server 
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                        $uploadedFile = $fileName; 
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, there was an error uploading your file.'; 
                    } 
                }else{ 
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, only '.implode('/', $allowTypes).' files are allowed to upload.'; 
                } 
             
             
            if($uploadStatus == 1){ 
                // Include the database config file 
                include_once 'db_connect.php'; 
                // Insert form data in the database 
                $SQL_UPDATE = "UPDATE files SET document_title='$update_title', description='$update_description', date='$update_date', keywords='$update_keywords', file_name='$uploadedFile', file_type='$fileType' WHERE id='$update_id'";
                mysqli_query($db, $SQL_UPDATE);
                 
                if($insert){ 
                    $response['status'] = 1; 
                    $response['message'] = 'File uploaded successfully!'; 
                } 
            }
        }
        else {
            // Include the database config file 
            include_once 'db_connect.php'; 
            // Insert form data in the database 
            $SQL_UPDATE = "UPDATE files SET document_title='$update_title', description='$update_description', date='$update_date', keywords='$update_keywords' WHERE id='$update_id'";
            mysqli_query($db, $SQL_UPDATE);
        }
        
    }else{ 
         $response['message'] = 'Please fill all the mandatory fields (name and email).'; 
    } 

    // Return response 
    echo json_encode($response);
}

if(isset($_POST['folder_name'])) {
    session_start();
    $folder_name = $_POST['folder_name'];
    $userid = $_SESSION['id'];
    $parent_id = $_POST['parent_id'];

    // Include the database config file 
    include_once 'db_connect.php'; 
    // Insert form data in the database 
    $sqlQ = "INSERT INTO folders (userid, name, parent_id) VALUES (?,?,?)"; 
    $stmt = $db->prepare($sqlQ); 
    $stmt->bind_param("sss", $userid, $folder_name, $parent_id); 
    $insert = $stmt->execute(); 
}

if(isset($_POST['file_manager'])) {
    session_start();
    $_SESSION['folder_id'] = $_POST['set_folderID'];
    header('Location: file-manager?page=directory='. $_SESSION['folder_id'].'');
}

if(isset($_POST['document_id'])) {
    session_start();
    $_SESSION['document_id'] = $_POST['document_id'];
}

if(isset($_POST['folder_id'])) {
    session_start();
    $_SESSION['folder_id'] = $_POST['folder_id'];
}

if(isset($_POST['destroy_session'])) { session_start(); session_unset(); session_destroy(); }

?>

<script type="text/javascript" src="js/errormsg.js"></script>
<script type="text/javascript" src="js/app.js"></script>