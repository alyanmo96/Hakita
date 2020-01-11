<?php
	session_start();
  $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  $us=$_POST['usernameLogin'];
  $pss=$_POST['PasswordLogin'];
  $alreadyAccount=-1;
  $result= mysqli_query($con, "SELECT * FROM teachers");
  while ($row=mysqli_fetch_assoc($result)) 
	{
		$s=$row['password'];
		if($row['password']==$_POST['PasswordLogin'])
		{
			$alreadyAccount=1;
		}
	}
  if ($alreadyAccount==1) 
  {
  	header('location: profile.php');
  }
  else
  {
    $message = " somthing wrong  ";
   // echo "<script type='text/javascript'>alert('$message');</script>";
    header('location: firstLoginPage.php');
  }
?>