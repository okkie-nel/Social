<?php
include './db_con.php';

    session_name("Social");
    session_start();            
    session_regenerate_id();     

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'hashpass', FILTER_SANITIZE_STRING); 

if (isset($_POST['remember'])) {
    setcookie("loginmail", $email,   time() + (10 * 365 * 24 * 60 * 60), '/');
}

 


 if ($stmt = $mysqli->prepare("SELECT id, name, password FROM user WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);  
        $stmt->execute();    
        $stmt->store_result();
        
        $stmt->bind_result($user_id, $username, $db_password);
        $stmt->fetch();
        
         if ($stmt->num_rows == 1) {
             
             if (password_verify($password, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    
                    $_SESSION['name'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
                    // Login successful.
                    echo 'YES';
                } else {
                    // Password is not correct
                    echo 'Username or password incorrect';
                }
             
         } else {
          echo 'Username or password incorrect';    
         }

}
        