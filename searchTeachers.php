<?php
/*
  1-on this page i need to change the desgin for a samll screen
  2- the select list {words need to be on the right side}
  3-the show of each teacher inside the card
*/
  //session_start();
  $Cities=$_POST['hidden_framework'];
  $Courses=$_POST['hidden_framework_courses']; 
  $courseIdCounter=0;// count how many teachers learn this course or in this city
  $CoursesIdArray = array(); // array of teachers id's
  //$CoursesIdArraylength = count($CoursesIdArray);
  $didUserChoose=-1;// use this to write if the user choose any option and it's not avilable
  $CoursesIdArraylength=0;
  $courseResultArrayCounter=0;
  $courseResultArray=array();// array of information for each teacher
  if ($Courses!=null||$Cities!=null) 
  {
    $didUserChoose=1;
    /* in this section there is three options:-
      1-if the user choosed course and city
      2-if the user choosed course 
      3-if the user choosed city
    */
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    //1- option number one
    if ($Courses!=null && $Cities!=null)//if user choose city and course for search
    {
      $arrayOFAllCities=array("עכו","עפולה", "ערד","עראבה","אשדוד","אשכלון","באקה אל גרביה","בת ים",  "באר שבע", "בית שאן","בית שמש","בני ברק", "דימונה", "אילת",  "אלעד",  "גבעת שמואל", "גבעתיים",   "חדרה",   "הרצליה",   "הוד השרון",  "חולון",   "ירושלים", "כפר קאסם",   "כרמיאל",    "כפר סבא",   "כפר יונה",  "כפר אתא",  "קרית ביאליק",  "קרית גת",  "קרית מלאכי",   "קרית מוצקין", "קרית אונו",   "קרית שמונה",  "קרית ים",  "לוד",    "מעלות תרשיחא", "מגדל העמק", "מודעין מכבים רעות",  "נהריה",   "נצרת", "נשר",  "נס ציונה",  "נתניה", "נתיבות",  "נוף הגליל", "אופקים", "אור עקיבה", "אור יהודה",  "פתח תקווה",   "קלנסווה","רעננה",  "רהט",  "רמת גן", "רמת השרון", "רמלה", "רחובות",  "ראשון לציון",  "ראש העין", "צפת", "סכנין", "שדרות",  "שפרעם", "טמרה", "טייבה", "תל אביב-יפו" , "טבריה" , "טירה" , "טירת הכרמל" , "אום אל-פחם" , "יבנה" , "יהוד-מונוסון" , "יקנעם עלית");
      $idArrayOfPeopleLiveOnChoosenCity=array();
      $CounterOfIdArrayOfPeopleLiveOnChoosenCity=0;
      $arrayOfChoosenCities=array();
      $counterOFArrayOfChoosenCities=0;
      //call the table of cities
      $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");
        for($t=0;$t<count($arrayOFAllCities);$t++)
        {
          if(stristr($Cities,$arrayOFAllCities[$t]))
          {
            $arrayOfChoosenCities[$counterOFArrayOfChoosenCities]=$arrayOFAllCities[$t];
            $counterOFArrayOfChoosenCities++;
          }
        }
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        for($t=0;$t<count($arrayOfChoosenCities);$t++)
        {
          if(stristr($teacherCitiesRows['cities'],$arrayOfChoosenCities[$t]))
          {
            $idArrayOfPeopleLiveOnChoosenCity[$CounterOfIdArrayOfPeopleLiveOnChoosenCity]=$teacherCitiesRows['id'];
            $CounterOfIdArrayOfPeopleLiveOnChoosenCity++;
            break;
          }
        }
      }
      $arrayOfAllCourses=array("אנגלית", "ערבית", "מתמטיקה", "מוסיקה" , "פיזיקה" , "אנדרויד" ,"ג'אווה");
      $idArrayOfPeopleLearnOfChoosenCourse=array();
      $CounterOfIdArrayOfPeopleLearnOfChoosenCourse=0;
      $arrayOfChoosenCourse=array();
      $counterOFArrayOfChoosenCourse=0;
      //call the table of courses
      $teachers_coursesResult = mysqli_query($con, "SELECT * FROM teachers_courses");
      // check which teacher learn the specified course
      for($t=0;$t<count($arrayOfAllCourses);$t++)
        {
          if(stristr($Courses,$arrayOfAllCourses[$t]))
          {
            $arrayOfChoosenCourse[$counterOFArrayOfChoosenCourse]=$arrayOfAllCourses[$t];
            $counterOFArrayOfChoosenCourse++;
          }
        }
     while ($CourseRows=mysqli_fetch_array($teachers_coursesResult)) 
        {
          for($t=0;$t<count($arrayOfChoosenCourse);$t++)
          {
            if(stristr($CourseRows['subject'],$arrayOfChoosenCourse[$t]))
            {
              $idArrayOfPeopleLearnOfChoosenCourse[$CounterOfIdArrayOfPeopleLearnOfChoosenCourse]=$CourseRows['id'];
              $CounterOfIdArrayOfPeopleLearnOfChoosenCourse++;
              break;
            }
          }
        }


        for($t=0;$t<count($idArrayOfPeopleLiveOnChoosenCity);$t++)
        {
          for($f=0;$f<count($idArrayOfPeopleLearnOfChoosenCourse);$f++)
          {
            if($idArrayOfPeopleLiveOnChoosenCity[$t]==$idArrayOfPeopleLearnOfChoosenCourse[$f])
            {
              $CoursesIdArraylength+=5;
              $CoursesIdArray[$courseIdCounter]=$idArrayOfPeopleLiveOnChoosenCity[$t];
              $courseIdCounter+=1;
              break;
            }
          }
        }

        $teachersResult = mysqli_query($con, "SELECT * FROM teachers");
        // form the teacher table we get the information about the teacher
        // like first name, last name and phone number
        while ($teacherRows=mysqli_fetch_array($teachersResult)) 
        {
          for($i=0;$i<$CoursesIdArraylength;$i++)
          {
            if($teacherRows['id']==$CoursesIdArray[$i])
            {
              $courseResultArray[$courseResultArrayCounter]=$teacherRows['id'];
              $courseResultArrayCounter+=1;
              $courseResultArray[$courseResultArrayCounter]=$teacherRows['fname'];
              $courseResultArray[$courseResultArrayCounter]=$courseResultArray[$courseResultArrayCounter]." ".$teacherRows['lname'];
              $courseResultArrayCounter+=1;
              $courseResultArray[$courseResultArrayCounter]=$teacherRows['status'];
              $courseResultArrayCounter+=3;
            }
          }
        }
        // call the teacher_cities table
        $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");
        //to git the city for each teacher we need 
        while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
        {
          for($i=0;$i<$CoursesIdArraylength;$i++)
          {
            if($teacherCitiesRows['id']==$courseResultArray[$i])
            {
               //$courseResultArray[$i+3]=CityFunction($teacherCitiesRows['id']);
               $courseResultArray[$i+3]=$teacherCitiesRows['cities'];
            }
          }
        }
        //get the image for each teacher if there is an image
        $teacher_images = mysqli_query($con, "SELECT * FROM images");
        while ($teacherImgRows=mysqli_fetch_array($teacher_images)) 
        {
          for($i=0;$i<$CoursesIdArraylength;$i++)
          {
            if($teacherImgRows['id']==$courseResultArray[$i])
            {
              $courseResultArray[$i+4]=$teacherImgRows['image'];
            }
          }
        }
    }
    else if ($Courses!=null&&$Cities==null) //if one of the two values selected
    {
      $teachers_coursesResult = mysqli_query($con, "SELECT * FROM teachers_courses");
      // check which teacher learn the specified course
      while ($CourseRows=mysqli_fetch_array($teachers_coursesResult)) 
      {
        if(stristr($CourseRows['subject'],$Courses))
        {
          $CoursesIdArraylength+=5;// for each teacher we give five index(id,first name,last name,phone and image)
          $CoursesIdArray[$courseIdCounter]=$CourseRows['id'];//enter the id on the ID array
          $courseIdCounter+=1;//go to get the next id teacher
        }
      }
      //call the teachers table
      $teachersResult = mysqli_query($con, "SELECT * FROM teachers");
      // form the teacher table we get the information about the teacher
      // like first name, last name and phone number
      while ($teacherRows=mysqli_fetch_array($teachersResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherRows['id']==$CoursesIdArray[$i])
          {
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['id'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['fname'];
            $courseResultArray[$courseResultArrayCounter]=$courseResultArray[$courseResultArrayCounter]." ".$teacherRows['lname'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['status'];
            $courseResultArrayCounter+=3;
          }
        }
      }
      // call the teacher_cities table
      $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");
      //to git the city for each teacher we need 
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherCitiesRows['id']==$courseResultArray[$i])
          {
             //$courseResultArray[$i+3]=CityFunction($teacherCitiesRows['id']);
             $courseResultArray[$i+3]=$teacherCitiesRows['cities'];
          }
        }
      }
      //get the image for each teacher if there is an image
      $teacher_images = mysqli_query($con, "SELECT * FROM images");
      while ($teacherImgRows=mysqli_fetch_array($teacher_images)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherImgRows['id']==$courseResultArray[$i])
          {
            $courseResultArray[$i+4]=$teacherImgRows['image'];
          }
        }
      }
    }
    else if ($Cities!=null&&$Courses==null) 
    {
      $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        if(stristr($teacherCitiesRows['cities'],$Cities))
        {
          $CoursesIdArraylength+=5;
          $CoursesIdArray[$courseIdCounter]=$teacherCitiesRows['id'];
          $courseIdCounter+=1;
        }
      }
      $teachersResult = mysqli_query($con, "SELECT * FROM teachers");
      while ($teacherRows=mysqli_fetch_array($teachersResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherRows['id']==$CoursesIdArray[$i])
          {
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['id'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['fname'];
            $courseResultArray[$courseResultArrayCounter]=$courseResultArray[$courseResultArrayCounter]." ".$teacherRows['lname'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['status'];
            $courseResultArrayCounter+=3;
          }
        }
      }
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherCitiesRows['id']==$courseResultArray[$i])
          {
            //$courseResultArray[$i+3]=CityFunction($teacherCitiesRows['id']);
            $courseResultArray[$i+3]=$teacherCitiesRows['cities'];
          }
        }
      }
      $teacher_images = mysqli_query($con, "SELECT * FROM images");
      while ($teacherImgRows=mysqli_fetch_array($teacher_images)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherImgRows['id']==$courseResultArray[$i])
          {
            $courseResultArray[$i+4]=$teacherImgRows['image'];
          }
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>


      <link rel="stylesheet" type="text/css" href="css/styleSearch.css">
      <style>
      .navbar-nav .nav-link {
    padding-right: 0;
    padding-left: 40%;
}
            .nav-link
            {
                font-size:23px;
            }    
            .nav-link:hover
            {
                font-size:30px;
            }
        .searchWords{
          color:black;
          font-size: 40px;
          text-shadow: 8px 12px 51px grey;
        }
        #notAvilableTitle{
          color:black;
          font-size: 50px;
          font-weight: bold;
          text-shadow: 37px 64px 5px white;
        }
        .row {
    display: block;
        }
        #container{
            background:url('./img/english.jpg');
        }
        .card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 350px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.title {
  color: grey;
  font-size: 18px;
}
.img{
  max-width: 50%;
  margin-left: 35%;
  margin-right: 20%;
  margin-top: 1%;
}
body{
  direction:rtl;
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
                    <a class="nav-link" href="firstLoginPage.php">כניסה/הרשמה <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
                  </li>
              </ul>
            </div>
          </nav>
    </section>
<hr>
<div class="container bootstrap snippet" id="container">
    <div class="row">
      <div>            
      <div class="col-sm-12">               
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="searchTeachers.php" method="post" id="registrationForm">
                      
                      <div class="form-group">
                             <div class="col-sm-6">
                                  <div style=" padding-top: 1%;">
                                   <p class="searchWords"> חיפוש מורה לפי עיר</p>
                                     <select name="framework" id="framework" class="form-control selectpicker" data-live-search="true" multiple >
                                        <option class="c" value="עכו">עכו</option>
                                    <option value="עפולה">עפולה</option>
                                    <option value="ערד">ערד</option>
                                    <option value="עראבה">עראבה</option>
                                    <option value="אשדוד">אשדוד</option>
                                    <option value="אשכלון">אשכלון</option>
                                    <option value="באקה אל גרביה">באקה אל גרביה</option>
                                    <option value="בת ים">בת ים</option>
                                    <option value="באר שבע">באר שבע</option>
                                    <option value="בית שאן">בית שאן</option>
                                    <option value="בית שמש">בית שמש</option>
                                    <option value="בני ברק">בני ברק</option>
                                    <option value="דימונה">דימונה</option>
                                    <option value="אילת">אילת</option>
                                    <option value="אלעד">אלעד</option>
                                    <option value="גבעת שמואל">גבעת שמואל</option>
                                    <option value="גבעתיים">גבעתיים</option>
                                    <option value="חדרה">חדרה</option>
                                    <option value="חיפה">חיפה</option>
                                    <option value="הרצליה">הרצליה</option>
                                    <option value="הוד השרון">הוד השרון</option>
                                    <option value="חולון">חולון</option>
                                    <option value="ירושלים">ירושלים</option>
                                    <option value="כפר קאסם">כפר קאסם</option>
                                    <option value="כרמיאל">כרמיאל</option>
                                    <option value="כפר סבא">כפר סבא</option>
                                    <option value="כפר יונה">כפר יונה</option>
                                    <option value="כפר אתא">כפר אתא</option>
                                    <option value="קרית ביאליק">קרית ביאליק</option>
                                    <option value="קרית גת">קרית גת</option>
                                    <option value="קרית מלאכי">קרית מלאכי</option>
                                    <option value="קרית מוצקין">קרית מוצקין</option>
                                    <option value="קרית אונו">קרית אונו</option>
                                    <option value="קרית שמונה">קרית שמונה</option>
                                    <option value="קרית ים">קרית ים</option>
                                    <option value="לוד">לוד</option>
                                    <option value="מעלות תרשיחא">מעלות תרשיחא</option>
                                    <option value="מגדל העמק">מגדל העמק</option>
                                    <option value="מודעין מכבים רעות">מודעין מכבים רעות</option>
                                    <option value="נהריה">נהריה</option>
                                    <option value="נצרת">נצרת</option>
                                    <option value="נשר">נשר</option>
                                    <option value="נס ציונה">נס ציונה</option>
                                    <option value="נתניה">נתניה</option>
                                    <option value="נתיבות">נתיבות</option>
                                    <option value="נוף הגליל">נוף הגליל</option>
                                    <option value="אופקים">אופקים</option>
                                    <option value="אור עקיבה">אור עקיבה</option>
                                    <option value="אור יהודה">אור יהודה</option>
                                    <option value="פתח תקווה">פתח תקווה</option>
                                    <option value="קלנסווה">קלנסווה</option>
                                    <option value="רעננה">רעננה</option>
                                    <option value="רהט">רהט</option>
                                    <option value="רמת גן">רמת גן</option>
                                    <option value="רמת השרון">רמת השרון</option>
                                    <option value="רמלה">רמלה</option>
                                    <option value="רחובות">רחובות</option>
                                    <option value="ראשון לציון">ראשון לציון</option>
                                    <option value="ראש העין">ראש העין</option>
                                    <option value="צפת">צפת</option>
                                    <option value="סכנין">סכנין</option>
                                    <option value="שדרות">שדרות</option>
                                    <option value="שפרעם"> שפרעם</option>
                                    <option value="טמרה">טמרה</option>
                                    <option value="טייבה">טייבה</option>
                                    <option value="תל אביב-יפו">תל אביב-יפו</option>
                                    <option value="טבריה">טבריה</option>
                                    <option value="טירה">טירה</option>
                                    <option value="טירת הכרמל">טירת-הכרמל</option>
                                    <option value="אום אל-פחם">אום אל-פחם</option>
                                    <option value="יבנה">יבנה</option>
                                    <option value="יהוד-מונוסון">יהוד מונוסון</option>
                                    <option value="Yokneam Illit">יקנעם עלית</option>
                                     </select>
                                     <br /><br />
                                     <input type="hidden" name="hidden_framework" id="hidden_framework" />                                  
                             
                                  <br />
                                 </div>
                                </div>  
                              </div>
                              <div class="form-group">
                             <div class="col-sm-6">
                                  <div style=" padding-top: 1%;">
                                   <p class="searchWords">  חיפוש מורה לפי קורס</p class="searchWords">
                                     <select name="frameworkCourse" id="frameworkCourse" class="form-control selectpicker" data-live-search="true" multiple >
                                        <option class="c" value="אנגלית">אנגלית</option>
                                        <option class="c" value="ערבית">ערבית</option>
                                        <option class="c" value="מתמטיקה">מתמטיקה/חשבון</option>
                                        <option class="c" value="מוסיקה">מוסיקה</option>
                                        <option class="c" value="פיזיקה">פיזיקה</option>
                                        <option class="c" value="אנדרויד">אנדרויד</option>
                                        <option class="c" value="גאווה">ג'אווה</option>
                                     </select>
                                     <br /><br />
                                     <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses" />                                                              
                                  <br />
                                 </div>
                                </div>  
                              </div>
                     <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                                  <label for="Save"><h4></h4></label>
                                  <input id="searchButton" type="submit" name="Save" value="חפש">
                            </div>
                      </div>
                </form>
             </div><!--/tab-pane-->            
              </div><!--/tab-pane-->
          </div><!--/tab-content-->
        </div><!--/col-9-->
    </div><!--/row-->
  </div>
  <hr><hr>
    <section id="searchResult">
      <div class="container">
          <div class="row">
            <?php
                //if what user choose not avilable
                if($CoursesIdArraylength==0&&$didUserChoose==1)
                {
                  echo '<div id="notAvilableTitle"> אין מורים בתחום שנבחר או באזור ';
                  echo '</div>';
                }
                else
                {
                  $D=array();
                  $DCounter=0;
                  $k=0;
                  echo "<div class=\"col-sm-10\">";
                  for($i=1;$i<$CoursesIdArraylength;$i+=5)
                    {
                      $k++;
                      if(($k%3)==0)
                      {
                        echo "<br><hr><hr>";
                      }
                      $D[$DCounter]=$courseResultArray[$i-1];
                      $DCounter++;
                      $ID=$courseResultArray[$i-1];
                      //new line
                      echo "<div class=\"col-sm-4\">";
                     // echo "<button value=\"$ID\" id=\"$ID\" class=\"teacher col-sm-11\">";
                     echo "<button value=\"$ID\" id=\"$ID\" class=\"card\">";
                      echo"   <input type=\"hidden\" id=\"$ID\">";
                      //echo  $courseResultArray[$i];//first name 
                      $nameToShow=$courseResultArray[$i];
                      $i++;
                      //echo nl2br("\n");
                      //echo $courseResultArray[$i];//phone number
                      $status=$courseResultArray[$i];
                      $i++;
                      echo nl2br("\n");
                      $cc=$courseResultArray[$i];
                      //echo  $courseResultArray[$i];//
                      $i++;
                      echo nl2br("\n");
                     // echo "<img src='img/".$courseResultArray[$i]."'   class='teacherImg'>";//image
                      echo "<img src='img/".$courseResultArray[$i]."'   class='img'>";
                     echo "<h2> "; echo $nameToShow; echo"</h2>";
                     echo "<p class=\"title\">";
                     echo $status;
                    echo "</p>";
                     echo "<p>";
                      echo $cc;
                     echo "</p>";
                      echo "</button>";
                      //new div
                      echo "</div>";
                      $i-=3;
                    }
                    echo "</div>";
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
$(document).ready(function(){
 $('.selectpicker').selectpicker();

 $('#framework').change(function(){
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
     $('#hidden_framework_courses').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }
  else
  {
    alert("נא לבחור קורס");
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
	window.location.href = "studentCheckTeacherPage.php?id=" + x;
	});
	}
	});
</script>