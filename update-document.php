<?php 
session_start();

include("lib/includes.php");
include("db_connect.php");

if(empty($_SESSION['id'])) { ?>
    <script>
        document.location.href = "login"; 
    </script> <?php
}
?>
<style>
    .prev-next {
        display: none;
    }
    .container {
        grid-template-rows: 50px 80px 0px 1fr 50px;
    }
    #upload-pop-up, #new-folder {
        display: none;
    }
</style>
        <div class="update-document">
                <?php
                $id = $_SESSION['document_id'];
                $SQL = "SELECT * FROM files WHERE id='$id'";
                $SQL_QUERY = mysqli_query($db, $SQL);

                if(mysqli_num_rows($SQL_QUERY) == 1) {
                    while($rows = mysqli_fetch_assoc($SQL_QUERY)) {
                    ?>
                    <form id="updateForm" enctype="multipart/form-data">
                        <input name="update_id" value="<?php echo $rows['id']; ?>" hidden />
                        <p id="text">Title: <input name="update_title" value="<?php echo $rows['document_title']; ?>"></p>
                        <p id="text">Description: <input name="update_description" value="<?php echo $rows['description']; ?>"></p>
                        <p id="text">Date: <input name="update_date" type="date" value="<?php echo $rows['date']; ?>"></p>
                        <p id="text">Keywords: <input name="update_keywords" value="<?php echo $rows['keywords']; ?>"></p>
                        <p id="text">File: <input value="<?php echo $rows['file_name']; ?>" readonly></p>
                        
                        <p id="text">Upload New File</p>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf, .docx, .pptx, .xlxs"/><br>
                        <button type="submit" class="update-btn" id='exclude-btn'><i class="fa-solid fa-file-pen"></i> Update Document</button>
                        <span class='responseMsg'>
                            <span class="icon"><i class="fa-solid fa-file-circle-check"></i></span> Document Updated Successfully!
                        </span>
                    </form>
                    <?php
                    }
                }
                ?>
            
        </div>
    </div>
</body>

<script type="text/javascript" src="js/vue.js"></script>