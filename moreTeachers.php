<?php
	/**
	 * on this file we can find more teachers than what show on main page.
	 * at this moment will display all teachers, on next level after choose this page 
	 * from the main page will display teacher as a new teacher or english teacher etc...
	 */
	session_start();
	$ID=$_SESSION['id'];//if there is any login id, get it.
	$_SESSION['id']=$ID;
	include 'userData.php';//call this file to get name of teachers and more like teacher price,status....

	function deleteUnrelativeElementFromArray($Id,$includeSubject){//function to keep the relative id's on array. using for {more english teachers}for example.
		$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
		$CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
		while($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
			if($rows['id']==$Id && (strpos($rows['subject'] , $includeSubject)!==FALSE)){//if we found the reqaired id, check if teacher learn this subject
				return 1;//yes learn, dont need to continue, back true.
			}	
		}return -1;//in case teacher not learn...
	}
	$i=0;/* variable used to add a new relative id on next array*/$IdArray = array(); // get all teachers id.
	$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
	$IdResults = mysqli_query($con, "SELECT * FROM users");
	while($rows=mysqli_fetch_array($IdResults)){
		if($rows['id']!=211&&$rows['setUserAs']!='student'){//the id of the admin and not a student
			if($_GET['subject']=='AllTeachers'){//for all teachers, we dont need to check if a special teacher learn a sepcial subject or not
				$IdArray[$i]=$rows['id'];$i++;//insert id on array. 	next $i				
			}elseif(deleteUnrelativeElementFromArray($rows['id'],$_GET['subject'])==1){//for a special teachers, we need to check if a special teacher learn a sepcial subject or not
				$IdArray[$i]=$rows['id'];$i++;//if yes, we get to this line and insert id. next $i				
			}
		}
	}$i-=1;

	function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
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
	
	for($e=1;$e<20000;$e++){
		if(array_key_exists($e, $_POST)){ 
		  redirectFunction($e); 
		} 
	  } 
	function redirectFunction($id){
		$_SESSION['teacher']=$id;
		header('location: viewTeacherProfile.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
		<?php include 'header.php';?>  
		<link rel="stylesheet" type="text/css" href="css/moreTeachersStyle.css">
	</head>
	<body>
		<section><!--navbar section-->
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>            
				<?php     
					echo'<a class="navbar-brand" href="Hakita.php">הכיתה</a>
					<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
					<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
						<li class="nav-item"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li>';
					if(!$ID){//for the unlogin user will display (signin/sign up) search for a teacher and FAQ page
						echo'  
                        	<li class="nav-item active"><a class="nav-link" href="login.php">כניסה</a></li>
                        	<li class="nav-item active"><a class="nav-link" href="Signup.php">הרשמה</a></li>
							<li class="nav-item"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>
							<li class="nav-item"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>';
					}else{/*for the login user, first we check if the login user is a student or a teacher
						that help with redirect to his profile, case there is a different between theprofile of teacher and the profile of student
						for the login user the navbar include:main page/ my profile  /logout/search for a teacher/FAQ page
						( on {3,4} what's deffirnet with unlogin user, here we send the id of the user)
						*/						
							if(checkUserDefineAs($IDOfStudent)==-1){// if the login user was a student, then he want to access to his profile
								echo'<li class="nav-item active"><a class="nav-link" href="studentProfile.php">פרופיל שלי <span class="sr-only">(current)</span></a></li>';
							}else{// if the login user was a teacher, then he want to access to his profile
							echo'<li class="nav-item active"><a class="nav-link" href="profile.php">פרופיל שלי <span class="sr-only">(current)</span></a></li>';
							}// login user go to search teachers page/FAQ page/exit from his account
							echo'<li class="nav-item"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>
							<li class="nav-item"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>
							<li class="nav-item"><a class="nav-link" href="logout.php">יציאה </a></li>';				
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
							echo'<div id="noResult">עוד אין מורים בתחום הזה שנבחר</div>';
						}else{//for each teacher show image, name, price and status.
							$j=0;$TeacherID=0;$D=array();$DCounter=0;
							echo'<div class="container"><div class="row" style=\'direction:rtl;\'>';
							echo"<form method=\"post\" action=\"moreTeachers.php\">";
							while($j<=$i){	
								$D[$DCounter]=$IdArray[$j];$DCounter++;//insert the teacher id for using on click state. 	next teacher
										$TeacherID=$IdArray[$j];
							echo"<button class=\"card mb-3\" name=\"$TeacherID\" style=\"max-width: 740px; direction: rtl;\">";
								echo"<div class=\"row no-gutters\">
									<div class=\"col-md-4\"><img src='img/".Image($IdArray[$j])." 'class=\"card-img\"></div>";//teacher image
										echo'<div class="col-md-8"><div class="card-body">';
							echo"<h5 class=\"card-title\">";
							if(Gender($IdArray[$j])==-1){echo "מורה פרטית ".name($IdArray[$j]);}
							else{echo"מורה פרטי ".name($IdArray[$j]);}
							echo"</h5>";
							teacherRating($IdArray[$j]);//teacher rating
							echo "".price($IdArray[$j])."₪לשעה<br>";//teacher price
							echo"קצת עלי&nbsp;\"". status($IdArray[$j])."\"";//teacher status
                            if(Gender($IdArray[$j])==-1){echo"<p class=\"card-text\">מלמדת שיעור פרטי ב-&nbsp;".returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],5)."</p>";}
							else{echo"<p class=\"card-text\"> מלמד שיעורים פרטים ב-&nbsp;".returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],5)."</p>";}
                            echo"<p class=\"card-text\"><small class=\"text-muted\">עיר לימוד:&nbsp;".returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],3)."</small></p></div></div></div></button>"; 
							$j++;
						}echo"</form></div></div>";
						}	
					?></div></div>
		<?php include_once 'footer.php';/*call the bottom footer*/?>
    </body>
</html>
<?php include 'script.php';/*some script like up button*/?>  