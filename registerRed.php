<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$redusername = $redpassword = $confirm_redpassword = $redfname = $redlname = $redmobilenum = $redaddress = $redemail = $redsex = $redheight = $redweight = "";

$redusername_err = $redpassword_err = $confirm_redpassword_err = $redfname_err = $redlname_err = $redmobilenum_err = $redaddress_err = $redemail_err = $redsex_err = $redheight_err = $redweight_err = "";
 
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["redusername"]))){
        $redusername_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT idred FROM red WHERE redusername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_redusername);
            
            // Set parameters
            $param_redusername = trim($_POST["redusername"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $redusername_err = "This username is already taken.";
                } else{
                    $redusername = trim($_POST["redusername"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    

    // Validate password
    if(empty(trim($_POST["redpassword"]))){
        $redpassword_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["redpassword"])) < 6){
        $redpassword_err = "Password must have atleast 6 characters.";
    } else{
        $redpassword = trim($_POST["redpassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_redpassword"]))){
        $confirm_redpassword_err = "Please confirm password.";     
    } else{
        $confirm_redpassword = trim($_POST["confirm_redpassword"]);
        if(empty($redpassword_err) && ($redpassword != $confirm_redpassword)){
            $confirm_redpassword_err = "Password did not match.";
        }
    }

    if (empty($_POST["redfname"])){
    $redfname_err = "Please enter your first name.";
    }else {
    $redfname = test_input($_POST["redfname"]); // check name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$redfname)){
    $redfname_err = "Only letters and white space allowed!";
    }
    }

     if (empty($_POST["redlname"])){
    $redlname_err = "Please enter your last name.";
    }else {
    $redlname = test_input($_POST["redlname"]); // check name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$redlname)){
    $redlname_err = "Only letters and white space allowed!";
    }
    }

    if (empty($_POST["redmobilenum"])){
    $redmobilenum_err = "Please enter your mobile number.";
    }else {
    $redmobilenum = test_input($_POST["redmobilenum"]); 
    if (!preg_match('/^[0-9]{11}+$/', $redmobilenum)){
    $redmobilenum_err = "Invalid mobile number format!";
    }
    }

     if(empty($_POST["redaddress"])){
        $redaddress_err = "Please enter your address.";     
    } else {$redaddress = test_input($_POST["redaddress"]);
    }

    if (empty($_POST["redsex"])) {
    $redsex_err = "Please select your sex.";
    } else {$redsex = test_input($_POST["redsex"]);
    }

    if (empty($_POST["redemail"])) {
    $redemail_err = "Email is required.";
    } else {
    $redemail = test_input($_POST["redemail"]);
    // check if e-mail address syntax is valid or not
    if (!filter_var($redemail, FILTER_VALIDATE_EMAIL)) {
    $redemail_err  = "Invalid email format!";
    }
    }

    if (empty($_POST["redheight"])) {
    $redheight_err = "Height is required.";
    } else{
    $redheight = test_input($_POST["redheight"]);   
    if (!is_numeric($redheight)){
    $redheight_err = "Input numbers only!";
    } 
    }

    if (empty($_POST["redweight"])) {
    $redweight_err = "Weight is required.";
    } else{
    $redweight = test_input($_POST["redweight"]);   
    if (!is_numeric($redweight)){
    $redweight_err = "Input numbers only!";
    } 
    }
    
     // Check input errors before inserting in database
    if(empty($redusername_err) && empty($redfname_err) && empty($redlname_err) && empty($redsex_err) && empty($redmobilenum_err) && empty($redaddress_err) && empty($redemail_err) && empty($redheight_err) && empty($redweight_err) && empty($redpassword_err) && empty($confirm_redpassword_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO red (redusername, redpassword, redfname, redlname, redsex, redmobilenum, redaddress, redemail, redheight, redweight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_redusername, $param_redpassword, $param_redfname, $param_redlname, $param_redsex, $param_redmobilenum, $param_redaddress, $param_redemail, $param_redheight, $param_redweight);
            
            // Set parameters
            $param_redusername = $redusername;
            $param_redfname = $redfname;
            $param_redlname = $redlname;
            $param_redsex = $redsex;
            $param_redmobilenum = $redmobilenum;
            $param_redaddress = $redaddress;
            $param_redemail = $redemail;
            $param_redheight = $redheight;
            $param_redweight = $redweight;
            $param_redpassword = password_hash($redpassword, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // redirect to login page
                header("location: loginRed.php");
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
            <div class="form-group <?php echo (!empty($redusername_err)) ? 'has-error' : ''; ?>">
                <div class="form-group col-md-2">
                <label for="redusername">Username</label>
                <input type="text" name="redusername" class="form-control" value="<?php echo $redusername; ?>">
                <span class="help-block"><?php echo $redusername_err; ?></span>
            </div>
            </div>    
            <div class="form-group <?php echo (!empty($redpassword_err)) ? 'has-error' : ''; ?>">
                <div class="form-group col-md-2">
                <label for="redpassword">Password</label>
                <input type="password" name="redpassword" class="form-control" value="<?php echo $redpassword; ?>">
                <span class="help-block"><?php echo $redpassword_err; ?></span>
            </div>
            </div>
            <div class="form-group <?php echo (!empty($confirm_redpassword_err)) ? 'has-error' : ''; ?>">
                <div class="form-group col-md-2">
                <label for="redconfirm_password">Confirm Password</label>
                <input type="password" name="confirm_redpassword" class="form-control" value="<?php echo $confirm_redpassword; ?>">
                <span class="help-block"><?php echo $confirm_redpassword_err; ?></span>
            </div>
            </div>
            <div class="form-group col-md-2">
                <label for="redfname">First name :</label>
                <input class="input" type="text" name="redfname" value="<?php echo $redfname; ?>">
                <span class="help-block"><?php echo $redfname_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="redlname">Last name :</label>
                <input class="input" type="text" name="redlname" value="<?php echo $redlname; ?>">
                <span class="help-block"><?php echo $redlname_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="redemail">Email :</label>
                <input class="input" type="text" name="redemail" value="<?php echo $redemail; ?>">
                <span class="help-block"><?php echo $redemail_err;?></span>
            </div>
            <div class="form-group col-md-2">   
                <label for="redmobilenum">Mobile Number :</label>
                <input class="input" type="text" name="redmobilenum" maxlength="11" value="<?php echo $redmobilenum; ?>">
                <span class="help-block"><?php echo $redmobilenum_err;?></span>
            </div>
            <div class="form-group col-md-2">  
                <label for="redaddress">Address</label>
                <textarea name="redaddress" class="form-control"><?php echo $redaddress;?></textarea>
                <span class="help-block"><?php echo $redaddress_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="redsex">Sex</label>
                <input type="radio" name="redsex" value="Female">Female
                <input type="radio" name="redsex" value="Male">Male
                <input type="radio" name="redsex" value="Other">Other
                <span class="help-block"><?php echo $redsex_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="redheight">Height :</label>
                <input class="input" type="text" name="redheight" value="<?php echo $redheight; ?>">
                <span class="help-block"><?php echo $redheight_err;?></span>
            </div>
            <div class="form-group col-md-2">
                <label for="redweight">Weight :</label>
                <input class="input" type="text" name="redweight" value="<?php echo $redweight; ?>">
                <span class="help-block"><?php echo $redweight_err;?></span>
             </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-info" value="Reset">
                <a href="registerPage.html" class="btn btn-secondary">Cancel</a>
            </div>
            <p>Already have an account? <a href="loginRed.php">Login here.</a></p><br>
        </form>
    </div>    
</body>
<footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
</footer>
</html>

