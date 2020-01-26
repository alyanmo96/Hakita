<?php
    session_start();
    $ID=-1;
    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $commentsResult = mysqli_query($con, "SELECT * FROM dBOfComments");
    $IDOfStudent;
    
    /*
    echo "{";
    echo $_GET['studentID'];
    echo $_POST['studentID'];
    echo "}";
    */
    if(isset($_POST['chooseLessonButton'])) 
        {     
            if($_GET['id'])
            {
                $ID=$_GET['id'];
            }
            else
            {
                $ID=$_POST['id'];
            }
            if($_GET['studentID'])
            {
                $IDOfStudent=$_GET['studentID']; 
            }
            else{
                $IDOfStudent=$_POST['studentID']; 
            } 
            $lessonTime=$_POST['chooseLessonButton'];
            $hour;
            $day;
            if($lessonTime<100)
            {
                $hour=$lessonTime%10;
                $d=$lessonTime/10;
                $day=floor($d);
            }
            else
            {
                $hour=$lessonTime%100;
                $d=$lessonTime/100;
                $day=floor($d);
            }
            
            $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
            while ($scheduleRow=mysqli_fetch_assoc($scheduleResult)) 
            {
                if ($scheduleRow['idOfTeacher']==$ID) //and idOfStudent
                {
                    if($scheduleRow['dayOfLesson']==$day && $scheduleRow['hourOFLesson']==$hour)
                    {
                        $upDate="UPDATE `teacherSchedule` SET `fullOrFree`='1' , `idOfStudent`=$IDOfStudent
                        WHERE idOfTeacher=$ID  and hourOFLesson=$hour  and dayOfLesson=$day";
                        $result = mysqli_query($con,$upDate);
                    }
                }
            }
        }

    if (isset($_POST["comments"])) {        
        $getComment=$_POST["comments"];
        $_POST["comments"]=null;
        //$rating=$_POST["teacherValue"];
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
        if($_GET['studentID'])
            {
                $commentWriterId=$_GET['studentID']; 
            }
            else{
                $commentWriterId=$_POST['studentID']; 
            }
           // echo "{"; echo$commentWriterId;echo"}";
       $todayDate=date('Y-m-d');
       $query="INSERT INTO `dBOfComments`(`idOfTeacher`,`idOfCommentWriter`,`dateOfComment`,`textOfComment`,`rating`) VALUES ('$ID','$commentWriterId','$todayDate','$getComment','$rating')";
        $result = mysqli_query($con,$query);
    }
    if($ID==-1)
    {
        $ID=$_GET['id'];
    }
	// conect with tables to get information about the user to show it and use
	$results = mysqli_query($con, "SELECT * FROM teachers");	
	$ImgResult = mysqli_query($con, "SELECT * FROM images");
	//variables will used on HTML
	//(username,status,email,first name, last name, phone number, cities, courses,img,price)
	$us=" ";	$sta=" ";	$email=" "; 	$fN=" ";	$lN=" "; 	$Phone=" "; 
	$Cities= " "; 	$Courses=" ";   	$ImgSource=" ";  	$pri;
    $gender=" ";$yearsOld=-1;
		while ($row=mysqli_fetch_assoc($results)) 
		{
			if ($row['id']==$ID) //get variables to use on HTML view
			{
        		$us=$row['username'];
				$fN=$row['fname'];
				$lN=$row['lname'];
				$email=$row['email'];
				$pri=$row['price'];
				$sta=$row['status'];
				$Phone=$row['phone'];
				$gender=$row['gender'];
				//$yearsOld=$row['yearsold'];
			}
		}			 
	$CourseResult = mysqli_query($con, "SELECT * FROM teachers_courses");
	$MoreThanOneWordSoAddComma=0;//to put comma between words if there is more than one course or more than city
	while ($CourseRows=mysqli_fetch_assoc($CourseResult)) 
	{
		if ($CourseRows['id']==$ID) 
			{
				if ($MoreThanOneWordSoAddComma>=1) 
				{
					$courses.=' , ';
				}
				$Courses.=$CourseRows['subject'];
				$MoreThanOneWordSoAddComma++;
			}	
    }
    $Courses.=",ADD";
    $arrayOfTeacherCourses=array();
    $IndexOfArrayOfTeacherCourses=0;
    $length=strlen($Courses);    
    $lastComma=0;
    $counterOfDigits=0;
    $ifFoundAComma=-1;
    $howManyTimesFindComma=0;    
    for($q=0;$q<$length;$q++)
    {
    	if(substr($Courses, $q, 1)==",")
		{
        	$ifFoundAComma=1;
            if($howManyTimesFindComma==0)
            {
            	$howManyTimesFindComma++;
                $arrayOfTeacherCourses[$IndexOfArrayOfTeacherCourses]=substr($Courses, $lastComma,$q);
                $IndexOfArrayOfTeacherCourses++;
            }
            else
            {
              $arrayOfTeacherCourses[$IndexOfArrayOfTeacherCourses]=substr($Courses, $lastComma,$counterOfDigits-1);
              $IndexOfArrayOfTeacherCourses++;
            }   
            $counterOfDigits=0;
            $lastComma=$q+1;
        }
        if($ifFoundAComma==1)
        {
        	$counterOfDigits++;
        }   
	}
	$result = mysqli_query($con, "SELECT * FROM teacher_cities");
    $MoreThanOneWordSoAddComma=0;
	while ($rows=mysqli_fetch_assoc($result)) 
	{
		if ($rows['id']==$ID) 
		{
			if ($MoreThanOneWordSoAddComma>=1) 
			{
				$Cities.=' , ';
			}
            $Cities.=$rows['cities'];
            //$arrayOfTeacherCities[$MoreThanOneWordSoAddComma]=$rows['cities'];
			$MoreThanOneWordSoAddComma++;
		}		
    }
    $Cities.=",ADD";
    $arrayOfTeacherCities=array();
    $IndexOfArrayOfTeacherCities=0;
    $length=strlen($Cities);    
    $lastComma=0;
    $counterOfDigits=0;
    $ifFoundAComma=-1;
    $howManyTimesFindComma=0;    
    for($q=0;$q<$length;$q++)
    {
    	if(substr($Cities, $q, 1)==",")
		{
        	$ifFoundAComma=1;
            if($howManyTimesFindComma==0)
            {
            	$howManyTimesFindComma++;
                $arrayOfTeacherCities[$IndexOfArrayOfTeacherCities]=substr($Cities, $lastComma,$q);
                $IndexOfArrayOfTeacherCities++;
            }
            else
            {
              $arrayOfTeacherCities[$IndexOfArrayOfTeacherCities]=substr($Cities, $lastComma,$counterOfDigits-1);
              $IndexOfArrayOfTeacherCities++;
            }   
            $counterOfDigits=0;
            $lastComma=$q+1;
        }
        if($ifFoundAComma==1)
        {
        	$counterOfDigits++;
        }   
	}
	while ($ImgRow=mysqli_fetch_assoc($ImgResult)) //get the image
	{
		if($ImgRow['id']==$ID)
		{
			$ImgSource=$ImgRow['image'];
		}
    }
    $commnetsPeopleArray=array();
    $commnetsPeopleArrayCounter=0;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>הכיתה</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>    
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <style>
        .tablink
        {
            border-radius: 30px;
        }
        .navbar-nav .nav-link {
            padding-right: 0;
            padding-left: 40%;
        }
            .nav-link
            {
                font-size:13px;
            }    
            .nav-link:hover
            {
                font-size:23px;
            }
            body{
                direction:rtl;
                max-width: 100%;
                text-align: center;
            }
            .row
            {
                max-width: 101%;
            }
            .cityButtons{
                margin-top:2%;
                border-radius: 30px;
            }
            .courseButtons{
                margin-top:2%;
                border-radius: 30px;
            }
            img {
            border-radius: 300px;
            border-style: none;
        }
        .img-fluid {
            max-width: 100%;
            height: 70px;
        }
        .commentsImages
        {
            float:right;
            max-height: 80px;
            margin-top: 40%;
        }
        .textOfComment
        {
            font-size: 20px;
            margin-top: -3%;
            margin-right: 1%;
            float: right;
        }
        p {
            margin-top: 1%;
            font-size: 25px;
            font-weight: 700;
        }
        .commentCard
        {
            background:url('./img/7.jpg');
            margin-right: 5%;
            border-radius: 300px;
        }
        .modal-footer
        {
            direction:ltr;
        }
        .addCommentButton
        {
            border-radius:300px;
        }
        .pleaseAddFeedback
        {
            margin-right: -50%;
        }
        textarea.form-control {
            height: 60px;
        }
        #sendMessageToTeacherFormSection
        {
            max-width: 70%;
            margin-left: 25%;
            margin-right: 25%;
        }
        .checked {
  color: orange;
}
    </style>
  </head>
  <body>
    <a id="button"></a>
    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="MainPage.php">עמוד הבית <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="searchTeachers.php">חיפוש מורה <span class="sr-only">(current)</span></a>
                  </li>
                  <?php
                    if(!$_GET['studentID']&&!$_POST['studentID'])
                    {
                        echo "<li class=\"nav-item active\">
                        <a class=\"nav-link\" href=\"firstLoginPage.php\">כניסה/הרשמה <span class=\"sr-only\">(current)</span></a>
                      </li> ";
                    }
                    if($_GET['studentID']||$_POST['studentID'])
                    {
                        echo "<li class=\"nav-item active\">
                        <a class=\"nav-link\" href=\"studentProfile.php\">פרופיל שלי <span class=\"sr-only\">(current)</span></a>
                      </li> ";
                    }
                  ?>                  
                  <li class="nav-item active">
                    <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
                  </li>
                  <?php
                    if($_GET['studentID']||$_POST['studentID'])
                    {
                      echo "<li class=\"nav-item active\">
                      <a class=\"nav-link\" href=\"MainPage.php\">יציאה </a>
                    </li>";
                    }
                  ?>
              </ul>
            </div>
          </nav>
    </section>
    <section class="z">        
        <div class="container">
            <div class="span3 well">
                <center>
                <a href="#aboutModal" data-toggle="modal" data-target="#myModal">
                   <!-- <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRbezqZpEuwGSvitKy3wrwnth5kysKdRqBW54cAszm_wiutku3R" name="aboutme" width="140" height="140" class="img-circle">
                  --><?php
						$results = mysqli_query($con, "SELECT * FROM images");
                        $rows=mysqli_fetch_array($results);
						if($ImgSource!='image')
						{
							echo "<img src='img/".$ImgSource."' height=140  width=140 class='img-circle'>";
						}				
					?>
                </a>
                <?php
			    	if (($fN!='first name'&&$fN!=' ')&&($lN!='last name'&&$lN!=' ')) 
			    	{
			    		echo "<h3>" . $fN . " ". $lN."</h3>";
			    	}
			    	else if (($fN!='first name'&&$fN!=' ')&&($lN=='last name'||$lN==' ')) 
			    	{
			    		echo "<h3>" . $fN . "</h3>";
			    	}
			    	else if (($fN=='first name'||$fN==' ')&&($lN!='last name'&&$lN!=' '))
			    	{
			    		echo "<h3>" . $lN."</h3>";
                    }
                    $countRatingOfTeacher=0;
                    $totalCountRatingOfTeacher=0;
                    while ($ratingOfTeacher=mysqli_fetch_assoc($commentsResult)) 
                    {
                        if($ratingOfTeacher['idOfTeacher']==$ID)
                        {
                            $countRatingOfTeacher++;
                            $totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
                        }
                    }
                    $fill=$totalCountRatingOfTeacher/$countRatingOfTeacher;
                    $allRating=ceil($fill);
                    
                    for($stars=0;$stars<$allRating;$stars++)
                    {
                        echo ' <span class="fa fa-star checked"></span>';
                    }
                    $emptyStars=5-$allRating;
                    $e=0;
                    while($e<$emptyStars)
                    {
                        $e++;
                        echo '<span class="fa fa-star"></span>';
                    }                
					if ($pri!=1&&$pri!=null) 
					{
						echo "<h6>" . "מחיר לשעה:-" .$pri ."</h6>";	
                    }	
                    if($sta!=" ")
                    {
                        echo "<h6>".$sta."</h6>";
                    }
			    ?>
                </center>
            </div>
            <!-- Modal           profile  citiesAndCourses  Account-->            
        </div>                                           
    </section>
    <section class="choose">
                    <div class="row">
                        <button class="tablink col-sm-3" onclick="openPage('aboutTeacher', this, 'blueviolet')"id="defaultOpen"> פרטי המורה</button>
                        <button class="tablink col-sm-3" onclick="openPage('dashboardSection', this, 'orange')">לוח שיעורים</button>
                    <button class="tablink col-sm-3" onclick="openPage('Links', this, 'blue')">צור קשר ושיתוף</button>
                    <button class="tablink col-sm-3" onclick="openPage('comments', this, 'green')">תגובות </button>
                </div>
                <br><br>
                    <div id="aboutTeacher" class="tabcontent">   
                              <?php
                                    echo "<div class=\"row\">";
                                    echo "<div class=\"col-sm-6\">";
                                    if (($fN!='first name'&&$fN!=' ')&&($lN!='last name'&&$lN!=' ')) 
                                    {
                                        echo "<h4>" . $fN . " ". $lN."</h4>";echo"<hr>";
                                    }
                                    else if (($fN!='first name'&&$fN!=' ')&&($lN=='last name'||$lN==' ')) 
                                    {
                                        echo "<h4>" . $fN . "</h4>";echo"<hr>";
                                    }
                                    else if (($fN=='first name'||$fN==' ')&&($lN!='last name'&&$lN!=' '))
                                    {
                                        echo "<h4>" . $lN."</h4>";echo"<hr>";
                                    }           
                                    if($yearsOld!=-1)
                                    {
                                        echo "<h4>" . $yearsOld."</h4>";echo"<hr>";
                                    } 
                                    if ($pri!=1&&$pri!=null) 
                                    {
                                        echo "<h4>" . "מחיר לשעה:-" .$pri ."</h4>";	echo"<hr>";
                                    }	    
                                    if ($Phone!=' '&&$Phone!=null) 
									{
										echo "<h4>"."מספר טלפון:".$Phone."</h4>";echo"<hr>";
                                    }        
                                    if ($email!='email'&&$email!=' ') 
									{
										echo "<h4>" . $email . "</h4>";echo"<hr>";
                                    }  
                                    if($sta!=" "&&$sta!=null&&$sta!=' ')
                                    {
                                        echo "<h4>".$sta."</h4>";
                                    } 
                                    echo "</div>";
                                    $D=array();
                                    $D[0]=$courseResultArray[$ID];    
                                    echo "<div class=\"col-sm-3\" id=\"courseButtons\">";
                                    //if ($Courses!=null) //arrayOfTeacherCourses
                                    if(count($arrayOfTeacherCourses)>0) 
									{
                                        //echo "<h4>"."מלמד:- ".$Courses."</h4>";
                                        for($ci=0;$ci<count($arrayOfTeacherCourses);$ci++)
                                        {
                                            echo "<button class=\"courseButtons\" value=\"$ID\" id=\"$ID\">$arrayOfTeacherCourses[$ci]</button>";
                                            echo"   <input type=\"hidden\" id=\"$ID\">";
                                        }
                                    }
                                    echo "</div>";
                                    echo "<div class=\"col-sm-3\" id=\"cityButtons\">";
                                   // if ($Cities!='cities')
                                    if(count($arrayOfTeacherCities)>0) 
									{
                                        //echo "<h4>"."נמצא ב- ".$Cities."</h4>";
                                        for($ci=0;$ci<count($arrayOfTeacherCities);$ci++)
                                        {
                                            echo "<button class=\"cityButtons\">$arrayOfTeacherCities[$ci]</button>";
                                        }
									}
                                    echo "</div>";
                                    echo "</div>";
                              ?>
                    </div>        
                    <div id="comments" class="tabcontent">
                    <li>
                    <?php
                        if($_GET['studentID']||$_POST['studentID'])
                        {
                            echo "
                            <button  class=\"addCommentButton btn btn-warning\" alt=\"work 1\" data-toggle=\"modal\" data-target=\"#myModalc\" title=\"כפתור הוספת תגובה על המורה\"> <h5>הוספת תגובה חדשה</h5></button>";
                        }
                    ?>
                        <div class="modal fade" id="myModalc" tabindex="-1" role="dialog" aria-labelledby="myModalLabelv">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                
                                    <h4 class="modal-title" id="myModalLabelv">הוספת תגובה</h4>
                                </div>
                                <form  name="feedbackForm" action="studentCheckTeacherPage.php" method="post">
                                        <?php
                                            echo"<input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\">"; 
                                            if($_GET['studentID'])
                                            {
                                                $sendID=$_GET['studentID']; 
                                            }
                                            else{
                                                $sendID=$_POST['studentID']; 
                                            }     
                                          //  echo "{"; echo$sendID;echo"}";                               
                                            echo"<input name=\"studentID\" type=\"hidden\" value=\"$sendID\" id=\"$sendID\">"; 

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
                            $thereIsAnyComment=-1;
                            $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
                            while ($commentRow=mysqli_fetch_assoc($commentResult)) //get comments if there any comments
                            {
                                if($commentRow['idOfTeacher']==$ID)
                                {
                                    $thereIsAnyComment=1;

                                    $idOfTeacher=$commentRow['idOfTeacher'];
                                    $idOfCommentWriter=$commentRow['idOfCommentWriter'];
                                    $commnetsPeopleArray[$commnetsPeopleArrayCounter]=$idOfCommentWriter;
                                    $getRatingOfEachComment=$commentRow['rating'];
                                    $commnetsPeopleArrayCounter++;
                                    $dateOfComment=$commentRow['dateOfComment'];
                                    $textOfComment=$commentRow['textOfComment'];
                                    $nameOfCommentWriter = " ";
                                    echo "<div class=\"commentCard col-sm-10\">"; 
                                    $resultnameOfCommentWriter = mysqli_query($con, "SELECT * FROM teachers");

                                    while ($rowOfCommentWriter=mysqli_fetch_array($resultnameOfCommentWriter)) 
                                    {
                                        if ($rowOfCommentWriter['id']==$idOfCommentWriter) 
                                        {
                                            if (($rowOfCommentWriter['fname']!='first name'&&$rowOfCommentWriter['fname']!=' ')&&($rowOfCommentWriter['lname']!='last name'&&$rowOfCommentWriter['lname']!=' ')) 
                                            {
                                                $nameOfCommentWriter.=$rowOfCommentWriter['fname'];
                                                $nameOfCommentWriter.=" ";
                                                $nameOfCommentWriter.=$rowOfCommentWriter['lname'];
                                            }
                                            else if (($rowOfCommentWriter['fname']!='first name'&&$rowOfCommentWriter['fname']!=' ')&&($rowOfCommentWriter['lname']=='last name'||$rowOfCommentWriter['lname']==' ')) 
                                            {
                                                $nameOfCommentWriter.=$rowOfCommentWriter['fname'];
                                            }
                                            else if (($rowOfCommentWriter['fname']=='first name'||$rowOfCommentWriter['fname']==' ')&&($rowOfCommentWriter['lname']!='last name'&&$rowOfCommentWriter['lname']!=' '))
                                            {
                                                $nameOfCommentWriter.=$rowOfCommentWriter['lname'];
                                            }  
                                        }
                                    }

                                    $resultsOfCommentWriterImage = mysqli_query($con, "SELECT * FROM images");
                                    while ($rowOfCommentWriter=mysqli_fetch_array($resultsOfCommentWriterImage)) 
                                    {
                                        if ($rowOfCommentWriter['id']==$idOfCommentWriter) 
                                        {
                                            if ($rowOfCommentWriter['image']!='image') 
                                            {
                                                echo '<div class="col-sm-1">';
                                                echo "<img src='img/".$rowOfCommentWriter['image']."'   class=\"commentsImages\">";
                                                echo '</div>';
                                            }
                                        }
                                    }
                                    echo "<p>".$textOfComment."</p>";  
                                    echo "<p class=\"textOfComment\">".$nameOfCommentWriter."</p>";   
                                  
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
                            }
                            if($thereIsAnyComment==-1)
                            {
                                echo "
                                <h1>אין עוד תגובות</h1>";
                            }
                        ?>
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
                            <div class="form-group col-sm-6">
                                <h3>קישורים למורה</h3>                  
                            </div>
                            <hr>
                            <div class="form-group col-sm-6">
                                <h3>פרטי תקשורת</h3> 
                                <?php
                                    if ($Phone!=' ') 
                                    {
                                        echo "<h4>"."מספר טלפון:".$Phone."</h4>";
                                    }        
                                    if ($email!='email'&&$email!=' ') 
                                    {
                                        echo "<h4>" . $email . "</h4>";
                                    }                             
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
                    <div id="dashboardSection" class="tabcontent">
                    <section class="board">          
                        <table class="table table-sm table-dark">
                            <thead>
                            <?php
                                    $sunday = date('d/m', strtotime("sunday")); 
                                    $monday = date('d/m', strtotime("monday")); 
                                    $tuesday = date('d/m', strtotime("tuesday"));
                                    $wednesday = date('d/m', strtotime("wednesday"));
                                    $thursday = date('d/m', strtotime("thursday")); 
                                    $friday = date('d/m', strtotime("friday")); 
                                    $saturday = date('d/m', strtotime("saturday"));

                                    echo "<tr>";
                                   echo" <th>שעה/יום</th>";
                                   echo" <th scope=\"col\">א- $sunday</th>";
                                   echo" <th scope=\"col\">ב- $monday</th>";
                                   echo" <th scope=\"col\">ג- $tuesday </th>";
                                   echo" <th scope=\"col\">ד- $wednesday</th>";
                                   echo" <th scope=\"col\">ה- $thursday</th>";
                                   echo" <th scope=\"col\">ו- $friday</th>";
                                   echo" <th scope=\"col\">שבת- $saturday</th>";
                                    echo "</tr>";
                                ?>
                            </thead>
                            <tbody>
                        <form action="studentCheckTeacherPage.php" method="post">                              
                                <?php
                                    echo"<input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\">"; 
                                    if($_GET['studentID'])
                                    {
                                        $sendID=$_GET['studentID']; 
                                    }
                                    else{
                                        $sendID=$_POST['studentID']; 
                                    }                                    
                                    echo"<input name=\"studentID\" type=\"hidden\" value=\"$sendID\" id=\"$sendID\">"; 
                                    for($hours=7;$hours<=22;$hours++)
                                    {
                                        if($hours==7||$hours==13||$hours==17)
                                        {
                                            echo "<tr class=\"bg-primary\">";
                                        }
                                        elseif ($hours==9||$hours==19||$hours==15)
                                        {
                                            echo "<tr class=\"bg-info\">";
                                        }
                                        elseif ($hours==11||$hours==21)
                                        {
                                            echo "<tr class=\"bg-warning\">";
                                        }
                                        else
                                        {
                                            echo "<tr>";
                                        }
                                        if($hours<10)
                                            {
                                                echo "<th>"."0".$hours.":00"."</th>";
                                            }
                                            else
                                            {
                                                echo "<th>".$hours.":00"."</th>";
                                            }
                                        for($Days=0;$Days<7;$Days++)
                                        {
                                            $DaysId=$Days+1;
                                            $hourseId=$hours;   
                                            $addAsString=strval($DaysId);
                                            $addAsString.=$hourseId;
                                            $buttonGiveId=intval($addAsString);                             


                                            $alreadyInsert=-1;
                                            $scheduleResultForBoard = mysqli_query($con, "SELECT * FROM teacherSchedule");
                                            while ($scheduleRow=mysqli_fetch_assoc($scheduleResultForBoard)) 
                                            {
                                                if ($scheduleRow['idOfTeacher']==$ID) 
                                                {
                                                    if($scheduleRow['dayOfLesson']==$DaysId && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==-1)
                                                    {
                                                        $alreadyInsert=1;
                                                    }
                                                }
                                            }

                                            if($hours<10&&$alreadyInsert==-1)
                                            {
                                                echo "<th></th>";
                                            }
                                            else if($hours<10&&$alreadyInsert==1)
                                            {
                                                echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">"."0".$hours.":00+"."</button></th>";
                                            }
                                            else if($hours>10&&$alreadyInsert==1)
                                            {
                                                echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">".$hours.":00+"."</button></th>";
                                            }
                                            else
                                            {
                                                echo "<th></th>";
                                            }
                                            $alreadyInsert=-1;
                                        }
                                        echo "</tr>";
                                    }
                                
                                    

                                ?>
                            </form> 
                            </tbody>
                        </table>
                        </section>

                    </div>
                </section>
            <script>
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
    $(document).ready(function(){
     $('.selectpicker').selectpicker();
    
     $('#framework').change(function(){
       alert("is here");
      $('#hidden_framework').val($('#framework').val());
     });
    
     $('#multiple_select_form').on('Save', function(event){
      event.preventDefault();
      if($('#framework').val() != '')
      {
       var form_data = $(this).serialize();
       $.ajax({
        url:"secondEditPage.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
         $('#hidden_framework').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       return false;
      }
     });
    });
    </script>
    
    <script>
    $(document).ready(function(){
     $('.selectpicker').selectpicker();
    
     $('#frameworkCourse').change(function(){
      $('#hidden_framework_courses').val($('#frameworkCourse').val());
     });
    
     $('#multiple_select_form').on('Save', function(event){
      event.preventDefault();
      if($('#frameworkCourse').val() != '')
      {
       var form_data = $(this).serialize();
       $.ajax({
        url:"secondEditPage.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
         $('#hidden_framework_courses').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       return false;
      }
     });
    });
    </script>
    <script>

	$(document).ready(function()
	{
        for (var i = 0; i <= phpIdArrayLength; i++)
        {
            let x=i;
            let n = x.toString();
            $("#"+n).click(function()
            {
                window.location.href = "searchTeachers.php?id=" + x;
            });
        }
        for (var i = 0; i <= phpIdArray; i++)
        {
            let x=i;
            let n = x.toString();
            $("#"+n).click(function()
            {alert("GGG");
               // window.location.href = "studentCheckTeacherPage.php?id=" + x;
            });
        }
	});
</script>