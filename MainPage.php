<?php
	$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
	$IdResults = mysqli_query($con, "SELECT * FROM teachers");
	$rows=mysqli_fetch_array($IdResults);
	$fId=$rows['id'];
	$rows=mysqli_fetch_array($IdResults);
	$sId=$rows['id'];
	$rows=mysqli_fetch_array($IdResults);
	$tId=$rows['id'];
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
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	    <style >
	    	body
	    	{
	    		direction: rtl;
	    		max-width: 100%;
	    	}
	    	.moreTeachers
	    	{
	    		direction: ltr;
	    	}
	    	.Services
	    	{
	    		direction: ltr;
	    	}
	    	#bs-example-navbar-collapse-1
			{
				float: left;
				max-width: 50%;
			}
			#hakitahTitle
			{
				margin-left: 6%;
				max-width: 20%;
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
      <a class="navbar-brand" href="MainPage.php">הכיתה</a>
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
		<section class="hero">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="Welcome text-center">
							<div class="table">
								<div class="table-cell">
									<h1>הכיתה</h1>
							        <a href="#">בדוק מה חדש באתר</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="work">
			 <div class="container">
			 	<div class="row">
			 		<div class="title text-center">
						<h1>מורים חדשים באתר</h1>
						<div class="border"></div>
					</div>
						<div class="col-sm-2 col-md-2">
							<?php
				  				$results = mysqli_query($con, "SELECT * FROM images");
				  				while ($rows=mysqli_fetch_array($results)) 
				  				{
				  					if ($rows['id']==$fId) 
				  					{
				  						echo "<img src='img/".$rows['image']."'   class='img-rounded img-responsive'>";
				  					}
				  				}			  			    
							?>
		        </div>
		        <div class="col-sm-2 col-md-2">
		            <blockquote>
		            	<?php
			  				$results = mysqli_query($con, "SELECT * FROM teachers");
			  				while ($rows=mysqli_fetch_array($results)) 
				  			{
				  				if ($rows['id']==$fId) 
				  				{
				  					if ($rows["fname"]!=' '&&$rows["lname"]!=' ') 
				  					{
				  						echo "" . $rows["fname"]. "  " . $rows["lname"];
				  						echo nl2br("\n");
				  					}
				  					else if($rows["fname"]!=' '&&$rows["lname"]==' ') 
				  					{
				  						echo "" . $rows["fname"];
				  						echo nl2br("\n");
				  					}
				  					else if ($rows["fname"]==' '&&$rows["lname"]!=' ') 
				  					{
				  						echo "" . $rows["lname"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["city"]!=' ') 
				  					{
				  						echo "" . $rows["city"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["price"]!=1) 
				  					{
				  						echo "" . $rows["price"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["status"]!=' ') 
				  					{
				  						echo "" . $rows["status"];
				  						echo nl2br("\n");
				  					}
				  				}
				  			}							
			  			?>
		        </div>
		        <div class="col-sm-2 col-md-2">
							<?php
				  				$results = mysqli_query($con, "SELECT * FROM images");
				  				while ($rows=mysqli_fetch_array($results)) 
				  				{
				  					if ($rows['id']==$sId) 
				  					{
				  						echo "<img src='img/".$rows['image']."' class='img-rounded img-responsive'>";
				  					}
				  				}			  			    
							?>
		        </div>
		        <div class="col-sm-2 col-md-2">
		            <blockquote>
		            	<?php
			  				$results = mysqli_query($con, "SELECT * FROM teachers");
			  				while ($rows=mysqli_fetch_array($results)) 
				  			{
				  				if ($rows['id']==$sId) 
				  				{
				  					if ($rows["fname"]!=' '&&$rows["lname"]!=' ') 
				  					{
				  						echo "" . $rows["fname"]. "  " . $rows["lname"];
				  						echo nl2br("\n");
				  					}
				  					else if($rows["fname"]!=' '&&$rows["lname"]==' ') 
				  					{
				  						echo "" . $rows["fname"];
				  						echo nl2br("\n");
				  					}
				  					else if ($rows["fname"]==' '&&$rows["lname"]!=' ') 
				  					{
				  						echo "" . $rows["lname"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["city"]!=' ') 
				  					{
				  						echo "" . $rows["city"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["price"]!=1) 
				  					{
				  						echo "" . $rows["price"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["status"]!=' ') 
				  					{
				  						echo "" . $rows["status"];
				  						echo nl2br("\n");
				  					}
				  				}
				  			}							
			  			?>
		        </div>
		        <div class="col-sm-2 col-md-2">
							<?php
				  				$results = mysqli_query($con, "SELECT * FROM images");
				  				while ($rows=mysqli_fetch_array($results)) 
				  				{
				  					if ($rows['id']==$tId) 
				  					{
				  						echo "<img src='img/".$rows['image']."' class='img-rounded img-responsive'>";
				  					}
				  				}			  			    
							?>
		        </div>
		        <div class="col-sm-2 col-md-2">
		            <blockquote>
		            	<?php
			  				$results = mysqli_query($con, "SELECT * FROM teachers");
			  				while ($rows=mysqli_fetch_array($results)) 
				  			{
				  				if ($rows['id']==$tId) 
				  				{
				  					if ($rows["fname"]!=' '&&$rows["lname"]!=' ') 
				  					{
				  						echo "" . $rows["fname"]. "  " . $rows["lname"];
				  						echo nl2br("\n");
				  					}
				  					else if($rows["fname"]!=' '&&$rows["lname"]==' ') 
				  					{
				  						echo "" . $rows["fname"];
				  						echo nl2br("\n");
				  					}
				  					else if ($rows["fname"]==' '&&$rows["lname"]!=' ') 
				  					{
				  						echo "" . $rows["lname"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["city"]!=' ') 
				  					{
				  						echo "" . $rows["city"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["price"]!=1) 
				  					{
				  						echo "" . $rows["price"];
				  						echo nl2br("\n");
				  					}
				  					if ($rows["status"]!=' ') 
				  					{
				  						echo "" . $rows["status"];
				  						echo nl2br("\n");
				  					}
				  				}
				  			}							
			  			?>
		        </div>		
			 <div class="text-center col-md-12">
			 	<a href="moreTeachers.php" class="btn btn-info btn-lg">
		          <span class="glyphicon glyphicon-arrow-left"></span> 
		          לעוד מורים
		        </a> 
			</div>
		</section>
		<section class="Services">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-4 s_item text-center">
						<div class="s_icon">
							<i class="fa fa-language">	
							</i>
						</div>
						<h4>מורים באתר</h4>
						<p>
							באתר קיימים הרבה מורים, ותיקים וחדשים.
		מורים לכל המקצועות, יש מורים פרטיים למתמטיקה, לאנגלית, ללשון, לערבית וגם לגיטרה.
		ובכל רחבי הארץ, מורים פרטיים בירושלים, רעננה, חיפה, באר שבע
						</p>
					</div>
					<div class="col-xs-12 col-sm-4 s_item text-center">
						<div class="s_icon">
							<i class="fa fa-calculator">	
							</i>
						</div>
						<h4>מאמרים באתר</h4>
						<p>
							
		באתר קיים הרבה מאמרים הקשורים להרבה מקצועות שאתם יכולים לכנס אלהם ולהרווח מזה המון
						</p>
					</div>
					<div class="col-xs-12 col-sm-4 s_item text-center">
						<div class="s_icon">
							<i class="fa fa-music">	
							</i>
						</div>
						<h4>שימוש באתר</h4>
						<p>
							תנאי שימוש באתר
					    </p>
					</div>
				</div>
			</div>
		</section>
		<section class="about">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">
						<div class="inner-about">
							<div class="title text-center">
								<h1>קצת עלינו</h1>
								<div class="border"></div>
							</div>
								<p class="pA">					        	
		באתר הכיתה כ-2300 מורים פרטיים, מרכזי לימוד ומאמני כושר. המלמדים את כל המקצועות בכל רחבי הארץ. בין היתר תמצאו באתר הכיתה כ-1350 מורים פרטיים למתמטיקה, כ-820 מורים פרטיים לאנגלית, כ-250 מורים פרטיים ללשון, כ-300 מורים פרטיים לפיסיקה, כ-150 מורים פרטיים להוראה מתקנת וחינוך מיוחד, כ-70 מורים פרטיים לכלכלה וכ-100 מורים פרטיים לסטטיסטיקה ועוד מורים פרטיים המלמדים מקצועות רבים אחרים. כמו כן ניתן למצוא בכיתה מורים פרטיים מערים בכל רחבי הארץ ובניהן ירושלים, תל אביב, באר שבע, חיפה, נתניה, ראשון לציון, פתח תקווה, אשדוד, מודיעין ועוד
						        ...
						        </p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="about contact">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">
						<div class="inner-about">
							<div class="title text-center">
								<h1>צור איתנו קשר</h1>
								<div class="border"></div>
							</div>
							<form action="">
								<input type="text" name="" placeholder="שם" class="form-control">
								<input type="email" name="" placeholder="Email" class="form-control">
								<input type="text" name="" placeholder="סטטוס" class="form-control">
								<input type="submit" value="send" class="btn btn-success">
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<p> 
							2019 By ELI	&copy
						</p>
					</div>
				</div>
			</div>
		</footer>
		<!--
		<a id="up" href="#top">
				<img src="img/arrow.jpg" width="30px" height="40px"/>
		</a>-->
		<!--<a id="toTop" href="javascript:;" style="display: inline;">-->
<!--		<a id="toTop" href="#top" style="display: inline;">
			<span id="toTopHover">	
			</span>
			<img width="40" height="40" alt="To Top" src="img/to-top@2x.png">
		</a>-->
	</body>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>
</html>