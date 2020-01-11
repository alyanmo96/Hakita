<?php
	$deleteId=$_GET['id'];
	$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
	$sql = "DELETE FROM images WHERE id=$deleteId ";
	if ($conn->query($sql) === TRUE) 
	{
	   echo "Record deleted successfully";
	} 
	else 
	{
       echo "Error deleting record: " . $conn->error;
	}
	header('location: AdminControlPage.php');
?>