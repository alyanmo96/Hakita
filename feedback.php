<?php
	/*
		1-the design
		2- on the bottom of the page get email from user
	*/
    session_start();
    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $feedbackCommentResult = mysqli_query($con, "SELECT * FROM feedback");
    $feedbackLastResult = mysqli_query($con, "SELECT * FROM feedback");
    $lastFeedback=" ";
    while ($commentRow=mysqli_fetch_assoc($feedbackLastResult))
    {
        $lastFeedback=$commentRow['textOfFeedback'];
    }
    if (isset($_POST["comments"])) {    
        if($_POST["comments"]!=$lastFeedback)
        {
            $getComment=$_POST["comments"];
            $rating=-1;
            if($_POST["teacherValue"]=="oneValue")
            {
                $rating=1;
            }
            else if($_POST["teacherValue"]=="twoValue")
            {
                $rating=2;
            }
            else if($_POST["teacherValue"]=="threeValue")
            {
                $rating=3;
            }
            else if($_POST["teacherValue"]=="fourValue")
            {
                $rating=4;
            }
            else if($_POST["teacherValue"]=="fiveValue")
            {
                $rating=5;
            }
            $_POST["teacherValue"]=null; 
            
            $ID=$_POST['id'];   
                
            $commentWriterId=267;
            $todayDate=date('Y-m-d');
            $query="INSERT INTO `feedback`(`dateOfFeedback`,`textOfFeedback`,`rating`) 
            VALUES
                ('$todayDate','$getComment','$rating')";
                $result = mysqli_query($con,$query);
        }      
    }

?>
<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>הכיתה</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>  
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


        <link rel="stylesheet" type="text/css" href="css/styleFAQ.css">
        <style>
            .navbar-brand 
            {
                font-size:35px;
            }
            .navbar-brand:hover
            {
                font-size:40px;
            }
            .nav-link
            {
                font-size:23px;
            }    
            .nav-link:hover
            {
                font-size:30px;
            }
            .commentCard
        {
            background:url('./img/8.jpg');
            margin-right: 5%;
            border-radius: 300px;
        }
            .checked {
  color: orange;
}
        </style>
	</head>
	<body>
        <a id="button"></a>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand active" href="MainPage.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="MainPage.php">עמוד הבית <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="firstLoginPage.php">כניסה והרשמה </a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="searchTeachers.php">חיפוש מורה</a>
                  </li>
              </ul>
            </div>
          </nav>
		  <section class="feedbackSection">		
          <h1> כל תגובה עוזרת לנו לשפר את האתר, להרגיש חופשי. נא לצרף Email</h1>	
          <div id="comments" class="tabcontent">
                    <li>
                        <button  class="addCommentButton btn btn-warning" alt="work 1" data-toggle="modal" data-target="#myModalc" title="כפתור הוספת תגובה על המורה"> <h5>הוספת תגובה חדשה</h5></button>
                        <div class="modal fade" id="myModalc" tabindex="-1" role="dialog" aria-labelledby="myModalLabelv">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabelv">הוספת תגובה</h4>
                                </div>
                                <form  name="feedbackForm" action="feedback.php" method="post">
                                        <?php
                                            echo"<input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\">"; 
                                        ?>
                                        <div class="modal-body">
                                            <div class="pleaseAddFeedback">
                                                אנא ספק/י את המשוב שלך להלן:
                                            </div>
                                            <hr>
                                            <div class="feedbackValueTitle">
                                            איך את/ה מדרג/ת את החוויה הכוללת שלך באתר ?
                                                <div>
                                                    לא טוב-
                                                    <input type="radio" name="teacherValue" id="oneValue" value="oneValue"  required>1
                                                    <input type="radio" name="teacherValue" id="twoValue" value="twoValue"  required>2
                                                    <input type="radio" name="teacherValue" id="threeValue" value="threeValue"  required>3
                                                    <input type="radio" name="teacherValue" id="fourValue" value="fourValue" required>4
                                                    <input type="radio" name="teacherValue" id="fiveValue"  value="fiveValue" required>5
                                                    -מצויין
                                                </div>
                                            </div>
                                            <hr>
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <textarea class="form-control" type="textarea" name="comments" id="comments" placeholder="הערות/תגובות שלך" maxlength="6000" rows="7" required></textarea>
                                            <hr>
                                            <fieldset> 
                                            <div class="text-center">
                                                    <input type="submit" class="logSignButton btn btn-info btn-primary text-center" title="שמירת פיידבאק וחזרה" value="הוספה כ-תגובה חדשה">
                                            </div>
                                            </fieldset>
                                    </form>
                                <br>
                                    <button type="submit" class="btn btn-info" data-dismiss="modal">יציאה ללא הוספת </button>
                                </div>
                                </div>
                            </div>
                            </div>
                    </li>
                        <?php                     
                            $feedbackCommentResult = mysqli_query($con, "SELECT * FROM feedback");
                            while ($commentRow=mysqli_fetch_assoc($feedbackCommentResult)) //get comments if there any comments
                            {
                                $getRatingOfEachComment=$commentRow['rating'];
                                $commnetsPeopleArrayCounter++;
                                $dateOfComment=$commentRow['dateOfFeedback'];
                                $textOfComment=$commentRow['textOfFeedback'];
                                echo "<div class=\"commentCard col-sm-10\">"; 
                                
                                echo "<p>".$textOfComment."</p>";    
                                
                                for($star=0;$star<$getRatingOfEachComment;$star++)
                                {
                                    echo ' <span class="fa fa-star checked"></span>';
                                }
                                $emptyStars=5-$getRatingOfEachComment;
                                $e=0;
                                while($e<$emptyStars)
                                {
                                    $e++;
                                    echo '<span class="fa fa-star"></span>';
                                }
                                echo "<p>".$dateOfComment."</p>";                                   
                                echo "<hr>";
                                echo "</div>";
                            }
                        ?>
                    </div>
		  </section>
		
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
</html>