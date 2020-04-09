<?php
	/**
 * student profile page, showing inforamtion about student, let them read and send messages,  payment for a lesson, search  a teacher and get help on FAQ page. 
 */
    session_start();
    //$con=mysqli_connect("Localhost","id13199818_id11176973aki1","{4jXlXc1>dkm+tIg","id13199818_haki1");
      $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    //include 'connectionPage.php';//include this file for calling the DB
    //variables will used on HTML
    $arryOfStudentInformation=array();//this array include the student first and last name, email status and phone number, instead of calling DB each time for student information we call it once
    $ImgSource=" ";  $username=" "; $thereIsNoAccountLikeThis=1;
    $ID=$_GET['id'];

    /**
     * 
     *  $ID=$_SESSION['id']
     *   $_SESSION['id']=$ID;
     * 
     */
    if(!$ID){//dont get to this page without any directiory
        header('location: logout.php');
    }
    elseif($ID){//get to this page by login
      $IdResults = mysqli_query($con, "SELECT * FROM users");
      while ($row=mysqli_fetch_assoc($IdResults)){
        if($row['id']==$ID){//insert student information into array to get it and use on HTML view
          $username=$row['username'];
          $arryOfStudentInformation[0]=$row['fname'];
          $arryOfStudentInformation[1]=$row['lname'];
          $arryOfStudentInformation[2]=$row['email'];
          $arryOfStudentInformation[3]=$row['phone'];
          $thereIsNoAccountLikeThis=-1;
          break;
        }
      }
    }
    if($thereIsNoAccountLikeThis==1){//if the id is wrong redirect to the main page
      header('location: logout.php');
    }
    $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
  while ($ImgRow=mysqli_fetch_assoc($resultsOfImageTable)){ //get the image of student
    if($ImgRow['id']==$ID){
			$ImgSource=$ImgRow['image'];
		}
  }   
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>הכיתה</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <link rel="stylesheet" type="text/css" href="css/studentProfile.css">
  </head>
  <body>
  	<section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <?php
                echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$ID\">הכיתה</a>";
                echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
                <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";
                echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php?id=$ID\"> עמוד הבית</a></li>"; 
                echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"searchTeachers.php?id=$ID\">חיפוש מורה</a></li>";
                echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"FAQ.php?id=$ID\">שאלות ותשובות</a></li>";

                /*
                 * 
                 * 
                 * 
                 *
                echo "<a class=\"navbar-brand\" href=\"Hakita.php\">הכיתה</a>";
                echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
                <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";
                echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php\"> עמוד הבית</a></li>"; 
                echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"searchTeachers.php\">חיפוש מורה</a></li>";
                echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"FAQ.php\">שאלות ותשובות</a></li>";
           
           */
           
           ?>       
               <!-- <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a></li>
               
               
               
               
               
               -->
                <li class="nav-item active"><a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a></li>
              
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
								echo "<img src='img/".$ImgSource."' height=170px; width=250px; class='img-rounded img-responsive'>";
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
                  echo "&nbsp;". $arryOfStudentInformation[0] . " ". $arryOfStudentInformation[1]."</h2>";
                  echo "<h2>" ."מייל שלי:"."&nbsp;". $arryOfStudentInformation[2]. "</h2>";
                  echo "<h3>"."מספר טלפון:"."&nbsp;".$arryOfStudentInformation[3]."</h3>";                	
                ?>
		        </div>
           </div>
          </div>
          <div class="title text-center"><br>
          	<div class="row">
              <div class="col-md-4">
                <a href="studentEdit.php?username=<?php echo $username;?>"><button type="button" class="redirectButtons btn btn-info">עדכן חשבון</button></a>
              
  <!-- <a href="studentEdit.php"><button type="button" class="redirectButtons btn btn-info">עדכן חשבון</button></a>
              
            change to by id  


            -->  
              </div>
              <div class="col-md-4">
                <a href="chatPage.php?username=<?php echo $username;?>"><button type="button" class="redirectButtons btn btn-info">הודעות</button></a>
              </div>
              <div class="col-md-4">
                <a href="classPage.php?username=<?php echo $username;?>"><button type="button" class="redirectButtons btn btn-info">שיעור שקבעתי</button></a>
              </div>
            </div>
					</div>
      </form>           
    </div>        
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
    </body>
</html>