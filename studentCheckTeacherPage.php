<?php
	session_start();
	$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
	// conect with tables to get information about the user to show it and use
	$results = mysqli_query($con, "SELECT * FROM teachers");	
	$ImgResult = mysqli_query($con, "SELECT * FROM images");
	//variables will used on HTML
	//(username,status,email,first name, last name, phone number, cities, courses,img,price)
	$us=" ";	$sta=" ";	$email=" "; 	$fN=" ";	$lN=" "; 	$Phone=" "; 
	$Cities= " "; 	$Courses=" ";   	$ImgSource=" "; 	$ID=$_GET['id']; 	$pri;
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
                  <li class="nav-item active">
                    <a class="nav-link" href="firstLoginPage.php">כניסה/הרשמה <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
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
                                            echo "<button value=\"$ID\" id=\"$ID\">$arrayOfTeacherCourses[$ci]</button>";
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
                                            echo "<button>$arrayOfTeacherCities[$ci]</button>";
                                        }
									}
                                    echo "</div>";
                                    echo "</div>";
                              ?>
                    </div>        
                    <div id="comments" class="tabcontent">
                        <h1>אין עוד תגובות</h1>
                    </div>


                    <div id="Links" class="tabcontent">
                        <div class="form-group">
                            <h3>שיתוף מורה</h3>
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
                        <h1>dashboard timeline</h1>
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
         //console.log(data);
         $('#hidden_framework').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       alert("נא לבחור עיר");
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
         //console.log(data);
         $('#hidden_framework_courses').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       alert("נא לבחור עיר");
       return false;
      }
     });
    });
    </script>
    <script>
	var phpIdArrayLength = <?php echo end($D);?>;alert("here");
	$(document).ready(function()
	{alert("here");
	for (var i = 0; i <= phpIdArrayLength; i++)
	{
	let x=i;
	let n = x.toString();
	$("#"+n).click(function()
	{alert("here");
	window.location.href = "searchTeachers.php?id=" + x;
	});
	}
	});
</script>