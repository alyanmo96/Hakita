<?php
/*
  1-this is the update information the user change, and to let the admin know the change
  2-if the two passwords are differents *****
*/
    session_start();
    /*
    $USERNAME=$_GET['username']; 
    echo "#$USERNAME#";

    $logIn=$_POST['usernameLogin']; 
    echo "%$logIn%";

    $signUp=$_POST['username'];
    echo "^$signUp^";

  $edit=$_GET['username']; 
  echo "&$edit&";

  $eedit=$_SESSION['varname'];
  echo "@$eedit@";
  */
  
    //$l=" ";
    $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $results = mysqli_query($db, "SELECT * FROM teachers");
    //this table used for admin, to check who make change
    $makeChangeEnter = mysqli_query($db, "SELECT * FROM makeChange");
    $userMakeChange=-1;
    $ID=0;  
    $username=" ";
    $Cities= " ";
    while ($row=mysqli_fetch_assoc($results)) 
    {  
       # if ($row['username']==$_GET['username']||$row['username']==$_SESSION['varname']||$row['username']==$_POST['username']) 
        if ($row['username']==$_GET['username']||$row['username']==$_SESSION['varname']) 
        {
          $ID=$row['id'];
          $username=$row['username'];
        }
    }  
    // get the changed variables 
      $firstName=$_POST['first_name'];
      $lastName=$_POST['last_name'];
      $eMail=$_POST['email'];
      $password1=$_POST['password'];
      $password2=$_POST['password2'];
      $price=$_POST['price'];
      $status=$_POST['status'];
      $Cities=$_POST['hidden_framework'];
      $Courses=$_POST['hidden_framework_courses']; 
      $phoneNumber=$_POST['phone'];

      if ($firstName!=null) // if user change the first name, update it
      {
        $upDate="UPDATE `teachers` SET `fname`='$firstName'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);
        $userMakeChange=1;
      }
      if ($lastName!=null) // if user change the last name, update it
      {
        $upDate="UPDATE `teachers` SET `lname`='$lastName'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);
        $userMakeChange=1;
      }
      if ($eMail!=null) // if user change the email address, update it
      {
        $upDate="UPDATE `teachers` SET `email`='$eMail'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);
        $userMakeChange=1;
      }
      if ($password1!=null) // if user change the password, update it
      {
        if ($password1==$password2) //check if the password and confairm password same string
        {
          $upDate="UPDATE `teachers` SET `password`='$password1'WHERE id=$ID";
          $results = mysqli_query($db,$upDate);
          $userMakeChange=1;
        }
        else//check if the password and confairm password are differents strings
        {
          //the new passwords are differents
        }
      }
      if ($price!=null)//if user change the price, update it
      {
        $upDate="UPDATE `teachers` SET `price`='$price'WHERE id=$ID";
        $results = mysqli_query($db,$upDate);
        $userMakeChange=1;
      }
      if ($status!=null)//if user change the status, update it
      {
        $upDate="UPDATE `teachers` SET `status`='$status'WHERE id=$ID";
        $result = mysqli_query($db,$upDate);
        $userMakeChange=1;
      } 
      if($phoneNumber!=null)//if user change phone number, update it
      {
        $upDate="UPDATE `teachers` SET `phone`='$phoneNumber'WHERE id=$ID";
        $result = mysqli_query($db,$upDate);
        $userMakeChange=1;
      }
      if ($Cities!=null) 
      {
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$ID";
        $result = mysqli_query($con,$upDate);
        $userMakeChange=1;
      } 
      if ($Courses!=null) 
      {
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$ID";
        $result = mysqli_query($con,$upDate);
        $userMakeChange=1;
      }
      if ($userMakeChange==1)//this table used for admin, to check who make change
      {
          $query="INSERT INTO `makeChange`(`id`) VALUES ('$ID')";
          $makeChangeEnter = mysqli_query($db,$query);
      }
      //back to profile page with the new data,if there was an any change
      header('location: profile.php');
?>