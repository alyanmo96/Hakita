<?php
/* on this page will display the amount of lessons teacher already teached,
  later lessons and two buttons one for the ZOOM app, and other for a video and message chat
  app without sharing desktop.
  sure the navbar for redirect to his/her profile, logout main page...
   */
  session_start();      
  $ID=$_SESSION['id'];//get the teacher id.
  $_SESSION['id']=$ID;  

  include 'userData.php';//call userData, to use some function from
  
  function getstudentLaterLessonsAmount($ID){
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        $lessonsCounter=0;
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfStudent']==$ID&&$rows['fullOrFree']==1){$lessonsCounter++;}
        }return $lessonsCounter;//dont display board time lesson
  }
?>
<!DOCTYPE html>
<html>
<head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <?php include 'header.php';/*get the header from header.php file*/?>
    <style>
      body{
        direction:rtl;
      }
    </style>
  </head>
  <body>
    <section><!--navbar section--><!--navbar include the main page of the site FAQ page, EXIT-->
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>        
                  <a class="navbar-brand" href="Hakita.php">הכיתה</a>
                  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                          <li class="nav-item active"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li>
                          <?php
							if(checkUserDefineAs($ID)==1){
								echo'<li class="nav-item active"><a class="nav-link" href="studentProfile.php"> פרופיל שלי</a></li>';
							}else{
								echo'<li class="nav-item active"><a class="nav-link" href="profile.php"> פרופיל שלי</a></li>';
							}
						?><li class="nav-item active"><a class="nav-link" href="messageRoom.php">הודעות</a></li>         
                          <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה</a></li>
                      </ul>
                  </div>
            </nav>
      </section>
      <br><br><br>
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">שם המורה</th>
            <th scope="col">תאריך שיעור</th>
            <th scope="col">שעת שיעור</th>
            <th scope="col"> מספר טלפון</th>
            <th scope="col">Email </th>
          </tr>
        </thead>
        <tbody>
          <?php
            $teachersIds=array();
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
            $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
            $lessonsCounter=0;
            while($rows=mysqli_fetch_assoc($scheduleResult)){
                if($rows['idOfStudent']==$ID){
                  array_push($teachersIds,$rows['idOfTeacher']);
                }  
            }
            $laterLesson=getstudentLaterLessonsAmount($ID);
            $teacherName=" ";
            $lessonDate;
            $lessonTime;
            for($i=0;$i<$laterLesson;$i++){
              $teacherName=name($teachersIds[$i]);
              $lessonDate=getLessonDate($teachersIds[$i],$ID);
              $lessonTime=getLessonTime($teachersIds[$i],$ID);
              $phoneNumber=phoneNumber($ID);
              $EmailAdress=email($ID);
              echo'<tr>';
                echo'<th scope="row">'.$i.'</th>';
                  echo'<td>'.$teacherName.'</td>';
                  echo'<td>'.$lessonDate.'</td>';
                  echo'<td>'.$lessonTime.':00</td>';
                  echo'<td>'.$phoneNumber.'</td>';
                  echo'<td>'.$EmailAdress.'</td>';
              echo'</tr>';    
            }
          ?>
        </tbody>
      </table>
  </body>
</html>