<?php
include './db_con.php';
 
    session_name("Social");
    session_start();            
    session_regenerate_id();  
    

    
$error_msg = "";

    if (isset($_POST['email'],$_POST["hashpass"])) {
    
    
        // clean user input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); 
        $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
        $interests = filter_input(INPUT_POST, 'interests', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'hashpass', FILTER_SANITIZE_STRING);

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
    
    
        $prep_stmt = "SELECT id FROM user WHERE email = ? LIMIT 1";
        $stmt = $mysqli->prepare($prep_stmt);

       
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $error_msg .= 'A user with this email address already exists.';
                $stmt->close();
            }
        } else {
            $error_msg .= '<p class="error">Database error</p>';
            $stmt->close();
        }
        if (empty($error_msg)) {

            $insert_stmt = $mysqli->prepare("INSERT INTO user (email, name, surname, password, dob,image, interests) VALUES (?, ?, ?, ?, ?, ?, ?)");     
            $password = password_hash($password, PASSWORD_BCRYPT);
            if ($nofile) {
                $newfile = "Pimages/default.png";
            }elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $newfile)) { 
           $error_msg = "Sorry, there was an error uploading your file.";
           } 
           if ($insert_stmt) {
           $insert_stmt->bind_param('sssssss', $email,$name,$surname,$password,$dob,$newfile,$interests);

           if (! $insert_stmt->execute()) {
                $error_msg .= $insert_stmt->error.'Database insert error';
               } else {
                   $user_browser = $_SERVER['HTTP_USER_AGENT'];
                       // XSS protection as we might print this value
                       $user_id = preg_replace("/[^0-9]+/", "", $mysqli->insert_id);
                       $_SESSION['user_id'] = $user_id;
                       // XSS protection as we might print this value
                       $name = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $name);

                       $_SESSION['name'] = $name;
                       $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                       
                       echo 'YES';
               }  
        }

       }
    
    }else{
 
    }
    
    echo $error_msg;




