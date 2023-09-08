<?php 
session_start();

include("lib/includes.php");
include("db_connect.php");

if(empty($_SESSION['id'])) { ?>
    <script>
        document.location.href = "login"; 
    </script> <?php
}
else {
    $_SESSION['delete_btn'] = '';
}

$COUNT_ARTICLES = 0;
$COUNT_FOLDERS = 0;

$SQL_COUNT = "SELECT * FROM files";
$SQL_COUNT_QUERY = mysqli_query($db, $SQL_COUNT);

if(mysqli_num_rows($SQL_COUNT_QUERY) > 0) {
    while($ROWS = mysqli_fetch_assoc($SQL_COUNT_QUERY)) {
        $COUNT_ARTICLES += 1;
    }
}
?>
<style>
    .active-file-manager {
        background: lavender;
        border-radius: 5px;
    }
</style>
        <div class="body">
            <div class="header-label">
                <span class="logo"><img src='assets/icons/ccsit-logo.jpg'></span>
                <span class="text">College of Computer Studies and Information Technology</span>
            </div>
            <span class="recent-uploads" id='exclude-header'><i class="fa-solid fa-newspaper"></i> Files</span>
            <span class="total-articles" id='exclude-header'><i class="fa-solid fa-box-open"></i> Total: <?php echo $COUNT_ARTICLES; ?></span>
            <table>
                <tr>
                    <th width='5%'>No.</th>
                    <th width='20%'>Documet Title</th>
                    <th width='20%'>Description</th>
                    <th width='15%'>Date</th>
                    <th width='15%'>Keywords</th>
                    <th width='13%' id='exclude-header'>Action</th>
                </tr>
                <?php 
                
                $sql = "SELECT * FROM files WHERE folder_id=0 ORDER BY date DESC";
                $query = mysqli_query($db, $sql);
                $cnt = 1;
                if(mysqli_num_rows($query) > 0) {
                    while($rows = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td data-role="target" data-id="<?php echo $rows['id']; ?>" data-target="<?php echo "File: ".$rows['document_title']; ?>"><center><?php echo $cnt; ?></center></td>
                                    <td data-role="target" data-id="<?php echo $rows['id']; ?>" data-target="<?php echo "File: ".$rows['document_title']; ?>">
                                    <?php 
                                        if($rows['file_type'] == "pdf") {
                                            echo "<i class='fa-solid fa-file-pdf fa-lg'></i> ".$rows['document_title'].""; 
                                        }
                                        if($rows['file_type'] == "pptx") {
                                            echo "<i class='fa-solid fa-file-powerpoint fa-lg'></i> ".$rows['document_title'].""; 
                                        }
                                        if($rows['file_type'] == "docx") {
                                            echo "<i class='fa-solid fa-file-word fa-lg'></i> ".$rows['document_title'].""; 
                                        }
                                        if($rows['file_type'] == "xlxs") {
                                            echo "<i class='fa-solid fa-file-excel fa-lg'></i> ".$rows['document_title'].""; 
                                        }
                                    ?>
                                    </td>
                                    <td data-role="target" data-id="<?php echo $rows['id']; ?>" data-target="<?php echo "File: ".$rows['document_title']; ?>"><?php echo $rows['description']; ?></td>
                                    <td data-role="target" data-id="<?php echo $rows['id']; ?>" data-target="<?php echo "File: ".$rows['document_title']; ?>"><center><?php echo $rows['date']; ?></center></td>
                                    <td data-role="target" data-id="<?php echo $rows['id']; ?>" data-target="<?php echo "File: ".$rows['document_title']; ?>"><center><?php echo $rows['keywords']; ?></center></td>
                                    <td data-role="target" data-id="<?php echo $rows['id']; ?>" data-target="<?php echo "File: ".$rows['document_title']; ?>" id='exclude-cell'>
                                        <center>
                                        <span>
                                            <button onclick="window.open('assets/resources/<?php echo $rows['file_name']; ?>'); return true;" id='exclude-btn'><i class="fa-solid fa-eye"></i> View</button>
                                        </span>
                                        <?php if($_SESSION['AUTH_USER'] == "ADMIN") { ?>
                                        <span>
                                            <button data-role="document_id" data-id="<?php echo $rows['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                        </span>
                                        <?php } ?>
                                        </center>
                                    </td>
                                </tr>
                        <?php
                        $cnt += 1;
                    }
                }
                else {
                    ?> 
                    
                    <td colspan="6" style="text-align: center;">No Files Uploaded Yet</td>

                    <?php
                }
                
                ?>
            </table>
        </div>
    </div>

        <div class="folders">
            
            <?php

                $sql = "SELECT * FROM folders WHERE parent_id=0 ORDER BY name ASC";
                $query = mysqli_query($db, $sql);
                $cnt = 1;
                if(mysqli_num_rows(($query)) > 0) {
                    while($rows = mysqli_fetch_assoc($query)) {
                            ?>
                        <button id="disable-btn<?php echo $rows['id']; ?>" class='<?php echo $rows['id']; ?>' data-role='view' data-id='<?php echo $rows['id']; ?>' data-target="<?php echo "Folder: ".$rows['name']; ?>">
                            <span class="icon"><i class="fa-solid fa-folder-closed"></i></span>
                            <span class="text" id="existingName<?php echo $rows['id']; ?>"><?php print $rows['name']; ?></span>
                            <span><input id="renameFolder<?php echo $rows['id']; ?>"></span>
                            <span class='check-icon' id="check-icon<?php echo $rows['id']; ?>"><i class="fa-solid fa-circle-check"></i></span>
                        </button>
                                    
                <?php }
                        
                } 
                else {
                 ?> <span style="position: relative; top: 40px; left: 20px; font-size: 13px; color: gray"><i class="fa-solid fa-folder-closed"></i> No Folder Created Yet</span> <?php
                }?>

        </div>
        
    </div>
</body>

<script type="text/javascript" src="js/vue.js"></script>