<?php
/**
 * this file is the edit page for students.
 * on this page student can make change with basic information like:
 * 1- name 2- email 3- phone number 4- password and 5- his Image.
 * at the bottom of the page student found a button called(change account to a teacher account),
 * by click on this button will display a window on a screen like(alert), and then student 
 * will be have two options 1- contiue(change for a teacher account) 2- exit(back to student account).
 */
  //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//connection with DB
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

  session_start();  
  if(isset($_POST['first_name'])||isset($_POST['last_name'])||
  isset($_POST['email'])||isset($_POST['phone'])||
  isset($_POST['password'])){//if student make change with his name/password/phone or email address
    $ID=$_POST['id'];//get the id of student
    $userMakeChange=1;//student yes make update
    if ($_POST['first_name']){//if student update his first name
        $fName=$_POST['first_name'];//new first name
        $upDate="UPDATE `teachers` SET `fname`='$fName'WHERE id=$ID";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);            
    }        
    if ($_POST['last_name']){//if student update his last name
        $lName=$_POST['last_name'];//new last name
        $upDate="UPDATE `teachers` SET `lname`='$lName'WHERE id=$ID";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);
    }
    if ($_POST['email']){//if student update his email
        $Email=$_POST['email'];//new email
        $upDate="UPDATE `teachers` SET `email`='$Email'WHERE id=$ID";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);
    }        
    if ($_POST['password']){//if student update his password
        $invalidPass=-1;//variable use to check if the new student password is valid or not.
        if ($_POST['password']==$_POST['verifyPassword']){//check that the insert password equal to the verify password
            $uppercase = preg_match('@[A-Z]@', $_POST["password"]);//password need to include uppercase
            $lowercase = preg_match('@[a-z]@', $_POST["password"]);//password need to include lowercase
            $number = preg_match('@[0-9]@', $_POST["password"]);//password need to include number
            if(strlen($_POST["password"])<8){//if password is less than 8 chars-->wrong
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                  echo "<script type='text/javascript'>alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                      echo "<script type='text/javascript'>alert('סיסמה קצרה מדי');</script>";
                }
            }else if(strlen($_POST["password"])>16){//if the password string is bigger than 16 chars
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                    echo "<script type='text/javascript'> alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                    echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי'); </script>";
                }
            }else{
              if(!$uppercase || !$lowercase || !$number){//a valid length of password, but it's not include uppercase or lowercase chars
                  $invalidPass=1;
                  echo "<script type='text/javascript'>alert('הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }
            }
            if($invalidPass==-1){//if it's a valid password-->update it
              $pass=$_POST['password'];//new password
              $upDate="UPDATE `teachers` SET `password`='$pass'WHERE id=$ID";//update new data on DB
              $IdResults = mysqli_query($con,$upDate);
            }
        }
    }
    if ($_POST['phone']){//if student update his phone number
        $phone=$_POST['phone'];//new phone
        $upDate="UPDATE `teachers` SET `phone`='$phone'WHERE id=$ID";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);
    }
 }   
  if(isset($_POST['upload'])){//if student update his image
    $userMakeChange=1;
    $ID=$_POST['id'];//get the id of student
    //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    if (isset($_POST['upload'])) {// If image upload button is clicked ...
      $image = $_FILES['image']['name'];// Get image name
      $image_text = mysqli_real_escape_string($con, $_POST['image_text']);// Get text
      $target = "img/".basename($image);// image file directory
      $upDate="UPDATE `images` SET `image`='$image'WHERE id=$ID";//Update user image
      $resultsOfImageTable = mysqli_query($con,$upDate);
      move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }
  }//next section is to get the student information, for display it on edit page.
  $username = ($_GET['username']) ? $_GET['username'] : $_POST['username'];


  /*
  security side

   $ID=$_SESSION['id'];

                $_SESSION['id']=$ID;

   need to search by id and not by username

   */
  //$db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

  $results = mysqli_query($db, "SELECT * FROM users");
  $firstName=" ";$lastName=" ";$email=" ";$Phone=" ";//varibale to show
  while ($row=mysqli_fetch_assoc($results)){

    //if ($row['id']==$ID){
    if ($row['username']==$username){
        $ID=$row['id'];
        //$username=$row['username'];
        $firstName=$row['fname'];$lastName=$row['lname'];//student name
        $email=$row['email'];$Phone=$row['phone'];//student connection 
    }
  }
  //$db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

  if(isset($_POST['changeAccountToTeacherAccountStepTwo'])){//change from student Account to teacher account into DB
    $ID=$_POST['id'];//id of student that want to convert his/her account to a teacher account
    $upDate="UPDATE `users` SET `setUserAS`='teacher'WHERE id=$ID";//update new data on DB
    $IdResults = mysqli_query($db,$upDate);
    
                /*

                header("location: profile.php);


                */

    header("location: profile.php?id=".$ID);
  }
  if(isset($_POST['deleteAccountStepTwo'])){//delete student Account from DB
    $ID=$_POST['id'];//id of student that want to delete his/her account
    $sql = "DELETE FROM users WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM images WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM dBOfComments WHERE idOfCommentWriter=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM makeChange WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM teacherSchedule WHERE idOfStudent=$ID";
    if ($db->query($sql) === TRUE){
    }  
    header("location: Hakita.php"); 
    /*

                header("location: logout.php);

                
                */     
  }
  if($userMakeChange==1){//if the student made any changes let ADMIN to know that. 
    $query="INSERT INTO `makeChange`(`id`) VALUES ('$ID')";
    $makeChangeEnter = mysqli_query($db,$query);
  }
?>
<!DOCTYPE html>
<html>
    <head>        
         <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <title>הכיתה</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
        <link rel="stylesheet" type="text/css" href="css/studentProfile.css">   
        <?php
             if(isset($_POST['changeAccountToTeacherAccount'])){
                echo"<script>$(document).ready(function(){ $('#myModall').modal('show');});</script> ";
                echo"<li><div class=\"modal fade\" id=\"myModall\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                    <div class=\"modal-dialog\" role=\"document\"><div class=\"modal-content\">
                   <div class=\"modal-header\"><h4 class=\"modal-title\" id=\"myModalLabel\">כעת את/ה מנסה להפוך את החשבון הקיים מחשבון של סטודנט לחשבון של מורה </h4></div>
                   <form  name=\"feedbackForm\" action=\"studentEdit.php\" method=\"post\">";   
                       echo"<input name=\"id\" type=\"hidden\" value=\"$ID\">"; 
                       echo"<input name=\"changeAccountToTeacherAccountStepTwo\" type=\"hidden\" value=\"yes\">"; 
                       echo"<div class=\"modal-body\">
                       <fieldset><div class=\"text-center\"><input type=\"submit\" class=\"logSignButton btn btn-warning text-center\"  value=\"המשך \"></div></fieldset>
                   </form><br>
                   <button type=\"submit\" class=\"btn btn-info\" data-dismiss=\"modal\">יציאה</button>
                </div></div></div></div></li>";
              }
              if(isset($_POST['deleteAccount'])){
                echo"<script>$(document).ready(function(){ $('#myModall').modal('show');});</script> ";
                echo"<li><div class=\"modal fade\" id=\"myModall\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                    <div class=\"modal-dialog\" role=\"document\"><div class=\"modal-content\">
                   <div class=\"modal-header\"><h4 class=\"modal-title\" id=\"myModalLabel\">מחיקת חשבון באתר הכיתה, לפני הסרת חשבון עבור בעיה כלשהיא אפשר לפנות למנהל האתר. לחיצה על הכפתור המשך תגרום להסרת החשבון</h4></div>
                   <form  name=\"feedbackForm\" action=\"studentEdit.php\" method=\"post\">";   
                       echo"<input name=\"id\" type=\"hidden\" value=\"$ID\">"; 
                       echo"<input name=\"deleteAccountStepTwo\" type=\"hidden\" value=\"yes\">"; 
                       echo"<div class=\"modal-body\">
                       <fieldset><div class=\"text-center\"><input type=\"submit\" class=\"logSignButton btn btn-warning text-center\"  value=\"המשך \"></div></fieldset>
                   </form><br>
                   <button type=\"submit\" class=\"btn btn-info\" data-dismiss=\"modal\">יציאה</button>
                </div></div></div></div></li>";
              }
        ?>
    </head>
    <body>
        <section><!--navbar section-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button><!---next section for the navbar-->
                <?php
                    echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$ID\">הכיתה</a>";
                    echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
                    <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";
                    echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php?id=$ID\"> עמוד הבית</a></li>"; 
                    echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php?id=$ID\">פרופיל שלי</a></li>";
                
                /*
                    echo "<a class=\"navbar-brand\" href=\"Hakita.php\">הכיתה</a>";
                    echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
                    <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";
                    echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php\"> עמוד הבית</a></li>"; 
                    echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php\">פרופיל שלי</a></li>";
                
                
                 */
                ?>       
                <li class="nav-item active"><a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a></li>
               
               <!--

            <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a></li>
               

               -->
               
                </ul></div>
            </nav>
        </section>
        <div class="row">  <!--next section is the inputs field--->
            <div class="col-sm-12"> 
                <form class="form" action="studentEdit.php" method="post" id="registrationForm">
                    <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                    <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                    <div class="form-group"> 
                        <div class="col-sm-6"> <!---last name-->
                            <label for="last_name"><h4  class="inputTitle">שם משפחה</h4></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lastName?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">  <!---first name-->  
                            <label for="first_name"><h4  class="inputTitle">שם פרטי</h4></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $firstName?>" title="enter your first name if any.">
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">    <!---phone number-->
                            <label for="phone"><h4  class="inputTitle">   מספר טלפון    </h4></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">  <!---email-->
                            <label for="email"><h4  class="inputTitle">Email</h4></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">                   
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-sm-6">  <!---password-->
                            <label for="verifyPassword"><h4  class="inputTitle">אימות סיסמה</h4></label>
                            <?php
                              if($invalidPass==1){ //if student insert an invalid password
                                echo"<input type=\"password\" class=\"form-control border-danger\" name=\"verifyPassword\" id=\"verifyPassword\" placeholder=\"אימות הסיסמה החדשה\">";
                              }else{//normal mood assword
                                echo"<input type=\"password\" class=\"form-control\" name=\"verifyPassword\" id=\"verifyPassword\" placeholder=\"אימות הסיסמה החדשה\">";
                              }
                            ?>
                        </div>  
                    </div>    
                    <div class="form-group">  
                        <div class="col-sm-6">   <!---verify Password-->
                            <label for="password"><h4 class="inputTitle">סיסמה</h4></label>
                            <?php
                              if($invalidPass==1){//if student insert an invalid password
                                echo"<input type=\"password\" class=\"form-control border-danger\" name=\"password\" id=\"password\" placeholder=\"סיסמה חדשה\">";
                              }else{//normal mood assword
                                echo"<input type=\"password\" class=\"form-control\" name=\"password\" id=\"password\" placeholder=\"סיסמה חדשה\">";                                
                              }
                            ?>
                        </div> 
                    </div><br><br><br>        
                    <div class="form-group">  <!---save button-->
                        <label for="Save"><h4></h4></label>
                        <input class="btn btn-primary" type="submit" name="Save" value="שמור">
                    </div>
                </form>
            </div><hr><hr>
            <div id="image" class="ImageSection">  <!---iamge section-->
            <div class="row">  
            <div class="col-sm-12"> 
                <form method="POST" action="studentEdit.php" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                    <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                    <input type="hidden" name="size" value="1000000">
                    <h4  class="inputImgTitle">לשנות תמונת פרופיל  </h4>
                    <div class="chooseImg">
                        <input class="file-path validate" type="file" name="image" id="imgSource">
                    </div>
                    <div><br>
                        <button  class="btn btn-primary" id="saveImageButton" type="submit" name="upload">שמור תמונה</button>
                    </div>
                </form>
            </div>
        </div></div>
        </div>  <br><br><br><br><br>
        <div class="row">  
            <div class="col-sm-6"> <!----changeAccountToTeacherAccount()---->
            <form action="studentEdit.php" method="post">
                <input type="submit" name="changeAccountToTeacherAccount" class="btn btn-warning" id="changeAccountToTeacherAccountButton"  value="העברה לחשבון של מורה">
                <input type="hidden" name="username" value="<?php echo $username?>">
                <input type="hidden" name="id" value="<?php echo $ID?>">                    
            </form>
            </div>
            <div class="col-sm-6"><!--delete account section-->
            <form action="studentEdit.php" method="post">
                <input type="submit" name="deleteAccount" class="btn btn-danger" id="deleteAccountButton" value="מחיקת חשבון">
                <input type="hidden" name="username" value="<?php echo $username?>">
                <input type="hidden" name="id" value="<?php echo $ID?>">                    
            </form>
            </div>
        </div>     
       <footer class="w3-container w3-teal-black w3-center w3-margin-top">
            <div class="row">
            <div class="col-sm-5">
              &copy;כל הזוכיות שמורות לאתר הכיתה
              <a href="https://www.jce.ac.il/"></a><br>
                קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
              <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
            </div><br/>
            <div class="col-sm-3"> 📚           
              רשימת מקצועות לימוד<br>
              צור קשר איתנו📧  
            </div><br/>
            <div class="col-sm-4">        עקובו אחרינו ב-פייסבוק:-
                <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
            </div>
          </div>
        </footer>
    </body>
</html>