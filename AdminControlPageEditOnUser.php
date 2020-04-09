<?php
/**
 *  this file let ADMIN to update details or delete user.
 *  get to this file from (AdminPage) file. after choose a special user,
 *  here get his ID and other check by it his all details.
 */
  session_start();



  /*
	*  $AdminPutId=$_SESSION['id']
	*   $_SESSION['id']=$AdminPutId;




	*/
  //get the id of user from the ADMIN (from AdminPage)
  $AdminPutId = ($_GET['id']) ? $_GET['id'] : $_POST['id'];
  // if the admin update password/ email/ name// phone number / courses/ cities of user
  if((isset($_POST['verifyPassword'])&&isset($_POST['password']))||
    isset($_POST['email'])||isset($_POST['phone'])||isset($_POST['price'])||isset($_POST['status'])||
    isset($_POST['first_name'])||isset($_POST['last_name'])||
    isset($_POST['hidden_framework'])||isset($_POST['hidden_framework_courses']))
  {// connect with DB to save the new data
    //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    //$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
      
    $results=mysqli_query($con, "SELECT * FROM users");// connect with table to reach the user
      // update the data.... update data that was changed
      if ($_POST['first_name']){ // if ADMIN update user first name
        $fName=$_POST['first_name'];
        $upDate="UPDATE `users` SET `fname`='$fName'WHERE id=$AdminPutId";//update it on table
        $results=mysqli_query($con,$upDate);
      }        
      if ($_POST['last_name']){// if ADMIN update user last name
        $lName=$_POST['last_name'];
        $upDate="UPDATE `users` SET `lname`='$lName'WHERE id=$AdminPutId";//update it on table
        $results=mysqli_query($con,$upDate);
      }        
      if ($_POST['price']){// if ADMIN update user price
        $Price=$_POST['price'];
        $upDate="UPDATE `users` SET `price`='$Price'WHERE id=$AdminPutId";//update it on table
        $results=mysqli_query($con,$upDate);
      }        
      if ($_POST['status']){// if ADMIN update user status
        $status=$_POST['status'];
        $upDate="UPDATE `users` SET `status`='$status'WHERE id=$AdminPutId";//update it on table
        $results=mysqli_query($con,$upDate);
      }
      if ($_POST['email']){  // if ADMIN update user email
        $Email=$_POST['email'];
        $upDate="UPDATE `users` SET `email`='$Email'WHERE id=$AdminPutId";//update it on table
        $results=mysqli_query($con,$upDate);
      }        
      if ($_POST['password']){ // if ADMIN update user password
        $invalidPass=-1;//next section to check if ADMIN insert a valid password
        if ($_POST['password']==$_POST['verifyPassword']){//next variables to check if ADMIN insert letters/number on password
            $uppercase=preg_match('@[A-Z]@', $_POST["password"]);
            $lowercase=preg_match('@[a-z]@', $_POST["password"]);
            $number=preg_match('@[0-9]@', $_POST["password"]);
            if(strlen($_POST["password"])<8){//if the password string is less than 8 chars
              if(!$uppercase || !$lowercase || !$number){//alert wrong input
                  echo"<script type='text/javascript'>alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                      echo"<script type='text/javascript'>alert('סיסמה קצרה מדי');</script>";
                }$invalidPass=1;
            }
            else if(strlen($_POST["password"])>16){//if the password string is bigger than 16 chars
              if(!$uppercase || !$lowercase || !$number){//alert wrong input
                  echo"<script type='text/javascript'>alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
              }else{//alert wrong input
                    echo"<script type='text/javascript'>alert('סיסמה ארוכה מדי');</script>";
              }$invalidPass=1;
            }else{
              if(!$uppercase || !$lowercase || !$number){//alert wrong input
                echo"<script type='text/javascript'>alert('הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                $invalidPass=1;
              }
            }
            if($invalidPass==-1){//if the password is valid
                $pass=$_POST['password'];//new password
                $upDate="UPDATE `users` SET `password`='$pass'WHERE id=$ID";//update it on table
                $results=mysqli_query($con,$upDate);
           }
        }else{//alert wrong input
          echo "<script type='text/javascript'>alert('הסיסמאות שונות');</script>";
        }
      }
      if ($_POST['phone']){// if ADMIN update user phone
          $phone=$_POST['phone'];
          $upDate="UPDATE `users` SET `phone`='$phone'WHERE id=$AdminPutId";//update it on table
          $results=mysqli_query($con,$upDate);
      }  
      if ($_POST['hidden_framework']){// if ADMIN update user cities
        $Cities=$_POST['hidden_framework'];
//        $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$AdminPutId";//update it on table
        $result=mysqli_query($con,$upDate);
      } 
      if ($_POST['hidden_framework_courses']){// if ADMIN update user courses
        $Courses=$_POST['hidden_framework_courses']; 
        //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$AdminPutId";//update it on table
        $result=mysqli_query($con,$upDate);
      }
  }
  if(isset($_POST['changeFromStudentAccountToTeacherAccount'])){//ADMIN going to change student account to teacher account
    //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    $results=mysqli_query($con, "SELECT * FROM users");
    $upDate="UPDATE `users` SET `setUserAs`='teacher'WHERE id=$AdminPutId";//update it on table
    $results=mysqli_query($con,$upDate);
  }
  if(isset($_POST['deleteUserButton'])){//ADMIN going to delete the choosen user
    $deleteUserId=$_POST['id'];//get the ID of user to delete
//    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    $sql="DELETE FROM users WHERE id=$deleteUserId ";//update it on table
    if ($con->query($sql) === TRUE){}else{// delete user and back to admin main page
        echo "Error deleting record: " . $con->error;
    }
    $sql="DELETE FROM teachers_courses WHERE id=$deleteUserId ";
    if ($con->query($sql) === TRUE){
    }else{// delete user and back to admin main page
        echo "Error deleting record: " . $con->error;
    }
    $sql="DELETE FROM teacher_cities WHERE id=$deleteUserId ";
    if ($con->query($sql) === TRUE){
    }else{// delete user and back to admin main page
        echo "Error deleting record: " . $con->error;
    }
    $sql="DELETE FROM images WHERE id=$deleteUserId ";
    if ($con->query($sql) === TRUE){
    }else{// delete user and back to admin main page
        echo "Error deleting record: " . $con->error;
    }
    header('location: AdminPage.php');
  }    
  if ($_POST['ImgId']){ // any changed on user IMAGE
    $AdminPutId=$_POST['ImgId'];
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
 
    //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $msg = "";
        if (isset($_POST['upload'])) { // Get image name         
          $image=$_FILES['image']['name'];          
          $image_text=mysqli_real_escape_string($con, $_POST['image_text']);// Get text
          $target="img/".basename($image);// image file directory
          $ThereIsImage=-1;
          $results = mysqli_query($con, "SELECT * FROM images");
			while ($rows=mysqli_fetch_array($results)){
				if ($rows['id']==$AdminPutId){
					if (($rows['image']!=null)||($rows['image']!='image')){
						$ThereIsImage=1;
					}
				}
			}
        $upDate="UPDATE `images` SET `image`='$image'WHERE id=$AdminPutId";
        $result = mysqli_query($con,$upDate);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
          $msg = "Image uploaded successfully";
        }else{
          $msg = "Failed to upload image";
        }
      }
  }  
  $username = ($_GET['ImgUsername']) ? $_GET['ImgUsername'] : $_POST['ImgUsername'];
        //$db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $results = mysqli_query($db, "SELECT * FROM users");
        //  varibale use to display user information for ADMIN 
        $ID=0;$firstName=" ";$lastName=" ";$email=" ";$price=" ";$status=" ";  $Phone=" ";$username=" ";$isTeacher=1;
        while ($row=mysqli_fetch_assoc($results)){ // get the details from teachers table
          if ($row['id']==$AdminPutId){
              $ID=$row['id'];
              $username=$row['username'];
              $firstName=$row['fname'];
              $lastName=$row['lname'];
              $email=$row['email'];
              $price=$row['price'];
              $status=$row['status'];
              $Phone=$row['phone'];
              if($row['setUserAs']=='student'){
                $isTeacher=-1;
              }
          }
        }
        $_SESSION['varname'] = $username;
?>
<!DOCTYPE html>
<html>
  <head><!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
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
    <nav class="navbar navbar-default"><!--navbar-->
      <div class="container">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-left">
            <li><a href="Hakita.php">יציאה</a></li>






            <!--
              
              
              
              <li><a href="logout.php">יציאה</a></li>
              
              --->
            <li><a href="AdminPage.php">עמוד המנהל</a></li>
          </ul>
          <div class="navbar-header navbar-right">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
          </button>
          </div>
        </div>
      </div>
    </nav><hr>
    <div class="container bootstrap snippet">
      <div class="row"><!--next section related to let ADMIN to update user information-->
        <div class="col-sm-10"><h1>עדכון פרטים לשם משתמש <?php echo $username ?></h1></div>
          <div class="col-sm-2">
          <a href="/users" class="pull-right">
            <?php
//              $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
              $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

              $resultOfUserImage = mysqli_query($con, "SELECT * FROM images");///get the user image
              while ($rows=mysqli_fetch_array($resultOfUserImage)){
                  if ($rows['id']==$ID){//wanted id
                    echo "<img src='img/".$rows['image']."'   class='img-circle img-responsive'>";
                  }
              }
            ?>
          </a>
        </div>
      </div>
      <div class="row">
        <div>            
          <div class="col-sm-9">
            <ul class="nav nav-tabs"><!--print username of user--></ul>              
            <div class="tab-content">
              <div class="tab-pane active" id="home"><hr>
                    <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                        <div class="form-group">
                          <div class="col-xs-12">
                            <label for="user_name"></label><!---hidden username use on update-->
                            <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-12">
                            <label for="id"></label><!---hidden id use on update-->
                            <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                          </div>
                        </div>
                        <div class="form-group">                          
                          <div class="col-xs-6">
                            <label for="last_name"><h4>שם משפחה</h4></label><!---lable use to  update last_name-->
                              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lastName?>" >
                          </div>
                        </div>
                        <div class="form-group">                          
                          <div class="col-xs-6">
                            <label for="first_name"><h4>שם פרטי</h4></label><!---lable use to  update first_name-->
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $firstName?>">
                          </div>
                        </div> 
                        <div class="form-group">                         
                          <div class="col-xs-6">
                            <label for="phone"><h4>   מספר טלפון    </h4></label><!---lable use to  update phone-->
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-6">
                            <label for="email"><h4>Email</h4></label><!---lable use to  update email-->
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">
                          </div>
                        </div>
                          <?php
                            if($isTeacher==1){//display just for teahers account <!---lable use to  update status and price-->
                              echo" <div class=\"form-group\"><div class=\"col-xs-6\"><label for=\"mobile\"><h4>סטטוס</h4></label><input type=\"text\" class=\"form-control\" name=\"status\" id=\"status\" placeholder=\" $status\" ></div></div>";
                              echo"<div class=\"form-group\"><div class=\"col-xs-6\"><label for=\"price\"><h4>מחיר לשעה</h4></label><input type=\"number\" class=\"form-control\" name=\"price\" placeholder=\" $price\"></div></div>";
                            }
                          ?>
                          <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="verifyPassword"><h4>אימות סיסמה</h4></label><!---lable use to  update password-->
                                <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה">
                            </div>
                          </div>  
                          <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="password"><h4>סיסמה</h4></label><!---lable use to  update password-->
                              <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                            </div>
                          </div> 
                          <?php
                            if($isTeacher==1){//display just for teahers account
                              echo ' <div class="form-group">
                              <div class="col-xs-6">
                                    <div style=" padding-top: 2%;">
                                      עירים
                                          ';
                                            echo "<SELECT name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple>";
                                            $results = mysqli_query($con, "SELECT * FROM cities");
                                            echo'<option >'.'בדוק את הערים הקימות'.'</option>';
                                            while ($rows=mysqli_fetch_array($results)){
                                                echo'<option>'.$rows['cityName'].'</option>';
                                            }
                                            echo"</SELECT><br/><br/>";
                                            echo"
                                      <input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\" />                                 
                                    <br/></div></div></div>
                                <div class=\"form-group\">
                              <div class=\"col-xs-6\">
                                    <div style=\" padding-top: 2%;\">
                                    קורסים
                                    ";  
                                          echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple>";
                                          $results = mysqli_query($con, "SELECT * FROM courses");
                                          echo'<option >'.'קורסים שמלמד'.'</option>';
                                          while ($rows=mysqli_fetch_array($results)){
                                              echo'<option>'.$rows['subject'].'</option>';
                                          }
                                          echo"</SELECT><br/><br/>";
                                      echo"<input type=\"hidden\" name=\"hidden_framework_courses\" id=\"hidden_framework_courses\"/>                 
                                    <br/></div></div></div>";
                           
                              }
                            ?>         
                      <div class="form-group"><!--save button-->
                        <div class="col-xs-12"><br>
                          <label for="Save"><h4></h4></label>
                          <input type="submit" name="Save" value="שמור">                              
                        </div></div>
                  </form>
            </div></div></div><!--/tab-content-->
            <div class="col-sm-3">
              <form method="POST" action="AdminControlPageEditOnUser.php" enctype="multipart/form-data">
                  <input type="hidden" class="form-control" name="ImgUsername" value="<?php echo $username?>">
                  <input type="hidden" class="form-control" name="ImgId" value="<?php echo $ID?>">
                  <input type="hidden" name="size" value="1000000"><hr><hr>
                  <h4>צרף תמונה חדשה....</h4>
                  <div class="chooseImg"><input class="file-path validate" type="file" name="image"></div>
                  <div><button type="submit" name="upload">שמור תמונה</button></div>
              </form><br><br>
            <form method="POST" action="AdminControlPageEditOnUser.php" enctype="multipart/form-data">
                <button name="deleteUserButton" class="btn btn-danger">מחק משתמש</button>
                <div class="form-group">
                    <div class="col-xs-12"><label for="id"></label>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                    </div>
                </div>
            </form><br><br>
            <?php
              if($isTeacher==-1){
                echo"
                <form method=\"POST\" action=\"AdminControlPageEditOnUser.php\" enctype=\"multipart/form-data\">
                <button name=\"changeFromStudentAccountToTeacherAccount\" class=\"btn btn-warning\"> שינוי לחשבון של מורה</button>
                <div class=\"form-group\">
                    <div class=\"col-xs-12\"><label for=\"id\"></label>
                        <input type=\"hidden\" class=\"form-control\" name=\"id\" value=\"$ID\">
                    </div>
                </div>
            </form>
                ";
              }
            ?>
      </div></div></div><!--/row-->
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
  if($('#framework').val() != ''){
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#hidden_framework').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }
  else{
   alert("נא לבחור עיר");
   return false;
  }
 });
});
$(document).ready(function(){
 $('.selectpicker').selectpicker();
 $('#frameworkCourse').change(function(){
  $('#hidden_framework_courses').val($('#frameworkCourse').val());
 });
 $('#multiple_select_form').on('Save', function(event){
  event.preventDefault();
  if($('#frameworkCourse').val() != ''){
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#hidden_framework_courses').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }else{
   return false;
  }
 });
});
</script>