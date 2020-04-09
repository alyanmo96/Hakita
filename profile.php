<?php

/**can enter to this page with the last user without need to login
 * this is the teacher profile page, on this page teacher show inforation about him and option to make any changes
 * read/send message for site users, check for a student ask him for a lesson, choose time for his lesson if he would
 * start a lesson with any user
 * check a payment
 */
    //variables will used on HTML	//(username,status,email,first name, last name, phone number, cities, courses,img,price)
	$ID;$defaultNavBar=-1;
    session_start();
    //include 'connectionPage.php';//include this file for calling the DB
    //$con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    if(isset($_POST['trashButton'])) { 
        $defaultNavBar=2;
        $idOfCommentWriter=$_POST['idOfCommentWriter'];
        $dateOfComment=$_POST['dateOfComment'];
        $ID=$_POST['idOfTeacher'];
        $sql = "DELETE FROM dBOfComments WHERE idOfTeacher=$ID and idOfCommentWriter=$idOfCommentWriter";
        if ($con->query($sql) === TRUE){
        }                
    }
    $teacherImforamtionArray=array();//this array will include main information about login teacher as like as first name,.... check next
    function returnTeacherInformationIntoArray($id,$teacherImforamtionArray){
        $thereIsNoAccountLikeThis=1;
       // include 'connectionPage.php';//include this file for calling the DB
//        $con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $IdResults = mysqli_query($con, "SELECT * FROM users");
        while ($row=mysqli_fetch_assoc($IdResults)){
            if ($row['id']==$id){//get variables to use on HTML view               
                $teacherImforamtionArray[0]=$row['username'];
				$teacherImforamtionArray[1]=$row['fname'];//first name
				$teacherImforamtionArray[2]=$row['lname'];//last name
				$teacherImforamtionArray[3]=$row['email'];//email
				$teacherImforamtionArray[4]=$row['price'];//price
				$teacherImforamtionArray[5]=$row['status'];//teacher status
                $teacherImforamtionArray[6]=$row['phone'];//teacher phone number
                $teacherImforamtionArray[7]=$row['id'];//teacher login id 
                $thereIsNoAccountLikeThis=-1;
                return $teacherImforamtionArray;
			}
        }
        if($thereIsNoAccountLikeThis==1){
            header('location: Hakita.php');
        }
    }

    function getName($id){// function used to return first name and seconde name as one name. use on teacher name and on names of comments wirters
        //include 'connectionPage.php';//include this file for calling the DB
        //$con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $IdResults = mysqli_query($con, "SELECT * FROM users");
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

    function  getImage($id){// function to return image for teacher name and comments wirters
        //include 'connectionPage.php';//include this file for calling the DB
        //$con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
        $ImgSource=" ";
        while ($rowOfCommentWriter=mysqli_fetch_array($resultsOfImageTable)){
            if ($rowOfCommentWriter['id']==$id){//found the image by id
                $ImgSource=$rowOfCommentWriter['image'];
                return $ImgSource;
            }
        }
    }   

    function getToggleButtonStatus($ID){//function use to check the status of toggle button
        //$con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$ID&&$rows['checkbox']==1){
                return 1;
            }
        }
        return -1;
    }

    function teacherRating($ID){
       // $con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
        $countRatingOfTeacher=0;        
        $totalCountRatingOfTeacher=0;
        while ($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
            if($ratingOfTeacher['idOfTeacher']==$ID){
                $countRatingOfTeacher++;  $totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
            }
        }
        if($countRatingOfTeacher>0){
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
      }

    function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
       // $con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
        $returnData="";//data{cities or courses want to return}
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
        }return $returnData;       // return data     
    }
    if(isset($_POST['chooseLessonButton'])){//after teacher check buttons on dashboard, get to here to insert it on DB 
        
        $alreadyInsert=-1;$defaultNavBar=1;
        if(isset($_GET['id'])){//get the id of teacher
            $ID=$_GET['id'];// by GET
        }else{
            $ID=$_POST['id'];// BY POST
        }
        
        $lessonTime=$_POST['chooseLessonButton'];//selected botton
        $hour;
        $day;//get the day of a week and which hour
        if($lessonTime<100){
            $hour=$lessonTime%10;
            $d=$lessonTime/10;
            $day=floor($d);
        }else{
            $hour=$lessonTime%100;
            $d=$lessonTime/100;
            $day=floor($d);
        }
       // echo "<br><br>day: ".$day."<br><br>";
        date_default_timezone_set('Asia/Jerusalem');  
        $script_tz = date_default_timezone_get();
        $firstday = date('d/m/Y', strtotime("this week")); 
        $intDateOfFirstDayOnWeek=intval($firstday);
        //$day+=$intDateOfFirstDayOnWeek;$day-=2;
        
        
      /*  echo "<br><br>intDateOfFirstDayOnWeek: ".$intDateOfFirstDayOnWeek."<br><br>";
        echo "<br><br>day: ".$day."<br><br>";
        echo "<br><br>hour ".$hour."<br><br>";
        echo "<br><br>firstday: ".$firstday."<br><br>";
      */ // $con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
        while ($scheduleRow=mysqli_fetch_assoc($scheduleResult)){// check if botton clicked before
            if ($scheduleRow['idOfTeacher']==$ID){
                if($scheduleRow['dayOfLesson']==$day && $scheduleRow['hourOFLesson']==$hour){
                    $alreadyInsert=1;
                   // echo "<br><br>found lesson<br><br>";
                break;
                }
			}
        }
        if($alreadyInsert==1){//if was clicked....later
            $alreadyInsert=-1;
            //echo "<br><br>two found lesson<br><br>";
            //$con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

            $sql = "DELETE FROM teacherSchedule WHERE idOfTeacher=$ID AND dayOfLesson=$day AND hourOFLesson=$hour";//update it on table
            if ($con->query($sql) === TRUE){}else{// delete user and back to admin main page
                echo "Error deleting record: " . $con->error;
            }
        }else{//if not clicked, insert as a new option teacher can learn on this time
            $defaultNavBar=1;          
            $year = date("Y");$month = date('m');
            //$day.=(string)$day;
            $TotalDate =  $year.'-'. $month  .'-'. $day;
            $query="INSERT INTO `teacherSchedule`(`idOfTeacher`,`hourOFLesson`,`idOfStudent`,`fullOrFree`,`dayOfLesson`,`lessonDate`,`checkbox`) 
            VALUES ('$ID','$hour','000','-1','$day','$TotalDate','1')";
            $result = mysqli_query($con,$query);
        } 
    }
    if(isset($_GET['checkBox'])){//toggleBotton
        $ID=$_GET['id']; $defaultNavBar=1;
        $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$ID&&$rows['checkbox']==1){
                $teacherImforamtionArray[11]=-1;
                $upDate="UPDATE `teacherSchedule` SET `checkbox`='-1' WHERE idOfTeacher=$ID";
                $result = mysqli_query($con,$upDate);
            break; 
            }elseif($rows['idOfTeacher']==$ID&&$rows['checkbox']==-1){
                $teacherImforamtionArray[11]=1;
                $upDate="UPDATE `teacherSchedule` SET `checkbox`='1' WHERE idOfTeacher=$ID";
                $result = mysqli_query($con,$upDate);
            break; 
            }
        }
    }    
    
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


    if(isset($_GET['id'])){//to get the id of teacher by login
        $ID=$_GET['id'];
    }
    if($ID){//after get the id from login or by update on profile page, check teacher main information by above function
        $teacherImforamtionArray = returnTeacherInformationIntoArray($ID,$teacherImforamtionArray);
    }
    $teacherImforamtionArray[8]=returnTeacherCitiesOrCoursesIntoArray($teacherImforamtionArray[7],3);//get cities of teacher
    $teacherImforamtionArray[9]=returnTeacherCitiesOrCoursesIntoArray($teacherImforamtionArray[7],5);//get courses of teacher
    $teacherImforamtionArray[10]=getImage($teacherImforamtionArray[7]);//get the 
    $teacherImforamtionArray[11]=getToggleButtonStatus($ID);//get the toggle status
    $arrayOfLessons=array();
    $counterArrayOfLessons=0;
    
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>הכיתה</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/profileStyle.css">
  </head>
  <body>
    <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>            
            <?php
                //navbar include the main page of the site FAQ page, EXIT, redirect page include the login id
                $ID=$teacherImforamtionArray[7];
                echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$teacherImforamtionArray[7]\">הכיתה</a>";
                echo '<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">';
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php?id=$teacherImforamtionArray[7]\"> עמוד הבית</a></li>";
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"chat.php?id=$teacherImforamtionArray[7]\">הודעות</a></li>";
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"EditPage.php?username=$teacherImforamtionArray[0]\">עדכן פרופיל</a></li>";
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"FAQ.php?id=$teacherImforamtionArray[7]\">שאלות ותשובות</a></li>";
             
             /*
                echo "<a class=\"navbar-brand\" href=\"Hakita.php\">הכיתה</a>";
                echo '<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">';
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php"> עמוד הבית</a></li>";
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"chat.php\">הודעות</a></li>";
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"EditPage.php\">עדכן פרופיל</a></li>";
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"FAQ.php\">שאלות ותשובות</a></li>";
             

             */
             
             ?>
                <li class="nav-item active">
                  <a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a>
                
                <!--

  <a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a>
                

                -->
                </li>
              </ul>
            </div>
          </nav>
    </section>
    <section class="z">        
        <div class="container">
            <div class="span3 well">
                <center>
                    <?php
                    //main teacher information, student ask for
                        echo "<a href=\"#aboutModal\" data-toggle=\"modal\"><img src='img/".$teacherImforamtionArray[10]."' height=140  width=140 class='img-circle'></a>";
                        echo "<h2>".$teacherImforamtionArray[1]." ".$teacherImforamtionArray[2]."</h2>";//teacher name
                        echo "<h5>"."מחיר לשעה: ".$teacherImforamtionArray[4]."₪</h5>";	
                        echo "<h5>".$teacherImforamtionArray[5]."</h5>";//status
                        echo "<p>".teacherRating($ID)."</p>";              
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
                else if($defaultNavBar==2){
                    echo" <button class=\"tablink col-sm-2\" onclick=\"openPage('aboutTeacher', this, 'blueviolet')\">קורסים ועירים</button>
                     <button class=\"tablink col-sm-2\" onclick=\"openPage('dashboardSection', this, 'orange')\">יומן שיעורים</button>
                     <button class=\"tablink col-sm-3\" onclick=\"openPage('comments', this, 'blueviolet')\"id=\"defaultOpen\"> תגובות התלמידים שלמדתי </button>";
                }else{
                    echo" <button class=\"tablink col-sm-2\" onclick=\"openPage('aboutTeacher', this, 'blueviolet')\"id=\"defaultOpen\">קורסים ועירים</button>
                     <button class=\"tablink col-sm-2\" onclick=\"openPage('dashboardSection', this, 'orange')\">יומן שיעורים</button>
                     <button class=\"tablink col-sm-3\" onclick=\"openPage('comments', this, 'blueviolet')\"> תגובות התלמידים שלמדתי </button>";
                }
            ?>            
            <button class="tablink col-sm-3" onclick="openPage('Links', this, 'orange')">יצירת קשר/שיתוף פרופיל</button>
        </div>
        <div id="aboutTeacher" class="tabcontent" style="background-color:white;">   
            <?php
                echo"<div class=\"row\">";
                    echo"<div class=\"col-sm-6\">";// print teacher courses
                        $D=array();



                        
                        //$D[0]=$courseResultArray[$teacherImforamtionArray[7]];
                        echo"<div class=\"col-sm-6\" id=\"courseButtons\">";
                        if ($teacherImforamtionArray[9]!='subject'){
                            echo"<h4>"."מלמד:- ".$teacherImforamtionArray[9]."</h4>";                    
                        }
                        echo"</div><hr><hr></div>";
                    echo"<div class=\"col-sm-6\">";// print teacher cities
                        echo "<div class=\"col-sm-6\" id=\"cityButtons\">";
                        if ($teacherImforamtionArray[8]!='cities'){
                            echo "<h4>"."נמצא ב- ".$teacherImforamtionArray[8]."</h4>";
                        }
                    echo"</div><hr><hr></div></div>";    
            ?>
        </div>        
        <div id="comments" class="tabcontent"><!--the section is for comment about teacher, comment user write it-->    
            <?php  
               $thereIsAnyComment=-1;//if there is not any comments stay as value -1, to view 'NO comment'
               $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
                while ($commentRow=mysqli_fetch_assoc($commentResult)){ //get comments if there any comments
                    if($commentRow['idOfTeacher']==$teacherImforamtionArray[7]){
                        $thereIsAnyComment=1;//at least there is one comments
                        $commnetsPeopleArray[$commnetsPeopleArrayCounter]=$commentRow['idOfCommentWriter'];
                        $getRatingOfEachComment=$commentRow['rating'];//get the rating of each comment to display it
                        $commnetsPeopleArrayCounter++;
                        $dateOfComment=$commentRow['dateOfComment'];//get the date of each comment to display it
                        $nameOfCommentWriter = " ";
                        $WC=$commentRow['idOfCommentWriter'];//get the id of comment writter for using on remove comment status
                        $CW=$teacherImforamtionArray[7];//comment card 
                        echo"<div class=\"card mb-3\" style=\"max-width: 740px; direction: rtl;\">";                        
                            echo"<form action=\"profile.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"idOfCommentWriter\" value=\"$WC\">
                                <input type=\"hidden\" name=\"idOfTeacher\" value=\"$CW\">
                                <input type=\"hidden\" name=\"dateOfComment\" value=\"$dateOfComment\">
                            </form>";
                      $nameOfCommentWriter=getName($commentRow['idOfCommentWriter']);//get the name of comment writter to display it
                        echo'<div class="row no-gutters">';
                        echo'<div class="col-md-4">';
                           echo"<img src='img/".getImage($commentRow['idOfCommentWriter'])." 'class=\"card-img\">";
                        echo '</div>';
                        echo'<div class="col-md-8">';
                            echo'<div class="card-body">';
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
                    if($teacherImforamtionArray[6]!=' '){
                        echo "<h4>"."מספר טלפון: ".$teacherImforamtionArray[6]."</h4>";
                    }        
                    if($teacherImforamtionArray[3] !='email'&&$teacherImforamtionArray[3]!=' '){
                        echo "<h4>" . $teacherImforamtionArray[3] . "</h4>";
                    }                             
                ?>                                              
            </div><hr><hr>
            <div class="form-group">
                <h3>שיתוף את הפרופיל שלי ב-</h3>
                <label for="facebook"><div class="fa fa-facebook"></div></label>
                <label for="linkedin"><div class="fa fa-linkedin"></div></label>   
                <label for="whatsapp"><div class="fa fa-whatsapp"></div></label> 
            </div> 
            <!---copy my profile link---->
            <button class="btn btn-info btn-lg" onclick="myFunction()">
                <span class="glyphicon glyphicon-paperclip">קישור לפרופיל שלי</span>
            </button>           
        </div>
        <div id="dashboardSection" class="tabcontent">
            <h3>הצגת יומן שיעורים שלי בצד הסטודנטים</h3>
            <form action="profile.php" method="post">  
                <label class="switch">
                    <?php
                        if($teacherImforamtionArray[11]==1){//if the toggle button is switch on that mean student can show the teacher time board else not
                           echo"<input name=\"toggleBotton\" type=\"checkbox\" checked onClick=\"checkbox()\">";
                        }else{
                            echo"<input name=\"toggleBotton\" type=\"checkbox\" unchecked onClick=\"checkbox()\">";
                        }
                    ?>
                    <span class="slider round"></span>
                </label>
            </form>
            <section class="board col-sm-12">
                <div class="container">      
                <div class="col-sm-12">     
                <table class="table table-sm table-dark">
                    <thead>                                
                    <?php 
                        $todayIndex;
                        date_default_timezone_set('Asia/Jerusalem');  
                        $script_tz = date_default_timezone_get();
                        $todayOnWeek=date('d-m-Y'); 
                        $day_of_week = date('N', strtotime($todayOnWeek));
                        $todayIndex=$day_of_week+1;  
                        $currentHour=date('H');
                        if($todayIndex>7){
                            $todayIndex=1;  
                        }                      
                        $days = array(1 => 'Sunday',2 => 'Monday',3 => 'Tuesday',4 => 'Wednesday',5 => 'Thursday',6 => 'Friday',7 => 'Saturday');
                        $daysArray=array();
                        $daysArrayCounter=0;
                        for($d=1;$d<=7;$d++){
                            if($todayIndex<=$d){
                                $daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d])); 
                            }else{
                                $daysArray[$daysArrayCounter]=date('d/m', strtotime($days[$d]."-1 week"));
                            }
                            $daysArrayCounter++;
                        }
                        $FirstLetterHebrewArray=array(1 => 'א-',2 => 'ב-',3 => 'ג-',4 => 'ד-',5 => 'ה-',6 => 'ו-',7 => 'שבת-',);
                        echo "<tr>";
                        echo" <th>שעה/יום</th>";
                        for($d=1;$d<=7;$d++){
                            $q=$d-1;
                            echo" <th scope=\"col\">$FirstLetterHebrewArray[$d]$daysArray[$q]</th>";
                        }
                        echo "</tr>";
                    ?>
                    </thead>
                    <tbody>
                   <form action="profile.php" method="post">                               
                        <?php
                            echo"<input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\">"; 
                            for($hours=7;$hours<=22;$hours++){
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
                                    $DaysId=$Days+1; 
                                    $addAsString=strval($DaysId);
                                    $addAsString.=$hours;
                                    $buttonGiveId=intval($addAsString);                       
                                    $alreadyInsert=-1;
                                   // $con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
                                        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

                                    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
                                    while ($scheduleRow=mysqli_fetch_assoc($scheduleResult)){
                                        if ($scheduleRow['idOfTeacher']==$ID){
                                           for($r=0;$r<5;$r++){
                                                $t=$r*7;
                                                if(($scheduleRow['dayOfLesson']==$DaysId+$t) && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==-1){
                                                    $alreadyInsert=1;
                                                }else if(($scheduleRow['dayOfLesson']==$DaysId+$t) && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==1){
                                                    $alreadyInsert=2;
                                                }
                                           }
                                        }
                                    }
                                    if($Days+1>=$todayIndex){
                                        if($Days+1==$todayIndex && $currentHour>$hours){
                                            echo "<th></th>";
                                        }
                                        elseif($hours<10&&$alreadyInsert==-1){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\">"."0".$hours.":00+"."</button></th>";
                                        }else if($hours<10&&$alreadyInsert==1){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">"."0".$hours.":00+"."</button></th>";
                                        }else if($hours<10&&$alreadyInsert==2){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:red\">"."0".$hours.":00+"."</button></th>";
                                        }else if($hours>=10&&$alreadyInsert==1){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">".$hours.":00+"."</button></th>";
                                        }else if($hours>10&&$alreadyInsert==2){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:red\">".$hours.":00+"."</button></th>";
                                        }else{
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\">".$hours.":00+"."</button></th>";
                                        }
                                        $alreadyInsert=-1;
                                    }else{
                                        echo "<th></th>";
                                    }
                                }
                                echo "</tr>";
                            }     
                        ?>
                    </form> 
                    </tbody>
                </table>
                </div> </div>
            </section>
        </div>
    </section>
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
        <script>
            function checkbox(){
                var checkBox = <?php echo $teacherImforamtionArray[7];?>;
                window.location.href = "profile.php?id=" + checkBox;
            }
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
            }        
            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
            </script>
            <script>
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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
</html>
<script>
function myFunction(){//script for copy the profile link, plus show a message.
    var x = document.createElement("INPUT");
  x.setAttribute("type", "text");
  var userId = <?PHP echo (!empty($ID) ? json_encode($ID) : '""'); ?>;
  var url="https://hakitaproject.000webhostapp.com/study/study/viewTeacherProfile.php?id=";
  url = url.concat(userId);
  x.setAttribute("value", url);
  document.body.appendChild(x);
  x.select();
  x.setSelectionRange(0, 99999)
  document.execCommand("copy"); 
  alert('קישור הפרופיל הועתק');
  x.setAttribute("type", "hidden");
}
</script>