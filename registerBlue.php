<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$blueusername = $bluepassword = $confirm_bluepassword = $bluefname = $bluelname = $bluesex = $blueemail = $blueheight = $blueweight = "";

$blueusername_err = $bluepassword_err = $confirm_bluepassword_err = $bluefname_err = $bluelname_err = $bluesex_err = $blueemail_err = $blueheight_err = $blueweight_err = "";
 
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["blueusername"]))){
        $blueusername_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT idblue FROM blue WHERE blueusername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepablue statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_blueusername);
            
            // Set parameters
            $param_blueusername = trim($_POST["blueusername"]);
            
            // Attempt to execute the prepablue statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $blueusername_err = "This username is already taken.";
                } else{
                    $blueusername = trim($_POST["blueusername"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    
    // Validate password
    if(empty(trim($_POST["bluepassword"]))){
        $bluepassword_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["bluepassword"])) < 6){
        $bluepassword_err = "Password must have atleast 6 characters.";
    } else{
        $bluepassword = trim($_POST["bluepassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_bluepassword"]))){
        $confirm_bluepassword_err = "Please confirm password.";     
    } else{
        $confirm_bluepassword = trim($_POST["confirm_bluepassword"]);
        if(empty($bluepassword_err) && ($bluepassword != $confirm_bluepassword)){
            $confirm_bluepassword_err = "Password did not match.";
        }
    }

     if (empty($_POST["bluefname"])){
    $bluefname_err = "First Name is required.";
    }else {
    $bluefname = test_input($_POST["bluefname"]); // check name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$bluefname)){
    $bluefname_err = "Only letters and white space allowed!";
    }
    }

     if (empty($_POST["bluelname"])){
    $bluelname_err = "Last Name is required.";
    }else {
    $bluelname = test_input($_POST["bluelname"]); // check name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$bluelname)){
    $bluelname_err = "Only letters and white space allowed!";
    }
    }

    if (empty($_POST["bluesex"])) {
    $bluesex_err = "Sex is required.";
    } else {$bluesex = test_input($_POST["bluesex"]);
    }

    if (empty($_POST["blueemail"])) {
    $blueemail_err = "Email is required.";
    } else {
    $blueemail = test_input($_POST["blueemail"]);
    // check if e-mail address syntax is valid or not
    if (!filter_var($blueemail, FILTER_VALIDATE_EMAIL)) {
    $blueemail_err  = "Invalid email format!";
    }
    }

    if (empty($_POST["blueheight"])) {
    $blueheight_err = "Height is required.";
    } else{
    $blueheight = test_input($_POST["blueheight"]);   
    if (!is_numeric($blueheight)){
    $blueheight_err = "Input numbers only!";
    } 
    }

    if (empty($_POST["blueweight"])) {
    $blueweight_err = "Weight is required.";
    } else{
    $blueweight = test_input($_POST["blueweight"]);   
    if (!is_numeric($blueweight)){
    $blueweight_err = "Input numbers only!";
    } 
    }
    
    // Check input errors before inserting in database
    if(empty($blueusername_err) && empty($bluefname_err) && empty($bluelname_err) && empty($bluesex_err) && empty($blueemail_err) && empty($blueheight_err) && empty($blueweight_err) && empty($bluepassword_err) && empty($confirm_bluepassword_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO blue (blueusername, bluepassword, bluefname, bluelname, bluesex, blueemail, blueheight, blueweight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_blueusername, $param_bluepassword, $param_bluefname, $param_bluelname, $param_bluesex, $param_blueemail, $param_blueheight, $param_blueweight);
            
            // Set parameters
            $param_blueusername = $blueusername;
            $param_bluefname = $bluefname;
            $param_bluelname = $bluelname;
            $param_bluesex = $bluesex;
            $param_blueemail = $blueemail;
            $param_blueheight = $blueheight;
            $param_blueweight = $blueweight;
            $param_bluepassword = password_hash($bluepassword, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // blueirect to login page
                header("location: loginBlue.php");
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
    <div >  
            <nav class="navbar navbar-light bg-dark header-fade">
                <ul class="nav"> 
                    <li class ="nav-item"><a class="nav-link text-white font-weight-bold" href="homePage.html" > Home</a></li>

                    <li class ="nav-item"><a class="nav-link text-white font-weight-bold" href="aboutPage.html"> About </a></li>
                </ul>
            </nav>
        </div>        
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($blueusername_err)) ? 'has-error' : ''; ?>">
                <div class="form-group col-md-2">
                <label for="blueusername">Username</label>
                <input type="text" name="blueusername" class="form-control" value="<?php echo $blueusername; ?>">
                <span class="help-block"><?php echo $blueusername_err; ?></span>
            </div>
            </div>    
            <div class="form-group <?php echo (!empty($bluepassword_err)) ? 'has-error' : ''; ?>">
                <div class="form-group col-md-2">
                <label for="bluepassword">Password</label>
                <input type="password" name="bluepassword" class="form-control" value="<?php echo $bluepassword; ?>">
                <span class="help-block"><?php echo $bluepassword_err; ?></span>
            </div>
            </div>
            <div class="form-group <?php echo (!empty($confirm_bluepassword_err)) ? 'has-error' : ''; ?>">
                <div class="form-group col-md-2">
                <label for="confirm_bluepassword">Confirm Password</label>
                <input type="password" name="confirm_bluepassword" class="form-control" value="<?php echo $confirm_bluepassword; ?>">
                <span class="help-block"><?php echo $confirm_bluepassword_err; ?></span>
            </div>
            </div>
            <div class="form-group col-md-2">
                <label for="bluefname">First name :</label>
                <input class="input" type="text" name="bluefname" value="<?php echo $bluefname; ?>">
                <span class="help-block"><?php echo $bluefname_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="bluelname">Last name :</label>
                <input class="input" type="text" name="bluelname" value="<?php echo $bluelname; ?>">
                <span class="help-block"><?php echo $bluelname_err;?></span>
            </div>
            <div class="form-group col-md-3">
                <label for="bluesex">Sex</label>

              <input type="radio" name="bluesex" value="Female">Female
                <input type="radio" name="bluesex" value="Male">Male
                <input type="radio" name="bluesex" value="Other">Other
                <span class="help-block"><?php echo $bluesex_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="blueemail">Email :</label>
                <input class="input" type="text" name="blueemail" value="<?php echo $blueemail; ?>">
                <span class="error"><?php echo $blueemail_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="blueheight">Height :</label>
                <input class="input" type="text" name="blueheight" value="<?php echo $blueheight; ?>">
                <span class="help-block"><?php echo $blueheight_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="blueweight">Weight :</label>
                <input class="input" type="text" name="blueweight" value="<?php echo $blueweight; ?>">
                <span class="help-block"><?php echo $blueweight_err;?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-info" value="Reset">
                <a href="registerPage.html" class="btn btn-secondary">Cancel</a>
            </div>
            <p>Already have an account? <a href="loginBlue.php">Login here.</a></p><br>
        </form>
    </div>    
</body>
<footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
</footer>
</html>