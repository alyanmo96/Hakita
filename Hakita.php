<?php 
/*
  This is the main page. include navbar : login, signUp, FAQ and search techer.   
  Search section.
  Teachers sections, there will be a sections for a new teachers, english teachers, arabic.....
  we start as we get the id and some information about teachers, id of login user in status of login.
  we need deatils about student for dsiplay on navbar my profile instead of login or sign up, and redirect to other pages. 
*/

  session_start();
  include 'userData.php';//this file include function to return user details like name.
  $ID=$_SESSION['id'];//the id of the login user.
  $_SESSION['id']=$ID;//share the id, used on redirect to other pages.

//this function is for return the name of teacher cities on teachers section like new teacher
  function teacherCities($id){//need to conncet with the DB, the main connection not useful inside function
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities");  
    $MoreThanOneWordSoAddComma=0;//this variable using case there is a teachers with more than one city, so write a comma between each two cities
     $city=" ";//city variable
     while($teacher_citiesRows=mysqli_fetch_assoc($resultOFTeachersCity)){//searching on cities table about the teacher id
         if ($teacher_citiesRows['id']==$id){//if the id on table eqaul to the id of teacher, check in which city he/she is
             if($MoreThanOneWordSoAddComma>=1){ //for more than one city add comma
                $city.=' , ';
             }
             if($teacher_citiesRows['cities']!='cities'){//add the city name
                $city.=$teacher_citiesRows['cities'];
                $MoreThanOneWordSoAddComma++;
             }
         }
     }return $city;//return which cities we get from table if there is
  }
//this function is for return the name of teacher courses who learn on teachers section like new teacher
  function teacherCourses($id){//need to conncet with the DB, the main connection not useful inside function
    $MoreThanOneWordSoAddComma=0;//this variable using case there is a teachers learn more than one course, so write a comma between each two courses
    $CourseName=" ";//course variable     
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
    while($CoursesResultsRows=mysqli_fetch_array($CoursesOfTeachersResults)){
       if($CoursesResultsRows['id']==$id){ //if the id on table eqaul to the id of teacher, check which course he/she learn
           if($MoreThanOneWordSoAddComma>=1){ //for more than one city add comma
              $CourseName.=" , ";
           }
           if($CoursesResultsRows['subject']!='subject'){//add the course name
              $CourseName=$CoursesResultsRows['subject'];
              $MoreThanOneWordSoAddComma++;
           }
       }	
    }return $CourseName;//return the courses that teacher learn
  }

  $allUsersArrayWithThereMainInformations=array();//this array include all inforation about user, like id's, first and last name
  $EnglishTeachersIdArray=array();//array for using on english teacher section
  $EnglishTeachersIdArrayCounter=0;
  $teachersIdArray=array();/*create array for the new teachers, random a three new teachers */
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
  $IdResults=mysqli_query($con, "SELECT * FROM users");
  $i=0;$j=0;//$i for $allUsersArrayWithThereMainInformations, and $j using for arrays help us with showing section
  while($rows=mysqli_fetch_array($IdResults)){/*create array for the new teachers, random a three new teachers */
    if($rows['id']!=211&&$rows['setUserAs']!='student'&&($rows['id']!=$_GET['id']&&$rows['id']!=$_POST['id'])){//get just the teachers
      $allUsersArrayWithThereMainInformations[$i]=$rows['id'];$i++;//get the id, and forward index
      $teachersIdArray[$j]=$rows['id'];$j++;//this useful for showing teachers sections like new teachers or engilsh teachers, and forward index
      $allUsersArrayWithThereMainInformations[$i]=$rows['fname'];$i++;//get first name, and forward index
      $allUsersArrayWithThereMainInformations[$i]=$rows['lname'];$i++;// get last name, and forward index
      $allUsersArrayWithThereMainInformations[$i]=teacherCourses($rows['id']);$i++;/////course, and forward index
      if(strpos($allUsersArrayWithThereMainInformations[$i-1], 'אנגלית') !== false){//for english teacher section
        $EnglishTeachersIdArray[$EnglishTeachersIdArrayCounter]=$rows['id'];
        $EnglishTeachersIdArrayCounter++;
      }            
      $allUsersArrayWithThereMainInformations[$i]=teacherCities($rows['id']);$i++;// cities, and forward index
      $allUsersArrayWithThereMainInformations[$i]=Image($rows['id']);$i++;// cities, and forward index   
     }
   }
   $NewTeachersArray=array_rand($teachersIdArray,3);//this going to be used for the new teachers section, chooseing by random
   for($i=0;$i<count($NewTeachersArray);$i++){//get a three teachers
     $NewTeachersArray[$i]=$teachersIdArray[$NewTeachersArray[$i]];   
   }
   $EnglishTeachersArray=array_rand($EnglishTeachersIdArray,3);//this going to be used for the english teachers section, chooseing by random
   for($i=0;$i<count($EnglishTeachersArray);$i++){//get a three teachers
     $EnglishTeachersArray[$i]=$EnglishTeachersIdArray[$EnglishTeachersArray[$i]];   
   }
    
    function returnTeacherCourses($id){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
      $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
      $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
      while($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
        if($rows['id']==$id){//wanted id
            if($rows['subject']!='subject'){//teacher courses not null
              return $rows['subject'];// return data
            }     
        }   
      }           
    }
    function returnTeacherCities($id){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
      $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
      $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
      while($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
          if($rows['id']==$id){//wanted id
              if($rows['cities']!='cities'){//teacher courses not null
                return $rows['cities'];// return data
              }     
          }   
      }           
    }
  for($e=1;$e<20000;$e++){
    if(array_key_exists($e, $_POST)) { 
      redirectFunction($e); 
    } 
  }

  function redirectFunction($id){
    $_SESSION['teacher']=$id;
    header('location: viewTeacherProfile.php');
  }
//next function is for display teachers on teachers sections, include name, image, teacher status rating, price, cities, courses.
  function displayTeacherSection($array){
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    echo"<form method=\"post\" action=\"Hakita.php\">";
        for($i=0;$i<count($array);$i++){
          $commentResult=mysqli_query($con, "SELECT * FROM dBOfComments");//for rating
          $countRatingOfTeacher=0;        
          $totalCountRatingOfTeacher=0;
          while($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
              if($ratingOfTeacher['idOfTeacher']==$array[$i]){//ID
                $countRatingOfTeacher++;  $totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
              }
          }
          $fill=$totalCountRatingOfTeacher/$countRatingOfTeacher;
          $getRatingOfEachComment=ceil($fill);
          echo "<button class=\"buttonCard col-sm-4\"  name=\"$array[$i]\" style=\"margin-left:2%;\">";
          echo"<img src='img/".Image($array[$i])." 'class=\"img\">";
          if(Gender($array[$i])==-1){echo"<h2 style=\"color: deeppink; font-weight: 700;\">".name($array[$i])."</h2>";}//just for style
          else{echo"<h2 style=\"color:blue; font-weight: 700;\">".name($array[$i])."</h2>";}//just for style
          if($getRatingOfEachComment>0){
            for($star=0;$star<$getRatingOfEachComment;$star++){//the orange star's
              echo'<span class="fa fa-star checked"></span>';
            }
            $emptyStars=5-$getRatingOfEachComment;$e=0;
            while($e<$emptyStars){//the empty star's
                $e++;echo '<span class="fa fa-star"></span>';
            } 
          }          
          if(strcmp(status($array[$i]),'status')!=0){//teacher status, if the string length is bigger than 26 letters, write instead ....
            $stst=status($array[$i]); 
            if(strlen($stst)>26){
              $status = mb_substr($stst,0,25,'utf-8');                            
            }else{
              $status=$stst;
            }$status.="...";                     
            echo"<div id=\"statusDiv\"><p class=\"clearfix\" style=\"height:20px;overflow:hidden;\">\"". $status."</p></div>";          
          }          
          if(returnTeacherCourses($array[$i])!=NULL){//teacher course, if the string length is bigger than 26 letters, write instead ....
            $courses =returnTeacherCourses($array[$i]);
            if(strlen($courses )>26){
              $courses = mb_substr($courses,0,25,'utf-8'); 
            }$courses.="...";                     
            echo"<div id=\"courseDiv\"><p>".$courses."</p></div>";
          }       
          if(returnTeacherCities($array[$i])!=NULL){//teacher cities, if the string length is bigger than 26 letters, write instead ....
            $cities=returnTeacherCities($array[$i]);
            if(strlen($cities )>26){
              $cities = mb_substr($cities,0,25,'utf-8'); 
            }$cities.="...";         
            echo"<div id=\"cityDiv\"><p><small class=\"cityAndPrice\">".$cities."</span></p></div>"; 
         }   
         $price=strlen(price($array[$i]));
          if(strlen($price)>15){
            $price = mb_substr($price,0,15,'utf-8'); 
          }    
          $price.="...";      
            echo"<p>".$price."</small></p>";
          echo"</button>"; 
        }echo"</form>";
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <?php include 'header.php';?>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/Hakita.css">
  </head>
  <body>
    <a id="button"></a><!--up button-->
    <?php
      $undisplay='Hakita';
    ?>
    <?php include_once 'nav.php'?>
    <div class="bgimg-1"><!--the main photo, include main title--->
      <div class="caption"><span class="border">הכיתה - אינדקס המורים הפרטיים הגדול של ישראל</span></div>
    </div><br><br>
    <div style="color: #777;background-color:white;text-align:center;text-align: justify;">
    <div class="container"><div class="row"><div class="col-sm-12"><div class="limiter"><div class="container-login100"><div class="form-group col-sm-12">
			<!--search section, include search by city/course, search button.--->
        <form class="form" action="searchTeachers.php" method="post" id="registrationForm">
              <div class="form-group col-sm-5">
                 <p class="searchWords"> חיפוש מורה לפי עיר</p>
                   <?php
                     echo"<SELECT title=\"בדוק את הערים הקימות\" id=\"framework\" class=\"selectpicker\" data-live-search=\"true\" multiple>";
                     $results=mysqli_query($con, "SELECT * FROM cities");
                     while($rows=mysqli_fetch_array($results)){
                         echo'<option>'.$rows['cityName'].'</option>';
                     }
                     echo"</SELECT>";
                   ?>                                      
                   <input type="hidden" name="hidden_framework" id="hidden_framework"/><br/>
               </div> 
              <div class="form-group col-sm-7" id="searchByCourse">
             <p class="searchWords">  חיפוש מורה לפי קורס</p>
             <?php
                 echo"<SELECT name=\"frameworkCourse\" title=\"בדוק את המקצועות הקיימים\" id=\"frameworkCourse\" class=\"selectpicker\" data-live-search=\"true\">";
                 $results=mysqli_query($con, "SELECT * FROM courses");
                 while($rows=mysqli_fetch_array($results)){
                     echo'<option>'.$rows['subject'].'</option>';
                 }
                 echo"</SELECT>";
               ?>                                      
               <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses"/><br/>
            </div>
              <div id="v"><label for="Save"></label><input id="searchButton" type="submit" name="Save" value="חפש"></div>
          </form>
				</div></div></div></div></div>
        <!--teacher sections, include new teachers, english teachers,....--->
    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify; min-height: 650px;">
      <h3 style="text-align:center; color:white;">מורים חדשים באתר</h3><hr>
      <p><small>
        <?php /*get the data for each one of the three choose as an english teachers to show them */
          displayTeacherSection($NewTeachersArray);//go to this function to display teachers
        ?>
      </small></p>  
      <div class=" buttonCheckForMoreTeachers text-center col-md-12">
        <a href="moreTeachers.php?subject=אנגלית" class="moreTeachers btn btn-info btn-lg">
          <span class="glyphicon glyphicon-arrow-left"></span>
          <span class="moreTeachersTitle">לעוד מורים חדשים באתר</span>
          <span class="glyphicon glyphicon-arrow-left"></span> 
        </a> 
      </div></div></div>
      <div class="bgimg-2">
        <div class="caption"></div>
      </div>
    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify; min-height: 650px;">
        <h3 style="text-align:center; color:white;">מורים אנגלית </h3><hr>
        <p><small>
        <?php /*get the data for each one of the three choose as an english teachers to show them */
          displayTeacherSection($EnglishTeachersArray);//go to this function to display teachers
        ?>
        </small></p>  
      <div class=" buttonCheckForMoreTeachers text-center col-md-12">
        <a href="moreTeachers.php?subject=אנגלית" class="moreTeachers btn btn-info btn-lg">
          <span class="glyphicon glyphicon-arrow-left"></span>
          <span class="moreTeachersTitle">לעוד מורים אנגלית באתר</span>
          <span class="glyphicon glyphicon-arrow-left"></span> 
        </a> 
      </div></div></div>
    <div class="bgimg-3">
      <div class="caption">
        <span class="border" style="background-color:transparent;font-size:25px;color: black;">ללמוד תוך אווירה נעימה</span>
      </div></div>
    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
      <h3 style="text-align:center; color:white;"> מורים ללשון  </h3><hr>
        <p>עוד לא מוכן</p>
      </div></div>
    <div class="bgimg-1"><div class="caption"><div class="containe" id="containe" name="containe"><div class="row"><div class="col-sm-12">
    </div></div></div></div></div><br><br><br><br>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ec53990697c2288"></script>
                        
    <?php include_once 'footer.php';?><!--get the bottom footer-->
  </body>
</html>
<?php include_once 'script.php';?><!--getsome functions like the up button, choose form courses/cities list-->