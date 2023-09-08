$(document).ready(function() {
    $("#upload-pop-up").click(function() {
        $(".upload-pop-up").show(200);
    });
    $("#close-upload-pop-up").click(function() {
        $(".upload-pop-up").hide(200);
        $('.statusMsg').hide(100);
    });
});

$(document).ready(function() {
    $("#new-folder").click(function() {
        $(".new-folder").show(200);
    });
    $(".cancel-btn").click(function() {
        $(".new-folder").hide(200);
        $('.statusMsg').hide(100);
        $(document).on('click', '#folder-name', function(){ $('.statusMsg').hide(100); });
    });
});

$(document).ready(function() {
    $(".create-folder").click(function(){
        var folder_name = $('#folder-name').val();
        var parent_id = $('#folder-id').val();
        $(document).on('click', '#folder-name', function(){ $('.statusMsg').hide(100); });
        if(folder_name == "") {
            $('.statusMsg').show(100);
            $('.statusMsg').html('<p style="color: gray; font-size: 13px;">Folder Name Cannot be Empty!</p>'); 
        }
        else {
            $.ajax({
                url: "server.php",
                method: "POST",
                data: { folder_name:folder_name, parent_id:parent_id },
                dataType: "text",
                success: function()
                {
                    $('.statusMsg').show(100);
                    $('.statusMsg').html('<p style="color: gray; font-size: 13px;">Folder Created Successfully!</p>');
                }
            })
        }
    });
});

$(document).ready(function() {
    $(document).on('click', 'button[data-role=view]', function(){
        var folder_id = $(this).data('id');
        $.ajax({
            url: "server.php",
            method: "POST",
            data: { folder_id:folder_id },
            dataType: "text",
            success: function() { window.location.href ="view-folder?page=directory=" + folder_id; }
        })
    });
});

$(document).ready(function(e){
    // Submit form data via Ajax
    $("#fupForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'text',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#fupForm').css("opacity",".5");
            },
            success: function(){
                $('#fupForm')[0].reset();
                $('.statusMsg').show(200);
                $('.statusMsg').html('<p style="color: gray; font-size: 13px;">File Uploaded Successfully!</p>');
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    });
});

// File type validation
$("#file").change(function() {
    var file = this.files[0];
    var fileType = file.type;
    var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
    if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
        alert('Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.');
        $("#file").val('');
        return false;
    }
});

$(document).ready(function(){
    $("#user_search").keyup(function() {
        var user_search = $('#user_search').val();
        var filter_option = $('#filter_option').val();
        $.ajax({
            url: "server.php",
            method: "POST",
            data: { 
                user_search:user_search,
                filter_option:filter_option
            },
            dataType: "text",
            success: function(data)
            {
                $(".body").html(data);
                $(".view-document").html(data);
                $(".update-document").html(data);
            }
        })
    });
});

$(document).ready(function() {
    $(".login-box").click(function() {
        var panel = document.getElementById("log-in");
        if (panel.style.display == "block") { $(".log-in").fadeOut(150); } 
        else { $(".log-in").fadeIn(150); }
    });
});

$(document).ready(function(e){
    // Submit form data via Ajax
    $("#logAUTH").on('submit', function(e){
        var username = $("#username").val();
        var password = $("#password").val();
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: {
                username:username,
                password:password
            },
            success: function(response){
                $('.responseError').html(response);
            }
        });
    });
});

$(document).ready(function(){
    // Submit form data via Ajax
    $(".log-out").click(function() {
        var destroy_session = 0;
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: { destroy_session:destroy_session },
            success: function() { window.location.href ="login"; }
        });
    });
});

$(document).ready(function(e){
    // Submit form data via Ajax
    $("#updateForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: new FormData(this),
            dataType: 'text',
            contentType: false,
            cache: false,
            processData:false,
            success: function(){
                $('.responseMsg').show(200);
            }
        });
    });
});

$(document).ready(function() {
    $(document).on('click', 'button[data-role=document_id]', function(){
        var document_id = $(this).data('id');
        $.ajax({
            url: "server.php",
            method: "POST",
            data: { document_id:document_id },
            dataType: "text",
            success: function() { window.location.href ="update-document?id=" + document_id; }
        })
    });
});

$(document).ready(function(e) {
    $('tr td').bind('contextmenu', 'button[data-role=target]', function(e){
        var id = $(this).data('id');
        var document = $(this).data('target');
        $(".menu-id").val(id);
        $(".download").val(id);
        $(".title-document").text(document);
        if(id != null) {
            $(".context-menu").show(200);
            return false;
        }
        else { return true; }
    });
    $(".download-btn").click(function() {
        var download_id = $(".download").val();
        $.ajax({
            url: "dl-config.php",
            method: "POST",
            data: { download_id:download_id },
            dataType: "text",
            success: function(data)
            {
                window.open("assets/resources/" + data); return true;
            }
        })
    })
});

$(document).ready(function(e) {
    $('button[data-role=view]').bind('contextmenu', 'button[data-role=view]', function(e){
        var id = $(this).data('id');

        var folder = $(this).data('target');
        $(".folder-id").val(id);
        $(".rename-id").val(id);
        $(".folder-name").text(folder);
        $(".context-menu-folder").show(200);

        return false;

    });
});

$(document).ready(function(){
    // Submit form data via Ajax
    $("#rename-btn").click(function() {
       var rename_folder = $(".rename-id").val();

       $.ajax({
        url: "rename.php",
        method: "POST",
        data: { rename_folder:rename_folder },
        dataType: "text",
        success: function(data)
        {
            $("#existingName" + rename_folder).hide(200);
            $("#renameFolder" + rename_folder).show(200);
            $("#renameFolder" + rename_folder).val(data);
            $("#check-icon" + rename_folder).show(200);
            $('#disable-btn' + rename_folder).attr("disabled","disabled");
        }
    })

    $("#check-icon" + rename_folder).click(function() {
        var rename_folder = $(".rename-id").val();
        var new_folder_name = $("#renameFolder" + rename_folder).val();
        $.ajax({
            url: "rename.php",
            method: "POST",
            data: { 
                new_folder_name:new_folder_name,
                rename_folder:rename_folder 
            },
            dataType: "text",
            success: function()
            {
                location.reload();
            }
        })

    });

    });
});

$(document).ready(function(){
    // Submit form data via Ajax
    
});

$(document).ready(function(){
    // Submit form data via Ajax
    $(".container").click(function() {
        $(".context-menu").hide(200);
        $(".context-menu-folder").hide(200);
    });
});

function printPageArea(areaID)
{
    var printContent = document.getElementById(areaID).innerHTML;
    var originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
}