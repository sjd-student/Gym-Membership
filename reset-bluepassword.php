<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then blueirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginblue.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_bluepassword = $confirm_bluepassword = "";
$new_bluepassword_err = $confirm_bluepassword_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_bluepassword"]))){
        $new_bluepassword_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_bluepassword"])) < 6){
        $new_bluepassword_err = "Password must have atleast 6 characters.";
    } else{
        $new_bluepassword = trim($_POST["new_bluepassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_bluepassword"]))){
        $confirm_bluepassword_err = "Please confirm the password.";
    } else{
        $confirm_bluepassword = trim($_POST["confirm_bluepassword"]);
        if(empty($new_bluepassword_err) && ($new_bluepassword != $confirm_bluepassword)){
            $confirm_bluepassword_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_bluepassword_err) && empty($confirm_bluepassword_err)){
        // Prepare an update statement
        $sql = "UPDATE blue SET bluepassword = ? WHERE idblue = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepablue statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_bluepassword, $param_idblue);
            
            // Set parameters
            $param_bluepassword = password_hash($new_bluepassword, PASSWORD_DEFAULT);
            $param_idblue = $_SESSION["idblue"];
            
            // Attempt to execute the prepablue statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and blueirect to login page
                session_destroy();
                header("location: loginblue.php");
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
        <link href="media/mweb.css" rel="stylesheet"/>>
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
                <input type="password" name="new_bluepassword" class="form-control" value="<?php echo $new_bluepassword; ?>">
                <span class="help-block"><?php echo $new_bluepassword_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_bluepassword_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_bluepassword" class="form-control">
                <span class="help-block"><?php echo $confirm_bluepassword_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="blueProfile.php">Cancel</a>
            </div>
        </form>
  
</body>
    <footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
</html>
