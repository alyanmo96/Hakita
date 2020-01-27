<?php

/**can enter to this page with the last user without need to login
 * 
 * 
 * 
 * 
 * 
 */
	session_start();
    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    
	// because you can reach to this page from more than one page, so we need to know from\
	//where we get to it for(edit page, first time on this page, etc...)
    /*echo $_GET['id'];
    echo $_POST['id'];
    $logIn=$_POST['usernameLogin']; 
	echo $logIn;
    $logInG=$_GET['usernameLogin']; 
    echo $logInG;*/
	//$signUp=$_POST['username'];
	//$edit=$_GET['username']; 	$eedit=$_SESSION['varname'];	
	// conect with tables to get information about the user to show it and use
	$results = mysqli_query($con, "SELECT * FROM teachers");	
	$ImgResult = mysqli_query($con, "SELECT * FROM images");
	//variables will used on HTML
	//(username,status,email,first name, last name, phone number, cities, courses,img,price)
	$us=" ";	$sta=" ";	$email=" "; 	$fN=" ";	$lN=" "; 	$Phone=" "; 
    $Cities= " "; 	$Courses=" ";   	$ImgSource=" "; 	$ID=$_GET['id']; 	$pri;
    
    if ($ID)//get to this page by login
	{
		while ($row=mysqli_fetch_assoc($results)) 
		{
			if($row['id']==$ID)//get variables to use on HTML view
			{
				$ID=$row['id'];
				$us=$row['username'];
				$fN=$row['fname'];
				$lN=$row['lname'];
				$sta=$row['status'];
				$email=$row['email'];
				$Phone=$row['phone'];
			}
		}
	}
	else if (($edit!=null)||($eedit!=null)) //back to profile page from edit page
	{//echo "((edit!=null)||(eedit!=null))";
		$ID;
		if($edit!=null)
		{
			$us=$edit; 
		}
		else if ($eedit!=null)
		{
			$us=$eedit;
		}
		while ($row=mysqli_fetch_assoc($results)) 
		{
			if ($row['username']==$us) //get variables to use on HTML view
			{
				$ID=$row['id'];
				$fN=$row['fname'];
				$lN=$row['lname'];
				$email=$row['email'];
				$sta=$row['status'];
				$Phone=$row['phone'];
			}
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
        .commentsImages
        {
            float:right;
            max-height: 80px;
            margin-top: 40%;
        }
        .textOfComment
        {
            font-size: 20px;
            margin-top: -3%;
            margin-right: 1%;
            float: right;
        }
        p {
            margin-top: 1%;
            font-size: 25px;
            font-weight: 700;
        }
        .commentCard
        {
            background:url('./img/7.jpg');
            margin-right: 5%;
            border-radius: 300px;
        }
        .board
        {
            max-width: 100%;
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
                    <a class="nav-link" href="Hakita.php">עמוד הבית <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <!--<a class="nav-link" href="searchTeachers.php" onclick="otherPagesWithId()"> חיפוש מורה</a>-->
                    <a class="nav-link"  onclick="otherPagesWithId()"> חיפוש מורה</a>               
                   <!--<a class="nav-link" href="searchTeachers.php?id=" id="a">חיפוש מורה</a>-->
                  </li>
                  <li class="nav-item active">
                    <!--<a class="nav-link" href="FAQ.php"onclick="otherPagesWithId()">שאלות ותשובות</a>-->
                    <a class="nav-link" onclick="FAQPagesWithId()">שאלות ותשובות</a>
                   
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
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
                   <?php
						$results = mysqli_query($con, "SELECT * FROM images");
                        $rows=mysqli_fetch_array($results);
						if($ImgSource!='image')
						{
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
                    if($sta!=" ")
                    {
                        echo "<h6>".$sta."</h6>";
                    }
                    $forEdit=" ";
                    if ($edit!=null) 
                    {
                        $forEdit=$edit;
                    }
                    else if($eedit!=null)
                    {
                        $forEdit=$eedit;
                    }
                    else if ($us!=null) 
                    {
                        $forEdit=$us;
                    }
                ?>
                    <a href="edit.php?username=<?php echo $forEdit; ?>" >
                        <button type="button" class="btn btn-info" id="editButton">עדכן פרופיל</button>
                    </a>
                </center>
            </div>          
        </div>                                           
    </section>
    <section class="choose">
                    <div class="row">
                        <button class="tablink col-sm-6" onclick="openPage('aboutTeacher', this, 'blueviolet')"> פרטים שלי</button>
                    <button class="tablink col-sm-6" onclick="openPage('message', this, 'orange')">  הודעות </button>
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
                                    echo "</div>";
                              ?>
                    </div>
					<!--message-->
					<div id="message" class="tabcontent">
                        <h1>עמוד ההודעות  </h1>
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
    function otherPagesWithId()
    {
        location.href = "searchTeachers.php?id=" + <?php echo $ID?>;
    }
    function FAQPagesWithId()
    {
        location.href = "FAQ.php?id=" + <?php echo $ID?>;
    }
</script>