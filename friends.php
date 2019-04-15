<?php

include './etc/db_con.php';
include './etc/getfriends.php';
session_name("Social");
session_start();            
session_regenerate_id();

    
if (isset($_SESSION['user_id'], $_SESSION['name'], $_SESSION['login_string'])) {
    $id = $_SESSION['user_id'];
    $friends= new Friends($id);
    $friendlist = $friends->ProcessFriends();
    $reqeustlist =  $friends->ProcessReqeusts();
    $notfriendlist = $friends->ProcessNotfriends();
} else {
    header('Location: index.php');
}   

$pg= "friends";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Social Friends</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    </head>
    <?php include './header.php';?>
    <body style="background-color: #1a6d9a;">
        <div class="main">
            <div id="friendspage" class="pagecontainer">
                <div id="friendscon">
                    <h2>Friends</h2>
                    <div id="friendlist">
                      <?=$friendlist?>
                    </div>
                    <button class="reqbuttacc addfriendbutt butt">Add Friend</button>
                </div>
                <div id="reqeustcon">
                    <h2>Requests</h2>
                    <div id="reqlist">
                   <?=$reqeustlist?>
                    </div>
                </div>
            </div>
            <div style="display: none;" id="addfriends" class="pagecontainer">
                <h2>Add Friends</h2>
            <button style="width: 5%;padding: .5%;float: right;" class="reqbuttdecl addfriendbutt butt">Close</button>
                <div id="notlist">
                <?=$notfriendlist?>
                </div>
            </div>
        </div>
        <script>
             function toggleaddfriend() {
            $('#friendspage').toggle();
                $('#addfriends').toggle();
                }
            
            $('.addfriendbutt').click(function(e) {
                 e.preventDefault();
                toggleaddfriend();
            });
          
        $(".main").on('click','.reqbutt',function(e) {
            var type = $(this).data("accdec");
            e.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "etc/friendaccdec.php",
                    data: {
                        id: <?=$id?>,
                        fid: $(this).val(),
                        accdecl: type
                    },
                    success: function(data) {
                       $('#reqlist').html(data.reqeustlist);
                       $('#friendlist').html(data.friendlist);
                       $('#notlist').html(data.notfriendlist);
                    },
                    error: function(data) {
                        alert('error');
                    }
                });
        });
        </script>
    </body>
   
</html>
