<?php
/**
 * this is the teacher profile page, on this page teacher display information about him/her,
 * option to redirect to Edit page to make any changes,  read/send message for site users,
 * check for a student ask him for a lesson, choose time for his lesson if he would, 
 * display or not the time lessons board on the student side.
 * start a lesson with any user
 * check a payment
 */
    session_start();      
    $ID=$_SESSION['id'];//get the teacher id.
    $_SESSION['id']=$ID;
    $defaultNavBar=-1;   

    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");//connection with DB
    if(isset($_POST['trashButton'])){//if teacher want to delete any student feedback(comment)
        $defaultNavBar=2;
        $idOfCommentWriter=$_POST['idOfCommentWriter'];//id Of Comment Writer
        $dateOfComment=$_POST['dateOfComment'];//date Of Comment,case student may be write more than one feedback
        $sql="DELETE FROM dBOfComments WHERE idOfTeacher=$ID and idOfCommentWriter=$idOfCommentWriter";
        if($con->query($sql)===TRUE){
        }                
    }
    //variables will used on HTML	//(username,status,email,first name, last name, phone number, cities, courses,img,price)
    $teacherImforamtionArray=array();//this array will include main information about login teacher as like as first name,.... check next
    function returnTeacherInformationIntoArray($id,$teacherImforamtionArray){
        $thereIsNoAccountLikeThis=1;
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        while($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id){//get variables to use on HTML view 
				$teacherImforamtionArray[1]=$row['fname'];//first name
				$teacherImforamtionArray[2]=$row['lname'];//last name
				$teacherImforamtionArray[3]=$row['email'];//email
				$teacherImforamtionArray[4]=$row['price'];//price
				$teacherImforamtionArray[5]=$row['status'];//teacher status
                $teacherImforamtionArray[6]=$row['phone'];//teacher phone number
                $thereIsNoAccountLikeThis=-1;
                return $teacherImforamtionArray;
			}
        }
        if($thereIsNoAccountLikeThis==1){
            header('location: Logout.php');
        }
    }

    function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $CoursesOfTeachersResults=mysqli_query($con, "SELECT * FROM teachers_courses");
        $returnData="";//data{cities or courses want to return}
        if($whatToReturn==5){//for courses
            while($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
                if($rows['id']==$id){
                    if($rows['subject']!='subject'){
                        $returnData.=$rows['subject'];break;
                    }
                }	
            }
        }else{//for cities
            $resultOFTeachersCity=mysqli_query($con, "SELECT * FROM teacher_cities"); 
            while($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
                if($rows['id']==$id){
                    if($rows['cities']!='cities'){
                        $returnData.=$rows['cities'];break;
                    }			
                }		
            }
        }return $returnData;//return data     
    }

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
        date_default_timezone_set('Asia/Jerusalem');//get the local time of israel
        $script_tz=date_default_timezone_get();
        $firstday=date('d/m/Y', strtotime("this week"));
        $intDateOfFirstDayOnWeek=intval($firstday);
        $day+=$intDateOfFirstDayOnWeek;
        $day-=2;
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
            $month = date('m');
            $checkDay.=(string)$day;
            $TotalDate =  $year.'-'. $month  .'-'. $checkDay;
            $query="INSERT INTO `teacherSchedule`(`idOfTeacher`,`hourOFLesson`,`idOfStudent`,`fullOrFree`,`dayOfLesson`,`lessonDate`,`checkbox`) 
            VALUES ('$ID','$hour','000','-1','$day','$TotalDate','1')";
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
        include 'userData.php';//call userData, to use some function from
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
    <link rel="stylesheet" type="text/css" href="css/profileStyle.css"><!--some addition CSS-->
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
                        <li class="nav-item active"><a class="nav-link" href="chat.php">הודעות</a></li>
                        <li class="nav-item active"><a class="nav-link" href="EditPage.php">עדכן פרופיל</a></li>
                        <li class="nav-item active"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>
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
                        echo"<h5>"."מחיר לשעה: ".$teacherImforamtionArray[4]."₪</h5>";	
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
                        echo"<div class=\"card mb-3\" style=\"max-width: 740px; direction: rtl;\">";                        
                            echo"<form action=\"profile.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"idOfCommentWriter\" value=\"$WC\">";
                               //<input type=\"hidden\" name=\"idOfTeacher\" value=\"$CW\">
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
                <label for="facebook"><div class="fa fa-facebook"></div></label>
                <label for="linkedin"><div class="fa fa-linkedin"></div></label>   
                <label for="whatsapp"><div class="fa fa-whatsapp"></div></label> 
            </div><!---copy my profile link---->
            <button class="btn btn-info btn-lg" onclick="myFunction()"><span class="glyphicon glyphicon-paperclip">קישור לפרופיל שלי</span></button>           
        </div><!--next section for the time board lessons, include a button for display the board on the student side or not. and include the board with button for each hour on week 07:00-22:00-->
        <div id="dashboardSection" class="tabcontent">
            <form action="profile.php" method="post">  
                <?php
                    if($teacherImforamtionArray[11]==1){//if the button is switch on that mean student can show the teacher time board else not
                       echo'<input type="submit" value="לא להציג יומן שיעורים" name="dashboardSectionbutton">';}
                    else{echo'<input type="submit" value="להציג יומן שיעורים" name="dashboardSectionbutton">';}
                ?>
            </form>
            <section class="board col-sm-12"><!--the board of lessons-->
                <div class="container">      
                <div class="col-sm-12">     
                <table class="table table-sm table-dark">
                    <thead>                                
                    <?php 
                    /*start with get the local time, display the above row include date for each day.
                    button with grey color as an optione of hours teacher can show student that he can learn at these times.
                    green buttons, mean that techer already choose that he can learn on this time.
                    red button mean that there a student ask for a kesson on this time.
                    */
                        $todayIndex;
                        date_default_timezone_set('Asia/Jerusalem'); $script_tz = date_default_timezone_get();
                        $todayOnWeek=date('d-m-Y');$day_of_week = date('N', strtotime($todayOnWeek));
                        $todayIndex=$day_of_week+1;  
                        $currentHour=date('H');
                        $firstdayDateType=date('d', strtotime("this week")); 
                        $firstday=intval($firstdayDateType); 
                        $firstday-=1;  
                        if($todayIndex>7){$todayIndex=1;}                      
                        $days = array(1 => 'Sunday',2 => 'Monday',3 => 'Tuesday',4 => 'Wednesday',5 => 'Thursday',6 => 'Friday',7 => 'Saturday');
                        $daysArray=array();$daysArrayCounter=0;
                        for($d=1;$d<=7;$d++){
                            if($todayIndex<=$d){$daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d]));}
                            else{$daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d]."-1 week"));}
                            $daysArrayCounter++;
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
                         for($hours=7;$hours<=22;$hours++){//for display the time borad table, include days/hours/date
                            if($hours%2==0){echo "<tr class=\"bg-primary\">";}
                            else{echo "<tr>";}
                            if($hours<10){echo "<th>"."0".$hours.":00"."</th>";}
                            else{echo "<th>".$hours.":00"."</th>";}
                            for($Days=0;$Days<7;$Days++){
                                $DaysId=$Days+1; 
                                $addAsString=strval($DaysId);$addAsString.=$hours;
                                $buttonGiveId=intval($addAsString);                       
                                $alreadyInsert=-1;
                                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                                $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
                                while($scheduleRow=mysqli_fetch_assoc($scheduleResult)){
                                    if($scheduleRow['idOfTeacher']==$ID){
                                       for($r=0;$r<5;$r++){
                                            if(($scheduleRow['dayOfLesson']==$Days+$firstday)&&$scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==-1){//for the green button
                                                $alreadyInsert=1;
                                            }elseif(($scheduleRow['dayOfLesson']==$Days+$firstday) && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==1){
                                                $alreadyInsert=2;//for the red button
                                            }
                                       }
                                    }
                                }
                                if($Days+1>=$todayIndex){//display buttons color according to what we decuss above.
                                    if($Days+1==$todayIndex && $currentHour>$hours){echo"<th></th>";}
                                    elseif($hours<10&&$alreadyInsert==-1){echo"<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\">"."0".$hours.":00+"."</button></th>";}
                                    elseif($hours<10&&$alreadyInsert==1){echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\" style=\"background-color:green\">"."0".$hours.":00+"."</button></th>";}//no student yet ask for a lesson on this time, and the teacher can learn on this time
                                    elseif($hours<10&&$alreadyInsert==2){echo "<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\" style=\"background-color:red\">"."0".$hours.":00+"."</button></th>";}//student alredy ask for a lesson on this time
                                    elseif($hours>=10&&$alreadyInsert==1){echo"<th><button name=\"chooseLessonButton\" value=\"$buttonGiveId\" style=\"background-color:green\">".$hours.":00+"."</button></th>";}//no student yet ask for a lesson on this time, and the teacher can learn on this time
                                    elseif($hours>10&&$alreadyInsert==2){echo"<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:red\">".$hours.":00+"."</button></th>";}//student alredy ask for a lesson on this time
                                    else{echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\">".$hours.":00+"."</button></th>";}
                                    $alreadyInsert=-1;
                                }else{echo "<th></th>";}
                            }echo "</tr>";
                        }  
                        ?>
                    </form> 
                    </tbody>
                </table>
                </div></div>
            </section>
        </div>
    </section>
    <?php include_once 'footer.php';/*call the bottom footer*/?>
    </body>
</html>
<?php include 'script.php';/*use some script, like up button if there is many feedback from students*/?>