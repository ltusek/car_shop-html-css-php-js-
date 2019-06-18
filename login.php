<?php
// Include config file
require_once 'dbconn.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password, level FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($MySQL, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password, $level);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['level'] = $level;
                            $_SESSION['last_time'] = time();
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <?php include "head.html"; $activePage = "log";?>

    <script type="text/javascript">

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

        function validate() {
            var slanje = true;     
            
            if ((! /^[a-zA-Z0-9]+$/.test(document.forma.user.value))) {
                document.forma.user.style.borderColor="red";
                document.getElementById("porukaUser").innerHTML="Prazno, ili nedopusteni znakovi!";
                slanje = false;
            }else{
                document.forma.user.style.borderColor="initial";
                document.getElementById("porukaUser").innerHTML="";
            }

            if((! /^[a-zA-Z0-9]+$/.test(document.forma.pass.value))) {
                document.forma.pass.style.borderColor="red";
                document.getElementById("porukaPass").innerHTML="Prazno, ili nedopusteni znakovi!";
                slanje=false;
            }else{
                document.forma.pass.style.borderColor="initial";
                document.getElementById("porukaPass").innerHTML="";
            }
                       
            return slanje;
        }

        function resetForm(){
            document.getElementById("porukaUser").innerHTML="";
            document.getElementById("porukaPass").innerHTML="";

            document.forma.username.style.borderColor="initial";
            document.forma.password.style.borderColor="initial";
        }

    </script>
</head>
<body>
    <?php include "header.html"; ?>

    <?php include "navigation.php"; ?>

    <article class="wrapper">
        <h2>Login</h2>
        <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="reglog" name="forma" id="formaUnos" method="POST" onsubmit="return validate();" onreset="return resetForm();">
        
            <div id="form_element" class="<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input name="username" value="<?php echo $username; ?>" type="text" placeholder="Username:" id="user" onkeypress="return restrictCharacters(this, event, alphadigit);">
                <span class="formaValidateRegLog" id="porukaUser"><?php echo $username_err; ?></span>
            </div>

            <div id="form_element" class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input name="password" type="password" placeholder="Password:" id="pass" onkeypress="return restrictCharacters(this, event, alphadigit);">
                <span class="formaValidateRegLog" id="porukaPass"><?php echo $password_err; ?></span>
            </div>

            <div id="form_element">
                <input name="submit" type="submit" value="Login!" id="reglogbutton">
                <input name="reset" type="reset" value="Reset!" id="reglogbutton">
            </div>


        </form>

    </article>

    <?php include "footer.html"; ?>  

</body>
</html>