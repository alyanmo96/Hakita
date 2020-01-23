<?php
  session_start();
  //call DB
  $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  $results = mysqli_query($db, "SELECT * FROM teachers");
  $resultsOfImageTable = mysqli_query($db, "SELECT * FROM images");
  $max=0;
  $user=" ";
  //get the new user id and username
  while ($row=mysqli_fetch_assoc($results)) 
	{
		$max=$row['id'];
    $user=$row['username'];
  }
  
  $fN=$_POST['first_name'];
  $lN=$_POST['last_name'];
  $eMail=$_POST['email'];
  //$pri=$_POST['price'];
  $sta=$_POST['status'];
  $PHONE=$_POST['phone'];

  $gender=$_POST['frameworkGender'];
  $studentOrTeacher=$_POST['frameworkstudentOrTeacher'];
    
  // enter the new information like (first name, last name, email address,etc...)
  $upDate="UPDATE `teachers` SET `fname`='$fN'WHERE id=$max";
  $result = mysqli_query($db,$upDate);

  $upDate="UPDATE `teachers` SET `lname`='$lN'WHERE id=$max";
  $result = mysqli_query($db,$upDate);

  $upDate="UPDATE `teachers` SET `email`='$eMail'WHERE id=$max";
  $result = mysqli_query($db,$upDate);

  if($gender!='זכר')
  {
    $upDate="UPDATE `teachers` SET `gender`='$gender'WHERE id=$max";
    $result = mysqli_query($db,$upDate);    
    $ImgSource="womenDefaultImage.png";
    $upDate="UPDATE `images` SET `image`='$ImgSource'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
  }
  else
  {
    $gender='זכר';
    $upDate="UPDATE `teachers` SET `gender`='$gender'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
    $ImgSource="manDefaultImage.png";
    $upDate="UPDATE `images` SET `image`='$ImgSource'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
  }

  if($studentOrTeacher!='מורה')
  {
    $upDate="UPDATE `teachers` SET `setUserAs`='$studentOrTeacher'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
  }
  else
  {
    $studentOrTeacher='מורה';
    $upDate="UPDATE `teachers` SET `setUserAs`='$studentOrTeacher'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
  }


  /*
  $upDate="UPDATE `teachers` SET `price`='$pri'WHERE id=$max";
  $result = mysqli_query($db,$upDate);
  */
  
  $upDate="UPDATE `teachers` SET `status`='$sta'WHERE id=$max";
  $result = mysqli_query($db,$upDate);

  $upDate="UPDATE `teachers` SET `phone`='$PHONE'WHERE id=$max";
  $result = mysqli_query($db,$upDate);
 /* $upDate="UPDATE `teachers` SET `image`='$IMG'WHERE id=$max";
  $result = mysqli_query($db,$upDate);
*/


$_SESSION['varname'] = $user;
	if ($user=="AdminEliEssiak") // login of admin (need to change that)
	{
    header('location: AdminControlPage.php');
	}
	else// sign up of a normal user
	{
    if( $studentOrTeacher=='מורה')
    {
      header('location: profile.php');
    }
    else{
      header('location: studentProfile.php');
    }
	}
?>