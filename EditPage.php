<?php
//edit page for teachers, update his informations, city/cours.
session_start();
  $ID=$_SESSION['id'];//get the teacher id.
  $_SESSION['id']=$ID;
  include 'userData.php';//calling this file to get some teacher information like name,... 
  
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
  if(isset($_POST['deleteAccountStepTwo'])){//delete student Account from DB
    DeleteAccount($ID);
    header("location: logout.php");    
  }

  $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
  $resultsOfCities = mysqli_query($con, "SELECT * FROM cities");
  $makeChangeEnter = mysqli_query($con, "SELECT * FROM makeChange");
  $resultsOfCourses = mysqli_query($con, "SELECT * FROM courses");

//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
  function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $returnData="";//data{cities or courses want to return}
    if($whatToReturn==5){//for courses
      $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");//calling the teachers_courses
        while($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
          if($rows['id']==$id){//found the wanted id
            if($rows['subject']!='subject'){
              $returnData.=$rows['subject'];break;
            }
          }	
        }
    }else{//for cities
      $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
      while($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
          if($rows['id']==$id){//found the wanted id
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
          if($ifFoundAComma==1){$counterOfDigits++;}   
      }return $arrayOfTeacherCoursesOrCities;
  }

  $userMakeChange=-1;//variable used to know if the user make any update on his information if yes--> let the admin know.
  //get any update data (by POST) to save it on table.{first/last name,phone number, email, password....}
  if(isset($_POST['first_name'])||isset($_POST['last_name'])||
  isset($_POST['email'])||isset($_POST['phone'])||$_POST['phoneTwo']||
  isset($_POST['password'])||isset($_POST['verifyPassword'])||
  isset($_POST['price'])||$_POST['priceTwo']||isset($_POST['status'])||
  isset($_POST['hidden_framework'])||isset($_POST['hidden_framework_courses'])){
        $userMakeChange=1;//user yes make update
        if($_POST['first_name']){//if user update his first name
          updateFirstName($ID, $_POST['first_name']);             
        }        
        if($_POST['last_name']){//if user update his last name
          updateLastName($ID, $_POST['last_name']);
        }
        if($_POST['email']){//if user update his email
          updateEmail($ID, $_POST['email']);
        }        
        if($_POST['password']){//if user update his password
          $invalidPass=Password($ID, $_POST['password'], $_POST['verifyPassword']);
        }
        if($_POST['phone']){//if user update his phone number
          updatePhoneNumber($ID, $_POST['phone']);
        }  
        if($_POST['phoneTwo']){//if user update his phone number
          updatePhoneNumberTwo($ID, $_POST['phoneTwo']);
        }  
        if($_POST['status']){//if user update his status.
          updateStatus($ID,$_POST['status']);//new status          
        }          
        if($_POST['price']){//if user update his price.
          updatePrice($ID,$_POST['price']);//new price            
        } 
        if($_POST['priceTwo']){//if user update his price.
          updatePriceTwo($ID,$_POST['priceTwo']);//new price            
        }          
        if($_POST['hidden_framework']){//when user add a new, we get teacher cities and add the new city
            $UploadCityOrCourse=1;//for navbar
            $Cities=$_POST['hidden_framework'];//new city
            if(strpos($_POST['Cities'],$Courses )!==false){}else{
              $Cities=returnStringWithoutComma($Cities,$_POST['Cities']);//function remove over comma's
              $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$ID";//update new data on DB
              $result=mysqli_query($con,$upDate);
          }           
        }
        if($_POST['hidden_framework_courses']){//if user update his courses learn
          $UploadCityOrCourse=1;//for navbar
            $Courses=$_POST['hidden_framework_courses']; 
            if(strpos($_POST['Courses'],$Courses )!==false){}
            else{
              $Courses=returnStringWithoutComma($Courses,$_POST['Courses']);//function remove over comma's
              $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$ID";//update new data on DB
              $result=mysqli_query($con,$upDate);
            }            
        } 
    }      
    if($_POST['deleteCity']||$_POST['deleteCourses']){// when user click on any botton of cities or courses to delete it        
      $UploadCityOrCourse=1;//for navbar
      if($_POST['deleteCourses']){
        $Courses=$_POST['Courses'];
        $CoursesOfTeachersResults=mysqli_query($con, "SELECT * FROM teachers_courses");
        $deleteCourses=$_POST['deleteCourses'];
        $Courses=trim(str_replace($deleteCourses,'',$Courses));
        if(strpos($Courses,',,' )!==false){
          $Courses=trim(str_replace(',,',',',$Courses));
        }
        if(substr($Courses, -1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Courses=rtrim($Courses, ",");
        }
        if(substr($Courses, 0, 1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Courses=ltrim($Courses, $Courses[0]); 
        }        
        $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$ID";//update new data on DB
        $result=mysqli_query($con,$upDate);
      }else{
        $Cities=$_POST['Cities'];
        $deleteCity=$_POST['deleteCity'];       
        $Cities=trim(str_replace($deleteCity,'',$Cities));
        if(strpos($Cities,',,' )!==false){
          $Cities=trim(str_replace(',,',',',$Cities));
        }
        if(substr($Cities, -1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Cities=rtrim($Cities, ",");
        }
        if(substr($Cities, 0, 1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $Cities=ltrim($Cities, $Cities[0]); 
        }
        $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
        $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$ID";//update new data on DB
        $result=mysqli_query($con,$upDate);        
      }
  }
  if($userMakeChange==1){//this table used for admin, to check which user make any update
      $query="INSERT INTO `makeChange`(`id`) VALUES ('$ID')";
      $makeChangeEnter=mysqli_query($con,$query);
  }  
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
  if(isset($_POST['upload'])){// If image upload button is clicked ...
    $userMakeChange=1;
    $image=$_FILES['image']['name'];
    updateImage($ID, $image,$_POST['image_text']);
  }/// to get the details about user and show them. start by getting. 
  //varibales to use and show 
  $userFirstName=" ";$userLastName=" ";$teacherStatus=" ";$PhoneTwo=" ";
  if(!$ID){//no user, logout
    header('location: Logout.php');
  }else{
    $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $results=mysqli_query($db, "SELECT * FROM users");
    while($row=mysqli_fetch_assoc($results)){//get the details from user table
      if($row['id']==$ID){
        $userFirstName=$row['fname'];$userLastName=$row['lname'];//teacher name
        $teacherStatus=$row['status'];    
        $PhoneTwo=$row['phoneTwo'];   
      }
    }
  }
  
?>
<!DOCTYPE html>
<html>
    <head><!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
      <?php include 'header.php';?>        
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
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
              <a class="navbar-brand" href="Hakita.php">הכיתה</a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li>
                <li class="nav-item active"><a class="nav-link" href="profile.php">פרופיל שלי <span class="sr-only">(current)</span></a></li>
                <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a></li></ul>
            </div>
          </nav>
    </section>
      <a id="button"></a>
      <section class="choose">
        <div class="container">                      
          <?php
            echo"<div class=\"row\">";//deffrent navbar default page according to what user upload
            if($PasswordNavbar){//if user upload his password
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('profile', this, 'orange')\">הגדרות פרופיל</button>";
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('Account', this, 'blueviolet')\"id=\"defaultOpen\">הגדרת חשבון</button>";
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('citiesAndCourses', this, 'orange')\">קורסים ועירים</button>";
            }elseif($UploadCityOrCourse){//if user upload his couses or his cities
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('profile', this, 'orange')\">הגדרות פרופיל</button>";
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('Account', this, 'blueviolet')\">הגדרת חשבון</button>";
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('citiesAndCourses', this, 'orange')\"id=\"defaultOpen\">קורסים ועירים</button>";
            }else{//default navbar main page, enter to edit page
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('profile', this, 'orange')\"id=\"defaultOpen\">הגדרות פרופיל</button>";
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('Account', this, 'blueviolet')\">הגדרת חשבון</button>"; 
              echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('citiesAndCourses', this, 'orange')\">קורסים ועירים</button>";                     
            } 
            echo"<button class=\"tablink col-sm-3\" onclick=\"openPage('Links', this, 'blueviolet')\">קישורים</button>";                 
          ?>
        </div>
      </div><!--next section, input for user, like first/last name, etc.....-->
      <div id="profile" class="tabcontent">  
          <form class="form" action="EditPage.php" method="post" id="registrationForm"><!--  show the detail of user that get from DB-->
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
                    <input type="text" class="form-control" name="phoneTwo" id="phoneTwo" placeholder="<?php echo $PhoneTwo?>" title="מספר טלפון ">
                </div>
            </div>
            <div class="form-group"><!--Bootstrap desgin-->
                <div class="col-sm-6"><!--Bootstrap desgin--> 
                    <label for="phone"><h4  class="inputTitle">   מספר טלפון    </h4></label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo phoneNumber($ID)?>" title="מספר טלפון ">
                </div>
            </div>
          <div class="form-group"><!--Bootstrap desgin-->
            <div class="col-sm-6"><!--Bootstrap desgin-->
              <label for="email"><h4  class="inputTitle">Email</h4></label>
              <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo email($ID)?>" title=" דואר אלקטרוני">                   
            </div>
          </div>   
          <div class="form-group"><div class="col-sm-6"> 
            <label for="status"><h4 class="inputTitle">סטטוס</h4></label>
            <input type="text" class="form-control" name="status" id="status" placeholder="מחיר מתחיל">
          </div></div>
          <div class="form-group"><div class="col-sm-6"> <!--price of lesson until-->
              <label for="price"><h4  class="inputTitle">מחיר עד</h4></label>
              <input type="number" class="form-control" name="priceTwo" placeholder="מחיר עג">                   
          </div></div>  
          <div class="form-group"><div class="col-sm-6"> <!--price of lesson start with coast-->
              <label for="price"><h4  class="inputTitle">מחיר מתחיל לשעה</h4></label>
              <input type="number" class="form-control" name="price" placeholder="<?php echo $teacherPrice ?>">                   
          </div></div>                      
        <div class="form-group"><br>
          <label for="Save"><h4></h4></label>
          <input class="btn btn-primary" type="submit" name="Save" value="שמור">
        </div>
      </form>
      <div id="image" class="ImageSection"><!--update image-->                  
        <form method="POST" action="EditPage.php" enctype="multipart/form-data">
          <input type="hidden" name="size" value="1000000"><hr><hr>
          <h4 class="inputImgTitle">לשנות תמונת פרופיל</h4>
          <div class="chooseImg">
            <input class="file-path validate" type="file" name="image" id="imgSource">
          </div><div><br>
            <button  class="btn btn-primary" id="saveImageButton" type="submit" name="upload">שמור תמונה</button>
          </div>
        </form>
        </div>
      </div>
      <div id="Account" class="tabcontent"><!--update password-->                
        <form class="passwordForm" action="EditPage.php" method="post" id="registrationorm">
          <div class="form-group">  
            <div class="col-sm-12"> 
              <label for="password"><h4 class="inputTitle">סיסמה חדשה</h4></label>
              <?php
                if($PasswordNavbar){echo "<input type=\"password\" class=\"form-control border-danger\" name=\"password\" id=\"password\" placeholder=\"סיסמה חדשה\" style=\"max-width:50%;\">";}
                else{echo"<input type=\"password\" class=\"form-control\" name=\"password\" id=\"password\" placeholder=\"סיסמה חדשה\" style=\"max-width:50%;\">";}
              ?>
            </div>
          </div>
          <div class="form-group"> 
            <div class="col-sm-12"><!--verify Password-->  
              <label for="verifyPassword"><h4  class="inputTitle">אימות סיסמה חדשה</h4></label>
              <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה" style="max-width:50%;">
            </div>
          </div>
          <div class="form-group"><br><!--save new details button-->  
            <label for="Save"><h4></h4></label>
            <input class="btn btn-light" type="submit" name="Save" value="שמור">
          </div>
        </form>
        <div class="form-group"><!--delete account button-->  
        <form action="EditPage.php" method="post">
          <input type="submit" name="deleteAccount" class="btn btn-danger" id="deleteAccountButton" value="מחיקת חשבון">                 
        </form>
        </div>
      </div><!--for teachers update cities and courses//teacher can delete any course/city he already choose, also to add anew city/course-->
      <div id="citiesAndCourses" class="tabcontent">
          <form method="POST" action="EditPage.php" enctype="multipart/form-data">                   
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
                    echo'<div class="form-group">
                    <div class="col-sm-12"><h1 style="color:black">נמצא ב:- '.$Cities.'</h1></div><hr><hr>';
                    echo"<div class=\"col-sm-12\" id=\"cityButtons\">";
                    echo'<h3 style="color:black">לחץ על הכפתור להוריד אותו מהנתונים </h3>';
                    echo"<input type=\"hidden\" name=\"Cities\"  value=\"$Cities\">";
                    if(count($arrayOfTeacherCities)>0) {//print cities that teacher live in as a buttons, that click on it redirect student to show more teachers on the same city
                      for($ci=0;$ci<count($arrayOfTeacherCities);$ci++){
                          echo"<input class=\"courseButtons btn btn-info\" type=\"submit\" name=\"deleteCity\" value=\"$arrayOfTeacherCities[$ci]\">";
                      }
                    }                                    
                    echo'</div></div><br><br><br><h3 style="color:black">הוספת עיר חדשה </h3>';
                    echo"<SELECT name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple style=\"max-width:50%;\">";
                    $results = mysqli_query($con, "SELECT * FROM cities");
                    echo'<option >'.'בדוק את הערים הקימות'.'</option>';
                    while($rows=mysqli_fetch_array($results)){
                        echo'<option>'.$rows['cityName'].'</option>';
                    }echo"</SELECT>";
                  ?>
                  <input type="hidden" name="hidden_framework" id="hidden_framework"/><br/>
                </div>
              </div>  
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div style="padding-top: 2%;"><hr><hr>
                  <?php
                    echo'<div class="form-group">
                      <div class="col-sm-12"><h1 style="color:black">מלמד:-  '.$Courses.'</h1></div></div><hr><hr>';                                    
                    echo"<div class=\"col-sm-12\" id=\"courseButtons\">";
                    echo'<h3 style="color:black">לחץ על הכפתור להוריד אותו מהנתונים </h3>';
                    echo"<input type=\"hidden\" name=\"Courses\" value=\"$Courses\">";
                    if(count($arrayOfTeacherCourses)>0){//print courses that teacher learn as a buttons, that click on it redirect student to show more teachers learn the same subject
                      for($ci=0;$ci<count($arrayOfTeacherCourses);$ci++){
                        $r=$arrayOfTeacherCourses[$ci];
                        echo "<input class=\"courseButtons btn btn-info\" type=\"submit\" name=\"deleteCourses\" value=\"$arrayOfTeacherCourses[$ci]\">";
                      }
                    }
                     echo '</div><br><br><br><h3 style="color:black">הוספת קורס חדש </h3>';
                    echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple style=\"max-width:50%;\">";
                    $results = mysqli_query($con, "SELECT * FROM courses");
                    echo'<option >'.'בדוק את המקצועות הקיימים  '.'</option>';
                    while ($rows=mysqli_fetch_array($results)){
                        echo'<option>'.$rows['subject'].'</option>';
                    }echo"</SELECT>";
                  ?><br/><br/>
                <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses" /><br/>
              </div></div>  
          </div>
          <div class="form-group"><br>
            <label for="Save"><h4></h4></label>
            <input class="btn btn-info" id="citiesAndCoursesSaveButton" type="submit" name="Save" value="שמור">
          </div>
        </form>
      </div>
        <div id="Links" class="tabcontent"><!--let teacher to add links-->
            <form class="form" action="EditPage.php" method="post" id="registrationFor">
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
      </div><div></div>
    </section>
    <?php include_once 'footer.php';/*bottom footer*/?>
  </body>
</html> 
<?php include_once 'script.php';/*some function like select city*/?> 