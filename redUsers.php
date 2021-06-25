<?php
 include('config.php');
  if(isset($_GET['delete'])){
$idred = $_GET['delete'];
$sql = "select * from red where idred = ".$idred;
$result = mysqli_query($link, $sql);
if(mysqli_num_rows($result) > 0){
$row = mysqli_fetch_assoc($result);

$sql = "delete from red where idred=".$idred;
if(mysqli_query($link, $sql)){
header('location:adminProfile.php');
}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User/s List (R)</title>
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
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Mobile #</th>
				<th>Address</th>
				<th>Sex</th>
				<th>Email</th>
				<th>Height</th>
				<th>Weight</th>
				<th>Creation Date</th>
				<th></th>
			</tr>
		 <?php
		 $sql = "select * from red";
		 $result = mysqli_query($link, $sql);
		 if(mysqli_num_rows($result)){
		 while($row = mysqli_fetch_assoc($result)){
		 ?>
		<tr>
		 <td><?php echo $row['idred'] ?></td>	
		 <td><?php echo $row['redusername'] ?></td>
		 <td><?php echo $row['redfname'] ?></td>
		 <td><?php echo $row['redlname'] ?></td>
		 <td><?php echo $row['redmobilenum'] ?></td>
		 <td><?php echo $row['redaddress'] ?></td>
		 <td><?php echo $row['redsex'] ?></td>
		 <td><?php echo $row['redemail'] ?></td>
		 <td><?php echo $row['redheight'] ?></td>
		 <td><?php echo $row['redweight'] ?></td>
		 <td><?php echo $row['redcreated_at'] ?></td>
		 <td>
		 <a href="adminredEdit.php?idred=<?php echo $row['idred'] ?>" class="btn btn-outline-secondary"><i class="fas fa-user-edit">Edit</i></a>
		 <a href="redUsers.php?delete=<?php echo $row['idred'] ?>" class="btn btn-danger" onclick="return confirm('Confirm deletion?')"><i class="far fa-trash-alt"></i>Delete</a>
		 </td>
		</tr>
		 <?php
		 }
		 }
		 ?>
	</table>
	<a href="adminProfile.php" class="btn btn-secondary">Back</a>
</body>
<footer>
        <nav class="navbar fixed-bottom navbar-dark bg-dark navbar-resize">
        <p class="trademark">Made by: Daproza, Soutanne J. </p>
        </nav>
</footer>
</html>       