<?php
/* on this page will display the amount of lessons teacher already teached,
  later lessons and two buttons one for the ZOOM app, and other for a video and message chat
  app without sharing desktop.
  sure the navbar for redirect to his/her profile, logout main page...
   */
  session_start();      
  $ID=$_SESSION['id'];//get the teacher id.
  $_SESSION['id']=$ID;  
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
                          <li class="nav-item active"><a class="nav-link" href="profile.php">פרופיל שלי </a></li>  
                          <li class="nav-item active"><a class="nav-link" href="chat.php">הודעות</a></li>         
                          <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה</a></li>
                      </ul>
                  </div>
            </nav>
      </section>
      <br><br><br>
      <div class="border border-light p-3 mb-4">
        <div class="text-center">
          <button  type="button" class="btn btn-success" onclick="openNoneShareDesktopApp()">חדר תרגול ללא שיתוף מסך</button>
        </div>
        <br><br>
        <div class="text-center">
          <button  type="button" class="btn btn-primary" onclick="openZoomMeeting()">ZOOM</button>
        </div>
      </div>  
      <?php
        include 'userData.php';//call userData, to use some function from
        $getTeacherTeachedLessonsAmount=getTeacherTeachedLessonsAmount($ID);
        echo'<h1 class="text-center">שיעורים שהלמדתי '.$getTeacherTeachedLessonsAmount.'</h1>';
        $laterLesson=getTeacherLaterLessonsAmount($ID);        
        echo'<h1 class="text-center"> כמה שיעורים יש לי ללמד '.$laterLesson.'</h1>';
      ?>
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">שם סטודנט</th>
            <th scope="col">תאריך שיעור</th>
            <th scope="col">שעת שיעור</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $studentAskForALessonArrayIds=array();
            $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
            $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
            $lessonsCounter=0;
            while($rows=mysqli_fetch_assoc($scheduleResult)){
                if($rows['idOfTeacher']==$ID&&$rows['fullOrFree']==1){
                  array_push($studentAskForALessonArrayIds,$rows['idOfStudent']);
                }  
            }
            $studentName=" ";
            $lessonDate;
            $lessonTime;
            for($i=0;$i<$laterLesson;$i++){
              $studentName=name($studentAskForALessonArrayIds[$i]);
              $lessonDate=getLessonDate($ID,$studentAskForALessonArrayIds[$i]);
              $lessonTime=getLessonTime($ID,$studentAskForALessonArrayIds[$i]);
              echo'<tr>';
                echo'<th scope="row">'.$i.'</th>';
                  echo'<td>'.$studentName.'</td>';
                  echo'<td>'.$lessonDate.'</td>';
                  echo'<td>'.$lessonTime.':00</td>';
              echo'</tr>';    
            }
          ?>
        </tbody>
      </table>
  </body>
</html>
<script>
function openNoneShareDesktopApp() {
  window.open("https://hakitatest.herokuapp.com/");
}
function openZoomMeeting() {
  window.open("Zoom.php");
}
</script>