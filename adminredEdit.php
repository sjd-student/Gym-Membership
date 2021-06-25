<?php
 require_once('config.php');
 if (isset($_GET['idred'])) {
 $idred = $_GET['idred'];
 $sql = "select * from red where idred=".$idred;
 $result = mysqli_query($link, $sql);
 if (mysqli_num_rows($result) > 0) {
 $row = mysqli_fetch_assoc($result);
 }else {
 $errorMsg = 'Could not Find Any Record';

}

}
 if(isset($_POST['Submit'])){
$redusername = $_POST['redusername'];
$redfname = $_POST['redfname'];
$redlname = $_POST['redlname'];
$redmobilenum = $_POST['redmobilenum'];
$redaddress = $_POST['redaddress'];
$redemail = $_POST['redemail'];
$redsex = $_POST['redsex'];
$redheight = $_POST['redheight'];
$redweight = $_POST['redweight'];

if(!isset($errorMsg)){
$sql = "update red
set redusername = '".$redusername."',
redfname = '".$redfname."',
redlname = '".$redlname."',
redmobilenum = '".$redmobilenum."',
redaddress = '".$redaddress."',
redsex = '".$redsex."',
redemail = '".$redemail."',
redheight = '".$redheight."',
redweight = '".$redweight."'

where idred=".$idred;
$result = mysqli_query($link, $sql);
if($result){
$successMsg = 'Successfully Updated!';
header('Location:redUsers.php');
}else{
$errorMsg = 'Error '.mysqli_error($link);
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
    <link rel="icon" href="media/favicon.ico" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="media/bootstrap.css" rel="stylesheet"/>
        <link href="media/all.css" rel="stylesheet"/>
        <link href="media/mweb.css" rel="stylesheet"/>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( document ).tooltip();
  } );
  </script>
  <style>
  label {
    display: inline-block;
    width: 5em;
  }
  </style>
 </head>
 <body>
    <navbar class="navbar navbar-light bg-light">
                <img src="media/icon.png" width="150" height="75" >
                <span class="navbar navbar-brand header-logo">Macho Gym</span>
            </navbar> 
<h2> Edit Profile </h2>

 <form action="" method="post" enctype="multipart/form-data">
 <div class="form-row">
 <div class="form-group col-md-2">
  <label for="redusername">Username</label>
 <input type="text" name="redusername" class="form-control" id="redusername" placeholder="Username"
value="<?php echo $row['redusername']; ?>">
</div>
<div class="form-group col-md-2">
 <label for="redfname">First Name</label>
 <input type="text" name="redfname"  class="form-control" id="redfname" placeholder="First name"
value="<?php echo $row['redfname']; ?>">
</div>
<div class="form-group col-md-2">
<label for="redlname">Last Name</label>
 <input type="text" name="redlname" placeholder="Last name" class="form-control" id="redlname" value="<?php echo $row['redlname']; ?>">
</div>
 <div class="form-group col-md-2">
<label for="redmobilenum">Mobile Number</label>
 <input type="text" name="redmobilenum" maxlength="11"  class="form-control" id="redmobilenum" placeholder="Mobile Number"
value="<?php echo $row['redmobilenum']; ?>">
</div>
</div>
 <div class="form-row">
 <div class="form-group col-md-6">
<label for="redaddress">Address</label>
 <input type="text" name="redaddress" placeholder="Address" class="form-control" id="redaddress" 
value="<?php echo $row['redaddress']; ?>">
</div>
<div class="form-group col-md-6">
<label for="redsex">Sex</label>
<input type="radio" name="redsex" value="Female" value="<?php echo $row['redsex']; ?>">Female
<input type="radio" name="redsex" value="Male" value="<?php echo $row['redsex']; ?>">Male
<input type="radio" name="redsex" value="Other" value="<?php echo $row['redsex']; ?>">Other
</div>
</div>
 <div class="form-row">
 <div class="form-group col-md-4">
<label for="redemail">E-mail</label>
 <input type="text" name="redemail" placeholder="E-mail" class="form-control" id="redemail"value="<?php echo $row['redemail']; ?>">
</div>
 <div class="form-group col-md-2">
 <label for="redheight">Height</label>
 <input type="text" name="redheight" placeholder="Height" class="form-control" id="redheight"value="<?php echo $row['redheight']; ?>">
</div>
 <div class="form-group col-md-2">
 <label for="redweight">Weight</label>
 <input type="text" name="redweight" placeholder="Weight" class="form-control" id="redweight"value="<?php echo $row['redweight']; ?>">
</div>
 <div class="form-group col-md-2">
<label for="redcreated_at">Creation Date</label>
 <input type="text" name="redcreated_at" disabled placeholder="Date created" class="form-control" id="redcreated_at"
value="<?php echo $row['redcreated_at']; ?>" title="Non-editable.">
</div>
</div>
 <a href="redUsers.php" class="btn btn-secondary">Cancel</a>
 <button type="submit" name="Submit" class="btn btn-success">Save</button>

 </form>
 </body>
     <footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
</html>