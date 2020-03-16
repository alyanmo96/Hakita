<?php
/**
 * this file let student or teachers show other teacher profile. write a cooment, ask for a lesson, send message and sure get information about teacher
 *  note that can get to this page by two ways as a login user or as a normal user (without login)
 */
    session_start();
    // get the id of teacher, and get the id of the login user on login state
    $ID = ($_GET['id']) ? $_GET['id'] : $_POST['id'];
    $IDOfStudent = ($_GET['studentID']) ? $_GET['studentID'] : $_POST['studentID'];
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//connect to DB
    $IdResults = mysqli_query($con, "SELECT * FROM teachers");   
    if(isset($_POST['usernameLogin'])&&isset($_POST['PasswordLogin'])){//if the student was not login then he ask for a lesson so he need to login
        while ($row=mysqli_fetch_assoc($IdResults)){ //check student validate account
            if($row['password']==$_POST['PasswordLogin']&&
                $row['username']==$_POST['usernameLogin']){
                $IDOfStudent=$row['id'];//student id
                $ID=$_POST['id'];//teacher id, get it by POST
                break;
			}
        }   
    }
    if (isset($_POST["comments"])) { // if any student write a comment about this teacher     
        $getComment=$_POST["comments"];
        $_POST["comments"]=null;             $rating=-1;
        $rating=intval($_POST["teacherValue"]);
        if(!(is_int($_POST["teacherValue"]))){// need to check if the _POST is intger
            $rating=intval($_POST["teacherValue"]);
        } 
        $_POST["teacherValue"]=null;   $ID=$_POST['id'];    $commentWriterId=$IDOfStudent; 
        $todayDate=date('Y-m-d');
        $query="INSERT INTO `dBOfComments`(`idOfTeacher`,`idOfCommentWriter`,`dateOfComment`,`textOfComment`,`rating`) VALUES ('$ID','$commentWriterId','$todayDate','$getComment','$rating')";
        $result = mysqli_query($con,$query);
    }
    function insertCitiesAndCoursesOnArray($subject,$arrayOfTeacherCoursesOrCities){
        $subject.=",ADD";//adding space to string
        $IndexOfArrayOfTeacher=0;
        $length=strlen($subject); //case we will get the cities or cources as a one string 
        $lastComma=0;        $counterOfDigits=0;        $ifFoundAComma=-1;        $howManyTimesFindComma=0;    
        for($q=0;$q<$length;$q++){
            if(substr($subject, $q, 1)==","){
                $ifFoundAComma=1;
                if($howManyTimesFindComma==0){
                    $arrayOfTeacherCoursesOrCities[$IndexOfArrayOfTeacher]=substr($subject, $lastComma,$q); $howManyTimesFindComma++;
                }else{
                    $arrayOfTeacherCoursesOrCities[$IndexOfArrayOfTeacher]=substr($subject, $lastComma,$counterOfDigits-1);                    
                }  
                $IndexOfArrayOfTeacher++;  $counterOfDigits=0; $lastComma=$q+1;
            }
            if($ifFoundAComma==1){
                $counterOfDigits++;
            }   
        }
        return $arrayOfTeacherCoursesOrCities;
    }function getToggleButtonStatus($ID){//function use to check the status of toggle button
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$ID&&$rows['checkbox']==1){//display board time
                return 1;
            }elseif($rows['idOfTeacher']==$ID&&$rows['checkbox']==-1){//not
                return -1;
            }
        }
        return -1;
    }
    function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
        $returnData="";//data{cities or courses want to return}
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
        if($whatToReturn==5){//for courses
            while ($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
                if ($rows['id']==$id){
                        if($rows['subject']!='subject'){
                            $returnData.=$rows['subject'];
                        break;
                        }
                    }	
            }
        }else{//for cities
            $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
            while ($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
                if ($rows['id']==$id){
                    if($rows['cities']!='cities'){
                        $returnData.=$rows['cities'];
                    break;
                    }			
                }		
            }
        }
        return $returnData; // return data     
    }
	$ImgSource=" ";
    $teacherArrayInformation=array();
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $IdResults = mysqli_query($con, "SELECT * FROM teachers");
    while ($row=mysqli_fetch_assoc($IdResults)){
        if ($row['id']==$ID){ //get variables to use on HTML view
            $teacherArrayInformation[0]=$row['username'];
            $teacherArrayInformation[1]=$row['fname'];
            $teacherArrayInformation[2]=$row['lname'];
            $teacherArrayInformation[3]=$row['phone'];
            $teacherArrayInformation[4]=$row['email'];
            $teacherArrayInformation[5]=$row['price'];
            $teacherArrayInformation[6]=$row['status'];          
		}
    }
    $teacherArrayInformation[7]=getToggleButtonStatus($ID);//to display board time or not
    // next to get the courses that teacher learn and cities teacher where in. for each of them create an array to use it later,each subject will be as a button
    $Cities= " "; 	$Courses=" ";   
    $Courses=returnTeacherCitiesOrCoursesIntoArray($ID,5);//courses 
    $arrayOfTeacherCourses=array();
    $arrayOfTeacherCourses=insertCitiesAndCoursesOnArray($Courses,$arrayOfTeacherCourses);
    $Cities=returnTeacherCitiesOrCoursesIntoArray($ID,3);//cities
    $arrayOfTeacherCities=array();	
    $arrayOfTeacherCities=insertCitiesAndCoursesOnArray($Cities,$arrayOfTeacherCities);
    function  getImage($id){// function to return image for teacher name and comments wirters
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
        $ImgSource=" ";
        while ($rowOfCommentWriter=mysqli_fetch_array($resultsOfImageTable)){
            if ($rowOfCommentWriter['id']==$id){//found the image by id
                $ImgSource=$rowOfCommentWriter['image'];
                return $ImgSource;
            }
        }
    } 
    $ImgSource=getImage($ID);    
    function getName($id){// function used to return first name and seconde name as one name. use on teacher name and on names of comments wirters
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $IdResults = mysqli_query($con, "SELECT * FROM teachers");
        $name=" ";
        while ($row=mysqli_fetch_assoc($IdResults)){
            if ($row['id']==$id){//when we found the name on the table of DB            
                $name.=$row['fname'];
                $name.='&nbsp;';
				$name.=$row['lname'];
                return $name;
			}
		}
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>הכיתה</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>    
        <link rel="stylesheet" type="text/css" href="css/profileStyle.css">
        <style>
            body {font-family: Arial;}
            /* Style the tab */
            .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            }
            /* Style the buttons inside the tab */
            .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
            }
            /* Change background color of buttons on hover */
            .tab button:hover {
            background-color: #ddd;
            }
            /* Create an active/current tablink class */
            .tab button.active {
            background-color: #ccc;
            }
            /* Style the tab content */
            .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
            }
        </style>
        <?php
            if(isset($_POST['chooseLessonButton'])||$_POST['chooseLesson']){ // ask for a lesson with teacher 
               if($_POST['openModel']){//user after choose a lesson, automaticly will open a window with data about teacher and about lesson, to be sure.
                    $lessonTime=$_POST['chooseLessonButton'];// we get this to show for student the day and hour of lesson 
                    $hour;$day;//two variable to save data on DB, saving data use day of lesson and hour of lesson
                    if($lessonTime<100){
                        $hour=$lessonTime%10;
                        $d=$lessonTime/10;
                        $day=floor($d);
                    }else{
                        $hour=$lessonTime%100;
                        $d=$lessonTime/100;
                        $day=floor($d);
                    }//form _POST['chooseLessonButton'] we get the number of day on current week, for example we get the number 3 as a day variable that mean tuesday and this week start as a date 8/3 on sunday so the date on tuesday will be 10/8
                    $firstday = date('d/m/Y', strtotime("this week")); 
                    $intDateOfFirstDayOnWeek=intval($firstday);
                    $day+=$intDateOfFirstDayOnWeek;$day-=2;//next script for showing the window
                    if(!$IDOfStudent){
                        echo "<script>$(document).ready(function(){ $('#myModall').modal('show');});</script> ";
                        echo "
                        <li>
                            <div class=\"modal fade\" id=\"myModall\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                                <div class=\"modal-dialog\" role=\"document\">
                                    <div class=\"modal-content\">
                                        <div class=\"modal-header\"><h4 class=\"modal-title\" id=\"myModalLabel\">  כניסה לחשבון </h4></div>
                                        <form  name=\"feedbackForm\" action=\"viewTeacherProfile.php\" method=\"post\">";   
                                            echo"<input name=\"id\" type=\"hidden\" value=\"$ID\">"; 
                                            echo"<div class=\"modal-body\">
                                            <div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                                                <input type=\"text\" class=\"form-control\" name=\"usernameLogin\" placeholder=\"שם משתמש\" title=\"הזנת שם משתמש \" required>
                                            </div> <br>
                                            <div class=\"input-group\">
                                                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                                <input type=\"password\" class=\"form-control\" name=\"PasswordLogin\" placeholder=\"סיסמה\" title=\"הזנת סיסמה\"required >
                                            </div>
                                            <fieldset> 
                                                <div class=\"text-center\">
                                                    <input type=\"submit\" class=\"logSignButton btn btn-info btn-primary text-center\"  value=\"כניסה למערכת \">
                                                </div>
                                            </fieldset>
                                        </form><br>
                                        <button type=\"submit\" class=\"btn btn-info\" data-dismiss=\"modal\">יציאה</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </li>";
                    }else{
                        echo "<script> $(document).ready(function(){ $('#myModalOfCheckTeacherInformation').modal('show'); }); </script>";
                    }
               } 
               else{//student after sure about the information above, will get to this section, to insert data on DB.
                    $ID=$_POST['id'];
                    $IDOfStudent=$_POST['studentID'];
                    $lessonTime=$_POST['chooseLessonButton'];
                    $hour;$day;//two variable to save data on DB, saving data use day of lesson and hour of lesson
                    if($lessonTime<100){
                        $hour=$lessonTime%10;
                        $d=$lessonTime/10;
                        $day=floor($d);
                    }else{
                        $hour=$lessonTime%100;
                        $d=$lessonTime/100;
                        $day=floor($d);
                    }//form _POST['chooseLessonButton'] we get the number of day on current week, for example we get the number 3 as a day variable that mean tuesday and this week start as a date 8/3 on sunday so the date on tuesday will be 10/8
                    date_default_timezone_set('Asia/Jerusalem');  
                    $script_tz = date_default_timezone_get();
                    $firstday = date('d/m/Y', strtotime("this week")); 
                    $intDateOfFirstDayOnWeek=intval($firstday);
                    $day+=$intDateOfFirstDayOnWeek;$day-=2;
                    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
                    while ($scheduleRow=mysqli_fetch_assoc($scheduleResult)){//save the data of asking lesson on DB
                        if ($scheduleRow['idOfTeacher']==$ID){//after we found the teacher id
                            if($scheduleRow['dayOfLesson']==$day && $scheduleRow['hourOFLesson']==$hour){
                                $upDate="UPDATE `teacherSchedule` SET `fullOrFree`='1' , `idOfStudent`=$IDOfStudent
                                WHERE idOfTeacher=$ID  and hourOFLesson=$hour  and dayOfLesson=$day";
                                $result = mysqli_query($con,$upDate);
                            }
                        }
                    }
             }    
        }             
        ?>
    </head>
    <body>
        <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
        <section><!--navbar section// for login user and unlogin user-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="Hakita.php">הכיתה</a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <?php
                            if(!$IDOfStudent){//navbar for user without login
                                echo '
                                <li class="nav-item active"><a class="nav-link" href="Hakita.php">עמוד הבית <span class="sr-only">(current)</span></a></li>
                                <li class="nav-item active"><a class="nav-link" href="searchTeachers.php">חיפוש מורה <span class="sr-only">(current)</span></a></li>                        
                                <li class="nav-item active"><a class="nav-link" href="loginSignUP.php">כניסה/הרשמה <span class="sr-only">(current)</span></a></li> 
                                <li class="nav-item active"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>';
                            }else{//navbar for user with login
                                echo "
                                <li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php?id=$IDOfStudent\">עמוד הבית <span class=\"sr-only\">(current)</span></a></li>
                                <li class=\"nav-item active\"><a class=\"nav-link\" href=\"searchTeachers.php?id=$IDOfStudent\">חיפוש מורה <span class=\"sr-only\">(current)</span></a></li>";
                                $isStudent=-1; //for redirect login user to teacher or student profile
                               // include 'connectionPage.php';//include this file for calling the DB
                               $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                               $IdResults = mysqli_query($con, "SELECT * FROM teachers");
                                while ($rows=mysqli_fetch_array($IdResults)){
                                    if ($rows['id']==$IDOfStudent && $rows['setUserAs']=='student'){//found the required id
                                        $isStudent=1;	break;//change the flag to one, and break, no need to continue.
                                    }
                                }
                                if($isStudent==1){//redirect to student profile
                                    echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php?id=$IDOfStudent\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
                                }else{//redirect to teacher profile
                                    echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php?id=$IDOfStudent\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
                                }
                                echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"FAQ.php?id=$IDOfStudent\">שאלות ותשובות</a></li>
                                    <li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php\">יציאה </a></li>";
                            }
                        ?> 
                    </ul>
                </div>
            </nav>
        </section>
        <div id="myModalOfCheckTeacherInformation" class="modal fade"><!--this section is for the window, that will open to show the information of lesson student choose-->
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"> לפני קביעת השיעור נא לאשר את הפרטים הבאים</h4>
                    </div>
                    <div class="modal-body">
                        <form action="viewTeacherProfile.php" method="post">
                            <?php
                                $chooseLessonButton=$_POST['chooseLessonButton'];//get information about lesson/teacher/student...to insert on DB
                                $IDOfTeacher=$_POST['id'];
                                $IdOfStudent=$_POST['studentID'];
                                $teacherName=getName($IDOfTeacher);
                                echo "שיעור עם המורה:".$teacherName."<br>";
                                echo "תאריך השיעור: ".$day." לחודש הזה <br>";
                                echo "שעת השיעור: ".$hour.":00<br>";
                                echo"<input name=\"chooseLessonButton\" type=\"hidden\" value=\"$chooseLessonButton\" id=\"$chooseLessonButton\">";                                        
                                echo"<input name=\"id\" type=\"hidden\" value=\"$IDOfTeacher\" id=\"$IDOfTeacher\">"; 
                                echo"<input name=\"studentID\" type=\"hidden\" value=\"$IdOfStudent\" id=\"$IdOfStudent\">"; 
                            ?>                                    
                            <button type="submit" class="btn btn-primary">המשך</button>
                            <button type="button" class="close btn-info" data-dismiss="modal" aria-hidden="true">יציאה</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <section class="z">        
            <div class="container">
                <div class="span3 well">
                    <center>
                    <a href="#aboutModal" data-toggle="modal" data-target="#myModal">
                    <?php
                        echo "<img src='img/".$ImgSource."' height=140  width=140 class='img-circle'></a>";			
                        echo "<h3>" . $teacherArrayInformation[1]."&nbsp;". $teacherArrayInformation[2]."</h3>";
                        $countRatingOfTeacher=0;         $totalCountRatingOfTeacher=0;
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
                        if ($teacherArrayInformation[5]!=1&&$teacherArrayInformation[5]!=null){
                            echo "<h6>" . "מחיר לשעה:-" .$teacherArrayInformation[5] ."</h6>";	
                        }
                        echo "<h6>".$teacherArrayInformation[6]."</h6>";                     
                    ?>
                    </center>
                </div>           
            </div>                                           
        </section>
        <section class="choose">
            <div class="row"><!--navbar for direction on teacher profile, {about teacher, teacher dashboard, comments about teacher }-->
                <button class="tablink col-sm-3" onclick="openCity(event, 'aboutTeacher')"> פרטי המורה</button>
                <?php
                    if($teacherArrayInformation[7]==1){//display board time
                        echo"<button class=\"tablink col-sm-3\" onclick=\"openCity(event, 'dashboardSection')\">לוח שיעורים</button>";
                    }
                ?>
                <button class="tablink col-sm-3" onclick="openCity(event, 'Links')">צור קשר ושיתוף</button>
                <button class="tablink col-sm-3" onclick="openCity(event, 'comments')">תגובות </button>
            
            </div>
            </section>
            <br><br>     
           <div id="aboutTeacher" class="tabcontent">
                <?php
                    echo '<div class="row"><div class="col-sm-6">';
                    echo "<h4>" . $teacherArrayInformation[1]."&nbsp;". $teacherArrayInformation[2]."</h4><hr>";
                    if ($teacherArrayInformation[5]!=1&&$teacherArrayInformation[5]!=null) {//to show the teacher price
                        echo "<h4>" . "מחיר לשעה:-" .$teacherArrayInformation[5] ."</h4>";	echo"<hr>";
                    }	    
                    if ($teacherArrayInformation[3]!=' '&&$teacherArrayInformation[3]!=null){//to show the teacher phone number if there is
                        echo "<h4>"."מספר טלפון:".$teacherArrayInformation[3]."</h4>";echo"<hr>";
                    }        
                    echo "<h4>".$teacherArrayInformation[4]."</h4><hr>";
                    echo "<h4>".$teacherArrayInformation[6]."</h4></div>";
                    $D=array();
                    $D[0]=$courseResultArray[$ID];    
                    echo "<div class=\"col-sm-3\" id=\"courseButtons\">";
                    echo "<form action=\"searchTeachers.php\" method=\"post\">";
                    if(count($arrayOfTeacherCourses)>0){//print courses that teacher learn as a buttons, that click on it redirect student to show more teachers learn the same subject
                        for($ci=0;$ci<count($arrayOfTeacherCourses);$ci++){
                            $r=$arrayOfTeacherCourses[$ci];
                            echo "<input  class=\"courseButtons\" type=\"submit\" name=\"hidden_framework_courses\" value=\"$arrayOfTeacherCourses[$ci]\"  önclick=\" goToSearchPage()\" >";
                        }
                    }
                    echo "</div><div class=\"col-sm-3\" id=\"cityButtons\">";
                    if(count($arrayOfTeacherCities)>0) {//print cities that teacher live in as a buttons, that click on it redirect student to show more teachers on the same city
                            for($ci=0;$ci<count($arrayOfTeacherCities);$ci++){
                                echo "<input  class=\"courseButtons\" type=\"submit\" name=\"hidden_framework\" value=\"$arrayOfTeacherCities[$ci]\"  önclick=\" goToSearchPage()\" >";
                            }
                        }
                    echo "</form></div></div>";
                ?>
            </div>
            <div id="dashboardSection" class="tabcontent"><!--section times lessons for teacher,
            user can show the lesson times for teacher as a green button.if user want to choose
            a specific lesson he need to be login first if not he will show{login to choose a lesson
            then he could choose}-->
                <?php
                    if(!$IDOfStudent){//user not login----> click sign in then insert username & password to continue or EXIT                                    
                        echo ' <button  class="addCommentButton btn btn-warning" alt="work 1" data-toggle="modal" data-target="#myModal"> <h5>  רשום כדי לקבוע שיעור</h5></button>';
                        echo '
                        <li>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header"><h4 class="modal-title" id="myModalLabel">  כניסה לחשבון </h4></div>
                                        <form  name="feedbackForm" action="viewTeacherProfile.php" method="post">';  
                                            echo"<input name=\"chooseLesson\" type=\"hidden\" value=\"$chooseLesson\">"; 
                                            echo"<input name=\"id\" type=\"hidden\" value=\"$ID\">"; 
                                            echo'<div class="modal-body">
                                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input type="text" class="form-control" name="usernameLogin" placeholder="שם משתמש" title="הזנת שם משתמש " required>
                                            </div> <br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input type="password" class="form-control" name="PasswordLogin" placeholder="סיסמה" title="הזנת סיסמה"required >
                                            </div>
                                            <fieldset> 
                                                <div class="text-center">
                                                    <input type="submit" class="logSignButton btn btn-info btn-primary text-center"  value="כניסה למערכת ">
                                                </div>
                                            </fieldset>
                                        </form><br>
                                        <button type="submit" class="btn btn-info" data-dismiss="modal">יציאה</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </li>';
                    }
                    
                ?>
            <section class="board">         
                <table class="table table-sm table-dark">
                    <thead>                                
                    <?php 
                        $todayIndex;// case the time is according to where the server location, we need to check that time is right according israel
                        date_default_timezone_set('Asia/Jerusalem');  
                        $script_tz = date_default_timezone_get();
                        $todayOnWeek=date('d-m-Y'); 
                        $day_of_week = date('N', strtotime($todayOnWeek));
                        $todayIndex=$day_of_week+1;  
                        $currentHour=date('H');
                        $currentHour+=1;
                        if($todayIndex>7){
                            $todayIndex=1;  
                        }                      
                        $days = array(1 => 'Sunday',2 => 'Monday',3 => 'Tuesday',4 => 'Wednesday',5 => 'Thursday',6 => 'Friday',7 => 'Saturday');
                        $daysArray=array();$daysArrayCounter=0;
                        for($d=1;$d<=7;$d++){// case the time is according to where the server location, we need to check that time is right according israel
                            if($todayIndex<=$d){
                                $daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d])); 
                            }else{
                                $daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d]."-1 week"));
                            }
                            $daysArrayCounter++;
                        }//hebrew letters for show as a days of week on table
                        $FirstLetterHebrewArray=array(1 => 'א-',2 => 'ב-',3 => 'ג-',4 => 'ד-',5 => 'ה-',6 => 'ו-',7 => 'שבת-',);
                        echo "<tr><th>שעה/יום</th>";
                        for($d=1;$d<=7;$d++){
                            $q=$d-1;
                            echo" <th scope=\"col\">$FirstLetterHebrewArray[$d]$daysArray[$q]</th>";
                        }
                        echo "</tr>";
                    ?>
                    </thead>
                    <tbody><!--after be a login or already login, choose a lesson, then insert the detials on DB{student id, teacher is, time of lesson}-->
                   <form action="viewTeacherProfile.php" method="post">                               
                        <?php
                            echo"<input name=\"openModel\" type=\"hidden\" value=\"1\" id=\"1\">"; //hidden teacher id, for logic
                            echo"<input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\">"; //hidden teacher id, for logic
                            echo"<input name=\"studentID\" type=\"hidden\" value=\"$IDOfStudent\" id=\"$IDOfStudent\">"; //hidden student id, for logic
                            for($hours=7;$hours<=22;$hours++){//show time's
                                if($hours%2==0){
                                    echo "<tr class=\"bg-primary\">";
                                }else{
                                    echo "<tr>";
                                }
                                if($hours<10){
                                    echo "<th>"."0".$hours.":00"."</th>";
                                }else{
                                    echo "<th>".$hours.":00"."</th>";
                                }
                                for($Days=0;$Days<7;$Days++){
                                    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                                    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
                                    $DaysId=$Days+1; 
                                    $addAsString=strval($DaysId);
                                    $addAsString.=$hours;
                                    $buttonGiveId=intval($addAsString);                       
                                    $alreadyInsert=-1;
                                    while ($scheduleRow=mysqli_fetch_assoc($scheduleResult)){
                                        if ($scheduleRow['idOfTeacher']==$ID){
                                           for($r=0;$r<5;$r++){//check if on this day and on this hour, teacher want to be a lesson, or yes he wanted and somebody already ask for a lesson on this time
                                                $t=$r*7;
                                                if(($scheduleRow['dayOfLesson']==$DaysId+$t) && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==-1){//teacher want to learn on this time and no body yet ask for a lesson on this time 
                                                    $alreadyInsert=1;
                                                }else if(($scheduleRow['dayOfLesson']==$DaysId+$t) && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==1){//teacher want to learn on this time and somebody already asked for a lesson on this time
                                                    $alreadyInsert=2;
                                                }
                                           }
                                        }
                                    }
                                    if($Days+1>=$todayIndex){//show the times that teacher can learn as a green buttons
                                        if($Days+1==$todayIndex && $currentHour>$hours){
                                            echo "<th>"."עבר"."</th>";
                                        }
                                        elseif($hours<10&&$alreadyInsert==1){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">"."0".$hours.":00+"."</button></th>";
                                        }else if($hours<10&&($alreadyInsert==-1||$alreadyInsert==2)){
                                            echo "<th>"."0".$hours.":00+"."</th>";
                                        }else if($hours>=10&&$alreadyInsert==1){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">".$hours.":00+"."</button></th>";
                                        }else{
                                            echo "<th>".$hours.":00+"."</th>";
                                        }
                                        $alreadyInsert=-1;
                                    }else{
                                        echo "<th>"."עבר"."</th>";
                                    }
                                }
                                echo "</tr>";
                            }     
                        ?>
                    </form> 
                    </tbody>
                </table>
            </section> 
            </div>
            <div id="Links" class="tabcontent">
            <div class="row">
                    <div class="form-group col-sm-6">
                        <h3>שיתוף מורה</h3>
                        <label for="facebook"><h4  class="inputTitleIcon">FACEBOOK</h4><div class="fa fa-facebook"></div></label>
                        <label for="linkedin"><h4  class="inputTitleIcon">LINKEDIN</h4><div class="fa fa-linkedin"></div></label>               
                        <label for="youtube"><h4  class="inputTitleIcon">YOUTUBE</h4><div class="fa fa-youtube"></div></label>
                        <label for="otherLinkOne"><h4  class="inputTitleIcon">קישור אחר</h4></label>
                        <label for="otherLinkTwo"><h4  class="inputTitleIcon">קישור אחר</h4></label>
                    </div>
                    <div class="form-group col-sm-6"><!--section for connection with teacher,-->
                        <h3>קישורים למורה</h3>                  
                    </div>
                    <hr>
                    <div class="form-group col-sm-6">
                        <h3>פרטי תקשורת</h3> 
                        <?php
                            if ($teacherArrayInformation[3]!=' '){
                                echo "<h4>"."מספר טלפון:".$teacherArrayInformation[3]."</h4>";
                            }        
                            echo "<h4>".$teacherArrayInformation[4]."</h4>";        
                        ?>                                              
                    </div>                        
                <div class="form-group col-sm-6">
                    <h1 class="letters">שליחת הודעה למורה</h1>
                    <form action="">
                        <input type="text" name="" placeholder="שם" class="form-control">
                        <input type="email" name="" placeholder="מייל לצור קשר" class="form-control">
                        <input type="text" name="" placeholder="תוכן ההודעה" class="form-control">
                        <input type="submit" value="send" class="btn btn-success text-center">
                    </form>
                </div>
                </div>
            </div>
            <div id="comments" class="tabcontent">
                <li>
                    <?php
                        if($IDOfStudent) {// for login user, let them to write comment, later it will be  avilable just after get a lesson
                            echo "<button  class=\"addCommentButton btn btn-warning\" alt=\"work 1\" data-toggle=\"modal\" data-target=\"#myModalc\" title=\"כפתור הוספת תגובה על המורה\"> <h5>הוספת תגובה חדשה</h5></button>";
                        }
                    ?>
                    <div class="modal fade" id="myModalc" tabindex="-1" role="dialog" aria-labelledby="myModalLabelv">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabelv">הוספת תגובה</h4>
                                </div>
                                <form  name="feedbackForm" action="viewTeacherProfile.php" method="post">
                                    <?php
                                        echo"<input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\">"; 
                                        echo"<input name=\"studentID\" type=\"hidden\" value=\"$IDOfStudent\" id=\"$IDOfStudent\">"; 
                                    ?>
                                    <div class="modal-body">
                                        <div class="pleaseAddFeedback">
                                            אנא ספק/י את המשוב שלך להלן:
                                        </div>
                                        <hr>
                                        <div class="feedbackValueTitle">
                                        איך את/ה מדרג/ת את החוויה הכוללת שלך ?
                                            <div>
                                                לא טוב-
                                                <input type="radio" name="teacherValue" id="oneValue" value="1"  required>1
                                                <input type="radio" name="teacherValue" id="twoValue" value="2"  required>2
                                                <input type="radio" name="teacherValue" id="threeValue" value="3"  required>3
                                                <input type="radio" name="teacherValue" id="fourValue" value="4" required>4
                                                <input type="radio" name="teacherValue" id="fiveValue"  value="5" required>5
                                                -מצויין
                                            </div>
                                        </div><hr>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <textarea class="form-control" type="textarea" name="comments" id="comments" placeholder="הערות/תגובות שלך" maxlength="6000" rows="7" required></textarea><hr>
                                        <fieldset> 
                                            <div class="text-center"><input type="submit" class="logSignButton btn btn-info btn-primary text-center" title="שמירת פיידבאק וחזרה" value="הוספה כ-תגובה חדשה"></div>
                                        </fieldset>
                                </form> <br>
                                    <button type="submit" class="btn btn-info" data-dismiss="modal">יציאה ללא הוספת </button>
                                </div>
                            </div>
                        </div>
                        </div>
                </li>
                <?php                            
                    $thereIsAnyComment=-1;
                    $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
                    while ($commentRow=mysqli_fetch_assoc($commentResult)){ //get comments if there any comments
                        if($commentRow['idOfTeacher']==$ID) {
                            $thereIsAnyComment=1;
                            $idOfCommentWriter=$commentRow['idOfCommentWriter'];
                            $getRatingOfEachComment=$commentRow['rating'];
                            $dateOfComment=$commentRow['dateOfComment'];
                            $textOfComment=$commentRow['textOfComment'];
                            echo "<div class=\"commentCard col-sm-10\">"; 
                            echo '<div class="col-sm-1">';
                            echo "<img src='img/".getImage($idOfCommentWriter)."'   class=\"commentsImages\"></div><p>".$textOfComment."</p>";
                            echo "<p class=\"textOfComment\">".getName($idOfCommentWriter)."</p>";   
                            for($star=0;$star<$getRatingOfEachComment;$star++){
                                echo ' <span class="fa fa-star checked"></span>';
                            }
                            $emptyStars=5-$getRatingOfEachComment;$e=0;
                            while($e<$emptyStars){
                                $e++;echo '<span class="fa fa-star"></span>';
                            }
                            echo "<p>".$dateOfComment."</p><hr></div>";
                        }
                    }
                    if($thereIsAnyComment==-1){
                        echo " <h1>אין עוד תגובות</h1>";
                    }
                ?>
            </div>
              
        <div class="ButtomFooter">      
        <div class="container">
        <div class="row">
        <div class="col-sm-4">
            עקובו אחרינו ב-פייסבוק:-
                <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
            </div>            
            <div class="col-sm-3">
            📚            
        רשימת מקצועות לימוד
        <br>
        צור קשר איתנו📧
            
        <p >הוספת פרויפיל</p>
            </div>
            <div class="col-sm-5">
            &copy;כל הזוכיות שמורות לאתר הכיתה
                <a href="https://www.jce.ac.il/">
                    </a><br>
                    קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
                    <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
                </div>
        </div>
        </div>
        </div>
        <script>
            function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
            }
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
        </script>
        </body>
</html>