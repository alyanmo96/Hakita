<?php
	session_start();
	$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
	$IdResults = mysqli_query($con, "SELECT * FROM teachers");
	$i=0;
	$IdArray = array(); 
	while ($rows=mysqli_fetch_array($IdResults)) 
	{
		if ($rows['id']!=211) 
		{
			$IdArray[$i]=$rows['id'];
			$i++;
		}
	}
	$i-=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>הכיתה</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style >
		body
		{
			direction: rtl;			
    		max-width: 100%;
		}
		.teacher
		{
			background-color: #c9c6c6;
			padding: 20px;
			border-radius: 300px;
		}
		.teacherImg
		{
			margin-left: 20px;
			margin-right: 30px;
			max-height: 100px;
			max-width: 120px;
		}
		.moreTeachers
		{
			direction: ltr;
		}
		.Services
		{
			direction: ltr;
		}
		#up
		{
			position:fixed;	
			top:70%;
			right:0%;
			cursor: pointer;
		}
		#toTopHover 
		{
			display: block;
			overflow: hidden;
			float: left;
		}
		#toTop 
		{
			display: none;
			text-decoration: none;
			position: fixed;
			bottom: .75rem;
			right: .75rem;
			overflow: hidden;
			width: 43px;
			height: 43px;
			border: none;
			z-index: 100;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-inverse">
  		<div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="MainPage.php">עמוד הבית</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li ><a href="firstLoginPage.php">כניסה/הרשמה</a></li>
        <li>
		        	<a alt="work 1" data-toggle="modal" data-target="#myModalc">צור קשר</a>
		        	<div class="modal fade" id="myModalc" tabindex="-1" role="dialog" aria-labelledby="myModalLabelv">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabelv">צור קשר</h4>
						      </div>
						      <div class="modal-body">
						       <img id="aboutimg" src="img/call.jpg" alt="work 1">
						        <hr>
						        <p class="pA">
						        	Admin: Eli Isaak.
						        	<hr>
						        	Phone: 0522222222.
						        	<hr>
						        	Email:EliIsaak@EliIsaak.com
								</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						       </div>
						    </div>
						  </div>
						</div>
		        </li>
        <li>  	<a href="#">שאלות ותשובות</a>       </li>
        <li>	<a href="searchTeachers.php">חיפוש מורה</a>        </li>
      </ul>
    </div>
  </div>
</nav>
	<section class="work">
		<div class="container">
			<div class="row">

			<!--	<div class="col-sm-2 col-md-2">-->
					<?php

						function CourseFunction(int $Id) 
						{
							$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
							$CourseResult = mysqli_query($con, "SELECT * FROM teachers_courses");
							$MoreThanOneCourse=0;
							$courses=" ";
							while ($CourseRows=mysqli_fetch_assoc($CourseResult)) 
							{
								if ($CourseRows['id']==$Id) 
								{
									if (stristr($CourseRows['subject'],"English")) 
									{
										if ($MoreThanOneCourse>=1) 
										{
											$courses.=' , ';
										}
										$courses.='אנגלית';
										$MoreThanOneCourse++;
									}
									if (stristr($CourseRows['subject'],"Arabic")) 
									{
										if ($MoreThanOneCourse>=1) 
										{
											$courses.=' , ';
										}
										$courses.='ערבית';
										$MoreThanOneCourse++;
									}
									if (stristr($CourseRows['subject'],"Hebrew")) 
									{
										if ($MoreThanOneCourse>=1) 
										{
											$courses.=' , ';
										}
										$courses.='עברית';
										$MoreThanOneCourse++;
									}
									if (stristr($CourseRows['subject'],"Music")) 
									{
										if ($MoreThanOneCourse>=1) 
										{
											$courses.=' , ';
										}
										$courses.='מוזיקה';
										$MoreThanOneCourse++;
									}
									if (stristr($CourseRows['subject'],"Java")) 
									{
										if ($MoreThanOneCourse>=1) 
										{
											$courses.=' , ';
										}
										$courses.='גאווה';
										$MoreThanOneCourse++;
									}
									if (stristr($CourseRows['subject'],"Physic")) 
									{
										if ($MoreThanOneCourse>=1) 
										{
											$courses.=' , ';
										}
										$courses.='פיזיקה';
										$MoreThanOneCourse++;
									}
									if (stristr($CourseRows['subject'],"Android")) 
									{
										if ($MoreThanOneCourse>=1) 
										{
											$courses.=' , ';
										}
										$courses.='אנדרויד';
										$MoreThanOneCourse++;
									}
								}
							}
						    return $courses;
						}

						function CityFunction(int $Id) 
						{
							$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");	
							$result = mysqli_query($con, "SELECT * FROM teacher_cities");
							$MoreThanOneCity=0;
							$city=" ";
							while ($rows=mysqli_fetch_assoc($result)) 
							{
								if ($rows['id']==$Id) 
								{
									if (stristr($rows['cities'],"Acre")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='עכו';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Afula")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='עפולה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Arad")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='ערד';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Arraba")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='עראבה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ashdod")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='אשדוד';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ashkelon")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='אשכלון';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Baqa al-Gharbiyye")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='באקה אל גרביה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Bat Yam")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='בת ים';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Beersheba")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='באר שבע';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Beit She\'an")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='בית שאן';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Beit Shemesh")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='בית שמש';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Bnei Brak")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='בני ברק';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Dimona")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='דימונה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Eilat")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='אילת';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"El\'ad")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='אלעד';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Giv\'at Shmuel")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='גבעת שמואל';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Givatayim")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='גבעתיים';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Hadera")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='חדרה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Haifa")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='חיפה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Herzliya")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='הרצליה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Hod HaSharon")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='הוד השרון';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Holon")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='חולון';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Jerusalem")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='ירושלים';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kafr Qasim")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='כפר קאסם';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Karmiel")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='כרמיאל';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kfar Yona")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='כפר יונה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Ata")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית אתא';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Bialik")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית ביאליק';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Gat")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית גת';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Malakhi")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית מלאכי';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Motzkin")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית מוצקין';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Ono")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית אונו';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Shmona")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית שמונה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Kiryat Yam")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קרית ים';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Lod")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='לוד';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ma\'alot Tarshiha")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='מעלות תרשיחא';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Migdal HaEmek")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='מגדל העמק';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Modi\'in-Maccabim-Re\'ut")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='מודיעין מכבים רעות';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Nahariya")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='נהריה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Nesher")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='נשר';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Nazareth")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='נצרת';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ness Ziona")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='נס ציונה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Netanya")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='נתניה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Netivot")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='נתיבות';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Nof HaGalil")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='נוף הגליל';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ofakim")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='אופקים';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Or Akiva")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='אור עקיבה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Petah Tikva")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='פתח תקווה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Qalansawe")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='קלנסווה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ra\'anana")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='רעננה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Rahat")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='רהט';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ramat Gan")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='רמת גן';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ramat HaSharon")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='רמת השרון';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Ramla")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='רמלה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Rehovot")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='רחובות';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Rishon LeZion")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='ראשון לציון';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Rosh HaAyin")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='ראש העין';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Safed")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='צפת';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Sakhnin")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='סכנין';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Sderot")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='סדירות';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Shfa-\'Amr")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='שפא עמר';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Tamra")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='טמרה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Tayibe")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='טייבה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Tel Aviv-Yafo")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='תל-אביב יפו';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Tiberias")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='טבריה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Tira")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='טירה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Tirat Carmel")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='טירת הכרמל';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Umm al-Fahm")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='אום אל-פאחם';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Yavne")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='יבנה';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Yehud-Monosson")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='יהודה מונוסון';
										$MoreThanOneCity++;
									}
									if (stristr($rows['cities'],"Yokneam Illit")) 
									{
										if ($MoreThanOneCity>=1) 
										{
											$city.=' , ';
										}
										$city.='יקנעם עילית';
										$MoreThanOneCity++;
									}
								}
							}
							return $city;
						}
						
						$j=0;
						while ($j<=$i) 
						{
							echo '<div class="teacher col-sm-3">';
							$results = mysqli_query($con, "SELECT * FROM images");
							while ($rows=mysqli_fetch_array($results)) 
							{
								if ($rows['id']==$IdArray[$j]) 
								{
									echo "<img src='img/".$rows['image']."'   class='teacherImg img-rounded img-responsive'>";
								}
							}						
							$results = mysqli_query($con, "SELECT * FROM teachers");

							$CoursesResults = mysqli_query($con, "SELECT * FROM teachers_courses");
							while ($rows=mysqli_fetch_array($results)) 
							{
								if ($rows['id']==$IdArray[$j]) 
								{
									if ($rows["fname"]!=' '&&$rows["lname"]!=' ') 
									{
										echo " שם  ";
										echo "" . $rows["fname"]. "  " . $rows["lname"]."<br />";
									}
									else if($rows["fname"]!=' '&&$rows["lname"]==' ') 
									{
										echo " שם  ";
										echo "" . $rows["fname"]."<br />";
									}
									else if ($rows["fname"]==' '&&$rows["lname"]!=' ') 
									{
										echo " שם  ";
										echo "" . $rows["lname"]."<br />";
									}
									if ($rows["city"]!=' ') 
									{
										$CityName=CityFunction($IdArray[$j]);
										echo "" . $CityName."<br />";
									}
									if ($rows["price"]!=1) 
									{
										echo "מחיר לשעה:-";
										echo "" . $rows["price"]."<br />";
									}
								}
							}
							while($rows=mysqli_fetch_array($CoursesResults))
							{
								if ($rows['id']==$IdArray[$j]) 
								{
									if ($rows["subject"]!=1) 
									{
										//$_SESSION["a"] = "LOGGED";
										//require_once('cityReturnFunction.php');
										//$user = 'test';
										//Header("Location: cityReturnFunction.php?user=".$user);
										//$data = CourseFunction();
										 include 'cityReturnFunction.php';

										$CourseName=CourseFunction($IdArray[$j]);
										echo "מלמד:-";
										echo "" . $CourseName."<br />";
									}
								}	
							}						
							echo '</div>';
							$j++;
						}
																			
					?>
			<!--	</div>-->
	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>		
</html>