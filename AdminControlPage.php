<?php
/**
 * 
 * 1-need to make change with desgin
 * 
 * 2-let admin to check teacher and student by different  search
 * 
 */
	session_start();
	$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
	$IdResults = mysqli_query($con, "SELECT * FROM teachers");
	$i=0;
	$IdArray = array();
	while ($rows=mysqli_fetch_array($IdResults))
	{
		if($rows['id']!=211)//not the admin.... also need to check that isnot a student
		{
			$IdArray[$i]=$rows['id'];
			$i++;
		}
	}
	$i-=1;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>הכיתה</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

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
        	.teacher{
				padding:1%;
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
      <a class="navbar-brand" href="MainPage.php">הכיתה</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav navbar-right">
        <li><a class="navbar-brand" href="MainPage.php">יציאה </a></li>
      </ul>
    </div>
  </div>
</nav>
	<hr>
	<div class="col-sm-4">
		<button type="button" class="btn btn-primary" onclick="makeChangeOnAdminInformation()">שינוי בפרטי המנהל</button>
	</div>
	<div class="col-sm-4">
		<button type="button" class="btn btn-primary" onclick="makeChange()">בדוק מי עשה שינו</button>
	</div>
	<div class="col-sm-4">
		<button type="button" class="btn btn-primary" onclick="newUser()">משתמשים חדשים באתר</button>
	</div>
	<div class="col-sm-6">
	</div>
	<h1 class="col-sm-6">חפש לפי שם או בחר מהרשימה למטה</h1>
	<div class="col-sm-6">
	</div>
	<div class="col-sm-6">
		<?php
		
		echo "<SELECT  name=\"searchByName\" id=\"searchByName\" class=\"form-control selectpicker\" data-live-search=\"true\">";
		$results = mysqli_query($con, "SELECT * FROM teachers");
		echo'<option >'.'בחר שם'.'</option>';
		while ($rows=mysqli_fetch_array($results))
		{
			if($rows['id']!=211)
			{
				echo'<option value="'.$rows['id'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
			}			
		}
		echo"</SELECT>";
		echo"<input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\" />";
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
				if($j%2==0)
				{
					echo '<div class="teacher col-sm-12">';
					echo "<hr><hr>";
					echo "</div>";
				}
			$results = mysqli_query($con, "SELECT * FROM images");
			while ($rows=mysqli_fetch_array($results))
			{
				if ($rows['id']==$IdArray[$j])
				{
					$D[$DCounter]=$IdArray[$j];
					$DCounter++;
					$d=$IdArray[$j];
					echo '<div class="teacher col-sm-5" id="$d">';
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
				if ($rows["city"]!=' '&&$rows["city"]!='cities')
				{
					$result = mysqli_query($con, "SELECT * FROM teacher_cities");
					$MoreThanOneCity=0;
					$city=" ";
					while ($rows=mysqli_fetch_assoc($result))
					{
						if ($rows['id']==$IdArray[$j])
						{
							if ($MoreThanOneCity>=1)
							{
								$city.=' , ';
							}
							$city.=$rows['cities'];
							$MoreThanOneCity++;
						}
					}
					echo "" . $city."<br />";
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
					if ($rows["subject"]!="subject")
					{
						$CourseResult = mysqli_query($con, "SELECT * FROM teachers_courses");
						$MoreThanOneCourse=0;
						$courses=" ";
						while ($CourseRows=mysqli_fetch_assoc($CourseResult))
						{
							if ($CourseRows['id']==$IdArray[$j])
							{
								if ($MoreThanOneCourse>=1)
								{
									$courses.=' , ';
								}
								$courses.=$CourseRows['subject'];
								$MoreThanOneCourse++;
							}
						}
						echo "מלמד:-";
						echo "" . $courses."<br />";
					}
				}
				}
			echo "</button>";
			echo '</div>';
			echo "<br><br>";
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
$(document).ready(function()
{
	$("#searchByName").on('change',function(){
	var id =$(this).val();
	if (id)
	{
	window.location.href = "AdminControlPageEditOnUser.php?id=" + id;
	}
	});
	});
</script>
<script>
	$(document).ready(function(){
	 $('.selectpicker').selectpicker();

	 $('#searchByName').change(function(){
	  $('#hidden_framework').val($('#searchByName').val());
	 });

	 $('#multiple_select_form').on('Save', function(event){
	  event.preventDefault();
	  if($('#searchByName').val() != '')
	  {
	   var form_data = $(this).serialize();
	   var id =$(this).val();
	   $.ajax({
	    url:"AdminControlPageEditOnUser.php",
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
	   return false;
	  }
	 });
	});
</script>
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
<script>
	function makeChange()
	{
		window.location.href = "adminCheckUsersChange.php";
	}
	function newUser()
	{
		window.location.href = "adminCheckNewUsers.php";
	}
	function makeChangeOnAdminInformation()
	{
		x=211;
		window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
	}
</script>