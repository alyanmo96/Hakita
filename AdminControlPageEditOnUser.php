<?php
/**
 *  this file let ADMIN to update details or delete user.
 *  get to this file from (AdminPage) file. after choose a special user,
 *  here get his ID and other check by it his all details.
 */
  session_start();
  //get the id of user from the ADMIN (from AdminPage)
  if($_GET['id'])//by redirect page
  {
    $AdminPutId=$_GET['id'];
  }
  else//get the id of user from the ADMIN //after edit on user details
  {
    $AdminPutId=$_POST['id'];
  }// if the admin update password/ email/ name// phone number / courses/ cities of user
  if((isset($_POST['verifyPassword'])&&isset($_POST['password']))||
    isset($_POST['email'])||isset($_POST['phone'])||
    isset($_POST['first_name'])||isset($_POST['last_name'])||
    isset($_POST['hidden_framework'])||isset($_POST['hidden_framework_courses']))
  {// connect with DB to save the new data
    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
      $results = mysqli_query($con, "SELECT * FROM teachers");// connect with table to reach the user
     // update the data.... update data that was changed
      if ($_POST['first_name']) // if ADMIN update user first name
      {
          $fName=$_POST['first_name'];
          $upDate="UPDATE `teachers` SET `fname`='$fName'WHERE id=$AdminPutId";//update it on table
          $results = mysqli_query($con,$upDate);
      }        
      if ($_POST['last_name']) 
      {// if ADMIN update user last name
          $lName=$_POST['last_name'];
          $upDate="UPDATE `teachers` SET `lname`='$lName'WHERE id=$AdminPutId";
          $results = mysqli_query($con,$upDate);
      }
      if ($_POST['email'])  // if ADMIN update user email
      {
          $Email=$_POST['email'];
          $upDate="UPDATE `teachers` SET `email`='$Email'WHERE id=$AdminPutId";
          $results = mysqli_query($con,$upDate);
      }        
      if ($_POST['password']) // if ADMIN update user password
      {
          if ($_POST['password']==$_POST['verifyPassword']) 
          {
              $pass=$_POST['password'];
              $upDate="UPDATE `teachers` SET `password`='$pass'WHERE id=$AdminPutId";
              $results = mysqli_query($con,$upDate);
          }
      }
      if ($_POST['phone']) 
      {// if ADMIN update user phone
          $phone=$_POST['phone'];
          $upDate="UPDATE `teachers` SET `phone`='$phone'WHERE id=$AdminPutId";
          $results = mysqli_query($con,$upDate);
      }  
      if ($_POST['hidden_framework']) 
      {// if ADMIN update user cities
        $Cities=$_POST['hidden_framework'];
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$AdminPutId";
        $result = mysqli_query($con,$upDate);
      } 
      if ($_POST['hidden_framework_courses']) 
      {// if ADMIN update user courses
        $Courses=$_POST['hidden_framework_courses']; 
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$AdminPutId";
        $result = mysqli_query($con,$upDate);
      }
  }
  if(isset($_POST['deleteUserButton']))
  {//ADMIN going to delete the choosen user
    $deleteUserId=$_POST['id'];//get the ID of user to delete
    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $sql = "DELETE FROM teachers WHERE id=$deleteUserId ";
    if ($con->query($sql) === TRUE) 
    {
      header('location: AdminPage.php');
      echo "Record deleted successfully";
    } 
    else 
    {// delete user and back to admin main page
        echo "Error deleting record: " . $con->error;
    }
      header('location: AdminPage.php');
    }
    
  if ($_POST['ImgId']) // any changed on user IMAGE
  {
    $AdminPutId=$_POST['ImgId'];
      $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $msg = "";
        if (isset($_POST['upload'])) {
          // Get image name
          $image = $_FILES['image']['name'];
          // Get text
          $image_text = mysqli_real_escape_string($con, $_POST['image_text']);

          // image file directory
          $target = "img/".basename($image);

          	$ThereIsImage=-1;
            $results = mysqli_query($con, "SELECT * FROM images");
			while ($rows=mysqli_fetch_array($results)) 
			{
				if ($rows['id']==$AdminPutId) 
				{
					if (($rows['image']!=null)||($rows['image']!='image'))
					{
						$ThereIsImage=1;
					}
				}
			}
			if ($ThereIsImage==-1) 
			{
				$sql="INSERT INTO `images`(`image`,`text`,`id`) VALUES ('$image','$image_text','$AdminPutId')";
	          // execute query
	          $result =mysqli_query($con, $sql);
			}
			else
			{
	          	$upDate="UPDATE `images` SET `image`='$image'WHERE id=$AdminPutId";
	 			$result = mysqli_query($con,$upDate);
			}
          if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
          }else{
            $msg = "Failed to upload image";
          }
        }
  }     
        if ($_GET['username']!=null) 
        {
          $username=$_GET['username'];
        }
        else if ($_POST['ImgUsername']!=null) 
        {
          $username=$_POST['ImgUsername'];
        }
        $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $results = mysqli_query($db, "SELECT * FROM teachers");
        //  varibale to show 
        $ID=0;
        $fN=" ";
        $lN=" ";
        $email=" ";
        $pri=" ";
        $sta=" "; 
        $Phone=" ";
        $username=" ";
        $isTeacher=1;
        while ($row=mysqli_fetch_assoc($results)) // get the details from teachers table
        {
          if ($row['id']==$AdminPutId) 
          {
              $ID=$row['id'];
              $username=$row['username'];
              $fN=$row['fname'];
              $lN=$row['lname'];
              $email=$row['email'];
              $pri=$row['price'];
              $sta=$row['status'];
              $Phone=$row['phone'];
              if($row['setUSerAs']=='student')
              {
                $isTeacher=-1;
              }
          }
        }
        $_SESSION['varname'] = $username;
?>
<!DOCTYPE html>
<html>
<head>
  <title>הכיתה</title>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <style>
        body
        {
          direction: rtl;
          text-align: center;
        }
        input[type=submit] 
        {
            max-width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
          }
         input[type=submit]:hover 
         {
            background-color: #45a049;
         }
         .chooseImg
         {
          max-width: 10%;
          margin-right: 46%;
         }
         .file-field.big .file-path-wrapper 
         {
            height: 3.2rem; 
          }
          .file-field.big .file-path-wrapper .file-path 
          {
            height: 3rem; 
          }
      </style>
</head>
<body>
 <nav class="navbar navbar-default">
        <div class="container">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-left">
            <li>
              <a href="Hakita.php">יציאה</a>
            </li>
            <li>
              <a href="AdminPage.php">עמוד המנהל</a>
            </li>
          </ul>
          <div class="navbar-header navbar-right">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <a class="navbar-brand" href="Hakita.php">הכיתה</a>
        </div>
        </div>
      </div>
    </nav>
<hr>
<div class="container bootstrap snippet">
    <div class="row">
      <div class="col-sm-10"><h1>עדכון פרטים</h1></div>
      <div class="col-sm-2">
        <a href="/users" class="pull-right">
          <?php
            $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
            $resultOfUserImage = mysqli_query($con, "SELECT * FROM images");
            while ($rows=mysqli_fetch_array($resultOfUserImage))
            {
                if ($rows['id']==$ID)
                {
                  echo "<img src='img/".$rows['image']."'   class='img-circle img-responsive'>";
                }
            }
          ?>
        </a>
      </div>
    </div>
    <div class="row">
      <div ><!--left col-->
              
      <div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active">
                  <h1> <?php echo $username ?></h1>
                </li>
              </ul>              
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                      <div class="form-group">
                            <div class="col-xs-12">
                                <label for="user_name"></label>
                                <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="id"></label>
                                <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                            </div>
                        </div>
                      <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="last_name"><h4>שם משפחה</h4></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lN?>" >
                            </div>
                        </div>
                        <div class="form-group">                          
                            <div class="col-xs-6">
                                <label for="first_name"><h4>שם פרטי</h4></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $fN?>" title="enter your first name if any.">
                            </div>
                        </div> 
                        <div class="form-group">                         
                            <div class="col-xs-6">
                                <label for="phone"><h4>   מספר טלפון    </h4></label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                            </div>
                        </div>
                          
                      <div class="form-group">
                                <div class="col-xs-6">
                                <label for="email"><h4>Email</h4></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">
                            </div>
                        </div>
                        <?php
                              if($isTeacher==1)
                              {
                                echo" <div class=\"form-group\">
                                  <div class=\"col-xs-6\">
                                    <label for=\"mobile\"><h4>סטטוס</h4></label>
                                      <input type=\"text\" class=\"form-control\" name=\"status\" id=\"status\" placeholder=\" $sta\" >
                                  </div>
                                 </div>";
                                 echo"     <div class=\"form-group\">
                                        <div class=\"col-xs-6\">
                                        <label for=\"price\"><h4>מחיר לשעה</h4></label>
                                        <input type=\"number\" class=\"form-control\" name=\"price\" placeholder=\" $pri\">
                                    </div>
                                </div>";
                              }
                        ?>
                        <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="verifyPassword"><h4>אימות סיסמה</h4></label>
                                <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה">
                            </div>
                        </div>  
                        <div class="form-group">                          
                            <div class="col-xs-6">
                                <label for="password"><h4>סיסמה</h4></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                            </div>
                        </div> 
                      <div class="form-group">
                             <div class="col-xs-6">
                                  <div style=" padding-top: 2%;">
                                    עירים
                                        <?php
                                          echo "<SELECT name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple>";
                                          $results = mysqli_query($con, "SELECT * FROM cities");
                                          echo'<option >'.'בדוק את הערים הקימות'.'</option>';
                                          while ($rows=mysqli_fetch_array($results))
                                          {
                                              echo'<option>'.$rows['cityName'].'</option>';
                                          }
                                          echo"</SELECT>";
                                        ?>
                                     <br /><br />
                                     <input type="hidden" name="hidden_framework" id="hidden_framework" />                                 
                                  <br />
                                 </div>
                                </div>  
                              </div>
                              <div class="form-group">
                             <div class="col-xs-6">
                                  <div style=" padding-top: 2%;">
                                  קורסים
                                     <?php
                                        echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple>";
                                        $results = mysqli_query($con, "SELECT * FROM courses");
                                        echo'<option >'.'קורסים שמלמד'.'</option>';
                                        while ($rows=mysqli_fetch_array($results))
                                        {
                                            echo'<option>'.$rows['subject'].'</option>';
                                        }
                                        echo"</SELECT>";
                                     ?>
                                     <br /><br />
                                     <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses" />                                  
                             
                                  <br />
                                 </div>
                                </div>  
                              </div>
                     <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                                  <label for="Save"><h4></h4></label>
                                  <input type="submit" name="Save" value="שמור">
                                
                            </div>
                      </div>
                </form>
             </div><!--/tab-pane-->
             
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->
          <div class="col-sm-3">

            <form method="POST" action="AdminControlPageEditOnUser.php" enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="ImgUsername" value="<?php echo $username?>">
                <input type="hidden" class="form-control" name="ImgId" value="<?php echo $ID?>">
                <input type="hidden" name="size" value="1000000">
                <hr>
                <hr>
                <h4>צרף תמונה חדשה....</h4>
                <div class="chooseImg">
                  <input class="file-path validate" type="file" name="image">
                </div>
                <div>
                  <button type="submit" name="upload">שמור תמונה</button>
                </div>
        </form>
          <br><br>
          <form method="POST" action="AdminControlPageEditOnUser.php" enctype="multipart/form-data">
              <button name="deleteUserButton" class="btn btn-danger">מחק משתמש</button>
              <div class="form-group">
                  <div class="col-xs-12">
                      <label for="id"></label>
                      <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                  </div>
              </div>
          </form>
          </div>
        </div><!--/col-9-->
    </div><!--/row-->
  </body>
  </html>                                                    


<script>
$(document).ready(function(){
 $('.selectpicker').selectpicker();

 $('#framework').change(function(){
  $('#hidden_framework').val($('#framework').val());
 });

 $('#multiple_select_form').on('Save', function(event){
  event.preventDefault();
  if($('#framework').val() != '')
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     //console.log(data);
     $('#hidden_framework').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }
  else
  {
   alert("נא לבחור עיר");
   return false;
  }
 });
});
</script>

<script>
$(document).ready(function(){
 $('.selectpicker').selectpicker();

 $('#frameworkCourse').change(function(){
  $('#hidden_framework_courses').val($('#frameworkCourse').val());
 });

 $('#multiple_select_form').on('Save', function(event){
  event.preventDefault();
  if($('#frameworkCourse').val() != '')
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     //console.log(data);
     $('#hidden_framework_courses').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }
  else
  {
   return false;
  }
 });
});
</script>