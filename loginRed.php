<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: redProfile.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$redusername = $redpassword = "";
$redusername_err = $redpassword_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["redusername"]))){
        $redusername_err = "Please enter username.";
    } else{
        $redusername = trim($_POST["redusername"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["redpassword"]))){
        $redpassword_err = "Please enter your password.";
    } else{
        $redpassword = trim($_POST["redpassword"]);
    }
    
    // Validate credentials
    if(empty($redusername_err) && empty($redpassword_err)){
        // Prepare a select statement
        $sql = "SELECT idred, redusername, redpassword FROM red WHERE redusername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_redusername);
            
            // Set parameters
            $param_redusername = $redusername;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $idred, $redusername, $hashed_redpassword);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($redpassword, $hashed_redpassword)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["idred"] = $idred;
                            $_SESSION["redusername"] = $redusername;                            
                            
                            // Redirect user to welcome page
                            header("location: redProfile.php");
                        } else{
                            // Display an error message if password is not valid
                            $redpassword_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $redusername_err = "No account found with that username.";
                }
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
    <title>Login</title>
    <link rel="icon" href="media/favicon.ico" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="media/bootstrap.css" rel="stylesheet"/>
        <link href="media/all.css" rel="stylesheet"/>
        <link href="media/mweb.css" rel="stylesheet"/>
    </head>
<body>
    <navbar class="navbar navbar-light bg-light">
                <img src="media/icon.png" width="150" height="75" >
                <span class="navbar navbar-brand header-logo">Macho Gym</span>
            </navbar>
    <div >  
            <nav class="navbar navbar-light bg-dark header-fade">
                <ul class="nav"> 
                    <li class ="nav-item"><a class="nav-link text-white font-weight-bold" href="homePage.html" > Home</a></li>

                    <li class ="nav-item"><a class="nav-link text-white font-weight-bold" href="aboutPage.html"> About </a></li>
                </ul>
            </nav>
        </div>            
    <div>
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-inline">
            <div class="form-group <?php echo (!empty($redusername_err)) ? 'has-error' : ''; ?>">
                <label class="sr-only">Username</label>
                <input type="text" name="redusername" class="form-control mb-2 mr-sm-2" value="<?php echo $redusername; ?>">
                <span class="help-block"><?php echo $redusername_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($redpassword_err)) ? 'has-error' : ''; ?>">
                <label class="sr-only">Password</label>
                <input type="password" name="redpassword" class="form-control mb-2 mr-sm-2">
                <span class="help-block"><?php echo $redpassword_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary mb-2"value="Login">
            </div>
            <p>Don't have an account? <a href="registerRed.php" class="btn btn-outline-info">Sign up now.</a></p>
        </form>
    </div>    
</body>
    <footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
</html>
