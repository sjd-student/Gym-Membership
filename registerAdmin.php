<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$adminusername = $adminpassword = $confirm_adminpassword = "";
$adminusername_err = $adminpassword_err = $confirm_adminpassword_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["adminusername"]))){
        $adminusername_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT idadmin FROM admin WHERE adminusername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_adminusername);
            
            // Set parameters
            $param_adminusername = trim($_POST["adminusername"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $adminusername_err = "This username is already taken.";
                } else{
                    $adminusername = trim($_POST["adminusername"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["adminpassword"]))){
        $adminpassword_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["adminpassword"])) < 6){
        $adminpassword_err = "Password must have atleast 6 characters.";
    } else{
        $adminpassword = trim($_POST["adminpassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_adminpassword"]))){
        $confirm_adminpassword_err = "Please confirm password.";     
    } else{
        $confirm_adminpassword = trim($_POST["confirm_adminpassword"]);
        if(empty($adminpassword_err) && ($adminpassword != $confirm_adminpassword)){
            $confirm_adminpassword_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($adminusername_err) && empty($adminpassword_err) && empty($confirm_adminpassword_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO admin (adminusername, adminpassword) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_adminusername, $param_adminpassword);
            
            // Set parameters
            $param_adminusername = $adminusername;
            $param_adminpassword = password_hash($adminpassword, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: loginAdmin.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Sign up</title>
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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($adminusername_err)) ? 'has-error' : ''; ?>">
                <div class="form-row">
                <div class="form-group col-md-2">
                <label>Username</label>
                <input type="text" name="adminusername" class="form-control" value="<?php echo $adminusername; ?>">
                <span class="help-block"><?php echo $adminusername_err; ?></span>
            </div>
        </div>
            <div class="form-group <?php echo (!empty($adminpassword_err)) ? 'has-error' : ''; ?>">
                <div class="form-row">
                <div class="form-group col-md-2">
                <label>Password</label>
                <input type="password" name="adminpassword" class="form-control" value="<?php echo $adminpassword; ?>">
                <span class="help-block"><?php echo $adminpassword_err; ?></span>
            </div>
        </div>
            <div class="form-group <?php echo (!empty($confirm_adminpassword_err)) ? 'has-error' : ''; ?>">
                <div class="form-row">
                <div class="form-group col-md-2">
                <label>Confirm Password</label>
                <input type="password" name="confirm_adminpassword" class="form-control" value="<?php echo $confirm_adminpassword; ?>">
                <span class="help-block"><?php echo $confirm_adminpassword_err; ?></span>
            </div>
        </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-info" value="Reset">
            </div>
            <a href="adminProfile.php" class="btn btn-secondary">Cancel</a>
        </form>
 
</body>
<footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
</footer>
</html>