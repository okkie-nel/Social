<!DOCTYPE html>
<?php
include './etc/db_con.php';
session_name("Social");
    session_start();            
    session_regenerate_id();  
     if (isset($_SESSION['user_id'], 
                        $_SESSION['name'], 
                        $_SESSION['login_string'])) {
$id = $_SESSION['user_id'];

if ($stmt = $mysqli->prepare("SELECT email , name, surname,dob,image,interests 
        FROM user
       WHERE id = ?
        LIMIT 1")) {
        $stmt->bind_param('i', $id);  
        $stmt->execute();    
        $stmt->store_result();
        
        $stmt->bind_result($email, $name, $surname, $dob1,$image,$interests);
        $stmt->fetch();
        
        
        if ($dob1 != "0000-00-00") {
            $dob1 = date("Y-m-d", strtotime($dob1));
            $dob = "Birthday: ".date("d M Y", strtotime($dob1));
        } else {
            $dob1= '';
            $dob = '';
        }
        if ($interests != "") {
            $interests1 = $interests;
            $interests = "Interests: </br>".$interests;
        }

        }
                        } else {
                      header('Location: index.php');      
}
$pg= "profile";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Social Profile</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    </head>
    <?php include './header.php';?>
    <body style="background-color: #1a6d9a;">
        <div  class="main">
            <div id="profile" class="pagecontainer">
                
                <div id="pimage" style="background-image: url('etc/<?=$image?>');"></div>
            <h2><?=$name." ".$surname ?></h2>
            <p id="pemail"><?=$email?></p>
            <p> <?=$dob?></p>
            <p><?=$interests?></p>
            <a class="editbutt editprofile">Edit Profile</a><br>
            <a class="editbutt editpassword">Change Password</a>
        </div>
            
            <form id="profileupdateform" style="display: none;" class="regupdateform form" name="form" enctype="multipart/form-data" action="etc/updtprofile.php" method="POST" >
            <button style="width: 5%;padding: .5%;float: right;" class="reqbuttdecl editprofile butt">X</button>
                <h2>Update Profile</h2>
                <div style="display: none;" class="updated">Updated!</div>
                
                <input  name="pass" id="pass" hidden value="0">
            <div class="rediv">
                <input required type="text" placeholder="Name" value="<?=$name?>" id="name" name="name"/>
            <input required type="text" placeholder="Surname" value="<?=$surname?>" id="surname" name="surname"/>
            <input style="color: #595959;border: 2px solid #595959;" readonly="readonly" required type="email" placeholder="Email" value="<?=$email?>" id="email" name="email"/>
            </div>
             <div class="rediv">
            <label for="dob">Date of Birth</label>
            <input type="date" value="<?=$dob1?>"  id="dob" name="dob">
            <label for="interests">Interests</label>
            <textarea value="" rows="4" cols="50" placeholder="" id="interests" name="interests"><?=$interests1?></textarea>
           
            </div>
             <div class="rediv">
                 <input hidden id="oldimg" name="oldimg" value="<?=$image?>">
                  <label for="image">Profile Image</label>
                  <div id="pimage" style="background-image: url('etc/<?=$image?>'); height: 8vh!important;"></div>
            <input type="file" name="image" id="image">
            <div class="error" style="display:none;"></div>
            <input class="formbutton" name="submit" type="submit" value="Update">
             </div>
        </form>
 
            <form id="passwordupdateform" style="display: none;"  class="regupdateform form" name="form" enctype="multipart/form-data" action="etc/updtprofile.php" method="POST" >
               <button style="width: 5%;padding: .5%;float: right;" class="reqbuttdecl editpassword butt">X</button>
                <h2>Update Password</h2>
                <div style="display: none;" class="updated">Updated!</div>
                
            <input  name="pass" id="pass" hidden value="1">
            <div class="rediv">
            <input required type="password" placeholder="Old Password" id="old_password" name="old_password"/>   
            <input required title="Please ensure your password has a uppercase,  a lowercase a special and a number character" pattern="^(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^\w\d]).*$" type="password" placeholder="New Password" id="password" name="password"/>   
            <input type="password" placeholder="Confirm Password"  id="confpassword" name="confpassword"/>
            </div>
            <div class="error" style="display:none;"></div>
            <input class="formbutton" name="submit" type="submit" value="Update" onclick="passwhash(this.form, this.form.password,this.form.old_password);">
        </form>   
        </div>
        <script>
            $('.editprofile').click( function(e) {e.preventDefault(); toggleUpdate();return false; } );
             $('.editpassword').click( function(e) {e.preventDefault(); toggleUpdatePass();return false; } );
          function toggleUpdate() {
            $('#profile').toggle();
            $('#profileupdateform').toggle();
                }
                function toggleUpdatePass() {
            $('#profile').toggle();
            $('#passwordupdateform').toggle();
                }
                
                
        </script>
        <script src="js/sha512.js" type="text/javascript"></script>
        <script src="js/update.js" type="text/javascript"></script>
        <script src="js/passwordconfirm.js" type="text/javascript"></script>
    </body>
   
</html>
