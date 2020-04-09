<?php
  /*
		FAQ page  {feedbak/about site/ contact admin}
  */
  session_start();

  
//    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    $feedbackCommentResult = mysqli_query($con, "SELECT * FROM feedback");
    $feedbackLastResult = mysqli_query($con, "SELECT * FROM feedback");
    $lastFeedback=" ";
    while ($commentRow=mysqli_fetch_assoc($feedbackLastResult))
    {
        $lastFeedback=$commentRow['textOfFeedback'];
    }
    if (isset($_POST["comments"])) {    
        if($_POST["comments"]!=$lastFeedback)
        {
            $getComment=$_POST["comments"];
            $rating=-1;
            if($_POST["teacherValue"]=="oneValue")
            {
                $rating=1;
            }
            else if($_POST["teacherValue"]=="twoValue")
            {
                $rating=2;
            }
            else if($_POST["teacherValue"]=="threeValue")
            {
                $rating=3;
            }
            else if($_POST["teacherValue"]=="fourValue")
            {
                $rating=4;
            }
            else if($_POST["teacherValue"]=="fiveValue")
            {
                $rating=5;
            }
            $_POST["teacherValue"]=null; 
            
            $ID=$_POST['id'];   
                
            $commentWriterId=267;
            $todayDate=date('Y-m-d');
            $query="INSERT INTO `feedback`(`dateOfFeedback`,`textOfFeedback`,`rating`) 
            VALUES
                ('$todayDate','$getComment','$rating')";
                $result = mysqli_query($con,$query);
        }      
    }


    /*
	*  $ID=$_SESSION['id']
	*   $_SESSION['id']=$ID;




	*/
  $ID = ($_GET['id']) ? $_GET['id'] : $_POST['id'];
  if(isset($_POST['feedback'])){//
    $feedback=1;
  }
  elseif(isset($_POST['siteUse'])){//siteUse
    $usingSite=1;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>הכיתה</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
.navbar-nav .nav-link {
    padding-right: 0;
    padding-left: 40%;
}
  body, html {
    height: 100%;
    margin: 0;
    font: 400 15px/1.8 "Lato", sans-serif;
    color: #777;
    direction: rtl;
  }

  .bgimg-1, .bgimg-2, .bgimg-3 {
    position: relative;
    opacity: 0.65;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;

  }
  .bgimg-1 {
    background-image: url("./img/FAQ1.jpg");
    min-height: 100%;
  }

  .bgimg-2 {
    background-image: url("./img/FAQ2.jpg");
    min-height: 400px;
  }

  .bgimg-3 {
    background-image: url("./img/FAQ3.jpg");
    min-height: 400px;
  }

  .caption {
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    text-align: center;
    color: #000;
  }

  .caption span.border {
    background-color: #111;
    color: #fff;
    padding: 18px;
    font-size: 25px;
    letter-spacing: 10px;
  }

  h3 {
    letter-spacing: 5px;
    text-transform: uppercase;
    font: 20px "Lato", sans-serif;
    color: #111;
  }

  /* Turn off parallax scrolling for tablets and phones */
  @media only screen and (max-device-width: 1024px) {
    .bgimg-1, .bgimg-2, .bgimg-3 {
      background-attachment: scroll;
    }
  }
  .fa {
  padding: 20px;
  font-size: 30px;
  width: 30px;
  text-align: center;
  text-decoration: none;
  margin: 5px 2px;
  border-radius: 50%;
}

.fa:hover {
    opacity: 0.7;
}

.fa-facebook {
  background: #3B5998;
  color: white;
}
#jceImg{
  max-width: 75px;
  max-height: 50px;
}
    .fa {
width: 13px;
text-align: center;
text-decoration: none;
border-radius: 50%;
}
.footer
{
	max-height: 80px;
    padding: 0%;
    background-color: black;
    margin-top: -50px;
    direction: rtl;
}
w3-teal, .w3-hover-teal:hover {
    background-color:black;
}
.w3-container, .w3-panel {
    background-color: black;
    color: white;
}
.ImageSection{
    background-color:gray;
    margin-left: auto;
    margin-right: auto;
    max-width: 50%;
}
@media only screen and (min-device-width: 1000px) {
  .col-sm-4 {
    float:left;
    padding-right: 64px;
    }
  }
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.containe {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
.commentCard
        {
            background:url('../img/2.jpg');
            margin-right: 5%;
            border-radius: 300px;
        }
        .checked {
            color: orange;
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
            @media (min-width: 600px) {
              .content {
                  width: 43%;
              }
              #button {
                  margin: 30px;
              }
            } 
            .card{
              margin-right: auto;
              margin-left: auto;
            }
            .usingSite{
              background-image: url("./img/FAQ1.jpg");
              min-height: 500px;
              background-attachment: fixed;
              background-position: center;
              background-repeat: no-repeat;
              background-size: cover;
            }
            #btn{
              line-height: 2.5;
            }
            #bttn{
              line-height: 2.5;
            }
            #btttn{
              line-height: 2.5;
            }
            #bttttn{
              line-height: 2.5;
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
            <?php
            if($ID){
              $isStudent=-1; 
              $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
              $IdResults = mysqli_query($con, "SELECT * FROM teachers");
              while ($rows=mysqli_fetch_array($IdResults)){
                if ($rows['id']==$ID && $rows['setUserAs']=='student'){
                    $isStudent=1;
                    break;
                }
              }
               //navbar include the main page of the site FAQ page, EXIT, redirect page include the login id
               echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$ID\">הכיתה</a>";
               echo '<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                   <ul class="navbar-nav mr-auto mt-2 mt-lg-0">';
                       echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php?id=$ID\"> עמוד הבית</a></li>";
                       if($isStudent==1){
                         echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php?id=$ID\">פרופיל שלי <span class=\"sr-only\">(current)</span></a> </li> ";
                       }else{// if the login user was a teacher, then he want to access to his profile
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php?id=$ID\">פרופיל שלי <span class=\"sr-only\">(current)</span></a> </li> ";
                       }
                       echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"searchTeachers.php?id=$ID\">חיפוש מורה</a></li>";
             echo'<li class="nav-item active">
             <a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a><!--exit-->
           </li>';


/*



echo "<a class=\"navbar-brand\" href=\"Hakita.php\">הכיתה</a>";
               echo '<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                   <ul class="navbar-nav mr-auto mt-2 mt-lg-0">';
                       echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"Hakita.php\"> עמוד הבית</a></li>";
                       if($isStudent==1){
                         echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php\">פרופיל שלי <span class=\"sr-only\">(current)</span></a> </li> ";
                       }else{// if the login user was a teacher, then he want to access to his profile
                        echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php">פרופיל שלי <span class=\"sr-only\">(current)</span></a> </li> ";
                       }
                       echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"searchTeachers.php">חיפוש מורה</a></li>";
             echo'<li class="nav-item active">
             <a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a><!--exit-->
           </li>';




*/

            }else{
               //navbar include the main page of the site FAQ page, EXIT, redirect page include the login id
               echo '<a class="navbar-brand" href="Hakita.php">הכיתה</a>
               <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                   <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                      <li class="nav-item active"><a class="nav-link" href="Hakita.php"> עמוד הבית</a></li>  
                      <li class="nav-item active"><a class="nav-link" href="loginSignUP.php">כניסה/הרשמה</a></li>
                       <li class="nav-item active"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>';
            }
              ?>               
              </ul>
            </div>
          </nav>
    </section>
    <?php
   if($feedback==1){

    echo "
    <section class=\"feedbackSection\">		
        <h1> כל תגובה עוזרת לנו לשפר את האתר, להרגיש חופשי. נא לצרף Email</h1>	
        <button  class=\"addCommentButton btn btn-warning\" alt=\"work 1\" data-toggle=\"modal\" data-target=\"#myModalc\" title=\"כפתור הוספת תגובה על המורה\"> <h5>הוספת תגובה חדשה</h5></button>
                      
        <div id=\"comments\" class=\"tabcontent\">
                  <li>
                      <div class=\"modal fade\" id=\"myModalc\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabelv\">
                          <div class=\"modal-dialog\" role=\"document\">
                              <div class=\"modal-content\">
                              <div class=\"modal-header\">
                                  <h4 class=\"modal-title\" id=\"myModalLabelv\">הוספת תגובה</h4>
                              </div>
                              <form  name=\"feedbackForm\" action=\"FAQ.php\" method=\"post\">
                                   <input name=\"id\" type=\"hidden\" value=\"$ID\" id=\"$ID\"> 
                                      <div class=\"modal-body\">
                                          <div class=\"pleaseAddFeedback\">
                                              אנא ספק/י את המשוב שלך להלן:
                                          </div>
                                          <hr>
                                          <div class=\"feedbackValueTitle\">
                                          איך את/ה מדרג/ת את החוויה הכוללת שלך באתר ?
                                              <div>
                                                  לא טוב-
                                                  <input type=\"radio\" name=\"teacherValue\" id=\"oneValue\" value=\"oneValue\"  required>1
                                                  <input type=\"radio\" name=\"teacherValue\" id=\"twoValue\" value=\"twoValue\"  required>2
                                                  <input type=\"radio\" name=\"teacherValue\" id=\"threeValue\"value=\"threeValue\"  required>3
                                                  <input type=\"radio\" name=\"teacherValue\" id=\"fourValue\" value=\"fourValue\" required>4
                                                  <input type=\"radio\" name=\"teacherValue\" id=\"fiveValue\" value=\"fiveValue\" required>5
                                                  -מצויין
                                              </div>
                                          </div>
                                          <hr>
                                          <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                          <textarea class=\"form-control\" type=\"textarea\" name=\"comments\" id=\"comments\" placeholder=\"הערות/תגובות שלך\" maxlength=\"6000\" rows=\"7\" required></textarea>
                                          <hr>
                                          <fieldset> 
                                          <div class=\"text-center\">
                                                  <input type=\"submit\" class=\"logSignButton btn btn-info btn-primary text-center\" title=\"שמירת פיידבאק וחזרה\" value=\"הוספה כ-תגובה חדשה\">
                                          </div>
                                          </fieldset>
                                  </form>
                              <br>
                                  <button type=\"submit\" class=\"btn btn-info\" data-dismiss=\"modal\">יציאה ללא הוספת </button>
                              </div>
                              </div>
                          </div>
                          </div>
                  </li>";                   
                          $feedbackCommentResult = mysqli_query($con, "SELECT * FROM feedback");
                          while ($commentRow=mysqli_fetch_assoc($feedbackCommentResult)) //get comments if there any comments
                          {  
                            $getRatingOfEachComment=$commentRow['rating'];
                            $dateOfComment=$commentRow['dateOfFeedback']; 
                            echo'<div class="card mb-3" style="max-width: 740px; direction: rtl;"> ';                       
                          echo'<div class="row no-gutters">';
                        
                        echo'<div class="col-md-8">';
                            echo'<div class="card-body">';
                            $textOfComment=$commentRow['textOfFeedback'];
                            echo"<p class=\"card-text\">".$textOfComment."</p>";  
                        for($star=0;$star<$getRatingOfEachComment;$star++){//the orange star's
                            echo ' <span class="fa fa-star checked"></span>';
                        }
                        $emptyStars=5-$getRatingOfEachComment;$e=0;
                        while($e<$emptyStars){//the empty star's
                            $e++;echo '<span class="fa fa-star"></span>';
                        }echo"&nbsp;&nbsp;&nbsp;".$dateOfComment."</h5>";                                              
                        echo "</div></div></div></div>"; 

                          }
                      echo"
                      <br><br>
                  </div>
                  <br><br>
    </section>";
   }
   elseif($usingSite==1){
    echo '<div class="usingSite">';
    
    echo'<div class="card mb-3" style="max-width: 740px; direction: rtl;"> ';                       
      echo'<div class="row no-gutters">';
        echo'<div class="card-body">';
        echo'<h3 align="right">עבור כל בעיה, תקלה במערכת יש לפנות בהודעה לאדמין האתר.</h3>';
        echo "</div></div>
      </div>";  


    echo'<div class="card mb-3" style="max-width: 740px; direction: rtl;"> ';                       
      echo'<div class="row no-gutters">';
        echo'<div class="card-body">';
        echo'<h3 align="right"><i class="fa fa-question-circle"></i> איך ליצור חשבון באתר, ואיזה סוג חשבון אני צריך ליצור</h3><hr><br>
        <h3 align="right">למעלה בכל העמודים , במצב של לא מחובר יש את האופציה של {כניסה/הרשמה}. בלחיצה תעבור/י לעמוד אחר שם יש לצור שם משתמש וסיסמה חדשים. לגבי סוג החשבון:- אם המטרה היא ללמד וללמוד אז יש לצור חשבון של מורה במידה ורק ללמוד אז יש לצור חשבון של סטודנט, חשוב לדעת שאפשר לעבור מחשבון של סטודנט לחשבון של מורה אחרי יצירת החשבון זה יהיה בעמוד של עדכון הנתונים.</h3>';
        echo "</div></div>
      </div>";    


      echo'<div class="card mb-3" style="max-width: 740px; direction: rtl;"> ';                       
      echo'<div class="row no-gutters">';
        echo'<div class="card-body">';
        echo'<h3 align="right"><i class="fa fa-question-circle"></i> איך לקבוע שיעור בתור סטודנט</h3><hr><br>
        <h3 align="right">אחרי שנכנסים לפרופיל של המורה, במידה ומופיע יומן שיעורים תהיה אפשרות ללחוץ לפי הזמן המתאים אחרת אם לא יש צורך לשלוח הודעה למורה.</h3>';
        echo "</div></div>
      </div>";  


      echo'<div class="card mb-3" style="max-width: 740px; direction: rtl;"> ';                       
      echo'<div class="row no-gutters">';
        echo'<div class="card-body">';
        echo'<h3 align="right"><i class="fa fa-question-circle"></i>איך משחזרים סיסמה</h3><hr><br>
        <h3 align="right">בעמוד של הכניסה מעל כפתור הכניסה רשום " שכחתי סיסמה", בלחיצה עוברים לעמוד אחר, שם יש למלא את המייל או שם משתמש ואז ללחוץ את הכפתור שלחיה. ואז מקבלים קישור כהודעה במייל. לחיצה על הקישור תעביר אותך לעמוד של כתיבה סיסמה חדשה.</h3>';
        echo "</div></div>
      </div>";  
      
      echo'<div class="card mb-3" style="max-width: 740px; direction: rtl;"> ';                       
      echo'<div class="row no-gutters">';
        echo'<div class="card-body">';
        echo'<h3 align="right"><i class="fa fa-question-circle"></i> מה זה הכפתור שנמצא בעמוד של יומן שיעורים בפרופיל של המחרה</h3><hr><br>
        <h3 align="right">כשהכפתור יהיה אפור אז יומן השיעורים שלך לא יופיע אצל אחרים, במידה והיה כחול אז זה כן יופיע.</h3>';
        echo "</div></div>
      </div>"; 

      echo'<div class="card mb-3" style="max-width: 740px; direction: rtl;"> ';                       
      echo'<div class="row no-gutters">';
        echo'<div class="card-body">';
        echo'<h3 align="right"><i class="fa fa-question-circle"></i> הפרופיל שלי לא מופיע בחיפוש</h3><hr>
        <h3 align="right">ככל שהמורה מחובר לאתר לא ימצא את עצמו כמורה אחר.</h3>';
        echo "</div></div>
      </div>";  

      echo " </div>"; 
   }else{

    echo"<div class=\"bgimg-1\">
      <div class=\"caption\">
        <span class=\"border\">הכיתה - אינדקס המורים הפרטיים הגדול של ישראל</span>
      </div>
    </div><br><br>
    <div style=\"color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;\">
    <div class=\"container\">
					<div class=\"row\">
      <div class=\"col-sm-12\">
        <div class=\"col-sm-4\">
          <a type=\"button\" class=\"btn btn-light\" href=\"#containe\">הודעה ל-אדמין</a>
          </div>
          <div class=\"col-sm-4\">
            <form action=\"FAQ.php\" method=\"POST\">
             ";
                if($ID){
                  echo"<input type=\"hidden\" name=\"id\" value=\"$ID\">";
                  echo"<button type=\"submit\" name=\"siteUse\" class=\"btn btn-light\" id=\"bttttn\">שאלות של שימוש באתר</button>
                  </div>
                  <div class=\"col-sm-4\">
                  <button type=\"submit\" name=\"feedback\" class=\"btn btn-light\" id=\"btttn\">פיידבאק</button><br><br>";
                }else{
                  echo'<button type="submit" name="siteUse" class="btn btn-light" id="bttn">שאלות של שימוש באתר</button>
                  </div>
                  <div class="col-sm-4">
                  <button type="submit"  name="feedback" class="btn btn-light"  id="btn">פיידבאק</button><br><br>';
                }
              echo"
          </form>
        </div>
    </div>
  </div>
  </div>
      <h3 style=\"text-align:center;\">מה זה בכלל אתר הכיתה? מה חדש בו?</h3>
      <p>אתר הכיתה מהווה זירת מפגש בין מורים פרטיים לתלמידים, בו המורה יכול לקבוע מתי, כמה ואיך לפרסם את עצמו.
      האתר בנוי כך, שכמה שיותר מורים ייחשפו ברגע נתון, ומאחוריו אלגוריתמיקה המאפשרת מגוון אמצעי חשיפה ופרסום, שנועדו לתת כלים מגוונים וחדשניים לחשיפה אופטימלית וחכמה באתר.
      בכללי, הרעיון הוא שמורה יפרסם את עצמו בדיוק במינון, בתזמון ובאופן שירצה לפרסם את עצמו, וכמוהו כל שאר המורים באתר.
      כמובן שתלמידים יכולים לסווג את המורים לפי מקצועות, תתי מקצועות, אזורים בארץ, מוסדות לימוד ועוד, וכך להגיע אל המורים באופן ממוקד יותר.
      האתר תומך גם במאמני כושר ומרכזי לימוד, לפי אותם עקרונות בדיוק.
      האתר פתוח לשימושכם והנאתכם, וכל האפשרויות בו, הן חינמיות לגמרי.

      עם זאת, קיימת אפשרות לרכישת רישיון לכרטיס מקודם- היינו כרטיס שתינתן לו האפשרות לזכות בחשיפה גבוהה יותר, באמצעות תעדופו על פני כרטיסים שאינם משלמים, מה שיתבטא בחשיפה גבוהה יותר בכל מיני דרכים באתר, על פני כרטיסים אשר לא מקודמים.

      הרישיון לכרטיס מקודם הינו לתקופה מסוימת- חודש, שלושה חודשים, שישה חודשים ושנה, ומחירי הקידום הינם שוברי שוק, נכון להיום, ושווים לכל נפש.</p>
      <div>
        <span class=\"border\" style=\"background-color:transparent;font-size:25px;color: gray;\">כיצד מתבצעות ההקפצות באתר?</span>
          <p>מטרת האתר היא לתת זמן מקסימלי של חשיפה איכותית לכל מורה ומורה, ואת זה אנו מנסים לעשות באמצעות שלושה מנגנוני הקפצה שונים ובלתי תלויים זה בזה;

      הקפצה עצמאית-     בהקפצה זו נכנס המורה עצמאית לאתר ומקפיץ את הפרופיל שלו בעצמו, ע\"י כפתור ההקפצה המיוחד.

      הקפצה מתוזמנת-   בהקפצה זו המורה קובע מועד הקפצה מראש ליממה הבאה; ניתן לקבוע עד שלושה מועדים.

      הקפצה אוטומטית-  בהקפצה זו המורה מוקפץ אוטומטית בשעות מסוימות, ולפי התוויות מסוימות.</p>
      </div>
    </div>
    <div class=\"bgimg-2\">
      <div class=\"caption\">
        <span class=\"border\" style=\"background-color:transparent;font-size:25px;color: #f7f7f7;\"></span>
      </div>
    </div>
    <div style=\"position:relative;\">
      <div style=\"color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;\">
        <p>האם תלמידים חייבים להירשם לאתר?
      לא. תלמידים יכולים לחפש ולפנות למורים חופשי ומבלי להירשם או להזדהות באתר.</p><hr>
      <p>האם מורים חייבים להירשם לאתר?
      כן. הרישום קצר וממוקד, וברישום מתבקש מורה לספר על עצמו, על ניסיונו, על התחומים הרלבנטיים בהם הוא יכול לסייע ועוד.</p><hr>
      <p>אילו מאמרים/חיבורים אפשר להעלות?
      לאתר ניתן להעלות קבצי PDF וכן ניתן לכתוב מאמרים ישירות במעבד התמלילים של האתר.
      חשוב לציין- שהתכנים המועלים לאתר הינם באחריות המפרסמים בלבד, ואין הנהלת האתר אחראית על תכנים אלו מכל היבט שהוא, לרבות
      (א) נכונות התכנים
      (ב) מקוריות התכנים
      (ג) פוגעניות התכנים, במידה ויש כזו.</p>
      </div>
    </div>
    <div class=\"bgimg-3\">
      <div class=\"caption\">
        <span class=\"border\" style=\"background-color:transparent;font-size:25px;color: black;\">ללמוד תוך אווירה נעימה</span>
      </div>
    </div>
    <div style=\"position:relative;\">
      <div style=\"color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;\">
        <p>האתר קשור לאקדמיה? לבתי ספר?
        האתר נותן מענה גם למקצועות הנלמדים בבתי הספר, מן היסודי ועד התיכון, וגם למקצועות הנלמדים באקדמיה.
        כמו כן ניתן למצוא באתר מאמנים בתחומי כושר שונים, וכן מרכזי לימוד בתחומים שונים.</p><hr>
        <p>זה עולה כסף?
        פתיחת כרטיס, אחזקתו ותפעולו השוטף- לא עולה כסף כלל.
        שימוש בכל הכלים שניתנים באתר- בחינם לגמרי.
        קידום כרטיס על פני כרטיסים אחרים- בעלות חודשית של עשרות בודדות של שקלים (בין פחות מ-30 לפחות מ-15), כאשר ככל שתקופת המנוי ארוכה יותר- העלות החודשית הולכת ופוחתת.
        הנהלת האתר שומרת את זכותה לעדכן מחירים ו/או חבילות מפעם לפעם.
        </p>
      </div>
    </div>
    <div class=\"bgimg-1\">
      <div class=\"caption\">
        <div class=\"containe\" id=\"containe\" name=\"containe\">
        <div class=\"row\">
        <div class=\"col-sm-12\">
          <form action=\"FAQ.php\" method=\"POST\">
            <label for=\"name\"></label>
            <input type=\"text\" id=\"name\" name=\"name\" placeholder=\"שם שלך\">
            <label for=\"email\"></label>
            <input type=\"text\" id=\"email\" name=\"email\" placeholder=\"דואר אלקטרוני\">
            <label for=\"subject\"></label>
            <textarea id=\"subject\" name=\"subject\" placeholder=\"תוכן ההודעה\" style=\"height:100px\"></textarea>
            <input type=\"submit\" value=\"שליחתה הודעה\">
          </form>
        </div>
        </div>
        </div>
      </div>
    </div><br><br><br><br><br><br><br><br><br>

             "; }?>
    <footer class="w3-container w3-teal-black w3-center w3-margin-top">
        <div class="row" style="max-width:99%;">
        <div class="col-sm-5">
          &copy;כל הזוכיות שמורות לאתר הכיתה
          <a href="https://www.jce.ac.il/"></a><br>
            קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
        </div>        
        <div class="col-sm-3"> 📚           
          רשימת מקצועות לימוד<br>
          צור קשר איתנו📧  
        </div><br/>
        <div class="col-sm-4">        עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
        </div><br/>
      </div>
    </footer>
  </body>
</html>
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