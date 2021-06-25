<?php
 include('config.php');
  if(isset($_GET['delete'])){
$idadmin = $_GET['delete'];
$sql = "select * from admin where idadmin = ".$idadmin;
$result = mysqli_query($link, $sql);
if(mysqli_num_rows($result) > 0){
$row = mysqli_fetch_assoc($result);

$sql = "delete from admin where idadmin=".$idadmin;
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
				<th>Creation Date</th>
				<th></th>
			</tr>
		 <?php
		 $sql = "select * from admin";
		 $result = mysqli_query($link, $sql);
		 if(mysqli_num_rows($result)){
		 while($row = mysqli_fetch_assoc($result)){
		 ?>
		<tr>
		 <td><?php echo $row['idadmin'] ?></td>	
		 <td><?php echo $row['adminusername'] ?></td>
		 <td><?php echo $row['created_at'] ?></td>
		 <td>
		 <a href="adminaccEdit.php?idadmin=<?php echo $row['idadmin'] ?>" class="btn btn-outline-secondary"><i class="fas fa-user-edit">Edit</i></a>
		 <a href="adminUsers.php?delete=<?php echo $row['idadmin'] ?>" class="btn btn-danger" onclick="return confirm('Confirm deletion?')"><i class="far fa-trash-alt"></i>Delete</a>
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