<?php
/*
  this is the search teacher page.
  can get to this page by the navbar on many other pages or on the main page there is a section
  of search teacher by city or by course.
  user after choose which course he want for example will show on same page teachers
  learn the choosen topic, and could click on any teacher card to redirect to teacher page and 
  continue there.
*/
  session_start();
  $IDOfStudent=$_SESSION['id'];//get the id of login user if there is
  $_SESSION['id']=$IDOfStudent;

  include 'userData.php';//calling this file to use some function from

  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");//connection with DB
//start with get what the user select on cities or courses list from main page or this page, if already select
  $Cities=$_POST['hidden_framework'];
  $Courses=$_POST['hidden_framework_courses']; 
  $freeSearch=$_POST['freeSearch'];

  $didUserChoose=-1;// use this to write if the user choose any option and it's not avilable(no teacher learn this course or in this city)

/* if user selected something, in this section there is three options:-
    1-if the user choosed course and city 2-if the user choosed course   3-if the user choosed city
*/    


  if($freeSearch!=null){
    $didUserChoose=1; 
    $teachers_courses = mysqli_query($con, "SELECT * FROM teachers_courses");//call the table of teacher courses
    $courseResultArray=array();// array of information for each teacher
    $courseResultArrayCounter=0;
    $arrayOfPeople=array();
    $counterArrayOfPeople=0;

    while($teacherCourseRows=mysqli_fetch_array($teachers_courses)){
        if(stristr($teacherCourseRows['subject'],$freeSearch)){
          $arrayOfPeople[$counterArrayOfPeople]=$teacherCourseRows['id'];
          $counterArrayOfPeople+=1;
        }
    }

  }
  if($Courses!=null||$Cities!=null){
    $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");//call the table of teacher cities
    $courses = mysqli_query($con, "SELECT * FROM courses");//call the table of courses
    $teachers_courses = mysqli_query($con, "SELECT * FROM teachers_courses");//call the table of teacher courses
    $courseResultArray=array();// array of information for each teacher
    $courseResultArrayCounter=0;
    $arrayOfPeople=array();
    $counterArrayOfPeople=0;
    $didUserChoose=1;    
    /*1- option number one, that user select city + course.
    * so we need to check if user location on selected city, then if the same user learn choosen course,
    * if yes we insert his id on array.
    */
    if($Courses!=null){//if user choose city and course for search, start with get teachers learn this course, then if he/she not located on this location delete the id
      if(strcmp('תוכנה', $Courses) == 0){//user choose software as a course
        $softwareCourse=1;
        while($courseRows=mysqli_fetch_array($teachers_courses)){
          if($courseRows['softwareCourse']==1){//take the id of the software courses
            $arrayOfPeople[$counterArrayOfPeople]=$courseRows['id'];
            $counterArrayOfPeople+=1;
          }
        }
      }else{
        while($teacherCourseRows=mysqli_fetch_array($teachers_courses)){
          if(stristr($teacherCourseRows['subject'],$Courses)){
            $arrayOfPeople[$counterArrayOfPeople]=$teacherCourseRows['id'];
            $counterArrayOfPeople+=1;
          }
        }
      }
      if($Cities!=null){//if user choose city and course for search, start with get teachers learn this course, then if he/she not located on this location delete the id
        $cityArray=array();
        $cityArrayCounter=0;
        while($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)){
          if(stristr($teacherCitiesRows['cities'],$Cities)||(strcmp($teacherCitiesRows['cities'], $Cities) == 0)){
            $cityArray[$cityArrayCounter]=$teacherCitiesRows['id'];
            $cityArrayCounter+=1;
          }
        }
        $arrayOfPeople=array_intersect($arrayOfPeople,$cityArray);
      }
    }elseif($Cities!=null&&$Courses==null){//if user select a city and not selected any course
      while($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)){
        if(stristr($teacherCitiesRows['cities'],$Cities)){
          $arrayOfPeople[$counterArrayOfPeople]=$teacherCitiesRows['id'];
          $counterArrayOfPeople+=1;
        }
      }
    }
  }
  
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <?include 'header.php';?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/searchStyle.css">
  </head>
  <body>
    <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
    <?php
      $undisplay='search';
    ?>
    <?php include_once 'nav.php'?>
      <?php
        if($IDOfStudent){// for login user : say hello/ good(morning/afternoon...)
          /* Set the $timezone variable to become the current timezone */
          date_default_timezone_set('Asia/Jerusalem');  $script_tz = date_default_timezone_get();
          $time = date("H"); echo "<h2>";
          /* If the time is less than 1200 hours, show good morning */
          if ($time < "12"&&$time>4){
              echo "בוקר טוב ";
          } else
          /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
          if ($time >= "12" && $time < "17") {
              echo "צוהריים טובים";
          } else
          /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
          if ($time >= "17" && $time < "19") {
              echo "ערב טוב ";
          } else
          /* Finally, show good night if the time is greater than or equal to 1900 hours */
          if ($time >= "19"||$time<=4) {
              echo "לילה טוב";
          }
          echo "&nbsp;".name($IDOfStudent). "</h2></section>";//also display the use name
        }  
      ?><!--next section for the search feild, to select course/city or both-->      
		<div class="limiter">
			<div class="container-login100">
				<div class="form-group col-sm-12">
					<form class="form" action="otherSearchTeachers.php" method="post" id="registrationForm">
              <div class="form-group col-sm-6">
                 <p class="searchWords"> חיפוש מורה לפי עיר</p>
                   <?php
                     echo"<SELECT title=\"בדוק את הערים הקימות\" id=\"framework\" class=\"selectpicker\" data-live-search=\"true\" multiple>";
                     $results=mysqli_query($con, "SELECT * FROM cities");
                     while($rows=mysqli_fetch_array($results)){
                         echo'<option>'.$rows['cityName'].'</option>';
                     }echo"</SELECT>";
                   ?>                                      
                   <input type="hidden" name="hidden_framework" id="hidden_framework"/><br/>
               </div> 
           <div class="form-group col-sm-6" id="searchByCourse">
             <p class="searchWords">  חיפוש מורה לפי קורס</p class="searchWords">
             <?php
                 echo"<SELECT name=\"frameworkCourse\" title=\"בדוק את המקצועות הקיימים\" id=\"frameworkCourse\" class=\"selectpicker\" data-live-search=\"true\">";
                 $results=mysqli_query($con, "SELECT * FROM courses");
                 while($rows=mysqli_fetch_array($results)){
                     echo'<option>'.$rows['subject'].'</option>';
                 }echo"</SELECT>";
               ?>                                      
               <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses"/><br/>
            </div><br>
              <div class="form-group">
                <div class="col-sm-12" id="freeSearch"><br>
                  <label for="Save"></label><input type="text" name="freeSearch"  class="form-control" placeholder="חיפש חופשי">
                </div>
            </div>
              <div class="form-group">
                <div class="col-xs-12"><br>
                  <label for="Save"></label><input id="searchButton" type="submit" name="Save" value="חפש">
                </div>
            </div>
        </form>
		</div></div></div>
    <?php
      if($didUserChoose==1 && $arrayOfPeople[0]!=NULL){
        echo"<section id=\"searchResult\">
            <div class=\"container\">
              <div class=\"row\">";
                    if($counterArrayOfPeople==0&&$didUserChoose==1){echo '<div id="notAvilableTitle"> אין מורים בתחום שנבחר או באזור '.'</div>';}//no teachers on selected course or city
                    else{//show the results of teachers
                      $D=array();
                      $DCounter=0;
                      echo'<div class="row col-sm-12"><div class="col-sm-10">'; 
                      echo"<form method=\"post\" action=\"viewTeacherProfile.php\">";                   
                      for($i=0;$i<$counterArrayOfPeople;$i++){
                          if($arrayOfPeople[$i]!=NULL){
                            $D[$DCounter]=$arrayOfPeople[$i];$DCounter++;
                            $ID=$arrayOfPeople[$i];
                            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                            $commentResult=mysqli_query($con, "SELECT * FROM dBOfComments");
                            $countRatingOfTeacher=0;        
                            $totalCountRatingOfTeacher=0;
                            while($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
                                if($ratingOfTeacher['idOfTeacher']==$ID){
                                    $countRatingOfTeacher++;  $totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
                                }
                            }
                            $value=randValues($ID);
                            $fill=$totalCountRatingOfTeacher/$countRatingOfTeacher;
                            $getRatingOfEachComment=ceil($fill);                 
                            if($i%3==0&&$i!=0){echo'<br>';}
                            echo "<button class=\"buttonCard col-sm-4\" name=\"showTeacher\" value=\"$value\" style=\"width:220px; height:360px;\">";
                            echo"<img src='img/".Image($ID)." 'class=\"img\">";
                            if(Gender($ID)==-1){echo"<h2 style=\"color: deeppink; font-weight: 700;\">".name($ID)."</h2>";}
                            else{echo"<h2 style=\"color:blue; font-weight: 700;\">".name($ID)."</h2>";}
                            for($star=0;$star<$getRatingOfEachComment;$star++){//the orange star's
                              echo ' <span class="fa fa-star checked"></span>';
                            }
                            $emptyStars=5-$getRatingOfEachComment;$e=0;
                            while($e<$emptyStars){//the empty star's
                              $e++;echo '<span class="fa fa-star"></span>';
                            } 
                            if(strcmp(status($ID),'status')!=0){//teacher status, if the string length is bigger than 26 letters, write instead ....
                              $stat=status($ID); 
                              if(strlen($stat)>26){
                                $status = mb_substr($stat,0,25,'utf-8');                            
                              }else{
                                $status=$stat;
                              }$status.="...";                     
                              echo"<p class=\"clearfix\" style=\"height:20px;overflow:hidden;\">\"". $status."</p>"; 
                            }          
                            if(returnTeacherCourses($ID)!=NULL){//teacher courses, if the string length is bigger than 26 letters, write instead ....
                              $courses =returnTeacherCourses($ID);
                              if(strlen($courses)>26){
                                $courses = mb_substr($courses,0,25,'utf-8'); 
                              }$courses.="...";                     
                              echo"<p>".$courses."</p>";
                            }              
                            if(returnTeacherCities($ID)!=NULL){//teacher cities, if the string length is bigger than 26 letters, write instead ....
                              $cities=returnTeacherCities($ID);
                              if(strlen($cities)>26){
                                $cities = mb_substr($cities,0,25,'utf-8'); 
                              }$cities.="...";         
                              echo"<p><small class=\"cityAndPrice\">".$cities."</span></p>"; 
                          }
                          if(strlen(price($ID))>1){
                            echo"<p>".price($ID)."</small></p>"; //teacher price
                          }
                            echo"</button>"; 
                          } 
                        }echo"</form></div></div>";
                    }echo"</div></div>
        </section>";
      }
      elseif($didUserChoose==1 && $arrayOfPeople[0]==NULL){
        echo '<div id="notAvilableTitle"> אין מורים בתחום שנבחר או באזור '.'</div>';
      }
    ?>
      <?php include_once 'footer.php';/*get the bottom footer*/?>
  </body>
</html>  
<?php include 'script.php';/*user script like the select list/ up button*/?>  