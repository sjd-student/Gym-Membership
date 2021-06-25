<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then rdeirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginblue.php");
    exit;
}
?>
<?php
 include('config.php');
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
    <div class="page-header">
        <h1>Greetings, <b><?php echo htmlspecialchars($_SESSION["blueusername"]); ?></b>. Remember to take frequent water breaks.</h1>
    </div>
<table class="table table-hover">
    <thead>
    <tr>
    <th>Username</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Sex</th>
    <th>E-mail</th>
    <th>Height</th>
    <th>Weight</th>
    </tr>
    </thead>
    <tbody>
         <?php
$sql = "
    SELECT 
    blueusername, bluefname, bluelname, bluesex, blueemail, blueemail, blueheight, blueweight
    FROM
    blue 
    WHERE 
    blueusername = '" . $_SESSION['blueusername'] ."'";
 $result = mysqli_query($link, $sql);
 if(mysqli_num_rows($result)){
 while($row = mysqli_fetch_assoc($result)){
 ?>
 <tr>
 <td><?php echo $row['blueusername'] ?></td>
 <td><?php echo $row['bluefname'] ?></td>
 <td><?php echo $row['bluelname'] ?></td>
 <td><?php echo $row['bluesex'] ?></td>
 <td><?php echo $row['blueemail'] ?></td>
 <td><?php echo $row['blueheight'] ?></td>
 <td><?php echo $row['blueweight'] ?></td>
  </tr>
   <?php
 }
 }
 ?>
 </tbody>
</table>
    <p>
        <a href="reset-bluepassword.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
<footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
    
</html>