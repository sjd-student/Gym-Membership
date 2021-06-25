<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then rdeirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginred.php");
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
        <h1>How's your daily grind? <b><?php echo htmlspecialchars($_SESSION["redusername"]); ?></b>. Remember to do your stretches.</h1>
    </div>
<table class="table table-hover">
    <thead>
    <tr>
    <th>Username</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Mobile Number</th>
    <th>Address</th>
    <th>Sex</th>
    <th>E-mail</th>
    <th>Height (cms)</th>
    <th>Weight (kg)</th>
    </tr>
    </thead>
    <tbody>
  <?php
 $sql = "select * from red where idred=".$_SESSION['idred'];
 $result = mysqli_query($link, $sql);
 if(mysqli_num_rows($result)){
 while($row = mysqli_fetch_assoc($result)){
 ?>
 <tr>
 <td><?php echo $row['redusername'] ?></td>
 <td><?php echo $row['redfname'] ?></td>
 <td><?php echo $row['redlname'] ?></td>
 <td><?php echo $row['redmobilenum'] ?></td>
 <td><?php echo $row['redaddress'] ?></td>
 <td><?php echo $row['redsex'] ?></td>
 <td><?php echo $row['redemail'] ?></td>
 <td><?php echo $row['redheight'] ?></td>
 <td><?php echo $row['redweight'] ?></td>
 <td><a href="redEdit.php?idred=<?php echo $row['idred'] ?>" class="btn-outline-secondary">Edit</a> </td>
 <?php
 }
 }
 ?>
 <td>
</tr>
 </tbody>
</table>
    <p>
        <a href="reset-redpassword.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
<footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
</html>