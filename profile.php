<?php

/**can enter to this page with the last user without need to login
 * 
 * 
 * 
 * 
 * 
 */
	session_start();
    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    
	// because you can reach to this page from more than one page, so we need to know from\
	//where we get to it for(edit page, first time on this page, etc...)
	$logIn=$_POST['usernameLogin']; 
	
	$logInG=$_GET['usernameLogin']; 
	//$signUp=$_POST['username'];
	$edit=$_GET['username']; 	$eedit=$_SESSION['varname']; 
	//echo $logIn;echo"{";echo $logInG;echo"}(";echo $edit;echo")["; //echo $eedit;echo"]";
	// i need to check the password of the admin
	if ($logIn=="AdminEliEssiak")//if this is the admin --> go to admin page 
	{
	 	header('location: AdminControlPage.php');
    }
/*
    $ifStudent = mysqli_query($con, "SELECT * FROM teachers");
    while ($scheduleRow=mysqli_fetch_assoc($ifStudent))
    {
        if($scheduleRow['setUserAs']=='student')
        {
            header('location: studentProfile.php');
            echo "<script>                
            var getIdFromPhpCode = \"<?php echo $AdminPutId ?>\";
            window.location.href=\"deleteUser.php?id=\"+getIdFromPhpCode;
            </script>";
        }
    } 
    */
	// conect with tables to get information about the user to show it and use
	$results = mysqli_query($con, "SELECT * FROM teachers");	
	$ImgResult = mysqli_query($con, "SELECT * FROM images");
	//variables will used on HTML
	//(username,status,email,first name, last name, phone number, cities, courses,img,price)
	$us=" ";	$sta=" ";	$email=" "; 	$fN=" ";	$lN=" "; 	$Phone=" "; 
    $Cities= " "; 	$Courses=" ";   	$ImgSource=" "; 	$ID; 	$pri;
    if(isset($_POST['chooseLessonButton'])) 
    {     
        $alreadyInsert=-1;
        if($_GET['id'])
        {
            $ID=$_GET['id'];
        }
        else
        {
            $ID=$_POST['id'];
        }
        //echo $_POST['chooseLessonButton'];
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
			if ($scheduleRow['idOfTeacher']==$ID) 
			{
                if($scheduleRow['dayOfLesson']==$day && $scheduleRow['hourOFLesson']==$hour)
                {
                    $alreadyInsert=1;
                }
			}
        }
        if($alreadyInsert!=-1)
        {
            $alreadyInsert=-1;
        }
        else
        {
            $todayDate=date('Y-m-d');
            $query="INSERT INTO `teacherSchedule`(`idOfTeacher`,`hourOFLesson`,`idOfStudent`,`fullOrFree`,`dayOfLesson`) 
            VALUES ('$ID','$hour','000','-1','$day')";
            $result = mysqli_query($con,$query);
        }        
        //$_POST['chooseLessonButton']=null;
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
			}
		}
    }
	else if ($logIn!=null)//get to this page by login
	{
		$eedit=$logIn;
		$edit=$logIn;
		$pss=$_POST['PasswordLogin'];
		$alreadyAccount=-1;
		while ($row=mysqli_fetch_assoc($results)) 
		{
			$s=$row['password'];
			if($row['password']==$_POST['PasswordLogin'])//check password
			{
				$alreadyAccount=1;
			}
			if($row['username']==$_POST['usernameLogin'])//get variables to use on HTML view
			{
				$ID=$row['id'];
				$us=$row['username'];
				$fN=$row['fname'];
				$lN=$row['lname'];
				$sta=$row['status'];
				$pri=$row['price'];
				$email=$row['email'];
                $Phone=$row['phone'];
                if($row['setUserAs']=='student')
                {
                    //echo "<input type=\"hidden\ name=\"usernameLogin\">";
                   header('location: studentProfile.php?id='.$ID);
                }
			}
		}
		if ($alreadyAccount!=1) //if the password was wrong
		{
		   header('location: loginSignUP.php');
		   $message = "  או שם המשתמש או הסיסמה לא לא נכון ";
		   echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}
	else if (($edit!=null)||($eedit!=null)) //back to profile page from edit page
	{
		$ID;
		if($edit!=null)
		{
			$us=$edit; 
		}
		else if ($eedit!=null)
		{
			$us=$eedit;
		}
		while ($row=mysqli_fetch_assoc($results)) 
		{
			if ($row['username']==$us) //get variables to use on HTML view
			{
				$ID=$row['id'];
				$fN=$row['fname'];
				$lN=$row['lname'];
				$email=$row['email'];
				$pri=$row['price'];
				$sta=$row['status'];
                $Phone=$row['phone'];
                if($row['setUserAs']=='student')
                {
                    header('location: studentProfile.php?id='.$ID);
                }
			}
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
				if($CourseRows['subject']!='subject')
				{
					$Courses.=$CourseRows['subject'];
					$MoreThanOneWordSoAddComma++;
				}
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
			if($rows['cities']!='cities')
			{
				$Cities.=$rows['cities'];
				$MoreThanOneWordSoAddComma++;
			}			
		}		
	}
	while ($ImgRow=mysqli_fetch_assoc($ImgResult)) //get the image
	{
		if($ImgRow['id']==$ID)
		{
			$ImgSource=$ImgRow['image'];
		}
    }
    $arrayOfLessons=array();
    $counterArrayOfLessons=0;
   
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>הכיתה</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <style>
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
            #cityButtons{
                margin-top:2%;
            }
            #courseButtons{
                margin-top:2%;
            }
            img {
    vertical-align: unset;
    border-radius: 300px;
    border-style: none;
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
        .board
        {
            max-width: 100%;
        }
        .ButtomSection
{
  direction: rtl;
  background-color: #f8b87e;
  color: white;
  font-size: large;

   left: 0;
   bottom: 0;
   width: 100%;
}
.fa {
  padding: 20px;
  font-size: 30px;
  width: 30px;
  text-align: center;
  text-decoration: none;
  margin: 5px 2px;
  border-radius: 50%;
}

.fa:hover {
    opacity: 0.7;
}

.fa-facebook {
  background: #3B5998;
  color: white;
}
#jceImg{
  max-width: 75px;
  max-height: 50px;
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
                    <a class="nav-link" href="Hakita.php">עמוד הבית <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                  </li>
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
							//echo "<img src='img/".$ImgSource."' height=170px; width=250px; class='img-rounded img-responsive'>";
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
					if ($pri!=1&&$pri!=null) 
					{
						echo "<h6>" . "מחיר לשעה:-" .$pri ."</h6>";	
                    }	
                    if($sta!=" ")
                    {
                        echo "<h6>".$sta."</h6>";
                    }
                    $forEdit=" ";
                    if ($edit!=null) 
                    {
                        $forEdit=$edit;
                    }
                    else if($eedit!=null)
                    {
                        $forEdit=$eedit;
                    }
                    else if ($us!=null) 
                    {
                        $forEdit=$us;
                    }
                ?>
                    <a href="edit.php?username=<?php echo $forEdit; ?>" >
                        <button type="button" class="btn btn-info" id="editButton">עדכן פרופיל</button>
                    </a>
                </center>
            </div>          
        </div>                                           
    </section>
    <section class="choose">
                    <div class="row">
                        <button class="tablink col-sm-3" onclick="openPage('aboutTeacher', this, 'blueviolet')"> פרטים שלי</button>
                        <button class="tablink col-sm-3" onclick="openPage('dashboardSection', this, 'orange')"id="defaultOpen">לוח שיעורים</button>
                    <button class="tablink col-sm-3" onclick="openPage('Links', this, 'blue')">יצירת קשר איתי ושיתוף פרופיל</button>
                    <button class="tablink col-sm-3" onclick="openPage('comments', this, 'green')"> תגובות התלמידים שלמדתי </button>
                    <button class="tablink col-sm-3" onclick="openPage('message', this, 'orange')">  הודעות </button>
                </div>
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
                                    if ($Courses!=null) 
									{
                                        echo "<h4>"."מלמד:- ".$Courses."</h4>";
                                        
                                    }
                                    echo "</div>";
                                    echo "<div class=\"col-sm-3\" id=\"cityButtons\">";
                                   if ($Cities!='cities')
									{
                                        echo "<h4>"."נמצא ב- ".$Cities."</h4>";
									}
                                    echo "</div>";
                                    echo "</div>";
                              ?>
                    </div>        
                    <div id="comments" class="tabcontent">
                        
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
					<!--message-->
					<div id="message" class="tabcontent">
                        <h1>עמוד ההודעות  </h1>
					</div>

                    <div id="Links" class="tabcontent">
                        <div class="form-group">
                            <h3>שיתוף את הפרופיל שלי</h3>
                            <label for="facebook"><h4  class="inputTitleIcon">FACEBOOK</h4><div class="fa fa-facebook"></div></label>
                            <label for="linkedin"><h4  class="inputTitleIcon">LINKEDIN</h4><div class="fa fa-linkedin"></div></label>               
                            <label for="youtube"><h4  class="inputTitleIcon">YOUTUBE</h4><div class="fa fa-youtube"></div></label>
                            <label for="otherLinkOne"><h4  class="inputTitleIcon">קישור אחר</h4></label>
                            <label for="otherLinkTwo"><h4  class="inputTitleIcon">קישור אחר</h4></label>
                            
                        </div>
                        <br><br>
                        <hr><hr>
                        <div class="form-group">
                            <h3>קישורים למורה</h3>                  
                        </div>
                        <br><br>
                        <hr><hr>
                        <div class="form-group">
                            <h3>פרטי תקשורת</h3> 
                            <br>
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
                        <hr><hr>
                    </div>
                    <div id="dashboardSection" class="tabcontent">
                    <section class="board">  
        
                            <table class="table table-sm table-dark">
                                <thead>
                                
                                <?php 
                                    $sunday = date('d/m', strtotime("sunday -1 week")); 
                                    $monday = date('d/m', strtotime("monday -1 week")); 
                                    $tuesday = date('d/m', strtotime("tuesday -1 week"));
                                    $wednesday = date('d/m', strtotime("wednesday -1 week"));
                                    $thursday = date('d/m', strtotime("thursday -1 week")); 
                                    $friday = date('d/m', strtotime("friday -1 week")); 
                                    $saturday = date('d/m', strtotime("saturday -1 week"));

                                    
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
                               <form action="profile.php" method="post">                               
                                    <?php
                                        $today = date("d/m"); 
                                        echo"<input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\">"; 
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
                                                        else if($scheduleRow['dayOfLesson']==$DaysId && $scheduleRow['hourOFLesson']==$hours && $scheduleRow['fullOrFree']==1)
                                                        {
                                                            $alreadyInsert=2;
                                                        }
                                                    }
                                                }
                                                $tod;
                                                $checkToday = date("l");
                                                switch ($checkToday) 
                                                {
                                                    case "Sunday":
                                                        $tod=1;
                                                        break;
                                                    case "Monday":
                                                        $tod=2;
                                                        break;    
                                                    case "Tuesday":
                                                        $tod=3;
                                                        break;
                                                    case "Wednesday":
                                                        $tod=4;
                                                        break;
                                                    case "Thursday":
                                                        $tod=5;
                                                        break;    
                                                    case "Friday":
                                                        $tod=6;
                                                        break;    
                                                    case "Saturday":
                                                        $tod=7;
                                                        break;
                                                }
                                                if($Days+1>=$tod)
                                                {
                                                    if($hours<10&&$alreadyInsert==-1)
                                                    {
                                                        echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\">"."0".$hours.":00+"."</button></th>";
                                                    }
                                                    else if($hours<10&&$alreadyInsert==1)
                                                    {
                                                        echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">"."0".$hours.":00+"."</button></th>";
                                                    }                                                
                                                    else if($hours<10&&$alreadyInsert==2)
                                                    {
                                                        echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:red\">"."0".$hours.":00+"."</button></th>";
                                                    }
                                                    else if($hours>10&&$alreadyInsert==1)
                                                    {
                                                        echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:green\">".$hours.":00+"."</button></th>";
                                                    }
                                                    else if($hours>10&&$alreadyInsert==2)
                                                    {
                                                        echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\" style=\"background-color:red\">".$hours.":00+"."</button></th>";
                                                    }
                                                    else
                                                    {
                                                        echo "<th><button name=\"chooseLessonButton\"  value=\"$buttonGiveId\">".$hours.":00+"."</button></th>";
                                                    }
                                                    $alreadyInsert=-1;
                                                }
                                                else
                                                {
                                                    echo "<th>"."עבר"."</th>";
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
                </section>
                <div class="ButtomSection">      
    <div class="container">
      <div class="row">
        
      <div class="col-sm-4">
          עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
        </div>


        <div class="col-sm-3">
          📚            
      רשימת מקצועות לימוד
      <br>
      צור קשר איתנו📧
         
      <p >הוספת פרויפיל</p>
        </div>
        <div class="col-sm-5">
          &copy;כל הזוכיות שמורות לאתר הכיתה
             
              <a href="https://www.jce.ac.il/">

                </a><br>
                קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          
                  <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
              
        </div>
      </div>
    </div>
      </div>
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