<?php
/**
 * this is the teacher profile page, on this page teacher display information about him/her,
 * option to redirect to Edit page to make any changes,  read/send message for site users,
 * check for a student ask him for a lesson, choose time for his lesson if he would, 
 * display or not the time lessons board on the student side.
 */
session_start();      
    $ID=$_SESSION['id'];//get the teacher id.
    $_SESSION['id']=$ID;
    include 'userData.php';//call userData, to use some function from
    $defaultNavBar=-1;   

    //get the viewer counter
    $viewCounter=getProfileViewerCounter($ID);
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");//connection with DB
    if(isset($_POST['trashButton'])){//if teacher want to delete any student feedback(comment)
        $defaultNavBar=2;
        $idOfCommentWriter=getRandValues($_POST['idOfCommentWriter']);//id Of Comment Writer
        $dateOfComment=$_POST['dateOfComment'];//date Of Comment,case student may be write more than one feedback
        $sql="DELETE FROM dBOfComments WHERE idOfTeacher=$ID and idOfCommentWriter=$idOfCommentWriter";
        if($con->query($sql)===TRUE){
        }                
    }
    //variables will used on HTML   //(username,status,email,first name, last name, phone number, cities, courses,img,price)
    $teacherImforamtionArray=array();//this array will include main information about login teacher as like as first name,.... check next
    
    if(isset($_POST['chooseLessonButton'])){//after teacher check buttons on time lesson board, get to here to insert it on DB 
        $alreadyInsert=-1;$defaultNavBar=1;$lessonTime=$_POST['chooseLessonButton'];//selected botton
        $hour;$day;//get which day of a week and which hour
        if($lessonTime<100){
            $hour=$lessonTime%10;
            $d=$lessonTime/10;$day=floor($d);
        }else{
            $hour=$lessonTime%100;
            $d=$lessonTime/100;$day=floor($d);
        }
        $todayIndex;
        date_default_timezone_set('Asia/Jerusalem'); 
        $script_tz = date_default_timezone_get();
        $todayOnWeek=date('d-m-Y');
        $day_of_week = date('N', strtotime($todayOnWeek));
        $todayIndex=$day_of_week+1;  
        $currentHour=date('H');
        $today=date("l");
        if($todayIndex>7){$todayIndex=1;}                      
        $days = array(1 => 'Sunday',2 => 'Monday',3 => 'Tuesday',4 => 'Wednesday',5 => 'Thursday',6 => 'Friday',7 => 'Saturday');
        for($d=1;$d<=7;$d++){
            if($d==$day){
                if($todayIndex<=$d){$integrDay=date('d', strtotime($days[$d]));}
                else{$integrDay=date('d', strtotime($days[$d]."-1 week"));}
                $day=intval($integrDay);
            }            
        }   
        $firstday = date('d', strtotime("this week")); 
        $month = date('m');
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        while($scheduleRow=mysqli_fetch_assoc($scheduleResult)){// check if botton clicked before
            if($scheduleRow['idOfTeacher']==$ID){
                if($scheduleRow['dayOfLesson']==$day && $scheduleRow['hourOFLesson']==$hour){
                    $alreadyInsert=1;break;
                }
            }
        }
        if($alreadyInsert==1){//if was clicked, teacher was choice this time as an hour he wanted to learn on it, then he not.
            $alreadyInsert=-1;
            $sql = "DELETE FROM teacherSchedule WHERE idOfTeacher=$ID AND dayOfLesson=$day AND hourOFLesson=$hour";//update it on table
            if ($con->query($sql) === TRUE){}else{
                echo "Error deleting record: " . $con->error;
            }
        }else{//if not clicked, insert as a new option teacher can learn on this time
            $defaultNavBar=1;          
            $year = date("Y");
            $checkDay.=(string)$day;
            $TotalDate =  $year.'-'. $month  .'-'. $checkDay;
            $lessonsAmount=getTeacherTeachedLessonsAmount($ID);
            $query="INSERT INTO `teacherSchedule`(`idOfTeacher`,`hourOFLesson`,`idOfStudent`,`fullOrFree`,`dayOfLesson`,`lessonDate`,`checkbox`,`lessonsAmount`) 
            VALUES ('$ID','$hour','000','-1','$day','$TotalDate','1','$lessonsAmount')";
            $result = mysqli_query($con,$query);
        } 
    }
    if(!empty($_POST['dashboardSectionbutton'])){//change the status oo dispaly or not for the time board
        $defaultNavBar=1;
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$ID&&$rows['checkbox']==1){//if it's on display mode set as not
                $teacherImforamtionArray[11]=-1;
                $upDate="UPDATE `teacherSchedule` SET `checkbox`='-1' WHERE idOfTeacher=$ID";
                $result=mysqli_query($con,$upDate);
            break; 
            }elseif($rows['idOfTeacher']==$ID&&$rows['checkbox']==-1){//if it's not on display mode set as yes
                $teacherImforamtionArray[11]=1;
                $upDate="UPDATE `teacherSchedule` SET `checkbox`='1' WHERE idOfTeacher=$ID";
                $result=mysqli_query($con,$upDate);
            break; 
            }
        }
    }  
    if($ID){//after get the id from login or by update on profile page, check teacher main information by above function
        $teacherImforamtionArray=returnTeacherInformationIntoArray($ID,$teacherImforamtionArray);
    }else{//if there is no id, redirect to logout page to forget eacher id/username and then to redirect to the main page
        header('location: logout.php');
    }
    $teacherImforamtionArray[8]=returnTeacherCitiesOrCoursesIntoArray($ID,3);//get cities of teacher
    $teacherImforamtionArray[9]=returnTeacherCitiesOrCoursesIntoArray($ID,5);//get courses of teacher
    $teacherImforamtionArray[10]=Image($ID);//get the from userData.php
    $teacherImforamtionArray[11]=getToggleButtonStatus($ID);//get the toggle status, from userData.php
    $arrayOfLessons=array();
    $counterArrayOfLessons=0;    
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <?php include 'header.php';/*get the header from header.php file*/?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/profile.css"><!--some addition CSS-->
  </head>
  <body>
    <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
    <section><!--navbar section--><!--navbar include the main page of the site FAQ page, EXIT-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>        
                <a class="navbar-brand" href="Hakita.php">הכיתה</a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li>
                        <li class="nav-item active"><a class="nav-link" href="messageRoom.php">הודעות</a></li>
                        <li class="nav-item active"><a class="nav-link" href="EditPage.php">עדכן פרופיל</a></li>
                        <li class="nav-item active"><a class="nav-link" href="Lesson.php"> שיעורים</a></li>
                        <li class="nav-item active"><a class="nav-link" href="searchTeachers.php">חיפוש מורה </a></li>             
                        <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only"></span></a></li>
                    </ul>
                </div>
          </nav>
    </section>
    <section class="z">        
        <div class="container">
            <div class="span3 well">
                <center>
                    <?php
                    //main teacher information
                        echo"<a href=\"#aboutModal\" data-toggle=\"modal\"><img src='img/".$teacherImforamtionArray[10]."' height=140  width=140 class='img-circle'></a>";
                        echo"<h2>".$teacherImforamtionArray[1]." ".$teacherImforamtionArray[2]."</h2>";//teacher name
                        echo"<h5>".$teacherImforamtionArray[4]."</h5>";  
                        echo"<h5>".teacherStudy($ID)."</h5>";
                        echo"<h5>".$teacherImforamtionArray[5]."</h5>";//teacher status
                        echo"<p>".teacherRating($ID)."</p>";//from userData.php              
                    ?>
                </center>
            </div>          
        </div>                                           
    </section>
    <section class="choose">
        <div class="container"><!--used as a second navbarfor {aboutTeacher,dashboard,Links,comments,message}-->
            <?php
                if($defaultNavBar==1){
                   echo"<button class=\"tablink col-sm-2\" onclick=\"openPage('aboutTeacher', this, 'blueviolet')\">קורסים ועירים</button>
                    <button class=\"tablink col-sm-2\" onclick=\"openPage('dashboardSection', this, 'orange')\"id=\"defaultOpen\">יומן שיעורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('comments', this, 'blueviolet')\"> תגובות התלמידים שלמדתי </button>";
                }
                elseif($defaultNavBar==2){
                    echo"<button class=\"tablink col-sm-2\" onclick=\"openPage('aboutTeacher', this, 'blueviolet')\">קורסים ועירים</button>
                    <button class=\"tablink col-sm-2\" onclick=\"openPage('dashboardSection', this, 'orange')\">יומן שיעורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('comments', this, 'blueviolet')\"id=\"defaultOpen\"> תגובות התלמידים שלמדתי </button>";
                }else{
                    echo"<button class=\"tablink col-sm-2\" onclick=\"openPage('aboutTeacher', this, 'blueviolet')\"id=\"defaultOpen\">קורסים ועירים</button>
                    <button class=\"tablink col-sm-2\" onclick=\"openPage('dashboardSection', this, 'orange')\">יומן שיעורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('comments', this, 'blueviolet')\"> תגובות התלמידים שלמדתי </button>";
                }
            ?>            
            <button class="tablink col-sm-3" onclick="openPage('Links', this, 'orange')">יצירת קשר/שיתוף פרופיל</button>
        </div><!--next section is the main section as a main page on profile, display teacher courses that learn and cities located in.-->
        <div id="aboutTeacher" class="tabcontent" style="background-color:white;">   
            <?php
                echo"<div class=\"row\">";
                    echo"<div class=\"col-sm-6\">";// print teacher courses
                    echo"<div class=\"col-sm-6\" id=\"courseButtons\">";
                        if($teacherImforamtionArray[9]!='subject'){
                            echo"<h4>"."מלמד:- ".$teacherImforamtionArray[9]."</h4>";                    
                        }echo"</div><hr><hr></div>";
                    echo"<div class=\"col-sm-6\">";// print teacher cities
                        echo "<div class=\"col-sm-6\" id=\"cityButtons\">";
                        if($teacherImforamtionArray[8]!='cities'){echo "<h4>"."נמצא ב- ".$teacherImforamtionArray[8]."</h4>";}
                        echo"</div><hr><hr></div></div>";    
            ?>
        </div>        
        <div id="comments" class="tabcontent"><!--the section is for comment about teacher, comment user write it, teacher can delete any comment, by click on the trash icon-->    
            <?php  
                echo'<h2>צפיות בפרופיל שלי: '.$viewCounter.'</h2>';
               $thereIsAnyComment=-1;//if there is not any comments stay as value -1, to view 'NO comment'
               $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
                while ($commentRow=mysqli_fetch_assoc($commentResult)){ //get comments if there any comments
                    if($commentRow['idOfTeacher']==$ID){
                        $thereIsAnyComment=1;//at least there is one comments
                        $commnetsPeopleArray[$commnetsPeopleArrayCounter]=$commentRow['idOfCommentWriter'];
                        $getRatingOfEachComment=$commentRow['rating'];//get the rating of each comment to display it
                        $commnetsPeopleArrayCounter++;
                        $dateOfComment=$commentRow['dateOfComment'];//get the date of each comment to display it
                        $nameOfCommentWriter = " ";
                        $WC=$commentRow['idOfCommentWriter'];//get the id of comment writter for using on remove comment status
                        $CW=$ID;//comment card 
                        $value=randValues($WC);
                        echo"<div class=\"card mb-3\" style=\"max-width: 740px; direction: rtl;\">";                        
                            echo"<form action=\"profile.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"idOfCommentWriter\" value=\"$value\">";
                               echo" <input type=\"hidden\" name=\"dateOfComment\" value=\"$dateOfComment\">
                            </form>";
                      $nameOfCommentWriter=name($commentRow['idOfCommentWriter']);//get the name of comment writter to display it
                        echo'<div class="row no-gutters"><div class="col-md-4">';
                        echo"<img src='img/".Image($commentRow['idOfCommentWriter'])." 'class=\"card-img\">";
                        echo '</div><div class="col-md-8"><div class="card-body">';
                        echo"<h5 class=\"card-title\">".$nameOfCommentWriter."";
                        for($star=0;$star<$getRatingOfEachComment;$star++){//the orange star's
                            echo ' <span class="fa fa-star checked"></span>';
                        }
                        $emptyStars=5-$getRatingOfEachComment;$e=0;
                        while($e<$emptyStars){//the empty star's
                            $e++;echo '<span class="fa fa-star"></span>';
                        }echo"</h5>";
                        echo"<p class=\"card-text\">".$commentRow['textOfComment']."</p>";                        
                        echo"<p class=\"card-text\"><small class=\"text-muted\">".$dateOfComment."</small>
                       <button class=\"btn\" name=\"trashButton\" value=\"trashButton\" title=\"מחיקת תגובה\"><i class=\"fa fa-trash\"></i></button></p>";  
                        echo "</div></div></div></div>";        
                    }
                }   
                if($thereIsAnyComment==-1){//if there is no comments
                    echo "<h1>אין תגובות</h1>";
                }
            ?>
        </div>
        <div id="Links" class="tabcontent">
            <div class="form-group">
                <?php
                    if($teacherImforamtionArray[6]!=' '){echo "<h4>"."מספר טלפון: ".$teacherImforamtionArray[6]."</h4>";}        
                    if($teacherImforamtionArray[3] !='email'&&$teacherImforamtionArray[3]!=' '){echo "<h4>" . $teacherImforamtionArray[3] . "</h4>";}                             
                ?>                                              
            </div><hr><hr>
            <div class="form-group">
                <h3>שיתוף את הפרופיל שלי ב-</h3>
                <?php include 'socialLinks.php';
                    $IDOfTeacher=$ID;
                ?>
                <div id="share"></div>
                <script src="jquery.js"></script>
                <script src="jssocials.min.js"></script>
                <script>
                    //first number said the length of the id
                    //after that we will take the digits
                    let url="http://hakita.rf.gd/viewTeacherProfile.php?view=";
                    let IDOfTeacher = <?PHP echo (!empty($IDOfTeacher) ? json_encode($IDOfTeacher) : json_encode($ID));?>;
                    let digits =IDOfTeacher.toString().length;
                    url = url.concat(digits);
                    url = url.concat(IDOfTeacher);     
                    url = url.concat('3f23$3487#ff');                   
                    $("#share").jsSocials({
                        shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "whatsapp"],
                        url,
                        text: "עמוד של המורה",
                        showLabel: true,
                        showCount: true,
                        shareIn: "popup"
                    });
                </script>
            </div><!--copy my profile link-->
            <br>
            <button class="btn btn-info btn-lg" onclick="myFunction()"><span class="glyphicon glyphicon-paperclip">קישור לפרופיל שלי</span></button>  
            <br><br>
                     
        </div><!--next section for the time board lessons, include a button for display the board on the student side or not. and include the board with button for each hour on week 07:00-22:00-->
        <div id="dashboardSection" class="tabcontent">
            <section class="board"><!--the board of lessons-->   
                <table class="table">
                    <thead>                                
                    <?php 
                        $todayIndex;
                        date_default_timezone_set('Asia/Jerusalem'); 
                        $script_tz = date_default_timezone_get();
                        $todayOnWeek=date('d-m-Y');
                        $day_of_week = date('N', strtotime($todayOnWeek));
                        $todayIndex=$day_of_week+1;  
                        $currentHour=date('H');
                        $today=date("l");
                        if($todayIndex>7){$todayIndex=1;}                      
                        $days = array(1 => 'Sunday',2 => 'Monday',3 => 'Tuesday',4 => 'Wednesday',5 => 'Thursday',6 => 'Friday',7 => 'Saturday');
                        $daysArray=array();$daysArrayCounter=0;
                        $daysIntegerArray=array();$daysIntegerArrayCounter=0;
                        for($d=1;$d<=7;$d++){
                            //first two condition for display the top row on board--> display the day and the month
                            if($todayIndex<=$d){$daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d]));}
                            else{$daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d]."-1 week"));}
                            
                            //next two condition for display the buttons on board--> check days with what in DB
                            if($todayIndex<=$d){$integrDay=date('d', strtotime($days[$d]));}
                            else{$integrDay=date('d', strtotime($days[$d]."-1 week"));}
                            $daysIntegerArray[$daysIntegerArrayCounter]=intval($integrDay);

                            $daysArrayCounter++;
                            $daysIntegerArrayCounter++;
                        }
                        $FirstLetterHebrewArray=array(1 => 'א-',2 => 'ב-',3 => 'ג-',4 => 'ד-',5 => 'ה-',6 => 'ו-',7 => 'שבת-',);
                        echo "<tr><th>שעה/יום</th>";
                        for($d=1;$d<=7;$d++){
                            $q=$d-1;
                            echo"<th scope=\"col\">$FirstLetterHebrewArray[$d]$daysArray[$q]</th>";
                        }echo"</tr>";
                    ?>
                    </thead>
                    <tbody>
                   <form action="profile.php" method="post">                               
                        <?php
                            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                            $teacherLessonsArray=array();
                            $lessonResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
                            while($lessonRow=mysqli_fetch_assoc($lessonResult)){
                                if($lessonRow['idOfTeacher']==$ID){   
                                    array_push($teacherLessonsArray, $lessonRow['dayOfLesson'], $lessonRow['hourOFLesson'], $lessonRow['fullOrFree']);
                                }
                            }  

                            for($hours=7;$hours<=22;$hours++){//for display the time borad table, include days/hours/date
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
                                    $returnTodayOfWeekAsANumber=returnTodayOfWeekAsANumber();
                                    for($Days=1;$Days<=7;$Days++){
                                        $addAsString=strval($Days);
                                        $addAsString.=$hours;
                                        $buttonGiveId=intval($addAsString);
                                        if($returnTodayOfWeekAsANumber>$Days||($returnTodayOfWeekAsANumber==$Days&&$currentHour>$hours)){
                                            echo"<th></th>";
                                        }else{
                                            if($hours<10){
                                                if(checkLessonTime($teacherLessonsArray,$daysIntegerArray[$Days-1], $hours)==1){
                                                    echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\" style=\"background-color:green\">"."0".$hours.":00+"."</button></th>";
                                                }elseif(checkLessonTime($teacherLessonsArray, $daysIntegerArray[$Days-1], $hours)==-1){
                                                    echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\" style=\"background-color:red\">"."0".$hours.":00+"."</button></th>";
                                                }else{
                                                    echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\">"."0".$hours.":00+"."</button></th>";
                                                }
                                            }else{
                                                if(checkLessonTime($teacherLessonsArray, $daysIntegerArray[$Days-1], $hours)==1){
                                                    echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\" style=\"background-color:green\">".$hours.":00+"."</button></th>";
                                                }elseif(checkLessonTime($teacherLessonsArray, $daysIntegerArray[$Days-1], $hours)==-1){
                                                    echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\" style=\"background-color:red\">".$hours.":00+"."</button></th>";
                                                }else{
                                                    echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\">".$hours.":00+"."</button></th>";
                                                }
                                            }
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
    </section><!--next to div's for small screen design-->
    <div id="forSmallScreen"><br><br><br><br><br><br><br><br></div>
    <?php include_once 'footer.php';/*call the bottom footer*/?>
    </body>
</html>
<?php include 'script.php';/*use some script, like up button if there is many feedback from students*/?>
