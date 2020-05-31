<?php
/**
 * this file let student show teacher profile or teacher show other teachers// teacher cant not
 * get to his profile if he login//.
 * write a cooment, ask for a lesson, send message, get information about teacher
 * can get to this page by two ways as a login user or as a normal user (without login)
 */
    session_start();
    // get the id of teacher, and get the id of the login user on login state
   
    
    $teacher=$_GET['viewprofile'];
    $gitHowManyDigitsForTheId=substr($teacher, 0, 1); 
    $IDOfTeacher=substr($teacher, 1, $gitHowManyDigitsForTheId);
    if(!$IDOfTeacher){
        $IDOfTeacher=$_SESSION['teacher'];//get teacher id 
    }
    $IDOfUser=$_SESSION['id'];//get login id t=if there is    
    
    if($_GET['view']){//when teacher share his profile
        $view=$_GET['view'];
        $gitHowManyDigitsForTheId=substr($view, 0, 1); 
        $IDOfTeacher=substr($view, 1, $gitHowManyDigitsForTheId);
    }   
    if($IDOfTeacher==$IDOfUser){//if the student he is also the teacher do not let him contiune
       header('Location: logout.php');//if there is no id, redirect to logout page to forget id and username, then to redirect to main page.
    }
    
    include 'userData.php';//calling to use fuction like get image of user

    $_SESSION['teacher']=$IDOfTeacher;//share teacher id used after login user write a feedback, choose a lesson time.

    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");//connect with DB
    
    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
    date_default_timezone_set('Asia/Jerusalem');$script_tz = date_default_timezone_get();$todayDate=date("Y-m-d");//delete all lasted lessons time from DB. accourding to local time.
    while($row=mysqli_fetch_assoc($scheduleResult)){        
        if($row['lessonDate']<$todayDate){
            $idOfLesson=$row['idOfLesson'];
            $sql = "DELETE FROM teacherSchedule WHERE idOfLesson=$idOfLesson";
            if ($con->query($sql) === TRUE){}   
        }
    }    
    $IdResults=mysqli_query($con, "SELECT * FROM users");   
    if(isset($_POST['usernameLogin'])&&isset($_POST['PasswordLogin'])){//if the student was not login then he ask for a lesson so he need to login
        while($row=mysqli_fetch_assoc($IdResults)){ //check student validate account
            if($row['password']==$_POST['PasswordLogin']&&
                $row['username']==$_POST['usernameLogin']){
                $dashboardSection=1;$IDOfUser=$row['id'];/*student id, if he was not login*/ break;
			}
        }   
    }
    $_SESSION['id']=$IDOfUser;//he we write the _SESSION of login id, case user can get to this page without needed to login and then he can if want.

    if(isset($_POST["comments"])) { // if any student write a comment about this teacher 
        $commentNav=1;//this variable for the second navbar
        $getComment=$_POST["comments"];
        $_POST["comments"]=null;$rating=-1;
        $rating=intval($_POST["teacherValue"]);
        if(!(is_int($_POST["teacherValue"]))){// need to check if the _POST is intger
            $rating=intval($_POST["teacherValue"]);
        } 
        $_POST["teacherValue"]=null;$commentWriterId=$IDOfUser; 
        $todayDate=date('Y-m-d');
        $query="INSERT INTO `dBOfComments`(`idOfTeacher`,`idOfCommentWriter`,`dateOfComment`,`textOfComment`,`rating`) VALUES ('$IDOfTeacher','$commentWriterId','$todayDate','$getComment','$rating')";
        $result=mysqli_query($con,$query);
    }//next function take the city or the course and insert into array to display them as a button
//for eaxmple on Jerusalem nutton on this page redirect user to all teachers on Jerusalem...
    function insertCitiesAndCoursesOnArray($subject,$arrayOfTeacherCoursesOrCities){
        $subject.=",ADD";//adding space to string
        $IndexOfArrayOfTeacher=0;
        $length=strlen($subject); //case we will get the cities or cources as a one string 
        $lastComma=0;$counterOfDigits=0;$ifFoundAComma=-1;$howManyTimesFindComma=0;    
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
        }return $arrayOfTeacherCoursesOrCities;
    }
    
    function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
        $returnData="";//data{cities or courses want to return}
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
        if($whatToReturn==5){//for courses
            while ($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
                if ($rows['id']==$id){
                    if($rows['subject']!='subject'){
                        $returnData.=$rows['subject'];break;
                    }
                }	
            }
        }else{//for cities
            $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
            while ($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
                if ($rows['id']==$id){
                    if($rows['cities']!='cities'){
                        $returnData.=$rows['cities'];break;
                    }			
                }		
            }
        }return $returnData;//return data     
    }
    
    $teacherArrayInformation=array();
    $IdResult=mysqli_query($con, "SELECT * FROM users");
    while($row=mysqli_fetch_assoc($IdResult)){
        if($row['id']==$IDOfTeacher){ //get variables to use on HTML view
            $teacherArrayInformation[0]=$row['username'];
            $teacherArrayInformation[1]=$row['fname'];$teacherArrayInformation[2]=$row['lname'];
            $teacherArrayInformation[3]=$row['phone'];$teacherArrayInformation[4]=$row['email'];
            $teacherArrayInformation[5]=$row['price'];
            if(strcmp($row['status'],'status')!=0){
                $teacherArrayInformation[6]=$row['status']; 
            }         
		}
    }
    $teacherArrayInformation[7]=getToggleButtonStatus($IDOfTeacher);//to display board time or not
    // next to get the courses that teacher learn and cities teacher where in. for each of them create an array to use it later,each subject will be as a button
    $Cities= " ";$Courses=" ";   
    $Courses=returnTeacherCitiesOrCoursesIntoArray($IDOfTeacher,5);//courses 
    $arrayOfTeacherCourses=array();
    $arrayOfTeacherCourses=insertCitiesAndCoursesOnArray($Courses,$arrayOfTeacherCourses);
    if(count($arrayOfTeacherCourses)==0){
        $arrayOfTeacherCourses=array();	
    } 
    
    
    
    $Cities=returnTeacherCitiesOrCoursesIntoArray($IDOfTeacher,3);//cities
    $arrayOfTeacherCities=array();	
    $arrayOfTeacherCities=insertCitiesAndCoursesOnArray($Cities,$arrayOfTeacherCities);  
    if(count($arrayOfTeacherCities)==0){
        $arrayOfTeacherCities=array();	
    } 

    //sendMessageUserButton
  if(isset($_POST['messageSubmit'])){//ADMIN going to delete the choosen user
    //send a message automaticly from student to teacher
    if($_POST['id']){//check if the message sent bu a site user or unlogin user
      $id=$_POST['id'];//if yes sent the id 
    }else{//else sent id as 0
      $id=0;
    }
    $name=$_POST['name'];
    $message_text='שם: '.$name.'\n';
    $email=$_POST['email'];
    $message_text.='email: '.$email.'\n';   
    $message_date = date("y-m-d h:i");
    $message_text.=$_POST['subject'];
    $query="INSERT INTO `messages`(`message_sender`,`message_receive`,`message_text`,`message_date`) VALUES
    ('$id',' $IDOfTeacher','$message_text','$message_date')";
    $messageResults = mysqli_query($con,$query);
 }


?>
<!DOCTYPE html>
<html>
    <head>
        <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
        <?php include_once 'header.php';?>
        <link rel="stylesheet" type="text/css" href="css/viewTeacherStyle.css">
        <?php
            if(isset($_POST['chooseLessonButton'])||$_POST['chooseLesson']){//ask for a lesson with teacher 
                $dashboardSection=1;
                if($_POST['openModel']){//user after choose a lesson, automaticly will open a window with data about teacher and about lesson, to be sure.
                    $lessonTime=$_POST['chooseLessonButton'];// we get this to show for student the day and hour of lesson 
                    $hour;$day;//two variable to save data on DB, saving data use day of lesson and hour of lesson
                    if($lessonTime<100){
                        $hour=$lessonTime%10;
                        $d=$lessonTime/10;$day=floor($d);
                    }else{
                        $hour=$lessonTime%100;
                        $d=$lessonTime/100;$day=floor($d);
                    }//form _POST['chooseLessonButton'] we get the number of day on current week, for example we get the number 3 as a day variable that mean tuesday and this week start as a date 8/3 on sunday so the date on tuesday will be 10/8
                    $firstday = date('d/m/Y', strtotime("this week")); 
                    $intDateOfFirstDayOnWeek=intval($firstday);
                    $day+=$intDateOfFirstDayOnWeek;$day-=2;//next script for showing the window
                    if(!$IDOfUser){
                        echo "<script>$(document).ready(function(){ $('#myModall').modal('show');});</script> ";
                        echo "<li>
                            <div class=\"modal fade\" id=\"myModall\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                                <div class=\"modal-dialog\" role=\"document\">
                                    <div class=\"modal-content\">
                                        <div class=\"modal-header\"><h4 class=\"modal-title\" id=\"myModalLabel\">  כניסה לחשבון </h4></div>
                                        <form  name=\"feedbackForm\" action=\"viewTeacherProfile.php\" method=\"post\">";
                                            echo"<div class=\"modal-body\">
                                            <div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                                                <input type=\"text\" class=\"form-control\" name=\"usernameLogin\" placeholder=\"שם משתמש\" title=\"הזנת שם משתמש \" required>
                                            </div> <br>
                                            <div class=\"input-group\">
                                                <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                                <input type=\"password\" class=\"form-control\" name=\"PasswordLogin\" placeholder=\"סיסמה\" title=\"הזנת סיסמה\"required >
                                            </div>
                                            <fieldset> 
                                                <div class=\"text-center\"><input type=\"submit\" class=\"logSignButton btn btn-info btn-primary text-center\"  value=\"כניסה למערכת \"></div>
                                            </fieldset>
                                        </form><br>
                                        <button type=\"submit\" class=\"btn btn-info\" data-dismiss=\"modal\">יציאה</button>
                            </div></div></div></div>
                        </li>";
                    }else{echo "<script> $(document).ready(function(){ $('#myModalOfCheckTeacherInformation').modal('show'); }); </script>";}
               }else{//student after sure about the information above, will get to this section, to insert data on DB.
                    $dashboardSection=1;
                    $lessonTime=$_POST['chooseLessonButton'];
                    $hour;$day;//two variable to save data on DB, saving data use day of lesson and hour of lesson
                    if($lessonTime<100){
                        $hour=$lessonTime%10;
                        $d=$lessonTime/10; $day=floor($d);
                    }else{
                        $hour=$lessonTime%100;
                        $d=$lessonTime/100;$day=floor($d);
                    }//form _POST['chooseLessonButton'] we get the number of day on current week, for example we get the number 3 as a day variable that mean tuesday and this week start as a date 8/3 on sunday so the date on tuesday will be 10/8
                    date_default_timezone_set('Asia/Jerusalem');  
                    $script_tz = date_default_timezone_get();
                    $firstday = date('d/m/Y', strtotime("this week")); 
                    $intDateOfFirstDayOnWeek=intval($firstday);
                    $day+=$intDateOfFirstDayOnWeek;$day-=2;
                    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
                    while ($scheduleRow=mysqli_fetch_assoc($scheduleResult)){//save the data of asking lesson on DB
                        if ($scheduleRow['idOfTeacher']==$IDOfTeacher){//after we found the teacher id
                            if($scheduleRow['dayOfLesson']==$day && $scheduleRow['hourOFLesson']==$hour){
                                $upDate="UPDATE `teacherSchedule` SET `fullOrFree`='1' , `idOfStudent`=$IDOfUser
                                WHERE idOfTeacher=$IDOfTeacher  and hourOFLesson=$hour  and dayOfLesson=$day";
                                $result = mysqli_query($con,$upDate);
                                //send EMAIL for (student + teacher)
                                $teacherEmail=email($IDOfTeacher);
                                $to = $teacherEmail;//sending to teacher email address
                                $from ="HakitaSite";// from
                                $subject="שיעור באתר הכיתה";//subject of message
                                $message="<p>שלום </p>";
                                $teacherName=name($IDOfTeacher);
                                $message.=$teacherName;
                                $message.=",<br>";
                                $message.="סטודנט רוצה לקבוע איתך שיעור בתאריך ".$day." בשעה ".$hour."";
                                $message.="<br>";
                                $message.="לעוד פרטים, נפתחה פינת הודעות לכם בתאר, נא לבדוק בתיבת ההודעת שלך.";
                                $message.="<br><br>";
                                $message.="<p>המשך יום נעים. </p>";
                                $headers="From:".$from."\r\n";
                                $headers.="Content-type: text/html\r\n";
                                if(mail($to,$subject,$message,$headers)){
                                }else{//if there any connection problem
                                echo "בעית תקשורת בשליחת ההודעה למייל";
                                echo "<script type='text/javascript'>alert('בעית תקשורת בשליחת ההודעה למייל');</script>";
                                }
                                
                                $studentEmail=email($IDOfUser);
                                $to = $studentEmail;//sending to student email address
                                $from ="HakitaSite";// from
                                $subject="שחזר סיסמה";//subject of message
                                $message="<p>שלום </p>";
                                $message.=name($IDOfUser);
                                $message.=",<br>";
                                $message.="קבעת שיעור עם המורה ".$teacherName.", בשעה".$hour.", ביום".$day."";
                                $message.="<br>";
                                $message.="לעוד פרטים, נפתחה פינת הודעות לכם בתאר, נא לבדוק בתיבת ההודעת שלך.";
                                $message.="<br><br>";
                                $message.="<p>המשך יום נעים. </p>";
                                $headers="From:".$from."\r\n";
                                $headers.="Content-type: text/html\r\n";
                                if(mail($to,$subject,$message,$headers)){
                                }else{//if there any connection problem
                                echo "בעית תקשורת בשליחת ההודעה למייל";
                                echo "<script type='text/javascript'>alert('בעית תקשורת בשליחת ההודעה למייל');</script>";
                                }        
                                
                                
                                //send a message automaticly from student to teacher
                                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                                $resultOFLesson = mysqli_query($con, "SELECT * FROM teacherSchedule");
                                while ($scheduleRow=mysqli_fetch_assoc($resultOFLesson)){
                                    if($scheduleRow['idOfStudent']=$IDOfUser &&  $scheduleRow['idOfTeacher']=$IDOfTeacher  &&
                                            $scheduleRow['hourOFLesson']=$hour  && $scheduleRow['dayOfLesson']=$day){
                                                $message_date = $scheduleRow['lessonDate'];
                                    }
                                }
                                $message_text='הודעה אוטומתית, שלום רב, אני רוצה לקבוע איתך שיעור בזמן ההוא '.$message_date.'';
                                $query="INSERT INTO `messages`(`message_sender`,`message_receive`,`message_text`,`message_date`) VALUES
                                ('$IDOfUser',' $IDOfTeacher','$message_text','$message_date')";
                                $messageResults = mysqli_query($con,$query);
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
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>  
                <a class="navbar-brand" href="Hakita.php">הכיתה</a>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active"><a class="nav-link" href="Hakita.php">עמוד הבית <span class="sr-only"></span></a></li>
                        <li class="nav-item active"><a class="nav-link" href="searchTeachers.php">חיפוש מורה <span class="sr-only"></span></a></li>  
                    <?php
                        if(!$IDOfUser){//navbar for user without login
                            echo'  
                            <li class="nav-item active"><a class="nav-link" href="login.php">כניסה</a></li>
                            <li class="nav-item active"><a class="nav-link" href="Signup.php">הרשמה</a></li>
                            <li class="nav-item active"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>';
                            }else{//navbar for user with login
                                if(checkUserDefineAs($IDOfUser)==1){//redirect to student profile
                                    echo'<li class="nav-item active"><a class="nav-link" href="studentProfile.php">פרופיל שלי <span class="sr-only"></span></a></li>';
                                }else{//redirect to teacher profile
                                    echo'<li class="nav-item active"><a class="nav-link" href="profile.php">פרופיל שלי <span class="sr-only"></span></a></li>';
                                }
                                echo'<li class="nav-item active"><a class="nav-link" href="messageRoom.php">הודעות</a></li>
                                <li class="nav-item active"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>
                                <li class="nav-item active"><a class="nav-link" href="logout.php">יציאה </a></li>';
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
                                $teacherName=name($IDOfTeacher);
                                echo "שיעור עם המורה:".$teacherName."<br>";
                                echo "תאריך השיעור: ".$day." לחודש הזה <br>";
                                echo "שעת השיעור: ".$hour.":00<br>";//also send id of teacher and student to continue on process
                                echo"<input name=\"chooseLessonButton\" type=\"hidden\" value=\"$chooseLessonButton\" id=\"$chooseLessonButton\">";
                            ?>                                    
                            <button type="submit" class="btn btn-primary">המשך</button>
                            <button type="button" class="close btn-info" data-dismiss="modal" aria-hidden="true">יציאה</button>
                        </form>
            </div></div></div></div>
        <section class="z">        
            <div class="container">
                <div class="span3 well">
                    <center>
                    <a href="#aboutModal" data-toggle="modal" data-target="#myModal">
                    <?php
                        echo "<img src='img/".Image($IDOfTeacher)."' height=140  width=140 class='img-circle'></a>";			
                        echo "<h3>" . $teacherArrayInformation[1]."&nbsp;". $teacherArrayInformation[2]."</h3>";
                        $countRatingOfTeacher=0;$totalCountRatingOfTeacher=0;
                        $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
                        while ($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
                            if($ratingOfTeacher['idOfTeacher']==$IDOfTeacher){
                                $countRatingOfTeacher++;$totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
                            }
                        }              
                        if ($teacherArrayInformation[5]!=1&&$teacherArrayInformation[5]!=null){
                            echo "<h6>".$teacherArrayInformation[5] ."</h6>";	
                        }
                        echo "<h6>".$teacherArrayInformation[6]."</h6>";  
                        $fill=$totalCountRatingOfTeacher/$countRatingOfTeacher;
                        $allRating=ceil($fill);                    
                        for($stars=0;$stars<$allRating;$stars++){
                            echo'<span class="fa fa-star checked"></span>';
                        }
                        $emptyStars=5-$allRating;$e=0;
                        while($e<$emptyStars){
                            $e++;echo'<span class="fa fa-star"></span>';
                        }                     
                    ?>
                    </center>
                </div>           
            </div>                                           
        </section>
        <section class="choose">
            <div class="row"><!--navbar for direction on teacher profile, {about teacher, teacher dashboard, comments about teacher }-->
                <?php
                    if($teacherArrayInformation[7]==1){//display board time
                        if($commentNav==1){ echo"
                            <button class=\"tablink col-sm-3\" onclick=\"openPage(event, 'aboutTeacher')\"> קורסים ועירים של המורה</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPage(event, 'dashboardSection')\">יומן שיעורים</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPage(event, 'Links')\">צור קשר ושיתוף</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPage(event, 'comments')\"id=\"defaultOpen\">תגובות </button>"; 

                        }elseif($dashboardSection==1){echo"
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'aboutTeacher')\">  קורסים ועירים של המורה</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'dashboardSection')\"id=\"defaultOpen\">יומן שיעורים</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'Links')\">צור קשר ושיתוף</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'comments')\">תגובות </button>";
                        }else{echo"
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'aboutTeacher')\"id=\"defaultOpen\">  קורסים ועירים של המורה</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'dashboardSection')\">יומן שיעורים</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'Links')\">צור קשר ושיתוף</button>
                            <button class=\"tablink col-sm-3\" onclick=\"openPageSection(event, 'comments')\">תגובות </button>";
                        }                        
                    }else{
                        echo"
                        <button class=\"tablink col-sm-4\" onclick=\"openPageSection(event, 'aboutTeacher')\"id=\"defaultOpen\"> קורסים ועירים של המורה</button>
                        <button class=\"tablink col-sm-4\" onclick=\"openPageSection(event, 'Links')\">צור קשר ושיתוף</button>
                        <button class=\"tablink col-sm-4\" onclick=\"openPageSection(event, 'comments')\">תגובות </button>
                        ";
                    }
                ?>
            </div>
            </section>
            <br><br>     
           <div id="aboutTeacher" class="tabcontent">
                <?php
                    echo'<div class="row"><div class="container">';   
                    echo"<form action=\"searchTeachers.php\" method=\"post\">";                   
                    if(count($arrayOfTeacherCourses)>0){//print courses that teacher learn as a buttons, that click on it redirect student to show more teachers learn the same subject
                        echo"<div class=\"col-sm-6\" id=\"courseButtons\">";
                        for($ci=0;$ci<count($arrayOfTeacherCourses);$ci++){
                            $r=$arrayOfTeacherCourses[$ci];
                            echo"<input  class=\"courseButtons\" type=\"submit\" name=\"hidden_framework_courses\" value=\"$arrayOfTeacherCourses[$ci]\"  önclick=\" goToSearchPage()\" >";
                        }echo"</div>";
                    }                 
                    if(count($arrayOfTeacherCities)>0) {//print cities that teacher live in as a buttons, that click on it redirect student to show more teachers on the same city
                        echo"<div class=\"col-sm-6\" id=\"cityButtons\">";
                        for($ci=0;$ci<count($arrayOfTeacherCities);$ci++){
                                echo "<input  class=\"courseButtons\" type=\"submit\" name=\"hidden_framework\" value=\"$arrayOfTeacherCities[$ci]\"  önclick=\" goToSearchPage()\" >";
                            }
                        }echo"</div>";
                    echo "</form></div></div>";
                ?>
            </div>
            <div id="dashboardSection" class="tabcontent"><!--section times lessons for teacher,
            user can show the lesson times for teacher as a green button.if user want to choose
            a specific lesson he need to be login first if not he will show{login to choose a lesson
            then he could choose}-->
                <?php
                    if(!$IDOfUser){//user not login----> click sign in then insert username & password to continue or EXIT                                    
                        echo'<button  class="addCommentButton btn btn-warning" alt="work 1" data-toggle="modal" data-target="#myModal"> <h5>  רשום כדי לקבוע שיעור</h5></button>';
                        echo'<li>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header"><h4 class="modal-title" id="myModalLabel">  כניסה לחשבון על מנת לקבוע שיעור </h4></div>
                                        <form  name="feedbackForm" action="viewTeacherProfile.php" method="post">';  
                                            echo"<input name=\"chooseLesson\" type=\"hidden\" value=\"$chooseLesson\">"; 
                                            echo'<div class="modal-body">
                                            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input type="text" class="form-control" name="usernameLogin" placeholder="שם משתמש" title="הזנת שם משתמש " required>
                                            </div> <br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input type="password" class="form-control" name="PasswordLogin" placeholder="סיסמה" title="הזנת סיסמה"required >
                                            </div>
                                            <fieldset> 
                                                <div class="text-center"><input type="submit" class="logSignButton btn btn-info btn-primary text-center"  value="כניסה למערכת "></div>
                                            </fieldset>
                                        </form><br>
                                        <button type="submit" class="btn btn-info" data-dismiss="modal">יציאה</button>
                            </div></div></div></div>
                        </li>';
                    }                    
                ?>
            <section class="board"><!--display the time board if the teacher alredy choose to display it on student side-->         
                <table class="table table-sm table-dark">
                    <thead>                                
                    <?php 
                        $todayIndex;// case the time is according to where the server location, we need to check that time is right according israel
                        date_default_timezone_set('Asia/Jerusalem');  $script_tz = date_default_timezone_get();
                        $todayOnWeek=date('d-m-Y');$day_of_week=date('N', strtotime($todayOnWeek));
                        $todayIndex=$day_of_week+1;$currentHour=date('H');$currentHour+=1;                        
                        $firstdayDateType=date('d', strtotime("this week")); 
                        $firstday=intval($firstdayDateType); 
                        $firstday-=1;  
                        if($todayIndex>7){
                            $todayIndex=1;  
                        }                      
                        $days=array(1 => 'Sunday',2 => 'Monday',3 => 'Tuesday',4 => 'Wednesday',5 => 'Thursday',6 => 'Friday',7 => 'Saturday');
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
                            for($hours=7;$hours<=22;$hours++){//show time's
                                if($hours%2==0){
                                    echo "<tr class=\"bg-info\">";
                                }else{
                                    echo "<tr class=\"bg-secondary\">";
                                }
                                if($hours<10){
                                    echo "<th>"."0".$hours.":00"."</th>";
                                }else{
                                    echo "<th>".$hours.":00"."</th>";
                                }
                                for($Days=0;$Days<7;$Days++){
                                    //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                                    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                                    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
                                    $DaysId=$Days+1; 
                                    $addAsString=strval($DaysId);
                                    $addAsString.=$hours;
                                    $buttonGiveId=intval($addAsString);                       
                                    $alreadyInsert=-1;
                                    while($scheduleRow=mysqli_fetch_assoc($scheduleResult)){
                                        if($scheduleRow['idOfTeacher']==$IDOfTeacher){
                                           for($r=0;$r<5;$r++){//check if on this day and on this hour, teacher want to be a lesson, or yes he wanted and somebody already ask for a lesson on this time
                                                if(($scheduleRow['dayOfLesson']==$Days+$firstday) && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==-1){//teacher want to learn on this time and no body yet ask for a lesson on this time 
                                                    $alreadyInsert=1;
                                                }elseif(($scheduleRow['dayOfLesson']==$Days+$firstday) && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==1){//teacher want to learn on this time and somebody already asked for a lesson on this time
                                                    $alreadyInsert=2;
                                                }
                                           }
                                        }
                                    }
                                    if($Days+1>=$todayIndex){//show the times that teacher can learn as a green buttons
                                        if(($Days+1==$todayIndex && $currentHour>$hours)||($hours<10&&($alreadyInsert==-1||$alreadyInsert==2))){
                                            echo "<th></th>";
                                        }
                                        elseif($hours<10&&$alreadyInsert==1){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">"."0".$hours.":00+"."</button></th>";
                                        }elseif($hours>=10&&$alreadyInsert==1){
                                            echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">".$hours.":00+"."</button></th>";
                                        }else{
                                            echo "<th></th>";
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
            </section> 
            </div>
            <div id="Links" class="tabcontent"><!--linke relative to teacher profile, like share page-->
            <div class="row">
                    <div class="form-group col-sm-6">
                        <h3>שיתוף פרופיל של המורה ב-</h3>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ec53990697c2288"></script>
                        <br>
                        <button class="btn btn-info btn-lg" onclick="myFunction()" id="profileLink"><span class="glyphicon glyphicon-paperclip">העתקת קישור לפרופיל הזה</span></button>
                        <br><br>                        
                        <!-- Add font awesome icons -->
                        <?php
                            $facebook=" ";$linkedin=" ";$youtube=" ";
                            $otherLinkOne=" ";$otherLinkTwo=" ";
                            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                            $resultsOfShares = mysqli_query($con, "SELECT * FROM shareTable");     
                            while($rows=mysqli_fetch_assoc($resultsOfShares)){
                                if($rows['id']==$IDOfTeacher){
                                $facebook=$rows['facebook'];$linkedin=$rows['linkedin'];$youtube=$rows['youtube'];
                                $otherLinkOne=$rows['firstOtherLink'];$otherLinkTwo=$rows['secondOtherLink'];
                                break;
                                }
                            }
                            if(strlen($facebook)>15){
                                echo"<a href=\"$facebook\" class=\"fa fa-facebook\"></a>";
                            }if(strlen($linkedin)>15){
                                echo"<a href=\"$linkedin\" class=\"fa fa-linkedin\"></a>";
                            }if(strlen($youtube)>15){
                                echo"<a href=\"$youtube\" class=\"fa fa-youtube\"></a>";
                            }if(strlen($otherLinkOne)>15){
                                echo"<a href=\"$otherLinkOne\" class=\"fa fa-flickr\"></a>";
                            }if(strlen($otherLinkTwo)>15){
                                echo"<a href=\"$otherLinkTwo\" class=\"fa fa-rss\"></a>";
                            }
                        ?>
                        
                    </div><hr>
                    <div class="form-group col-sm-6">
                        <h3>פרטי תקשורת</h3> 
                        <?php
                            if($teacherArrayInformation[3]!=' '){
                                echo "<h4>"."מספר טלפון:".$teacherArrayInformation[3]."</h4>";
                            }        
                            echo"<h4>".$teacherArrayInformation[4]."</h4>";        
                        ?>             
                    <h1 class="letters"> הודעה למורה</h1>
                    <form action="viewTeacherProfile.php" method="POST">
                        <input type="text" name="name" placeholder="שם" class="form-control" required>
                        <?php
                            if($IDOfUser){
                                echo"<input type=\"hidden\" name=\"id\" value=\"$IDOfUser\">";
                            }else{
                                echo'<input type="email" name="email" placeholder="מייל לצור קשר" class="form-control" required>';
                            }
                        ?>
                        <input type="text" name="subject" placeholder="תוכן ההודעה" class="form-control" required>
                        <input type="messageSubmit" value="שלח/י" class="btn btn-success text-center">
                    </form>
                </div></div>
            </div>
            <div id="comments" class="tabcontent"><!--feedback section, login user can add feedback else no-->
                <li>
                    <?php
                        if($IDOfUser){// for login user, let them to write comment, later it will be  avilable just after get a lesson
                            echo "<button  class=\"addCommentButton btn btn-warning\" alt=\"work 1\" data-toggle=\"modal\" data-target=\"#myModalc\" title=\"כפתור הוספת תגובה על המורה\"> <h5>הוספת תגובה חדשה</h5></button>";
                            echo"
                            <div class=\"modal fade\" id=\"myModalc\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabelv\">
                            <div class=\"modal-dialog\" role=\"document\">
                                <div class=\"modal-content\">
                                <div class=\"modal-header\"><h4 class=\"modal-title\" id=\"myModalLabelv\">הוספת תגובה</h4></div>
                                <form  name=\"feedbackForm\" action=\"viewTeacherProfile.php\" method=\"post\">
                                    <div class=\"modal-body\">
                                        <div class=\"pleaseAddFeedback\"> אנא ספק/י את המשוב שלך להלן: </div><hr>
                                        <div class=\"feedbackValueTitle\">
                                        איך את/ה מדרג/ת את החוויה הכוללת שלך ?
                                            <div>
                                                לא טוב-
                                                <input type=\"radio\" name=\"teacherValue\" id=\"oneValue\" value=\"1\"  required>1
                                                <input type=\"radio\" name=\"teacherValue\" id=\"twoValue\" value=\"2\"  required>2
                                                <input type=\"radio\" name=\"teacherValue\" id=\"threeValue\" value=\"3\"  required>3
                                                <input type=\"radio\" name=\"teacherValue\" id=\"fourValue\" value=\"4\" required>4
                                                <input type=\"radio\" name=\"teacherValue\" id=\"fiveValue\"  value=\"5\" required>5
                                                -מצויין
                                            </div>
                                        </div><hr>
                                        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                        <textarea class=\"form-control\" type=\"textarea\" name=\"comments\" id=\"comments\" placeholder=\"הערות/תגובות שלך\" maxlength=\"6000\" rows=\"7\" required></textarea><hr>
                                        <fieldset><div class=\"text-center\"><input type=\"submit\" class=\"logSignButton btn btn-info btn-primary text-center\" title=\"שמירת פיידבאק וחזרה\" value=\"הוספה כ-תגובה חדשה\"></div></fieldset>
                                </form><br>
                                    <button type=\"submit\" class=\"btn btn-info\" data-dismiss=\"modal\">יציאה ללא הוספת </button>
                                </div></div></div></div></li>";
                        }                        
                    $thereIsAnyComment=-1;
                    $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
                    while ($commentRow=mysqli_fetch_assoc($commentResult)){ //get comments if there any comments
                        if($commentRow['idOfTeacher']==$IDOfTeacher){
                            $thereIsAnyComment=1;//get the details of eache comment
                            $idOfCommentWriter=$commentRow['idOfCommentWriter']; $getRatingOfEachComment=$commentRow['rating'];
                            $dateOfComment=$commentRow['dateOfComment']; $textOfComment=$commentRow['textOfComment'];
                            echo"<div class=\"card mb-3\" style=\"max-width: 740px; direction: rtl;\">";
                            echo'<div class="row no-gutters"><div class="col-md-3">';
                            echo"<img src='img/".Image($commentRow['idOfCommentWriter'])." 'class=\"card-img\">";
                            echo'</div><div class="col-md-9"><div class="card-body">';
                            echo"<h5 class=\"card-title\">".name($commentRow['idOfCommentWriter'])."";//get the name of comment writter to display it
                            for($star=0;$star<$getRatingOfEachComment;$star++){//the orange star's
                                echo'<span class="fa fa-star checked"></span>';
                            }
                            $emptyStars=5-$getRatingOfEachComment;$e=0;
                            while($e<$emptyStars){//the empty star's
                                $e++;echo'<span class="fa fa-star"></span>';
                            }echo"</h5>";
                            echo"<p class=\"card-text\">".$commentRow['textOfComment']."</p>";                        
                            echo"<p class=\"card-text\"><small class=\"text-muted\">".$dateOfComment."</small></p></div></div></div></div>";        
                        }
                    }
                    if($thereIsAnyComment==-1){//if there is no feedback yet
                        echo" <h1>אין עוד תגובות</h1>";
                    }
                ?>
            </div><br><br><br><br>              
        <?php include_once 'footer.php';/*bottom footer*/?>
    </body>
</html>
<?php include_once 'script.php';/*some scrtipts like copy URL of this page*/?>