<?php
/**
 * student profile page, showing inforamtion about student, let them read and send messages,  payment for a lesson, search  a teacher and get help on FAQ page. 
 */
    session_start();
    include 'connectionPage.php';//include this file for calling the DB
    //variables will used on HTML
    $arryOfStudentInformation=array();//this array include the student first and last name, email status and phone number, instead of calling DB each time for student information we call it once
    $ImgSource=" "; 	$ID=$_GET['id']; $username=" ";
    if(!$ID){//dont get to this page without any directiory
        header('location: Hakita.php');
    }
    else if($ID){//get to this page by login
      while ($row=mysqli_fetch_assoc($IdResults)){
        if($row['id']==$ID){//insert student information into array to get it and use on HTML view
          $username=$row['username'];
          $arryOfStudentInformation[0]=$row['fname'];
          $arryOfStudentInformation[1]=$row['lname'];
          $arryOfStudentInformation[2]=$row['status'];
          $arryOfStudentInformation[3]=$row['email'];
          $arryOfStudentInformation[4]=$row['phone'];
          break;
        }
      }
    }
	while ($ImgRow=mysqli_fetch_assoc($resultsOfImageTable)){ //get the image of student
		if($ImgRow['id']==$ID){
			$ImgSource=$ImgRow['image'];
		}
  }   
?>
<!DOCTYPE html>
<html>
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
    <link rel="stylesheet" type="text/css" href="css/profileStyle.css">
  </head>
  <body>
    <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <?php
                echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$ID\">הכיתה</a>";
                echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
                <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";
                if($ID){
                  echo "<li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"Hakita.php?id=$ID\"> עמוד הבית</a>
                    </li>"; 
                }
                echo "<li class=\"nav-item active\">";
                echo "<a class=\"nav-link\" href=\"searchTeachers.php?id=$ID\">חיפוש מורה</a>";
                echo "</li>";
                echo "<li class=\"nav-item active\">";
                echo "<a class=\"nav-link\" href=\"FAQ.php?id=$ID\">שאלות ותשובות</a>";
                echo "</li>";
            ?>       
                <li class="nav-item active">
                  <a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a>
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
						if($ImgSource!='image'){
							echo "<img src='img/".$ImgSource."' height=140  width=140 class='img-circle'>";
						}				
					?>
                </a>
                <?php
                    echo "<h3>" . $arryOfStudentInformation[0] . " ". $arryOfStudentInformation[1]."</h3>";
                    echo "<h6>".$arryOfStudentInformation[2]."</h6>";
                ?>
                <a href="EditPage.php?username=<?php echo $username; ?>" >
                    <button type="button" class="btn btn-info" id="editButton">עדכן פרופיל</button>
                </a>
                </center>
            </div>          
        </div>                                           
    </section>
    <section class="choose">
                    <div class="row">
                        <button class="tablink col-sm-6" onclick="openPage('aboutStudent', this, 'blueviolet')"> פרטים שלי</button>
                    <button class="tablink col-sm-6" onclick="openPage('messageSlide', this, 'orange')">  הודעות </button>
                </div>                
					<!--message-->
					<div id="messageSlide" class="tabcontent">
                        <h1>עמוד ההודעות  </h1>
					</div>
                    <div id="aboutStudent" class="tabcontent">   
                        <?php
                              echo "<div class=\"row\">";
                              echo "<div class=\"col-sm-6\">";
                              echo "<h4>" . $arryOfStudentInformation[0] . " ". $arryOfStudentInformation[1]."</h4>";echo"<hr>";  
                              echo "<h4>"."מספר טלפון:".$arryOfStudentInformation[4]."</h4>";echo"<hr>";
                              echo "<h4>" . $arryOfStudentInformation[3] . "</h4>";echo"<hr>";
                              echo "<h4>".$arryOfStudentInformation[2]."</h4>";
                              echo "</div>";                                    
                              echo "</div>";
                        ?>
                    </div>
                </section>
                <div class="ButtomSection">      
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