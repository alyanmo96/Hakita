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
            <a class="navbar-brand" href="#">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="loginSignUP.php">כניסה/הרשמה <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="Hakita.php"> עמוד הבית</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="searchTeachers.php">חיפוש מורה</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
                  </li>
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
								$price=-1;
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
											echo '<h3 class="card-title rtl">';
											echo " שם  ";
											echo "" . $rows["fname"]. "  " . $rows["lname"];
											echo '</h3>';
										}
										else if($rows["fname"]!=null&&$rows["lname"]==null) 
										{
											echo '<h3 class="card-title rtl">';
											echo " שם  ";
											echo "" . $rows["fname"];
											echo '</h3>';
										}
										else if ($rows["fname"]==null&&$rows["lname"]!=null) 
										{
											echo '<h3 class="card-title rtl">';
											echo " שם  ";
											echo "" . $rows["lname"];
											echo '</h3>';
										}
									if($rows["status"]!=null && $rows["status"]!=" ")
									{
										echo $rows["status"];
										echo nl2br("\n");
									}
									if ($rows["price"]!=1) 
									{
										$price=$rows["price"];
									}
									}
								}
								$CityName=" ";
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
								if ($price!=-1) 
								{
									echo "מחיר לשעה:-";
									echo "₪" . $price;
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
				window.location.href = "viewTeacherProfile.php?id=" + x;
				});
				if(s!=-1)
				{					
					window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
				}
			}
		});
	
</script>