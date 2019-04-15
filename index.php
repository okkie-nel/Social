<!DOCTYPE html>
<?php
session_name("Social");
    session_start();            
    session_regenerate_id();  
if (isset($_SESSION['user_id'], 
                        $_SESSION['name'], 
                        $_SESSION['login_string'])) {
                        header('Location: profile.php');
                        }
if(!isset($_COOKIE["loginmail"])) {
    $email = "";
} else {
    $email = $_COOKIE["loginmail"];
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Social Login</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    </head>
    <body class="formbody">
        <form autocomplete="off" name="form" class="form" id="loginform" action="etc/login.php">
            <img class="formlogo"src="img/logo.png" alt=""/>
            <input autocomplete="off" type="text" placeholder="Email" id="email" name="email" value="<?php echo $email;?>"/>
            <input type="password" placeholder="Password" id="password" name="password"/>
            <div class="error" style="display:none;"></div>
            <span class="calltaspan">Not Registered? <a href="signup.php">Sign Up Now!</a> </span>
            <input class="formbutton" type="submit" value="Login" onclick="passwhash(this.form, this.form.password,this.form.confpassword);">
            <span class="calltaspan"><input style="width: 10%;" type="checkbox" id="remember" name="remember"/>Remember Me</span>
        </form>
        <script src="js/signup.js" type="text/javascript"></script>
        <script src="js/sha512.js" type="text/javascript"></script>
        
    </body>   
</html>
