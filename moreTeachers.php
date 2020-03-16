<?php
	/**
	 * on this file we can find more teachers than what show on main page.
	 * at this moment will display all teachers, on next level after choose this page 
	 * from the main page will display teacher as a new teacher or english teacher etc...
	 */
	session_start();
	if($_GET['id']){//get to this page by login user or not
		$userId=$_GET['id'];
	}
	include 'connectionPage.php';//include this file for calling the DB
	function deleteUnrelativeElementFromArray($Id,$includeSubject){//function to keep the relative id's on array. using for {more english teachers}for example.
		include 'connectionPage.php';//include this file for calling the DB, need to connect again, case public connection not work inside function
		while ($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
			if ($rows['id']==$Id && (strpos($rows['subject'] , $includeSubject)!==FALSE)){//if we found the reqaired id, check if teacher learn this subject
				return 1;//yes learn, dont need to continue, back true.
			}	
		}
		return -1;//in case teacher not learn...
	}
	$i=0;/* variable used to add a new relative id on next array*/$IdArray = array(); // get all teachers id.
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
		include 'connectionPage.php';//include this file for calling the DB
		while ($rows=mysqli_fetch_array($resultsOfImageTable)){
		  if ($rows['id']==$id){//if we found the reqaired id, show the image
			    echo "<div class=\"col-md-3\"><img src='img/".$rows['image']."'   class=\"m-1 w-100 img-fluid\" style=\"max-height: 200px;\"></div>";
		  	}
		}
	}
	function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
        include 'connectionPage.php';//include this file for calling the DB
        $returnData="";//data{cities or courses want to return}
        if($whatToReturn==5){//for courses
            while ($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
                if ($rows['id']==$id){//if we found the reqaired id
                        if($rows['subject']!='subject'){//found what we need, get it and return it back
                            $returnData.=$rows['subject'];
                        break;
                        }
                    }	
            }
        }else{//for cities
            while ($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
                if ($rows['id']==$id){
                    if($rows['cities']!='cities'){
                        $returnData.=$rows['cities'];
                    break;
                    }			
                }		
            }
        }
        return $returnData;// return data  for cities or courses
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
						include 'connectionPage.php';//include this file for calling the DB
						while ($rows=mysqli_fetch_array($IdResults)){
							if ($rows['id']==$userId && $rows['setUserAs']=='student'){//found the required id
								$isStudent=1;	break;//change the flag to one, and break, no need to continue.
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
						}
					?>
				</ul>
				</div>
			</nav>
		</section> 
		<hr>
		<section class="col-sm-1">
			<a id="button"></a>
		</section>
		<section class="work col-sm-12">
			<div class="container">
				<div class="row">
					<?php
						if(count($IdArray)==0){//if there is not yet any teacher learn this course on site...on early level.
							echo '<div id="noResult">
							עוד אין מורים בתחום הזה שנבחר</div>';
						}else{//for each teacher show image, name, price and status.
							$j=0;$TeacherID=0;$D=array();$DCounter=0;
							echo '<div class="container"><div class="row" style=\'direction:rtl;\'>';
							while ($j<=$i){	
								$price=-1;
								echo '<div class="card w-100 mb-2"></div><div class="card w-100 mb-2"><div class="row">';
								teacherImage($IdArray[$j]);//get the teacher image from above function
								$D[$DCounter]=$IdArray[$j];$DCounter++;//insert the teacher id for using on click state. 	next teacher
								$TeacherID=$IdArray[$j];								
								$results = mysqli_query($con, "SELECT * FROM teachers");
								echo'<div class="card-body text-right col-md-9">';
								while ($rows=mysqli_fetch_array($results)){
									if ($rows['id']==$IdArray[$j]){
										echo '<h3 class="card-title rtl">'. "  שם:   "."" . $rows["fname"]. "  " . $rows["lname"].'</h3>';	
										if($rows["status"]!=null && $rows["status"]!=" "){
											echo $rows["status"]."".nl2br("\n");
										}
										if ($rows["price"]!=1){//insert the price, to use it for show later
											$price=$rows["price"];
										}
									}
								}
								$CityName=returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],3);
								if ($CityName!=null){
									echo "" . $CityName."".nl2br("\n");
								}
								$CourseName=returnTeacherCitiesOrCoursesIntoArray($IdArray[$j],5);
								if ($CourseName!=null){
									echo "" . $CourseName."".nl2br("\n");
								}
								if ($price!=-1){
									echo "מחיר לשעה:-"."₪" . $price."".nl2br("\n");
								}	
								echo '</p></div></div>';$j++;
								echo"<button value=\"$Teacher\" id=\"$TeacherID\">הצגת פרופיל</button><input type=\"hidden\" id=\"$TeacherID\"></div>";
							}
							echo '</div></div>';
						}	
					?>
			<div class="ButtomSection col-sm-12">      
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
    </body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>		
</html>
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