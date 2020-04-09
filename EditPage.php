<?php
/**
 * edit page for teachers, it's different from edit page for admin.
 */




    /**
     * 
     *  $ID=$_SESSION['id']
     *   $_SESSION['id']=$ID;
     * 
     * 
     * 
     * 
     * 
     * 
     */


//include this file for calling tables on DB 
  session_start();
  if(isset($_POST['deleteAccountStepTwo'])){//delete student Account from DB
    //$db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    $ID=$_POST['id'];//id of student that want to delete his/her account
    $sql = "DELETE FROM teachers WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM images WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM dBOfComments WHERE idOfCommentWriter=$ID OR idOfTeacher=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM makeChange WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }  
    $sql = "DELETE FROM teacherSchedule WHERE idOfStudent=$ID OR idOfTeacher=$ID";
    if ($db->query($sql) === TRUE){
    }   
    $sql = "DELETE FROM teacher_cities WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }     
    $sql = "DELETE FROM teachers_courses WHERE id=$ID";
    if ($db->query($sql) === TRUE){
    }  
    header("location: Hakita.php");  
       /**
     * 
   *header("location: logout.php"); 
     * 
     * 
     * 
     * 
     * 
     * 
     */    
  }
  //$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

  $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
  $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
  $IdResults = mysqli_query($con, "SELECT * FROM teachers");
  $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
  $resultsOfCities = mysqli_query($con, "SELECT * FROM cities");
  $makeChangeEnter = mysqli_query($con, "SELECT * FROM makeChange");
  $resultsOfCourses = mysqli_query($con, "SELECT * FROM courses");
//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
  function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){
    //$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//calling the DB
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    $returnData="";//data{cities or courses want to return}
    if($whatToReturn==5){//for courses
      $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");//calling the teachers_courses
        while ($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
          if ($rows['id']==$id){//found the wanted id
            if($rows['subject']!='subject'){
                $returnData.=$rows['subject'];break;
            }
          }	
        }
    }else{//for cities
      $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
      while ($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
          if ($rows['id']==$id){//found the wanted id
              if($rows['cities']!='cities'){
                  $returnData.=$rows['cities'];break;
              }			
          }		
      }
    }return $returnData;//return data     
  }
  function returnStringWithoutComma($new,$last){//function use to remove over comma's
    $new.=',';//addin a new comma, cause we going to add a new subject
    $new.=$last;//add the currently subject
    if(substr($new, -1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
      $new=rtrim($new, ",");
    }
    if(substr($new, 0, 1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
      $new=ltrim($new, $new[0]); 
    }return $new;//return data
  }
  function insertCitiesAndCoursesOnArray($subject,$arrayOfTeacherCoursesOrCities){//function use to return cities and courses on diffreents arrays, to use each index as a bottton of city or course
      $subject.=",ADD";//adding space to string
      $IndexOfArrayOfTeacher=0;
      $length=strlen($subject); //case we will get the cities or cources as a one string 
      $lastComma=0;        $counterOfDigits=0;        $ifFoundAComma=-1;        $howManyTimesFindComma=0;    
      for($q=0;$q<$length;$q++){
          if(substr($subject, $q, 1)==","){
              $ifFoundAComma=1;
              if($howManyTimesFindComma==0){
                $howManyTimesFindComma++;
                $arrayOfTeacherCoursesOrCities[$IndexOfArrayOfTeacher]=substr($subject, $lastComma,$q);
              }else{
                $arrayOfTeacherCoursesOrCities[$IndexOfArrayOfTeacher]=substr($subject, $lastComma,$counterOfDigits-1);                    
              }$IndexOfArrayOfTeacher++;  $counterOfDigits=0; $lastComma=$q+1;
          }
          if($ifFoundAComma==1){
            $counterOfDigits++;
          }   
      }return $arrayOfTeacherCoursesOrCities;
  }
  $userMakeChange=-1;//variable used to know if the user make any update on his information if yes--> let the admin know.
  //get any update data (by POST) to save it on table.{first/last name,phone number, email, password....}
  if(isset($_POST['first_name'])||isset($_POST['last_name'])||
  isset($_POST['email'])||isset($_POST['phone'])||
  isset($_POST['password'])||isset($_POST['verifyPassword'])||
  isset($_POST['price'])||isset($_POST['status'])||
  isset($_POST['hidden_framework'])||isset($_POST['hidden_framework_courses'])){
        $ID=$_POST['id'];//get the id of user
        $userMakeChange=1;//user yes make update
        if($_POST['first_name']){//if user update his first name
            $fName=$_POST['first_name'];//new first name
            $upDate="UPDATE `teachers` SET `fname`='$fName'WHERE id=$ID";//update new data on DB
            $IdResults = mysqli_query($con,$upDate);            
        }        
        if($_POST['last_name']){//if user update his last name
            $lName=$_POST['last_name'];//new last name
            $upDate="UPDATE `teachers` SET `lname`='$lName'WHERE id=$ID";//update new data on DB
            $IdResults = mysqli_query($con,$upDate);
        }
        if($_POST['email']){//if user update his email
            $Email=$_POST['email'];//new email
            $upDate="UPDATE `teachers` SET `email`='$Email'WHERE id=$ID";//update new data on DB
            $IdResults = mysqli_query($con,$upDate);
        }        
        if($_POST['password']){//if user update his password
            $invalidPass=-1;//variable use to check if the new user password is valid or not.
            $PasswordNavbar=1;//variable use to check if the new user password is valid or not.
            if($_POST['password']==$_POST['verifyPassword']){//check that the insert password equal to the verify password
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
                }elseif(strlen($_POST["password"])>16){//if the password string is bigger than 16 chars
                    $invalidPass=1;
                    if(!$uppercase || !$lowercase || !$number){
                        echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                    }else{
                        echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי');</script>";
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
        if($_POST['phone']){//if user update his phone number
          $phone=$_POST['phone'];//new phone
          $upDate="UPDATE `teachers` SET `phone`='$phone'WHERE id=$ID";//update new data on DB
          $IdResults = mysqli_query($con,$upDate);
        }  
        if($_POST['status']){//if user update his status.
          $status=$_POST['status'];//new status
          $upDate="UPDATE `teachers` SET `status`='$status'WHERE id=$ID";//update new data on DB
          $IdResults = mysqli_query($con,$upDate);
        }          
        if($_POST['price']){//if user update his price.
            $price=$_POST['price'];//new price
            $upDate="UPDATE `teachers` SET `price`='$price'WHERE id=$ID";//update new data on DB
            $IdResults = mysqli_query($con,$upDate);
        }          
        if($_POST['hidden_framework']){//when user add a new, we get teacher cities and add the new city
            $UploadCityOrCourse=1;//for navbar
            $Cities=$_POST['hidden_framework'];//new city
            if (strpos($_POST['Cities'],$Courses )!== false){}else{
              $Cities=returnStringWithoutComma($Cities,$_POST['Cities']);//function remove over comma's
              $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$ID";//update new data on DB
              $result = mysqli_query($con,$upDate);
          }           
        }
        if($_POST['hidden_framework_courses']){//if user update his courses learn
          $UploadCityOrCourse=1;//for navbar
            $Courses=$_POST['hidden_framework_courses']; 
            if (strpos($_POST['Courses'],$Courses ) !== false){}else{
              $Courses=returnStringWithoutComma($Courses,$_POST['Courses']);//function remove over comma's
              $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$ID";//update new data on DB
              $result = mysqli_query($con,$upDate);
            }            
        } 
    }      
    if($_POST['deleteCity']||$_POST['deleteCourses']){// when user click on any botton of cities or courses to delete it        
      $UploadCityOrCourse=1;//for navbar
      $ID=$_POST['id'];
      if($_POST['deleteCourses']){
        $Courses=$_POST['Courses'];
        $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
        $deleteCourses=$_POST['deleteCourses'];
        $Courses = trim(str_replace($deleteCourses,'',$Courses));
        if(strpos($Courses,',,' ) !== false){
          $Courses = trim(str_replace(',,',',',$Courses));
        }
        if(substr($Courses, -1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Courses=rtrim($Courses, ",");
        }
        if(substr($Courses, 0, 1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Courses=ltrim($Courses, $Courses[0]); 
        }        
        $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$ID";//update new data on DB
        $result = mysqli_query($con,$upDate);
      }else{
        $Cities=$_POST['Cities'];
        $deleteCity=$_POST['deleteCity'];       
        $Cities = trim(str_replace($deleteCity,'',$Cities));
        if(strpos($Cities,',,' ) !== false){
          $Cities = trim(str_replace(',,',',',$Cities));
        }
        if(substr($Cities, -1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Cities=rtrim($Cities, ",");
        }
        if(substr($Cities, 0, 1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Cities=ltrim($Cities, $Cities[0]); 
        }
        $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
        $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$ID";//update new data on DB
        $result = mysqli_query($con,$upDate);        
      }
  }
  if($userMakeChange==1){//this table used for admin, to check which user make any update
      $query="INSERT INTO `makeChange`(`id`) VALUES ('$ID')";
      $makeChangeEnter = mysqli_query($con,$query);
  }  
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

  //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  if(isset($_POST['upload'])){// If image upload button is clicked ...
    $image=$_FILES['image']['name'];// Get image name
    $image_text=mysqli_real_escape_string($con, $_POST['image_text']);// Get text
    $target="img/".basename($image);// image file directory
    $upDate="UPDATE `images` SET `image`='$image'WHERE id=$ID";//Update user image
    $resultsOfImageTable = mysqli_query($con,$upDate);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
  }/// to get the details about user and show them. start by getting username and search about him on table of DB. 
  
  
  
  $username=($_GET['username']) ? $_GET['username'] : $_POST['username'];
  
  
    /**
     * 
     *  $ID=$_SESSION['id']
     *   $_SESSION['id']=$ID;
     * 
     * 
     * 
     * 
     * 
     * 
     */
    $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

  ///$db=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  $results=mysqli_query($db, "SELECT * FROM users");
  //  varibales to use and show 
  $ID=0;$userFirstName=" ";$userLastName=" ";$email=" ";$teacherPrice=" ";$teacherStatus=" ";$Phone=" ";
  while($row=mysqli_fetch_assoc($results)){// get the details from user table
    if($row['username']==$username){
    //if($row['id']==$ID){
      $ID=$row['id'];

      ////$username=$row['username'];
      $userFirstName=$row['fname'];$userLastName=$row['lname'];//teacher name
      $email=$row['email'];$Phone=$row['phone'];//teacher connection
      $teacherPrice=$row['price'];$teacherStatus=$row['status'];        
    }
  }
?>
<!DOCTYPE html>
<html>
    <head><!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
      <meta charset="utf-8">
      <title>הכיתה</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="css/TeacherEdit.css">
      <?php
        if(isset($_POST['deleteAccount'])){
          echo"<script>$(document).ready(function(){ $('#myModall').modal('show');});</script> ";
          echo"<li><div class=\"modal fade\" id=\"myModall\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
              <div class=\"modal-dialog\" role=\"document\"><div class=\"modal-content\">
             <div class=\"modal-header\"><h4 class=\"modal-title\" id=\"myModalLabel\">מחיקת חשבון באתר הכיתה, לפני הסרת חשבון עבור בעיה כלשהיא אפשר לפנות למנהל האתר. לחיצה על הכפתור המשך תגרום להסרת החשבון</h4></div>
             <form  name=\"feedbackForm\" action=\"EditPage.php\" method=\"post\">";   
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
            </button>
              <?php
                  echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$ID\">הכיתה</a>";
                  echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
                  <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";
                  echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php?id=$ID\"> עמוד הבית</a></li>"; 
                  echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php?id=$ID\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li>";
              /*

                echo "<a class=\"navbar-brand\" href=\"Hakita.php\">הכיתה</a>";
                  echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
                  <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";
                  echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php"> עמוד הבית</a></li>"; 
                  echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li>";
              

              */
              
              
              ?>       
                <li class="nav-item active"><a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a></li></ul>
            <!--


    <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a></li></ul>
            

            -->
            
            
            
            </div>
          </nav>
    </section>
      <a id="button"></a>
      <section class="choose">
        <div class="container">                      
          <?php
            echo"<div class=\"row\">";//deffrent navbar default page according to what user upload
            if($PasswordNavbar){//if user upload his password
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('profile', this, 'orange')\">הגדרות פרופיל</button>";
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('Account', this, 'blueviolet')\"id=\"defaultOpen\">הגדרת חשבון</button>";
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('citiesAndCourses', this, 'orange')\">קורסים ועירים</button>";
            }elseif($UploadCityOrCourse){//if user upload his couses or his cities
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('profile', this, 'orange')\">הגדרות פרופיל</button>";
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('Account', this, 'blueviolet')\">הגדרת חשבון</button>";
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('citiesAndCourses', this, 'orange')\"id=\"defaultOpen\">קורסים ועירים</button>";
            }else{//default navbar main page, enter to edit page
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('profile', this, 'orange')\"id=\"defaultOpen\">הגדרות פרופיל</button>";
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('Account', this, 'blueviolet')\">הגדרת חשבון</button>"; 
              echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('citiesAndCourses', this, 'orange')\">קורסים ועירים</button>";                     
            } 
            echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('Links', this, 'blueviolet')\">קישורים</button>";                 
          ?>
        </div>
      </div><!--next section, input for user, like first/last name, etc.....-->
      <div id="profile" class="tabcontent">  
          <form class="form" action="EditPage.php" method="post" id="registrationForm"><!--  show the detail of user that get from DB, use hidden username and id to update data -->
            <div class="form-group"><!--Bootstrap desgin-->
                <div class="col-xs-12"><!--Bootstrap desgin-->
                    <label for="user_name"></label><input type="hidden" class="form-control" name="username" value="<?php echo $username?>"><!--used for POST, to get the username and update data according it-->
                </div>
            </div>
            <div class="form-group"><!--Bootstrap desgin-->
                <div class="col-xs-12"><!--Bootstrap desgin-->
                    <label for="id"></label><input type="hidden" class="form-control" name="id" value="<?php echo $ID?>"><!--send the id of user, using on update-->
                </div>
            </div>
            <div class="form-group"><!--Bootstrap desgin-->
                <div class="col-sm-6"><!--Bootstrap desgin-->
                  <label for="last_name"><h4  class="inputTitle">שם משפחה</h4></label>
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $userLastName?>"  title="שם משפחה">
                </div>
          </div>
            <div class="form-group"><!--Bootstrap desgin-->
                <div class="col-sm-6"><!--Bootstrap desgin-->
                    <label for="first_name"><h4  class="inputTitle">שם פרטי</h4></label>
                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $userFirstName?>" title="שם פרטי">
                </div> 
            </div>
            <div class="form-group"><!--Bootstrap desgin-->
                <div class="col-sm-6"><!--Bootstrap desgin--> 
                    <label for="phone"><h4  class="inputTitle">   מספר טלפון    </h4></label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>" title="מספר טלפון ">
                </div>
            </div>
          <div class="form-group"><!--Bootstrap desgin-->
            <div class="col-sm-6"><!--Bootstrap desgin-->
                    <label for="email"><h4  class="inputTitle">Email</h4></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>" title=" דואר אלקטרוני">                   
            </div>
          </div>                  
          <?php
              echo"<div class=\"form-group\">
                  <div class=\"col-sm-6\"> 
                    <label for=\"status\"><h4 class=\"inputTitle\">סטטוס</h4></label>
                    <input type=\"text\" class=\"form-control\" name=\"status\" id=\"status\" placeholder=\" $teacherStatus\">
                  </div>
              </div>";
              echo "<div class=\"form-group\">
                <div class=\"col-sm-6\"> 
                  <label for=\"price\"><h4  class=\"inputTitle\">מחיר לשעה</h4></label>
                  <input type=\"number\" class=\"form-control\" name=\"price\" placeholder=\" $teacherPrice\">                   
                </div>
              </div>";
          ?>                
        <div class="form-group"><br>
          <label for="Save"><h4></h4></label>
          <input class="btn btn-primary" type="submit" name="Save" value="שמור">
        </div>
      </form>
      <div id="image" class="ImageSection"><!--update image-->                  
        <form method="POST" action="EditPage.php" enctype="multipart/form-data">
          <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
          <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
          <input type="hidden" name="size" value="1000000"><hr><hr>
          <h4 class="inputImgTitle">לשנות תמונת פרופיל  </h4>
          <div class="chooseImg">
            <input class="file-path validate" type="file" name="image" id="imgSource">
          </div><div><br>
            <button  class="btn btn-primary" id="saveImageButton" type="submit" name="upload">שמור תמונה</button>
          </div>
        </form>
        </div>
      </div>
      <div id="Account" class="tabcontent"><!--update password-->                
        <form class="passwordForm" action="EditPage.php" method="post" id="registrationForm">
          <div class="form-group">
            <div class="col-xs-12">
              <label for="user_name"></label><input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
            </div>
          </div>
          <div class="form-group">
              <div class="col-xs-12">
                <label for="id"></label><input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
              </div>
            </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label for="id"></label><input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
            </div>
          </div>
          <div class="form-group">  
            <div class="col-sm-12"> 
              <label for="password"><h4 class="inputTitle">סיסמה חדשה</h4></label>
              <?php
                if($PasswordNavbar){
                  echo "<input type=\"password\" class=\"form-control border-danger\" name=\"password\" id=\"password\" placeholder=\"סיסמה חדשה\" style=\"max-width:50%;\">";
                }else{
                  echo "<input type=\"password\" class=\"form-control\" name=\"password\" id=\"password\" placeholder=\"סיסמה חדשה\" style=\"max-width:50%;\">";
                }
              ?>
            </div>
          </div>
          <div class="form-group"> 
            <div class="col-sm-12">  
              <label for="verifyPassword"><h4  class="inputTitle">אימות סיסמה חדשה</h4></label>
              <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה" style="max-width:50%;">
            </div>
          </div>
          <div class="form-group"><br>
            <label for="Save"><h4></h4></label>
            <input class="btn btn-light" type="submit" name="Save" value="שמור">
          </div>
        </form>
        <div class="form-group">  
        <form action="EditPage.php" method="post">
                <input type="submit" name="deleteAccount" class="btn btn-danger" id="deleteAccountButton" value="מחיקת חשבון">
                <input type="hidden" name="username" value="<?php echo $username?>">
                <input type="hidden" name="id" value="<?php echo $ID?>">                    
            </form>
        </div>
      </div><!--for teachers update cities and courses//teacher can delete any course/city he already choose, also to add anew city/course-->
      <div id="citiesAndCourses" class="tabcontent">
          <form method="POST" action="EditPage.php" enctype="multipart/form-data">                   
            <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
            <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
            <?php
              $Cities=returnTeacherCitiesOrCoursesIntoArray($ID,3);
              $Courses=returnTeacherCitiesOrCoursesIntoArray($ID,5); 
              $Courses=returnTeacherCitiesOrCoursesIntoArray($ID,5);//courses 
              $arrayOfTeacherCourses=array();
              $arrayOfTeacherCourses=insertCitiesAndCoursesOnArray($Courses,$arrayOfTeacherCourses);
              $Cities=returnTeacherCitiesOrCoursesIntoArray($ID,3);//cities
              $arrayOfTeacherCities=array();	
              $arrayOfTeacherCities=insertCitiesAndCoursesOnArray($Cities,$arrayOfTeacherCities);                     
            ?>
            <div class="form-group">
              <div class="col-sm-12">
                <div style="padding-top: 2%;">
                  <?php
                    echo"<input type=\"hidden\" name=\"id\" value=\"$ID\">";
                    echo'<div class="form-group">
                    <div class="col-sm-12"><h1 style="color:black">נמצא ב:-
                    '.$Cities.'</h1></div><hr><hr>';
                    echo"<div class=\"col-sm-12\" id=\"cityButtons\">";
                    echo'<h3 style="color:black">לחץ על הכפתור להוריד אותו מהנתונים </h3>';
                    echo"<input type=\"hidden\" name=\"Cities\"  value=\"$Cities\">";
                    if(count($arrayOfTeacherCities)>0) {//print cities that teacher live in as a buttons, that click on it redirect student to show more teachers on the same city
                      for($ci=0;$ci<count($arrayOfTeacherCities);$ci++){
                          //echo "<input  class=\"courseButtons btn btn-info\" type=\"submit\" name=\"hidden_framework\" value=\"$arrayOfTeacherCities[$ci]\">";
                          echo "<input class=\"courseButtons btn btn-info\" type=\"submit\" name=\"deleteCity\" value=\"$arrayOfTeacherCities[$ci]\">";
                      }
                    }                                    
                    echo'</div></div><br><br><br><h3 style="color:black">הוספת עיר חדשה </h3>';
                    echo"<SELECT name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple style=\"max-width:50%;\">";
                    $results = mysqli_query($con, "SELECT * FROM cities");
                    echo'<option >'.'בדוק את הערים הקימות'.'</option>';
                    while ($rows=mysqli_fetch_array($results)){
                        echo'<option>'.$rows['cityName'].'</option>';
                    }
                    echo"</SELECT>";
                  ?>
                  <input type="hidden" name="hidden_framework" id="hidden_framework"/><br/>
                </div>
              </div>  
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div style=" padding-top: 2%;"><hr><hr>
                  <?php
                    echo '<div class="form-group">
                      <div class="col-sm-12"><h1 style="color:black">מלמד:-  '.$Courses.'</h1></div></div><hr><hr>';                                    
                    echo "<div class=\"col-sm-12\" id=\"courseButtons\">";
                    echo'<h3 style="color:black">לחץ על הכפתור להוריד אותו מהנתונים </h3>';
                    echo "<input type=\"hidden\" name=\"Courses\" value=\"$Courses\">";
                    if(count($arrayOfTeacherCourses)>0){//print courses that teacher learn as a buttons, that click on it redirect student to show more teachers learn the same subject
                      for($ci=0;$ci<count($arrayOfTeacherCourses);$ci++){
                        $r=$arrayOfTeacherCourses[$ci];
                        echo "<input  class=\"courseButtons btn btn-info\" type=\"submit\" name=\"deleteCourses\" value=\"$arrayOfTeacherCourses[$ci]\">";
                      }
                    }
                     echo '</div><br><br><br><h3 style="color:black">הוספת קורס חדש </h3>';
                    echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple style=\"max-width:50%;\">";
                    $results = mysqli_query($con, "SELECT * FROM courses");
                    echo'<option >'.'בדוק את המקצועות הקיימים  '.'</option>';
                    while ($rows=mysqli_fetch_array($results)){
                        echo'<option>'.$rows['subject'].'</option>';
                    }
                    echo"</SELECT>";
                  ?><br/><br/>
                <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses" /><br/>
              </div>
            </div>  
          </div>
          <div class="form-group"><br>
            <label for="Save"><h4></h4></label>
            <input class="btn btn-info" id="citiesAndCoursesSaveButton" type="submit" name="Save" value="שמור">
          </div>
        </form>
      </div>
        <div id="Links" class="tabcontent"><!--let teacher to add links-->
            <form class="form" action="EditPage.php" method="post" id="registrationForm">
            <div class="form-group">
              <div class="col-sm-6">  
                <label for="facebook"><div class="fa fa-facebook"></div></label><input type="text" class="form-control" name="facebook" placeholder="">  
              </div>                
            </div>
            <div class="form-group">
            <div class="col-sm-6">  
              <label for="linkedin"><div class="fa fa-linkedin"></div></label><input type="text" class="form-control" name="linkedin" placeholder="">                   
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">  
                <label for="youtube"></h4><div class="fa fa-youtube"></div></label><input type="text" class="form-control" name="youtube" placeholder="">                   
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">  
                <label for="otherLinkOne"><h4  class="inputTitleIcon">קישור אחר</h4></label><input type="text" class="form-control" name="otherLinkOne" placeholder="">                   
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">  
                <label for="otherLinkTwo"><h4  class="inputTitleIcon">קישור אחר</h4></label>
                <input type="text" class="form-control" name="otherLinkTwo" placeholder="">                   
              </div>
          </div>
            <div class="form-group"><br>
              <label for="Save"><h4></h4></label>
              <input class="btn btn-secondary" id="iconsSaveButton" type="submit" name="Save" value="שמור">
            </div>
        </form>
      </div>
    <div>                  
    </div>
  </section>
    <footer class="w3-container w3-teal-black w3-center w3-margin-top">
        <div class="row" style="max-width:99%;">
        <div class="col-sm-5">
          &copy;כל הזוכיות שמורות לאתר הכיתה
          <a href="https://www.jce.ac.il/"></a><br>
            קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
        </div>        
        <div class="col-sm-3"> 📚           
          רשימת מקצועות לימוד<br>
          צור קשר איתנו📧  
        </div><br/>
        <div class="col-sm-4">        עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
        </div><br/>
      </div>
    </footer>
    </body>
</html> 
<script>
  function openPage(pageName,elmnt,color) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < tablinks.length; i++) {
          tablinks[i].style.backgroundColor = "";
      }
      document.getElementById(pageName).style.display = "block";
      elmnt.style.backgroundColor = color;
  } // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();//for up button
  var btn = $('#button');
  $(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
      btn.addClass('show');
  } else {
      btn.removeClass('show');
  }
  });
  btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
  });
  $(document).ready(function(){//use to select from two list's of cities and courses-->return the value of select
 $('.selectpicker').selectpicker();
 $('#framework').change(function(){
  $('#hidden_framework').val($('#framework').val());
 });
 $('#frameworkCourse').change(function(){
  $('#hidden_framework_courses').val($('#frameworkCourse').val());
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
  }else if($('#frameworkCourse').val() != ''){
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
   alert("נא לבחור עיר");
   return false;
  }
 }); 
});
</script>