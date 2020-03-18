<?php
/*
  this is the search teacher page.
  can get to this page by the navbar on many other pages or on the main page there is a section
  of search teacher by city or by course.
  user after choose which course he want for example will show on same page teachers
  learn the choosen topic, and could click on any teacher card to redirect to teacher page and 
  continue there.
*/
if($_GET['id']||$_POST['id']||$_GET['studentID']||$_POST['studentID']){
  if($_GET['id']){
      $IDOfStudent=$_GET['id'];
  }elseif($_GET['studentID']){
    $IDOfStudent=$_GET['studentID'];
  }else if($_POST['studentID']){
    $IDOfStudent=$_POST['studentID'];
  }else{
    $IDOfStudent=$_POST['id'];
  }
}
  $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//connct to DB
//start with get what the user select on cities or courses list from main page or this page
  $Cities=$_POST['hidden_framework'];
  $Courses=$_POST['hidden_framework_courses']; 
  $didUserChoose=-1;// use this to write if the user choose any option and it's not avilable(no teacher learn this course or in this city)
  
  function teacherNameAndStatusAndAgeAndPriceFunction($id){//function used to return name and status for each teacher on serach
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
    $IdResults = mysqli_query($con, "SELECT * FROM teachers");
    while ($row=mysqli_fetch_assoc($IdResults)){
        if ($row['id']==$id){//found wanted id -> get variables to use on HTML view               
          $nameResult=$row['fname']." ".$row['lname'];//get the first and last name as a name
          $statusResult=$row['status'];//get the teacher status
          //$ageResult=$row[''];
          $priceResult=$row['price'];
          return array($nameResult, $statusResult,$priceResult);//return four values(name, status, age,price)
      }
    }
  }
  
  function getImage($id){// function to return image for teacher name and comments wirters
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
    $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
    while ($rowOfCommentWriter=mysqli_fetch_array($resultsOfImageTable)){
        if ($rowOfCommentWriter['id']==$id){//found the image by id
            return $rowOfCommentWriter['image'];
        }
    }
  } 
  
  function teacherRating($ID){
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
    $countRatingOfTeacher=0;        
    $totalCountRatingOfTeacher=0;
    while ($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
        if($ratingOfTeacher['idOfTeacher']==$ID){
            $countRatingOfTeacher++;  $totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
        }
    }
    $fill=$totalCountRatingOfTeacher/$countRatingOfTeacher;
    $allRating=ceil($fill);                    
    for($stars=0;$stars<$allRating;$stars++){
        echo ' <span class="fa fa-star checked"></span>';
    }
    $emptyStars=5-$allRating;$e=0;
    while($e<$emptyStars){
        $e++;echo '<span class="fa fa-star"></span>';
    }
  }

  function returnTeacherCities($id){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
    $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
    while ($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
        if ($rows['id']==$id){//wanted id
            if($rows['cities']!='cities'){//teacher courses not null
              return $rows['cities'];// return data
            }			
        }		
    }           
  }
  function relativeCities($whatSelected,$arrayOfChoosen){
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
    $teacher_citiesResultForArray = mysqli_query($con, "SELECT * FROM cities");//call the table of cities
    $arrayOFAll=array();
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResultForArray)){
        $r=$teacherCitiesRows['cityName'];
        array_push($arrayOFAll,$r);//insert a list of cities names on array, each city on different index on array, 
        //to compare on next section(after loop) what user choose as a cities and what we have on DB
      }
      $counterOFArrayOfChoosen=0;      
      for($t=0;$t<count($arrayOFAll);$t++){
        if(stristr($whatSelected,$arrayOFAll[$t])){
          $arrayOfChoosen[$counterOFArrayOfChoosen]=$arrayOFAll[$t];
          $counterOFArrayOfChoosen++;
        }
      }
    return $arrayOfChoosen;
  }
/* 
  if user selected something, in this section there is three options:-
    1-if the user choosed course and city 2-if the user choosed course   3-if the user choosed city
*/    
  if ($Courses!=null||$Cities!=null){    
    $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");//call the table of teacher cities
    $teachers_coursesResultForArray = mysqli_query($con, "SELECT * FROM courses");//call the table of courses
    $teachers_coursesResult = mysqli_query($con, "SELECT * FROM teachers_courses");//call the table of teacher courses
    $courseResultArray=array();// array of information for each teacher
    $courseResultArrayCounter=0;
    $didUserChoose=1;    
    /*1- option number one, that user select city + course.
    * so we need to check if user location on selected city, then if the same user learn choosen course,
    * if yes we insert his id on array.
    */
    if($Courses!=null && $Cities!=null){//if user choose city and course for search
      //on next section we the choosen cities
      $idArrayOfPeopleLiveOnChoosenCity=array();
      $CounterOfIdArrayOfPeopleLiveOnChoosenCity=0;
      $arrayOfChoosenCities=array();
      $arrayOfChoosenCities=relativeCities($Cities,$arrayOfChoosenCities);
      //on next section we compare between list of cities and where teachers found
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)){
        for($t=0;$t<count($arrayOfChoosenCities);$t++){
          if(stristr($teacherCitiesRows['cities'],$arrayOfChoosenCities[$t])){
            $idArrayOfPeopleLiveOnChoosenCity[$CounterOfIdArrayOfPeopleLiveOnChoosenCity]=$teacherCitiesRows['id'];
            $CounterOfIdArrayOfPeopleLiveOnChoosenCity++;
            break;
          }
        }
      }
//on next section we do the same thing above but for course side, then we compare id's from to sections      
      $idArrayOfPeopleLearnOfChoosenCourse=array();
      $CounterOfIdArrayOfPeopleLearnOfChoosenCourse=0;
      $arrayOfChoosenCourse=array();
      $counterOFArrayOfChoosenCourse=0;
      $arrayOfAllCourses=array();
      while ($CourseRows=mysqli_fetch_array($teachers_coursesResultForArray)){
        $r=$CourseRows['subject'];
        array_push($arrayOfAllCourses,$r); //insert a list of courses names on array, each course on different index on array, 
        //to compare on next section(after loop) what user choose as a courses and what we have on DB
      }
      for($t=0;$t<count($arrayOfAllCourses);$t++){
        if(stristr($Courses,$arrayOfAllCourses[$t])){
          $arrayOfChoosenCourse[$counterOFArrayOfChoosenCourse]=$arrayOfAllCourses[$t];
          $counterOFArrayOfChoosenCourse++;
        }
      }
      while ($CourseRows=mysqli_fetch_array($teachers_coursesResult)){// check which teacher learn the specified course
          for($t=0;$t<count($arrayOfChoosenCourse);$t++){
            if(stristr($CourseRows['subject'],$arrayOfChoosenCourse[$t])){
              $idArrayOfPeopleLearnOfChoosenCourse[$CounterOfIdArrayOfPeopleLearnOfChoosenCourse]=$CourseRows['id'];
              $CounterOfIdArrayOfPeopleLearnOfChoosenCourse++;
              break;
            }
          }
      }
//// last section on selected city + course....keep the same id        
      for($t=0;$t<count($idArrayOfPeopleLiveOnChoosenCity);$t++){
        for($f=0;$f<count($idArrayOfPeopleLearnOfChoosenCourse);$f++){
          if($idArrayOfPeopleLiveOnChoosenCity[$t]==$idArrayOfPeopleLearnOfChoosenCourse[$f]){
            $courseResultArray[$courseResultArrayCounter]=$idArrayOfPeopleLiveOnChoosenCity[$t];
            $courseResultArrayCounter+=1;
            break;
          }
        }
      }
    }else if ($Courses!=null&&$Cities==null){ //if user selected course and not choosing any city, user can check just for one course
      while ($CourseRows=mysqli_fetch_array($teachers_coursesResult)){
        if(stristr($CourseRows['subject'],$Courses)){
          $courseResultArray[$courseResultArrayCounter]=$CourseRows['id'];
          $courseResultArrayCounter+=1;
        }
      }
    }elseif($Cities!=null&&$Courses==null){
      $arrayOfChoosenCities=array();
      $arrayOfChoosenCities=relativeCities($Cities,$arrayOfChoosenCities);
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)){ //on next section we compare between list of cities and where teachers found
        for($t=0;$t<count($arrayOfChoosenCities);$t++){
          if(stristr($teacherCitiesRows['cities'],$arrayOfChoosenCities[$t])){
            $courseResultArray[$courseResultArrayCounter]=$teacherCitiesRows['id'];
            $courseResultArrayCounter+=1;
            break;
          }
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
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
    <link rel="stylesheet" type="text/css" href="css/searchStyle.css">
    <style>
      .checked {
        color: orange;
      }
      #share-buttons img {
      width: 15px;
      padding: 1px;
      border: 0;
      box-shadow: 0;
      display: inline;
      }
      .fa {
     padding: 0px;
     font-size: 10px; 
     width: 100px; 
    text-align: center;
    text-decoration: none;
     margin:0px; 
    border-radius: 50%;
      }
    </style>
  </head>
  <body>
      <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
      <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <a class="navbar-brand" href="#">הכיתה</a>
              <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <?php
                  $isStudent=-1; 
                  $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                  $IdResults = mysqli_query($con, "SELECT * FROM teachers");
                  while ($rows=mysqli_fetch_array($IdResults)){
                    if ($rows['id']==$IDOfStudent && $rows['setUserAs']=='student'){
                        $isStudent=1;
                        break;
                    }
                  }
                    if($IDOfStudent){
                      echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php?id=$IDOfStudent\"> עמוד הבית</a></li>"; 
                      if($isStudent==-1){
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php?id=$IDOfStudent\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
                      }else{
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php?id=$IDOfStudent\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
                      }
                      echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"FAQ.php?id=$IDOfStudent\">שאלות ותשובות</a></li>";
                      echo '<li class="nav-item active"><a class="nav-link" href="Hakita.php"> יציאה</a></li>';
                    }else{
                      echo '<li class="nav-item active"><a class="nav-link" href="Hakita.php">עמוד הבית <span class="sr-only">(current)</span></a></li>';
                      echo '<li class="nav-item active"><a class="nav-link" href="loginSignUP.php">כניסה/הרשמה </a></li>';
                      echo '<li class="nav-item active"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>';
                    }
                  ?>   
                </ul>
              </div>
        </nav>
      </section><hr>
      <section>
        <?php
          if($IDOfStudent){// for login user : say hello/ good(morning/afternoon...)
            /* Set the $timezone variable to become the current timezone */
            date_default_timezone_set('Asia/Jerusalem');  
            $script_tz = date_default_timezone_get();
            $time = date("H");
            echo "<h2>";
            /* If the time is less than 1200 hours, show good morning */
            if ($time < "12"){
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
            if ($time >= "19") {
                echo "לילה טוב";
            }
            $teacherNameAndStatusFunction=teacherNameAndStatusAndAgeAndPriceFunction($IDOfStudent);
            echo "&nbsp;".$teacherNameAndStatusFunction[0]. "</h2>";
          }  
        ?>
      </section><hr>
      <section>
      <div class="container bootstrap snippet" id="container">
        <div class="row">
          <div>            
            <div class="col-sm-12">               
              <div class="tab-content">
                <div class="tab-pane active" id="home"><hr>
                    <form class="form" action="searchTeachers.php" method="post" id="registrationForm">
                        <?php 
                          echo "<input type=\"hidden\" name=\"id\" id=\"$IDOfStudent\" value=\"$IDOfStudent\">";
                          $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                        ?>
                        <div class="form-group">
                              <div class="col-sm-6">
                                    <div style=" padding-top: 1%;">
                                    <p class="searchWords"> חיפוש מורה לפי עיר</p>
                                      <?php
                                        echo "<SELECT  name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple>";
                                        $results = mysqli_query($con, "SELECT * FROM cities");
                                        echo'<option>'.'בדוק את הערים הקימות'.'</option>';
                                        while ($rows=mysqli_fetch_array($results)){
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
                              <div class="col-sm-6">
                                    <div style=" padding-top: 1%;">
                                    <p class="searchWords">  חיפוש מורה לפי קורס</p class="searchWords">
                                    <?php
                                        echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                        $results = mysqli_query($con, "SELECT * FROM courses");
                                        echo'<option>'.'בדוק את המקצועות הקיימים  '.'</option>';
                                        while ($rows=mysqli_fetch_array($results)){
                                            echo'<option>'.$rows['subject'].'</option>';
                                        }
                                        echo"</SELECT>";
                                      ?>
                                      <br/><br/>
                                      <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses"/>                                                              
                                    <br/>
                                   </div>
                                  </div>  
                                </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                  <br>
                                    <label for="Save"><h4></h4></label>
                                    <input id="searchButton" type="submit" name="Save" value="חפש">
                              </div>
                        </div>
                  </form>
              </div><!--/tab-pane-->            
                </div><!--/tab-pane-->
            </div><!--/tab-content-->
          </div><!--/col-9-->
      </div><!--/row-->
    </div><hr><hr>
    </section>
      <section id="searchResult">
        <div class="container">
            <div class="row">
              <?php
                  if($courseResultArrayCounter==0&&$didUserChoose==1){
                    echo '<div id="notAvilableTitle"> אין מורים בתחום שנבחר או באזור '.'</div>';
                  }else{//show the results of teachers
                    $D=array();
                    $DCounter=0;
                    echo "<div class=\"col-sm-11\">";
                    for($i=0;$i<$courseResultArrayCounter;$i++){
                        $D[$DCounter]=$courseResultArray[$i];
                        $DCounter++;
                        $ID=$courseResultArray[$i];
                        echo "<div class=\"col-sm-3\" id=\"$ID\">";
                          echo "<button value=\"$ID\" id=\"$ID\" class=\"card\">";
                            echo"<input type=\"hidden\" id=\"$ID\">";
                            /**
                             * $returnTeacherAgeAndPrice=teacherNameAndStatusAndAgeAndPriceFunction($ID);
                             * echo "<p>".$returnTeacherAgeAndPrice[3]."</p><br>";//age
                             * echo "<p>".$returnTeacherAgeAndPrice[2]."</p><br>";//price
                             */
                            $teacherNameAndStatusFunction=teacherNameAndStatusAndAgeAndPriceFunction($ID);
                            echo "<img src='img/".getImage($ID)."'   class='img'>";
                            echo "<h2> ".$teacherNameAndStatusFunction[0]."</h2>";
                            echo "<p class=\"title\">". $teacherNameAndStatusFunction[1]."</p>";
                          /*
                           *need to add price, age, rating  ($ID)
                           */ 
                            echo "<p>".teacherRating($ID)."</p><br>"; 
                            echo "<p>".returnTeacherCities($ID)."</p><br>";
                            echo "<p>מחיר : ".$teacherNameAndStatusFunction[2]."</p><br>";
                          echo "</button>";
                        echo "</div>";
                      }
                      echo "</div>";
                  } 
              ?>
            </div>
        </div>
      </section>
      <div class="ButtomSection">      
      <div class="container">
        <div class="row">
          <div class="col-sm-5">
            &copy;כל הזוכיות שמורות לאתר הכיתה
              
                <a href="https://www.jce.ac.il/">

                  </a><br>
                  קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
            
                    <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
                
          </div>
          <div class="col-sm-3">
            📚            
        רשימת מקצועות לימוד
        <br>
        צור קשר איתנו📧
          
        <p >הוספת פרויפיל</p>
          </div>
          <div class="col-sm-4">
            עקובו אחרינו ב-פייסבוק:-
              <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
          </div>
        </div>
      </div>
        </div>
  </body>
</html>  
<script>//get the cities names student choose
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

<script>//get the courses names student choose
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
     $('#hidden_framework_courses').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }
  else
  {
    alert("נא לבחור קורס");
   return false;
  }
 });
});
</script>                                               
<script>
//script used for the up button
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
 // to get the id of teacher 
 var phpIdArrayLength = <?php echo end($D);?>;
  // to get the id of student if login
  var studentId = <?PHP echo (!empty($IDOfStudent) ? json_encode($IDOfStudent) : '""'); ?>;
	$(document).ready(function(){
	for (var i = 0; i <= phpIdArrayLength; i++){
	let x=i;
	let n = x.toString();
	$("#"+n).click(function()	{
    if(!studentId){//normal view a special teacher profile without login
      window.location.href = "viewTeacherProfile.php?id=" + x;
    }else{//normal view a special teacher profile with login
      window.location.href = "viewTeacherProfile.php?id=" + x + "&studentID="+studentId;
    }  
	});
	}
	});
</script>