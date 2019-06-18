<?php
// Include config file
require_once 'dbconn.php';
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$name = "";
$level = 0;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($MySQL, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    //name and level
    $name = trim($_POST['name']);
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, name, level) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($MySQL, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $name, $level);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($MySQL);
}
?>


<!DOCTYPE html>
<html>
<head>
    <?php include "head.html"; $activePage = "reg";?>

    <script type="text/javascript">
        
        function validate() {
            var slanje = true;     
            
            if (document.forma.user.value.length < 5 || (! /^[a-zA-Z0-9]+$/.test(document.forma.user.value))) {
                document.forma.user.style.borderColor="red";
                document.getElementById("porukaUser").innerHTML="Username mora imati barem 5 znakova, bez nedopustenih znakova!";
                slanje = false;
            }else{
                document.forma.user.style.borderColor="grey";
                document.getElementById("porukaUser").innerHTML="";
            }

            if(document.forma.pass.value.length < 6 || (! /^[a-zA-Z0-9]+$/.test(document.forma.pass.value)) || (! /^[a-zA-Z0-9]+$/.test(document.forma.repass.value))) {
                document.forma.pass.style.borderColor="red";
                document.forma.repass.style.borderColor="red";
                document.getElementById("porukaPass").innerHTML="Password mora imati barem 6 znakova, bez nedopustenih znakova!";
                slanje=false;
            }else{
                document.forma.pass.style.borderColor="grey";
                document.getElementById("porukaPass").innerHTML="";
            }

            if (document.forma.name.value == "" || (! /^[a-zA-Z0-9]+$/.test(document.forma.name.value))) {
                document.forma.name.style.borderColor="red";
                document.getElementById("porukaName").innerHTML="Ime mora biti navedeno, bez nedopustenih znakova!";
                slanje=false;
            }else{
                document.forma.name.style.borderColor="grey";
                document.getElementById("porukaName").innerHTML="";
            }
                       
            return slanje;
        }

        var digitsOnly = /[1234567890]/g;
        var integerOnly = /[0-9\.]/g;
        var alphaOnly = /[A-Za-z]/g;
        var alphadigit = /[0-9A-Za-z_]/g;

        function restrictCharacters(myfield, e, restrictionType) {
            if (!e) var e = window.event
            if (e.keyCode) code = e.keyCode;
            else if (e.which) code = e.which;
            var character = String.fromCharCode(code);

            // if they pressed esc... remove focus from field...
            if (code==27) { this.blur(); return false; }
            
            // ignore if they are press other keys
            // strange because code: 39 is the down key AND ' key...
            // and DEL also equals .
            if (!e.ctrlKey && code!=9 && code!=8 && (code!=39 || (code==39 && character=="'"))) {
                if (character.match(restrictionType)) {
                    return true;
                } else {
                    return false;
                }
                
            }
        }


        var check = function(){
            if (document.forma.pass.value == document.forma.repass.value) {
                document.getElementById('reglogbutton').disabled = false;
                document.getElementById('porukaPassRe').style.color = 'green';
                document.getElementById('porukaPassRe').innerHTML = 'Passwords matching!';
                document.forma.pass.style.borderColor="initial";
                document.forma.repass.style.borderColor="initial";
            } else {
                document.getElementById('reglogbutton').disabled = true;
                document.getElementById('porukaPassRe').style.color = 'red';
                document.getElementById('porukaPassRe').innerHTML = 'Passwords not matching!';
                document.forma.pass.style.borderColor="red";
                document.forma.repass.style.borderColor="red";
            }
        }

        function resetForm(){
            document.getElementById("porukaUser").innerHTML="";
            document.getElementById("porukaPass").innerHTML="";
            document.getElementById("porukaPassRe").innerHTML="";
            document.getElementById("porukaName").innerHTML="";

            document.forma.username.style.borderColor="initial";
            document.forma.password.style.borderColor="initial";
            document.forma.confirm_password.style.borderColor="initial";
            document.forma.name.style.borderColor="initial";
        }


    </script>
</head>
<body>
    <?php include "header.html"; ?>

    <?php include "navigation.php"; ?>

    <article class="wrapper">
        <h2>Registracija</h2>
        <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="reglog" name="forma" id="formaUnos" method="POST" onsubmit="return validate();" onreset="return resetForm();">
        
            <div id="form_element" class="<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input name="username" value="<?php echo $username; ?>" type="text" placeholder="Username:" id="user" onkeypress="return restrictCharacters(this, event, alphadigit);">
                <span class="formaValidateRegLog" id="porukaUser"><?php echo $username_err; ?></span>
            </div>

            <div id="form_element" class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input name="password" value="<?php echo $password; ?>" type="password" placeholder="Password:" id="pass" onkeypress="return restrictCharacters(this, event, alphadigit);" onkeyup='check();'>
                <span class="formaValidateRegLog" id="porukaPass"><?php echo $password_err; ?></span>
            </div>

            <div id="form_element" class="<?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input name="confirm_password" value="<?php echo $confirm_password; ?>" type="password" placeholder="Repeat password:" id="repass" onkeypress="return restrictCharacters(this, event, alphadigit);" onkeyup='check();'>
                <span class="formaValidateRegLog" id="porukaPassRe"><?php echo $confirm_password_err; ?></span>
            </div>

            <div id="form_element">
                <input name="name" value="<?php echo $name; ?>" type="text" placeholder="Name:" id="name" onkeypress="return restrictCharacters(this, event, alphaOnly);">
                <span class="formaValidateRegLog" id="porukaName"></span>
            </div>

            <div id="form_element">
                <input name="submit" type="submit" value="Register!" id="reglogbutton" disabled>
                <input name="reset" type="reset" value="Reset!" id="reglogbutton">
            </div>


        </form>

    </article>

    <?php include "footer.html"; ?>  

</body>
</html>