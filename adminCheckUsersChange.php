<?php
	$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $results = mysqli_query($con, "SELECT * FROM teachers");
    $makeChangeEnter = mysqli_query($con, "SELECT * FROM makeChange");
    $getIdFromMakeChangeDataBaseCounter=0;
    $getIdFromMakeChangeDataBase=array();
    while ($row=mysqli_fetch_assoc($makeChangeEnter)) 
    {  
       $getIdFromMakeChangeDataBase[$getIdFromMakeChangeDataBaseCounter]=$row['id'];
       $getIdFromMakeChangeDataBaseCounter++;
    }
    $i=0;
	$IdArray = array(); 
	while ($rows=mysqli_fetch_array($results)) 
	{
		for ($j=0; $j < count($getIdFromMakeChangeDataBase); $j++) 
		{ 
			if ($rows['id']==$getIdFromMakeChangeDataBase[$j]) 
			{
				$IdArray[$i]=$rows['id'];
				$i++;
			}
		}
	}
	$i-=1;
?>
<!DOCTYPE html>
<html>
<head>
  <title>הכיתה</title>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <style>
        body
        {
          direction: rtl;
          text-align: center;
        }
        input[type=submit] 
        {
            max-width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
          }
         input[type=submit]:hover 
         {
            background-color: #45a049;
         }
         .chooseImg
         {
          max-width: 10%
          padding-right:50%;
          margin-right: 46%;
         }
         .file-field.big .file-path-wrapper 
         {
            height: 3.2rem; 
          }
          .file-field.big .file-path-wrapper .file-path 
          {
            height: 3rem; 
          }
          .teacherImg
			{
			margin-left: 20px;
			margin-right: 30px;
			max-height: 100px;
			max-width: 120px;
			}
			#button 
        {
            display: inline-block;
            background-color: #4cae4c;
            width: 50px;
            height: 50px;
            text-align: center;
            border-radius: 4px;
            position: fixed;
            bottom: 30px;
            right: 30px;
            transition: background-color .3s, 
                opacity .5s, visibility .5s;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
         }
            #button::after {
            content: "\f077";
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            font-size: 2em;
            line-height: 50px;
            color: #fff;
            }
            #button:hover {
            cursor: pointer;
            background-color: #333;
            }
            #button:active {
            background-color: #555;
            }
            #button.show {
            opacity: 1;
            visibility: visible;
            }

            /* Styles for the content section */

            .content {
            width: 77%;
            margin: 50px auto;
            font-family: 'Merriweather', serif;
            font-size: 17px;
            color: #6c767a;
            line-height: 1.9;
            }
            @media (min-width: 500px) {
            .content {
                width: 43%;
            }
            #button {
                margin: 30px;
            }
            }
      </style>
</head>
<body>
<a id="button"></a>
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
        <li > <a href="AdminControlPage.php">עמוד המנהל</a></li>
      </ul>
    </div>
  </div>
</nav>
	<hr>
	<div class="col-sm-6">
	</div>
	<div class="col-sm-6">
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
		?>
</div>
<br>
<hr>
	<section class="work">
<div class="container">
<div class="row">
	<?php
			$j=0;
			$D=array();
			$DCounter=0;
			while ($j<=$i)
			{
			$results = mysqli_query($con, "SELECT * FROM images");
			while ($rows=mysqli_fetch_array($results))
			{
				if ($rows['id']==$IdArray[$j])
				{
					$D[$DCounter]=$IdArray[$j];
					$DCounter++;
					$d=$IdArray[$j];
					echo '<div class="teacher col-sm-3" id="$d">';
					#echo "<button id=\"$d\">";
					echo "<button value=\"$d\" id=\"$d\">";
					                                   echo"   <input type=\"hidden\" id=\"$d\">";
					if ($rows['image']!='image'&&$rows['image']!=null)
					{
						echo "<img src='img/".$rows['image']."'   class='teacherImg img-rounded img-responsive'>";
					}
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
				$CourseName=CourseFunction($IdArray[$j]);
				echo "מלמד:-";
				echo "" . $CourseName."<br />";
				}
				}
				}
			echo "</button>";
			echo '</div>';
			$j++;
		}
	?>
	</div>
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
<script>
	var phpIdArrayLength = <?php echo end($D);?>;
	$(document).ready(function()
	{
	for (var i = 0; i <= phpIdArrayLength; i++)
	{
	let x=i;
	let n = x.toString();
	$("#"+n).click(function()
	{
	window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
	});
	}
	});
</script>