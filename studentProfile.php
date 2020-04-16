<?php
	// student profile page, showing inforamtion about student, let them read and send messages,  payment for a lesson, search  a teacher and get help on FAQ page. 
  session_start();
  $ID=$_SESSION['id'];//get the student id
  $_SESSION['id']=$ID;
  if(!$ID){//if there is no id, redirect to logout page to forget id and username, then to redirect to main page.
    header('location: logout.php');
  }
  include 'userData.php';//use some function like name to display, email address...
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <?php include 'header.php';/*headers*/?>  
    <link rel="stylesheet" type="text/css" href="css/studentProfile.css">
  </head>
  <body>
  	<section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <a class="navbar-brand" href="Hakita.php">הכיתה</a>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item active"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li> 
              <li class="nav-item active"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>
              <li class="nav-item active"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>             
              <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a></li>
            </ul>
          </div>
        </nav>
    </section>
    <div class="container emp-profile">
      <form method="post">
        <div class="row">
          <div class="col-md-4">
            <div class="profile-img">
              <?php
								echo "<img src='img/".Image($ID)."' height=170px; width=250px; class='img-rounded img-responsive'>";
							?>
            </div>
          </div>
          <div class="col-md-6">
              <div class="profile-head">
                <?php
                  // for login user : say hello/ good(morning/afternoon...) Set the $timezone variable to become the current timezone */
                  date_default_timezone_set('Asia/Jerusalem');$script_tz = date_default_timezone_get();$time = date("H");
                  echo "<h2>";
                  /* If the time is less than 1200 hours, show good morning */
                  if($time < "12"){
                      echo "בוקר טוב ";
                  }else
                  /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
                  if($time >= "12" && $time < "17"){
                      echo "צוהריים טובים";
                  }else
                  /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
                  if ($time >= "17" && $time < "19"){
                      echo "ערב טוב ";
                  }else
                  /* Finally, show good night if the time is greater than or equal to 1900 hours */
                  if($time >= "19") {
                      echo "לילה טוב";
                  }                  
                  echo"<h2>".name($ID)."</h2>";//display student name
                  echo"<h2>" ."מייל שלי: ". email($ID). "</h2>";//display student email address
                  echo"<h3>"."מספר טלפון:"."&nbsp;".phoneNumber($ID)."</h3>";//display student phone number         	
                ?>
		        </div>
           </div>
          </div>
          <div class="title text-center"><br>
          	<div class="row">
              <div class="col-md-4">
                  <?php
                    if(Gender($ID)==1){//for display buttons as a blue or pink color, according to student gender
                      echo'<a href="studentEdit.php"><button type="button" class="redirectButtons btn btn-info">עדכן חשבון</button></a></div>
                      <div class="col-md-4"><a href="chatPage.php"><button type="button" class="redirectButtons btn btn-info">הודעות</button></a></div>
                      <div class="col-md-4"><a href="classPage.php"><button type="button" class="redirectButtons btn btn-info">שיעור שקבעתי</button></a></div>';
                    }else{
                      echo'<a href="studentEdit.php"><button type="button" class="redirectButtons btn btn-pink" style="background-color: #ff1e8d;">עדכן חשבון</button></a></div>
                      <div class="col-md-4"><a href="chatPage.php"><button type="button" class="redirectButtons btn btn-info" style="background-color: #ff1e8d;">הודעות</button></a></div>
                      <div class="col-md-4"><a href="classPage.php"><button type="button" class="redirectButtons btn btn-info" style="background-color: #ff1e8d;">שיעור שקבעתי</button></a></div>';
                    }
                  ?>
        </div></div>
      </form>           
    </div>        
    <?php include_once 'footer.php';/*botttom footer*/?>
  </body>
</html>