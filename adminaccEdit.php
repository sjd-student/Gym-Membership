<?php
 require_once('config.php');
 if (isset($_GET['idadmin'])) {
 $idadmin = $_GET['idadmin'];
 $sql = "select * from admin where idadmin=".$idadmin;
 $result = mysqli_query($link, $sql);
 if (mysqli_num_rows($result) > 0) {
 $row = mysqli_fetch_assoc($result);
 }else {
 $errorMsg = 'Could not Find Any Record';

}

}
 if(isset($_POST['Submit'])){
$adminusername = $_POST['adminusername'];

if(!isset($errorMsg)){
$sql = "update admin
set adminusername = '".$adminusername."',
where idadmin=".$idadmin;
$result = mysqli_query($link, $sql);
if($result){
$successMsg = 'Successfully Updated!';
header('Location:adminUsers.php');
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
 <h2>Edit Profile</h2>

 <form class="" action="" method="post" enctype="multipart/form-data">
<div class="form-row">
 <div class="form-group col-md-2">
  <label for="adminusername">Username</label>
 <input type="text" name="adminusername" placeholder="Username"
value="<?php echo $row['adminusername']; ?>">
</div>
<div class="form-group col-md-2">
<label for="created_at">Creation Date</label>
 <input type="text" name="created_at" disabled placeholder="Date created"
value="<?php echo $row['created_at']; ?>" title="I'm afraid, that's not possible.">
</div>
</div>
 <a href="adminUsers.php" class="btn btn-secondary">Cancel</a>
 <button type="submit" name="Submit" class="btn btn-success">Save</button>
 </form>
 </body>
     <footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
    </footer>
</html>