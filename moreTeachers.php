<?php
	/**
	 * on this file we can find more teachers than what show on main page.
	 * at this moment will display all teachers, on next level after choose this page 
	 * from the main page will display teacher as a new teacher or english teacher etc...
	 */
	session_start();
/*
	*  $userId=$_SESSION['id']
	*   $_SESSION['id']=$userId;




	*/
	if($_GET['id']){//get to this page by login user or not
		$userId=$_GET['id'];
	}
    //$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
	$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

	function deleteUnrelativeElementFromArray($Id,$includeSubject){//function to keep the relative id's on array. using for {more english teachers}for example.
//		$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB, need to connect again, case public connection not work inside function
		$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

		$CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
		while ($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
			if ($rows['id']==$Id && (strpos($rows['subject'] , $includeSubject)!==FALSE)){//if we found the reqaired id, check if teacher learn this subject
				return 1;//yes learn, dont need to continue, back true.
			}	
		}return -1;//in case teacher not learn...
	}
	$i=0;/* variable used to add a new relative id on next array*/$IdArray = array(); // get all teachers id.
	$IdResults = mysqli_query($con, "SELECT * FROM users");
	while ($rows=mysqli_fetch_array($IdResults)){
		if ($rows['id']!=211&&$rows['setUserAs']!='student'){//the id of the admin and not a student
			if($_GET['subject']=='AllTeachers'){//for all teachers, we dont need to check if a special teacher learn a sepcial subject or not
				$IdArray[$i]=$rows['id'];$i++;//insert id on array. 	next $i				
			}elseif(deleteUnrelativeElementFromArray($rows['id'],$_GET['subject'])==1){//for a special teachers, we need to check if a special teacher learn a sepcial subject or not
				$IdArray[$i]=$rows['id'];$i++;//if yes, we get to this line and insert id. next $i				
			}
		}
	}$i-=1;
	function teacherImage($id){//this function is for return the name of teacher image
//		$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
		$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

		$resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
		while($rows=mysqli_fetch_array($resultsOfImageTable)){
		  if($rows['id']==$id){//if we found the reqaired id, show the image
				return $rows['image'];
		  	}
		}
	}
	function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
//		$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB	
		$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

		$returnData="";//data{cities or courses want to return}
        if($whatToReturn==5){//for courses
			$CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
			while($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
                if($rows['id']==$id){//if we found the reqaired id
                        if($rows['subject']!='subject'){//found what we need, get it and return it back
                            $returnData.=$rows['subject'];break;
                        }
                    }	
            }
		}else{//for cities
			$resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities");
            while($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
                if($rows['id']==$id){
                    if($rows['cities']!='cities'){
                        $returnData.=$rows['cities'];break;
                    }			
                }		
            }
        } return $returnData;// return data  for cities or courses
	}
	function getTeacherInformation($id){// function used to return first name and seconde name as one name. use on teacher name and on names of comments wirters
//        $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
		$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

		$IdResults=mysqli_query($con, "SELECT * FROM users");
		$name=" ";
		$fact=array();
        while($row=mysqli_fetch_assoc($IdResults)){
            if ($row['id']==$id){//when we found the name on the table of DB            
                $name.=$row['fname'];$name.='&nbsp;';$name.=$row['lname'];array_push($fact,$name);	
				array_push($fact,$row['gender']);
				array_push($fact,$row['price']); 				
				array_push($fact,$row['status']); 
			}
		}
		return $fact; 
    }
	function teacherRating($id){
		$countRatingOfTeacher=0;$totalCountRatingOfTeacher=0;
//		$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB	
		$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

		$commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
		while ($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
			if($ratingOfTeacher['idOfTeacher']==$id){
				$countRatingOfTeacher++;$totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
			}
		}
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
?>
<!DOCTYPE html>
<html lang="en">
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
		<link rel="stylesheet" type="text/css" href="css/moreTeachersStyle.css">
		<style>
		.card-img{
			max-height:150px;
		}
		.checked {
    color: orange;
  }
  .col-sm-6 {
            float: right;
        }
        .card{margin-right: auto;
            margin-left: auto;
		}
		.card-title {
    margin-bottom: 0px;
    float: right;
}.fa {
    padding: 0px;
    font-size: 15px;
    width: 10px;
    text-align: center;
    text-decoration: none;
    margin: 5px;
    border-radius: 50%;
}
footer
      {
          background-color: black;
          color: white;
      }   
		</style>
	</head>
	<body>
		<section><!--navbar section-->
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>            
				<?php     
					if(!$userId){//for the unlogin user will display (signin/sign up) search for a teacher and FAQ page
						echo '<a class="navbar-brand" href="Hakita.php">הכיתה</a>
						<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
						<ul class="navbar-nav mr-auto mt-2 mt-lg-0"> 
							<li class="nav-item"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li>
							<li class="nav-item active"><a class="nav-link" href="loginSignUP.php">כניסה/הרשמה </a></li>
							<li class="nav-item"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>
							<li class="nav-item"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>';
					}else{/*for the login user, first we check if the login user is a student or a teacher
						that help with redirect to his profile, case there is a different between theprofile of teacher and the profile of student
						for the login user the navbar include:main page/ my profile  /logout/search for a teacher/FAQ page
						( on {3,4} what's deffirnet with unlogin user, here we send the id of the user)
						*/   
						$isStudent=-1; 
						$IdResult = mysqli_query($con, "SELECT * FROM teachers");//include this file for calling the DB
						while($rows=mysqli_fetch_array($IdResult)){
							if ($rows['id']==$userId && $rows['setUserAs']=='student'){//found the required id
								$isStudent=1;break;//change the flag to one, and break, no need to continue.
							}
						}
						echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$userId\">הכיתה</a>
						<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
						<ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"Hakita.php?id=$userId\"> עמוד הבית</a></li>";
							if($isStudent==1){// if the login user was a student, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php?id=$userId\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}else{// if the login user was a teacher, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php?id=$userId\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}// login user go to search teachers page/FAQ page/exit from his account
							echo"<li class=\"nav-item\"><a class=\"nav-link\" href=\"searchTeachers.php?id=$userId\">חיפוש מורה</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"FAQ.php?id=$userId\">שאלות ותשובות</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"Hakita.php\">יציאה </a></li>";
						/*


						echo "<a class=\"navbar-brand\" href=\"Hakita.php\">הכיתה</a>
						<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
						<ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"Hakita.php\"> עמוד הבית</a></li>";
							if($isStudent==1){// if the login user was a student, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}else{// if the login user was a teacher, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}// login user go to search teachers page/FAQ page/exit from his account
							echo"<li class=\"nav-item\"><a class=\"nav-link\" href=\"searchTeachers.php\">חיפוש מורה</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"FAQ.php\">שאלות ותשובות</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">יציאה </a></li>";







						*/
						
						
						
						}
					?>
				</ul>
				</div>
			</nav>
		</section><hr>
		<section class="col-sm-1"><a id="button"></a></section>
		<section class="work col-sm-12">
			<div class="container">
				<div class="row">
					<?php
						if(count($IdArray)==0){//if there is not yet any teacher learn this course on site...on early level.
							echo '<div id="noResult">עוד אין מורים בתחום הזה שנבחר</div>';
						}else{//for each teacher show image, name, price and status.
							$j=0;$TeacherID=0;$D=array();$DCounter=0;
							echo '<div class="container">
							<div class="row" style=\'direction:rtl;\'>';
							while ($j<=$i){	
								$D[$DCounter]=$IdArray[$j];$DCounter++;//insert the teacher id for using on click state. 	next teacher
										$TeacherID=$IdArray[$j];
							echo"<button class=\"card mb-3\" id=\"$TeacherID\" style=\"max-width: 740px; direction: rtl;\">";
								echo"<div class=\"row no-gutters\">
										<div class=\"col-md-4\"><img src='img/".teacherImage($IdArray[$j])." 'class=\"card-img\"></div>";
										echo'<div class="col-md-8">
										<div class="card-body">';
							$teacherInformation=getTeacherInformation($IdArray[$j]);
							echo"<h5 class=\"card-title\">";
							if($teacherInformation[1]=='female'){
								echo "מורה פרטית ".$teacherInformation[0];
							}else{
								echo"מורה פרטי ".$teacherInformation[0];
							}
							echo"</h5>";
							teacherRating($IdArray[$j]);
							echo $teacherInformation[2]."₪לשעה<br>";
							echo"קצת עלי&nbsp;\"". $teacherInformation[3]."\"";
                            if($teacherInformation[1]=='female'){
								echo"<p class=\"card-text\">מלמדת שיעור פרטי ב-&nbsp;".returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],5)."</p>";                        
                            }else{
								echo"<p class=\"card-text\"> מלמד שיעורים פרטים ב-&nbsp;".returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],5)."</p>";                        
                            }
                            echo"<p class=\"card-text\"><small class=\"text-muted\">עיר לימוד:&nbsp;".returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],3)."</small></p></div></div></div></button>"; 
							$j++;
						}
						echo '</div></div>';
						}	
					?></div></div>
					<footer class="w3-container w3-teal-black w3-center w3-margin-top">
        <div class="row">
        <div class="col-sm-5">
          &copy;כל הזוכיות שמורות לאתר הכיתה
          <a href="https://www.jce.ac.il/"></a><br>
            קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
        </div>        
        <div class="col-sm-3"> 📚           
          רשימת מקצועות לימוד<br>
          צור קשר איתנו📧  
        <br><p >הוספת פרויפיל</p>
		</div><br/>
        <div class="col-sm-4">        עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
        </div><br/>
      </div>
    </footer>	
    </body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>		
</html>

<!---




check window.location.href without parameters



--->
<script>//next section will be for the up button
	var btn = $('#button');
    $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        btn.addClass('show');
    }else {
        btn.removeClass('show');
    }
    });
    btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
    });//next section used to redirect to view the teacher profile
	var userId = <?PHP echo (!empty($userId) ? json_encode($userId) : '""'); ?>;//if there a login user so we need to send his id to the next page, to continue there hi functions
    var phpIdArrayLength = <?php echo end($D);?>;//get the teacheer id
	$(document).ready(function(){
		for (var i = 0; i <= phpIdArrayLength; i++){
			let x=i;
			let n = x.toString();
			$("#"+n).click(function(){
				if(userId){//redirect with login user
					window.location.href = "viewTeacherProfile.php?id=" + x + "&studentID="+userId;
				}else{//redirect without login user
				  window.location.href = "viewTeacherProfile.php?id=" + x;
				}				
			});
		}
		});	
</script>