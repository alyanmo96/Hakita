<?php
	session_start();
	$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
	$IdResults = mysqli_query($con, "SELECT * FROM teachers");
	$i=0;
	$IdArray = array(); 
	while ($rows=mysqli_fetch_array($IdResults)) 
	{
		//if ($rows['id']!=211&&$rows['userAs']!='תלמיד') //the id of the admin and not a student
		if ($rows['id']!=211) //the id of the admin and not a student
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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styleSearch.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="row col-sm-12">
                <a class="navbarOptions btn btn-secondary btn-lg active col-sm-2"  href="FAQ.php">שאלות ותשובות </a>
                <a class="navbarOptions btn btn-secondary btn-lg active col-sm-2"  href="MainPage.php">עמוד הבית</a>
                <a class="navbarOptions btn btn-secondary btn-lg active col-sm-2"  href="searchTeachers.php">חיפוש מורה</a>
                <a class="navbarOptions btn btn-secondary btn-lg active col-sm-2" href="firstLoginPage.php">כניסה/הרשמה</a>                  
            </div>
        </div class="container">
    </section>
<hr>
	<a id="button"></a>
	<section class="work">
		<div class="container">
			<div class="row">
					<?php
						if(count($IdArray)==0)
						{
							echo '<div id="noResult">
							עוד אין מורים בתחום הזה שנבחר';
							echo '</div>';
						}
						else
						{
							$j=0;
							$TeacherID=0;
							$D=array();
							$DCounter=0;
							echo '<div class="container">';
							echo '<div class="row" style=\'direction:rtl;\'>';
							while ($j<=$i) 
							{	
								echo '<div class="card w-100 mb-2">';
								echo '</div>';
								echo '<div class="card w-100 mb-2">';
								echo '<div class="row">';
								$results = mysqli_query($con, "SELECT * FROM images");
								while ($row=mysqli_fetch_array($results)) 
								{
									if ($row['id']==$IdArray[$j]) 
									{
										$D[$DCounter]=$IdArray[$j];
										$DCounter++;
										$TeacherID=$IdArray[$j];
										if ($row['image']!='image') 
										{
											echo '<div class="col-md-3">';
											echo "<img src='img/".$row['image']."'   class=\"m-1 w-100 img-fluid\" style=\"max-height: 200px;\">";
											echo '</div>';
										}
									}
								}					
								$results = mysqli_query($con, "SELECT * FROM teachers");
								echo'<div class="card-body text-right col-md-9">';
								while ($rows=mysqli_fetch_array($results)) 
								{
									if ($rows['id']==$IdArray[$j]) 
									{
										if ($rows["fname"]!=null&&$rows["lname"]!=null) 
										{
											echo '<h5 class="card-title rtl">';
											echo " שם  ";
											echo "" . $rows["fname"]. "  " . $rows["lname"];
											echo '</h5>';
										}
										else if($rows["fname"]!=null&&$rows["lname"]==null) 
										{
											echo '<h5 class="card-title rtl">';
											echo " שם  ";
											echo "" . $rows["fname"];
											echo '</h5>';
										}
										else if ($rows["fname"]==null&&$rows["lname"]!=null) 
										{
											echo '<h5 class="card-title rtl">';
											echo " שם  ";
											echo "" . $rows["lname"];
											echo '</h5>';
										}
									if ($rows["price"]!=1) 
									{
										echo "מחיר לשעה:-";
										echo "₪" . $rows["price"];
										echo nl2br("\n");
									}
									}
								}
								$result = mysqli_query($con, "SELECT * FROM teacher_cities");
								$MoreThanOneWordSoAddComma=0;
								while ($teacher_citiesRows=mysqli_fetch_assoc($result)) 
								{
									if ($teacher_citiesRows['id']==$IdArray[$j]) 
									{
										if ($MoreThanOneWordSoAddComma>=1) 
										{
											$CityName.=' , ';
										}
										if($teacher_citiesRows['cities']!='cities')
										{
											$CityName.=$teacher_citiesRows['cities'];
											$MoreThanOneWordSoAddComma++;
										}
									}
								}	
								$MoreThanOneWordSoAddComma=0;
								if ($CityName!=null) 
								{
									echo "" . $CityName;
									echo nl2br("\n");
								}
								$CoursesResults = mysqli_query($con, "SELECT * FROM teachers_courses");
								while($CoursesResultsRows=mysqli_fetch_array($CoursesResults))
								{
									if ($CoursesResultsRows['id']==$IdArray[$j]) 
									{
										if ($MoreThanOneWordSoAddComma>=1) 
										{
											$CourseName.=",";
										}
										if($CoursesResultsRows['subject']!='subject')
										{
											$CourseName=$CoursesResultsRows['subject'];
											$MoreThanOneWordSoAddComma++;
										}
									}	
								}	
								if ($CourseName!=null) 
								{
									echo "" . $CourseName;
									echo nl2br("\n");
								}
								echo "</p>";		
								$j++;	
								echo '</div>';
								echo '</div>';
								echo"<button value=\"$Teacher\" id=\"$TeacherID\">הצגת פרופיל</button>";
								echo"   <input type=\"hidden\" id=\"$TeacherID\">";
								echo '</div>';
							}
								echo '</div>';
								echo '</div>';
						}	
					?>
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
    var phpIdArrayLength = <?php echo end($D);?>;
	$(document).ready(function()
		{
			for (var i = 0; i <= phpIdArrayLength; i++)
			{
				let x=i;
				let s=-1;
				let n = x.toString();
				$("#"+n).click(function()
				{//alert(n);
					s=x;				
				window.location.href = "studentCheckTeacherPage.php?id=" + x;
				});
				if(s!=-1)
				{					
					window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
				}
			}
		});
	
</script>