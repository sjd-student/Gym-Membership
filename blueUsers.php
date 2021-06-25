<?php
 include('config.php');
  if(isset($_GET['delete'])){
$idblue = $_GET['delete'];
$sql = "select * from blue where idblue = ".$idblue;
$result = mysqli_query($link, $sql);
if(mysqli_num_rows($result) > 0){
$row = mysqli_fetch_assoc($result);

$sql = "delete from blue where idblue=".$idblue;
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
    <title>User/s List (B)</title>
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
				<th>Sex</th>
				<th>Email</th>
				<th>Height</th>
				<th>Weight</th>
				<th>Creation Date</th>
				<th></th>
			</tr>
		 <?php
		 $sql = "select * from blue";
		 $result = mysqli_query($link, $sql);
		 if(mysqli_num_rows($result)){
		 while($row = mysqli_fetch_assoc($result)){
		 ?>
		<tr>
		 <td><?php echo $row['idblue'] ?></td>	
		 <td><?php echo $row['blueusername'] ?></td>
		 <td><?php echo $row['bluefname'] ?></td>
		 <td><?php echo $row['bluelname'] ?></td>
		 <td><?php echo $row['bluesex'] ?></td>
		 <td><?php echo $row['blueemail'] ?></td>
		 <td><?php echo $row['blueheight'] ?></td>
		 <td><?php echo $row['blueweight'] ?></td>
		 <td><?php echo $row['bluecreated_at'] ?></td>
		 <td>
		 <a href="adminblueEdit.php?idblue=<?php echo $row['idblue'] ?>" class="btn btn-outline-secondary"><i class="fas fa-user-edit">Edit</i></a>
		 <a href="blueUsers.php?delete=<?php echo $row['idblue'] ?>" class="btn btn-danger" onclick="return confirm('Confirm deletion?')"><i class="far fa-trash-alt"></i>Delete</a>
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