<?php
 require_once('config.php');
 if (isset($_GET['idblue'])) {
 $idblue = $_GET['idblue'];
 $sql = "select * from blue where idblue=".$idblue;
 $result = mysqli_query($link, $sql);
 if (mysqli_num_rows($result) > 0) {
 $row = mysqli_fetch_assoc($result);
 }else {
 $errorMsg = 'Could not Find Any Record';

}

}
 if(isset($_POST['Submit'])){
$blueusername = $_POST['blueusername'];
$bluefname = $_POST['bluefname'];
$bluelname = $_POST['bluelname'];
$blueemail = $_POST['blueemail'];
$bluesex = $_POST['bluesex'];
$blueheight = $_POST['blueheight'];
$blueweight = $_POST['blueweight'];

if(!isset($errorMsg)){
$sql = "update blue
set blueusername = '".$blueusername."',
bluefname = '".$bluefname."',
bluelname = '".$bluelname."',
bluesex = '".$bluesex."',
blueemail = '".$blueemail."',
blueheight = '".$blueheight."',
blueweight = '".$blueweight."'

where idblue=".$idblue;
$result = mysqli_query($link, $sql);
if($result){
$successMsg = 'Successfully Updated!';
header('Location:blueUsers.php');
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
  <label for="blueusername">Username</label>
 <input type="text" name="blueusername" class="form-control" id="blueusername" placeholder="Username"
value="<?php echo $row['blueusername']; ?>">
</div>
<div class="form-group col-md-2">
 <label for="bluefname">First Name</label>
 <input type="text" name="bluefname"  class="form-control" id="bluefname" placeholder="First name"
value="<?php echo $row['bluefname']; ?>">
</div>
<div class="form-group col-md-2">
<label for="bluelname">Last Name</label>
 <input type="text" name="bluelname" placeholder="Last name" class="form-control" id="bluelname" value="<?php echo $row['bluelname']; ?>">
</div>
</div>

<div class="form-group col-md-6">
<label for="bluesex">Sex</label>
<input type="radio" name="bluesex" value="Female" value="<?php echo $row['bluesex']; ?>">Female
<input type="radio" name="bluesex" value="Male" value="<?php echo $row['bluesex']; ?>">Male
<input type="radio" name="bluesex" value="Other" value="<?php echo $row['bluesex']; ?>">Other
</div>
</div>
 <div class="form-row">
 <div class="form-group col-md-4">
<label for="blueemail">E-mail</label>
 <input type="text" name="blueemail" placeholder="E-mail" class="form-control" id="blueemail"value="<?php echo $row['blueemail']; ?>">
</div>
 <div class="form-group col-md-2">
 <label for="blueheight">Height</label>
 <input type="text" name="blueheight" placeholder="Height" class="form-control" id="blueheight"value="<?php echo $row['blueheight']; ?>">
</div>
 <div class="form-group col-md-2">
 <label for="blueweight">Weight</label>
 <input type="text" name="blueweight" placeholder="Weight" class="form-control" id="blueweight"value="<?php echo $row['blueweight']; ?>">
</div>
 <div class="form-group col-md-2">
<label for="bluecreated_at">Creation Date</label>
 <input type="text" name="created_at" disabled placeholder="Date created" class="form-control" id="bluecreated_at"
value="<?php echo $row['bluecreated_at']; ?>" title="I'm afraid, that's not possible.">
</div>
</div>
 <a href="blueUsers.php" class="btn btn-secondary">Cancel</a>
 <button type="submit" name="Submit" class="btn btn-success">Save</button>

 </form>
 </body>
     <footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
</html>