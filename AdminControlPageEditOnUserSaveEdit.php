<?php
    session_start();
    $usernameBy_GET=$_GET['username'];
    $usernameBy_POST=$_GET['username'];
    $usernameBy_SESSION=$_GET['varname']; 
    $l=" ";
    $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $results = mysqli_query($db, "SELECT * FROM teachers");
    $ID=0;  
    $username=" ";
    $Cities= " ";
    while ($row=mysqli_fetch_assoc($results)) 
    {  
       if ($row['username']==$_GET['username']||$row['username']==$_SESSION['varname']||$row['username']==$_POST['username']) 
        {
          $ID=$row['id'];
          $username=$row['username'];
        }
    }
      $fN=$_POST['first_name'];
      $lN=$_POST['last_name'];
      $eMail=$_POST['email'];
      $password1=$_POST['password'];
      $password2=$_POST['password2'];
      $pri=$_POST['price'];
      $sta=$_POST['status'];
      $Cities=$_POST['hidden_framework'];
      $Courses=$_POST['hidden_framework_courses']; 
      if ($fN!=null) 
      {
        $upDate="UPDATE `teachers` SET `fname`='$fN'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);

      }

      if ($lN!=null) 
      {
        $upDate="UPDATE `teachers` SET `lname`='$lN'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);
      }
      if ($eMail!=null) 
      {
        $upDate="UPDATE `teachers` SET `email`='$eMail'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);
      }
      
      if ($password1!=null) 
      {
        if ($password1==$password2) 
        {
          $upDate="UPDATE `teachers` SET `password`='$password1'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);
        }
      }

      if ($pri!=null) 
      {
        $upDate="UPDATE `teachers` SET `price`='$pri'WHERE id=$ID";
      $results = mysqli_query($db,$upDate);
      }
      
      if ($sta!=null) 
      {
        $upDate="UPDATE `teachers` SET `status`='$sta'WHERE id=$ID";
        $result = mysqli_query($db,$upDate);
      } 

      if ($Cities!=null) 
      {
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$ID";
        $result = mysqli_query($con,$upDate);
      } 

      if ($Courses!=null) 
      {
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$ID";
        $result = mysqli_query($con,$upDate);
      }
      header('location: AdminControlPage.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<h1>admin</h1>
</body>
</html>