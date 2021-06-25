<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginAdmin.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
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
    <div class="navbar sticky-top">
        <h1>Nice pose! <b><?php echo htmlspecialchars($_SESSION["adminusername"]); ?></b>. Get ready for a new day.</h1>
    </div>

    <div>
        <h2 class="text-center">View Profiles :</h2>
        <table class="table table-bordered">
            <tr>
                <td>Admin</td>
                <td><a href="adminUsers.php" class=" btn btn-secondary"><i class="far fa-eye"></i>View</a></td>
            </tr>
            <tr>
                <td>Blue (Casual)</td>
                <td><a href="blueUsers.php" class=" btn btn-secondary"><i class="far fa-eye"></i>View</a></td>
            </tr>
            <tr>
                <td>Red (Pro)</td><td><a href="redUsers.php" class=" btn btn-secondary"><i class="far fa-eye"></i>View</a></td>
            </tr>
        </table>
    </div>

    <p>
        <a href="reset-adminpassword.php" class="btn btn-warning">Reset your password</a>
        <a href="registerAdmin.php" class="btn btn-primary">Register another Admin</a>
        <a href="logout.php" class="btn btn-danger">Sign out of your account</a>
    </p>
</body>
<footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
</footer>
</html>