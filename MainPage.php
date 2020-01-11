<?php
//!!!!!!!!!!!!!!!!!!!!!!!!!its need to be the last three teachers
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $IdResults = mysqli_query($con, "SELECT * FROM teachers");
    /*create array for the new teachers, it's need to choose random a three new teachers
    * but yet there is no alot teachers
    */
    $NewTeachersArray=array();
    for($i=0;$i<3;$i++)
    {
        $rows=mysqli_fetch_array($IdResults);
        $NewTeachersArray[$i]=$rows['id'];
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <title>הכיתה</title>

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

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .row
        {
            display:block;
        }
        li
        {
            color:black;
            font-size:20px;
        }
        .navbar-brand 
        {
            font-size:35px;
        }    
        .nav-link:hover
        {
            font-size:30px;
        }
        h1
        {
            font-size:45px;
        }
        .moreTeachers
        {
            font-size:25px;
        }
        img {
    max-width: 100%;
}
.searchTeacherMainPageSection{
    background-color:white;
}
.searchWords
{
    font-size:30px;
}
    </style>
</head>
<body>
    <a id="button"></a><!--up button-->
    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="firstLoginPage.php">כניסה/הרשמה <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="searchTeachers.php">חיפוש מורה</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
                  </li>
              </ul>
            </div>
          </nav>
    </section>    
    <section class="mainPagePhoto">    </section><!--main photo-->     
<hr>
<div class="container bootstrap snippet" id="container">
    <div class="row">
      <div>            
      <div class="searchTeacherMainPageSection col-sm-12">               
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
                                   <p class="searchWords">  חיפוש מורה לפי תחום</p class="searchWords">
                                     <select name="frameworkCourse" id="frameworkCourse" class="form-control selectpicker" data-live-search="true" multiple >
                                        <option class="c" value="אנגלית">אנגלית</option>
                                        <option class="c" value="ערבית">ערבית</option>
                                        <option class="c" value="מתמטיקה">מתמטיקה/חשבון</option>
                                        <option class="c" value="מוסיקה">מוסיקה</option>
                                        <option class="c" value="פיזיקה">פיזיקה</option>
                                        <option class="c" value="אנדרויד">אנדרויד</option>
                                        <option class="c" value="ג'אווה">ג'אווה</option>
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
                                  <input id="searchButton" class="btn btn-success" type="submit" name="Save" value="חפש">
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
    <section class="newTeachersSection">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                   <h1>מורים חדשים באתר</h1>                   
                   <div class="border"></div>
                   <br>
                   <br>
               </div>
            <?php /*get the data for each one of the three choose as a new teachers to show them */
                for($i=0;$i<count($NewTeachersArray);$i++)
                {
                    
    $resultsOfTeacherTable = mysqli_query($con, "SELECT * FROM teachers");
    $resultOFCity = mysqli_query($con, "SELECT * FROM teacher_cities");
    $CoursesResults = mysqli_query($con, "SELECT * FROM teachers_courses");
    $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
                    echo "<button value=\"$NewTeachersArray[$i]\" id=\"$NewTeachersArray[$i]\" class=\"teacher col-sm-3\">";
                        echo"<input type=\"hidden\" id=\"$NewTeachersArray[$i]\">"; 
                        echo "<blockquote>";
                        while ($rows=mysqli_fetch_array($resultsOfImageTable)) 
                        {
                            if ($rows['id']==$NewTeachersArray[$i]) 
                            {
                                echo "<img src='img/".$rows['image']."' class='img-rounded img-responsive'>";
                            }
                        }
                        while ($rows=mysqli_fetch_array($resultsOfTeacherTable)) 
                        {
                            if ($rows['id']==$NewTeachersArray[$i]) 
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
                                $MoreThanOneWordSoAddComma=0;
                                $city=" ";
                                while ($teacher_citiesRows=mysqli_fetch_assoc($resultOFCity)) 
                                {
                                    if ($teacher_citiesRows['id']==$NewTeachersArray[$i]) 
                                    {
                                        if ($MoreThanOneWordSoAddComma>=1) 
                                        {
                                            $city.=' , ';
                                        }
                                        if($teacher_citiesRows['cities']!='cities')
                                        {
                                            $city.=$teacher_citiesRows['cities'];
                                            $MoreThanOneWordSoAddComma++;
                                        }
                                    }
                                }
                                if ($city!=' ') 
                                {
                                    echo "" . $city;
                                    echo nl2br("\n");
                                }
                                $CourseName=" ";
                                while($CoursesResultsRows=mysqli_fetch_array($CoursesResults))
                                {
                                    if ($CoursesResultsRows['id']==$NewTeachersArray[$i]) 
                                    {
                                        if ($MoreThanOneWordSoAddComma>=1) 
                                        {
                                            $CourseName.=" , ";
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
                            }
                        }
                    echo "</button>";	
                }
            ?>
        <div class=" buttonCheckForMoreTeachers text-center col-md-12">
            <a href="moreTeachers.php" class="moreTeachers btn btn-info btn-lg"> 
            <span class="glyphicon glyphicon-arrow-left"></span>
            לעוד מורים חדשים באתר
             <span class="glyphicon glyphicon-arrow-left"></span> 
           </a> 
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
	var phpIdArrayLength = <?php echo end($NewTeachersArray);?>;
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
