<!DOCTYPE html>

<html>
    <head>
       <meta charset="UTF-8">
        
        <title>Social Registration</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    </head>
    <body class="formbody">
        <form id="regupdateform" class="form regupdateform" name="form" enctype="multipart/form-data" action="etc/register.php" method="POST" >
            <div id="regformlogocon">
                <img id="regformlogo"src="img/logo.png" alt=""/>
            </div>
            <div class="rediv">
            <input required type="text" placeholder="Name" id="name" name="name"/>
            <input required type="text" placeholder="Surname" id="surname" name="surname"/>
            <input required type="email" placeholder="Email" id="email" name="email"/>
            </div>
              <div class="rediv">
            <input required title="Please ensure your password has a uppercase,  a lowercase a special and a number character" pattern="^(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^\w\d]).*$" type="password" placeholder="Password" id="password" name="password"/>   
            <input type="password" placeholder="Confirm Password"  id="confpassword" name="confpassword"/>
            </div>
             <div class="rediv">
            <label for="dob">Date of Birth</label>
            <input type="date"  id="dob" name="dob">
            <label for="interests">Interests</label>
            <textarea rows="4" cols="50" placeholder="" id="interests" name="interests">  </textarea>
           
            </div>
             <div class="rediv">
                  <label for="image">Profile Image</label>
            <input type="file" name="image" id="image">
            <span class="calltaspan">Already Registered? <a href="index.php">Sign In Now!</a> </span>
            <input class="formbutton" name="submit" type="submit" value="Register" onclick="passwhash(this.form, this.form.password,this.form.confpassword);">
             </div>
           
        </form>
        <script src="js/sha512.js" type="text/javascript"></script>
        <script src="js/signup.js" type="text/javascript"></script>
        <script src="js/passwordconfirm.js" type="text/javascript"></script>

    </body>
</html>