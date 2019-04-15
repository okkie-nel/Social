<?php
include './db_con.php';

session_name("Social");
session_start();            
session_regenerate_id();  

$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
        
    if ($pass) {
    
        $old_password = filter_input(INPUT_POST, 'old_hashpass', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'hashpass', FILTER_SANITIZE_STRING);
        
        if ($stmt = $mysqli->prepare("SELECT password FROM user WHERE id = ?")) {
            $stmt->bind_param('i', $_SESSION['user_id']);  
            $stmt->execute();    
            $stmt->store_result();
            $stmt->bind_result($db_password);
            $stmt->fetch();
         
            if (password_verify($old_password, $db_password)) {

                $password = password_hash($password, PASSWORD_BCRYPT);
           
                $update_stmt = $mysqli->prepare("UPDATE user SET password = ? WHERE id = ?");  
                if ($update_stmt) {
                    $update_stmt->bind_param('si', $password,$_SESSION['user_id']);
        
                if (! $update_stmt->execute()) {
                    $error_msg .= $update_stmt->error.'Database insert error';
                } else {
                    echo 'YES';
                }  
            
                }
            } else {
            echo 'Password Incorrect';    
            }
            
        }else{
            echo 'Old Password Incorrect';
        }
    } else {
    
        // clean user input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); 
        $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
        $interests = filter_input(INPUT_POST, 'interests', FILTER_SANITIZE_STRING);
        $oldimg = filter_input(INPUT_POST, 'oldimg', FILTER_SANITIZE_STRING);

        $rand = time() . rand(10*45, 100*98);

        $target_dir = "Pimages/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $newfile = $target_dir.$rand.".".$imageFileType;
    
    
        if (is_uploaded_file($_FILES["image"]['tmp_name'])) {

            $nofile = false;
            $check = getimagesize($_FILES["image"]["tmp_name"]);

            if($check == false) {
                $error_msg = "File Uploaded Not an Image";
            }elseif ($_FILES["image"]["size"] > 500000) {
                $error_msg = "Sorry, your file is too large.";
            }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $error_msg =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

        }else{
            $nofile = true;
        }
    
        if (empty($error_msg)) {
     
            $update_stmt = $mysqli->prepare("UPDATE user SET email = ?, name = ?, surname = ?, dob = ?, image = ?, interests = ? WHERE id = ?");     

            if ($nofile) {
               $newfile = $oldimg;

            }elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $newfile)) { 
           $error_msg = "Sorry, there was an error uploading your file.";
           } 
           if ($update_stmt) {
           $update_stmt->bind_param('ssssssi', $email,$name,$surname,$dob,$newfile,$interests,$_SESSION['user_id']);

           if (! $update_stmt->execute()) {
                $error_msg .= $update_stmt->error.'Database insert error';
               } else {
                       echo 'YES';
               }

           }else{
            echo '';
           }
    
        }
    }
    
