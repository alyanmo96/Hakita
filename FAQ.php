<?php
	/*
		1-the design
		2- on the bottom of the page get email from user
	*/
?>
<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>הכיתה</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>  
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


        <link rel="stylesheet" type="text/css" href="css/styleFAQ.css">
        <style>
            .navbar-brand 
            {
                font-size:35px;
            }
            .navbar-brand:hover
            {
                font-size:40px;
            }
            .nav-link
            {
                font-size:23px;
            }    
            .nav-link:hover
            {
                font-size:30px;
            }
        
        </style>
	</head>
	<body>
        <a id="button"></a>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand active" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="Hakita.php">עמוד הבית <span class="sr-only">(current)</span></a>
                  </li>
                  <?php
                    if(!$_GET['id']&&!$_POST['id'])
                    {
                      echo "<li class=\"nav-item active\">
                        <a class=\"nav-link\" href=\"loginSignUP.php\">כניסה/הרשמה </a>
                        </li>"; 
                    }
                   ?> 
                  <li class="nav-item active">
                    <a class="nav-link" onclick="otherPagesWithId()">חיפוש מורה</a>
                  </li>
				  <?php
                    if($_GET['id']||$_POST['id'])
                    {
                      echo "<li class=\"nav-item active\">
                        <a class=\"nav-link\" href=\"Hakita.php\"> יציאה</a>
						</li>"; 
						if($_GET['id'])
						{
							$ID=$_GET['id'];
						}
						else
						{
							$ID=$_POST['id'];
						}
                    }
                   ?> 
              </ul>
            </div>
          </nav>
		  <section class="feedbackSection">			
			<a class="nav-link" href="feedback.php"><button>פידבאק feedback</button></a>
		  </section>
			<section class="about">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-10 col-sm-offset-1">
							<div class="inner-about">
								<div class="title text-center">
									<h1 class="letters">קצת עלינו</h1 class="letters">
									<div class="border"></div>
								</div>
									<p  id="theBigParagraph" class="letters">					        	
			באתר הכיתה כ-3300 מורים פרטיים, מרכזי לימוד ומאמני כושר. המלמדים את כל המקצועות בכל רחבי הארץ. בין היתר תמצאו באתר הכיתה כ-1350 מורים פרטיים למתמטיקה, כ-820 מורים פרטיים לאנגלית, כ-250 מורים פרטיים ללשון, כ-300 מורים פרטיים לפיסיקה, כ-150 מורים פרטיים להוראה מתקנת וחינוך מיוחד, כ-70 מורים פרטיים לכלכלה וכ-100 מורים פרטיים לסטטיסטיקה ועוד מורים פרטיים המלמדים מקצועות רבים אחרים. כמו כן ניתן למצוא בכיתה מורים פרטיים מערים בכל רחבי הארץ ובניהן ירושלים, תל אביב, באר שבע, חיפה, נתניה, ראשון לציון, פתח תקווה, אשדוד, מודיעין ועוד
									...
									</p>
							</div>
						</div>
					</div>
				</div>
            </section>
            <br>
             <br>
			<section class="Services">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 s_item text-center">
							<div class="s_icon">
								<i class="letters fa fa-language">	
								</i>
							</div>
							<h4 class="letters">מורים באתר</h4 class="letters">
							<p class="letters">
								באתר קיימים הרבה מורים, ותיקים וחדשים.
			מורים לכל המקצועות, יש מורים פרטיים למתמטיקה, לאנגלית, ללשון, לערבית וגם לגיטרה.
			ובכל רחבי הארץ, מורים פרטיים בירושלים, רעננה, חיפה, באר שבע
							</p>
						</div>
						<div class="col-sm-4 s_item text-center">
							<div class="s_icon">
								<i class="letters fa fa-calculator">	
								</i>
							</div>
							<h4 class="letters">מאמרים באתר</h4>
							<p class="letters">
								
			באתר קיים הרבה מאמרים הקשורים להרבה מקצועות שאתם יכולים לכנס אלהם ולהרווח מזה המון
							</p>
						</div>
						<div class="col-sm-4 s_item text-center">
							<div class="s_icon">
								<i class="letters fa fa-music">	
								</i>
							</div>
							<h4 class="letters">שימוש באתר</h4 class="letters">
							<p class="letters">
								תנאי שימוש באתר
							</p class="letters">
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
									<h1 id="talkWithUsTitle" class="letters">צור איתנו קשר</h1>
									<div class="border"></div>
                                </div>
                                <a  id="call" class="letters"href="tel:+97254-775-1900">הצגת מספר/להתקשר</a>
                                <br>
                                <br>
                                <h1 class="letters">השאר הודעה כדי לצור איתך קשר</h1>
								<form action="">
									<input type="text" name="" placeholder="שם" class="form-control">
                                    <input type="email" name="" placeholder="מייל לצור קשר" class="form-control">
									<input type="text" name="" placeholder="תוכן ההודעה" class="form-control">
									<input type="submit" value="send" class="btn btn-success text-center">
								</form>
							</div>
						</div>
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
    function otherPagesWithId()
    {
        location.href = "searchTeachers.php?id=" + <?php echo $ID?>;
    }
    function FAQPagesWithId()
    {
        location.href = "FAQ.php?id=" + <?php echo $ID?>;
    }
</script>