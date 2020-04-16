<?php
/**
 * this file is the edit page for students.
 * on this page student can make change with basic information like:
 * 1- name 2- email 3- phone number 4- password and 5- his Image.
 * at the bottom of the page student found a button called(change account to a teacher account),
 * by click on this button will display a window on a screen like(alert), and then student 
 * will be have two options 1- contiue(change for a teacher account) 2- exit(back to student account).
 */
session_start();  

    $ID=$_SESSION['id'];//get the student id
    $_SESSION['id']=$ID;
    if(!$ID){//if there is no id, redirect to logout page to forget id and username, then to redirect to main page.
        header("location: logout.php");  
    }//else...
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");//connection with DB
    include 'userData.php';//calling userData to use many function as bellow
    
    if(isset($_POST['first_name'])||isset($_POST['last_name'])||
    isset($_POST['email'])||isset($_POST['phone'])||
    isset($_POST['password'])){//if student make change with his name/password/phone or email address
        $userMakeChange=1;//student yes make update
        if($_POST['first_name']){//if student update his first name
            updateFirstName($ID, $_POST['first_name']);//function on userData.php        
        }        
        if($_POST['last_name']){//if student update his last name
            updateLastName($ID, $_POST['last_name']);//function on userData.php  
        }
        if($_POST['email']){//if student update his email
            updateEmail($ID, $_POST['email']);//function on userData.php  
        }        
        if($_POST['password']){//if student update his password
            $invalidPass=Password($ID, $_POST['password'], $_POST['verifyPassword']);//function on userData.php  
        }
        if ($_POST['phone']){//if student update his phone number
            updatePhoneNumber($id, $_POST['phone']);//function on userData.php  
        }
    }   
  
    if(isset($_POST['upload'])){//if student update his image
        $userMakeChange=1;
        $image=$_FILES['image']['name'];
        updateImage($ID, $image,$_POST['image_text']);//function on userData.php  
    }
    $results=mysqli_query($con, "SELECT * FROM users");
    $firstName=" ";$lastName=" ";//varibale to show
    while($row=mysqli_fetch_assoc($results)){
        if($row['id']==$ID){
            $firstName=$row['fname'];$lastName=$row['lname'];//student name
        }
  }
  
  if(isset($_POST['changeAccountToTeacherAccountStepTwo'])){//change from student Account to teacher account into DB
    $upDate="UPDATE `users` SET `setUserAS`='teacher'WHERE id=$ID";//update new data on DB
    $IdResults = mysqli_query($con,$upDate);
    header("location: profile.php");//redirect to profile of teachers
  }
  if(isset($_POST['deleteAccountStepTwo'])){//delete student Account from DB  
    DeleteAccount($ID);//function on userData.php  
    header("location: logout.php");//if there is no id, redirect to logout page to forget id and username, then to redirect to main page.
  }
  if($userMakeChange==1){//if the student made any changes let ADMIN to know that. 
    $query="INSERT INTO `makeChange`(`id`) VALUES ('$ID')";
    $makeChangeEnter = mysqli_query($con,$query);
  }
?>
<!DOCTYPE html>
<html>
    <head>        
        <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
        <?php include 'header.php';?>  
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <link rel="stylesheet" type="text/css" href="css/studentProfile.css">   
        <?php
             if(isset($_POST['changeAccountToTeacherAccount'])){//when student want to changes his account from studetn to teacher account, will get a pop up message to continue the process or not.
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
              if(isset($_POST['deleteAccount'])){//when student want to delete his account, will get a pop up message to continue the process or not.
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
                <a class="navbar-brand" href="Hakita.php">הכיתה</a>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li>
                    <li class="nav-item active"><a class="nav-link" href="studentProfile.php">פרופיל שלי</a></li>  
                    <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a></li>
            </ul></div>
            </nav>
        </section>
        <div class="row"><!--next section is the inputs field--->
            <div class="col-sm-12"> 
                <form class="form" action="studentEdit.php" method="post" id="registrationForm">
                    <div class="form-group"> 
                        <div class="col-sm-6"><!---last name-->
                            <label for="last_name"><h4  class="inputTitle">שם משפחה</h4></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lastName?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6"><!---first name-->  
                            <label for="first_name"><h4  class="inputTitle">שם פרטי</h4></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $firstName?>" title="enter your first name if any.">
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6"><!---phone number-->
                            <label for="phone"><h4  class="inputTitle">   מספר טלפון    </h4></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo phoneNumber($ID)?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6"><!---email-->
                            <label for="email"><h4  class="inputTitle">Email</h4></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo email($ID)?>">                   
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-sm-6"><!---password-->
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
                    </div></div><br><br><br>        
                    <div class="form-group"><!---save button-->
                        <label for="Save"><h4></h4></label>
                        <input class="btn btn-primary" type="submit" name="Save" value="שמור">
                    </div>
                </form>
            </div><hr><hr>
            <div id="image" class="ImageSection"><!---iamge section-->
            <div class="row">  
            <div class="col-sm-12"> 
                <form method="POST" action="studentEdit.php" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <h4 class="inputImgTitle">לשנות תמונת פרופיל  </h4>
                    <div class="chooseImg">
                        <input class="file-path validate" type="file" name="image" id="imgSource">
                    </div><div><br>
                        <button  class="btn btn-primary" id="saveImageButton" type="submit" name="upload">שמור תמונה</button>
                    </div>
                </form>
        </div></div></div></div><br><br><br><br><br>
        <div class="row">  
            <div class="col-sm-6"><!----changeAccountToTeacherAccount()---->
                <form action="studentEdit.php" method="post"><input type="submit" name="changeAccountToTeacherAccount" class="btn btn-warning" id="changeAccountToTeacherAccountButton"  value="העברה לחשבון של מורה"></form>
            </div>
            <div class="col-sm-6"><!--delete account section-->
            <form action="studentEdit.php" method="post"><input type="submit" name="deleteAccount" class="btn btn-danger" id="deleteAccountButton" value="מחיקת חשבון"></form>
            </div>
        </div>     
        <?php include_once 'footer.php';/*display bottom footer*/?>
    </body>
</html>