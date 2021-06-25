<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginRed.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_redpassword = $confirm_redpassword = "";
$new_redpassword_err = $confirm_redpassword_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_redpassword"]))){
        $new_redpassword_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_redpassword"])) < 6){
        $new_redpassword_err = "Password must have atleast 6 characters.";
    } else{
        $new_redpassword = trim($_POST["new_redpassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_redpassword"]))){
        $confirm_redpassword_err = "Please confirm the password.";
    } else{
        $confirm_redpassword = trim($_POST["confirm_redpassword"]);
        if(empty($new_redpassword_err) && ($new_redpassword != $confirm_redpassword)){
            $confirm_redpassword_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_redpassword_err) && empty($confirm_redpassword_err)){
        // Prepare an update statement
        $sql = "UPDATE red SET redpassword = ? WHERE idred = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_redpassword, $param_idred);
            
            // Set parameters
            $param_redpassword = password_hash($new_redpassword, PASSWORD_DEFAULT);
            $param_idred = $_SESSION["idred"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: loginRed.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
      <link rel="icon" href="media/favicon.ico" type="image/png">
 <link href="media/bootstrap.css" rel="stylesheet"/>
        <link href="media/all.css" rel="stylesheet"/>
        <link href="media/mweb.css" rel="stylesheet"/>
</head>
<body>
    <navbar class="navbar navbar-light bg-light">
                <img src="media/icon.png" width="150" height="75" >
                <span class="navbar navbar-brand header-logo">Macho Gym</span>
            </navbar>
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-inline"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_redpassword" class="form-control mb-2 mr-sm-2" value="<?php echo $new_redpassword; ?>">
                <span class="help-block"><?php echo $new_redpassword_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_redpassword_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_redpassword" class="form-control mb-2 mr-sm-2">
                <span class="help-block"><?php echo $confirm_redpassword_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="redProfile.php">Cancel</a>
            </div>
        </form>
</body>
    <footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
</html>
