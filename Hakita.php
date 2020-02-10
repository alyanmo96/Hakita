<?php
/*
*   this would be the main page
 */
    //!!!!!!!!!!!!!!!!!!!!!!!!!its need to be the last three teachers
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $IdResults = mysqli_query($con, "SELECT * FROM teachers");    
    /*create array for the new teachers, random a three new teachers */
    $NewTeachersArrayBeforeRand=array();
    $i=0;
    while ($rows=mysqli_fetch_array($IdResults))
    {
        if($rows['id']!=211&&$rows['setUserAs']!='student')
        {
            $NewTeachersArrayBeforeRand[$i]=$rows['id'];
            $i++;
        }
    }
    $NewTeachersArray = array_rand($NewTeachersArrayBeforeRand, 3);
    for($i=0;$i<count($NewTeachersArray);$i++)
    {
        $NewTeachersArray[$i]=$NewTeachersArrayBeforeRand[$NewTeachersArray[$i]];   
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <style>
    .teacher {
    margin: 1%;
    max-height:288px;
    }
    .img-rounded {
    border-radius: 6px;
    max-height: 52px;
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
            <a class="navbar-brand" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="loginSignUP.php">כניסה/הרשמה <span class="sr-only">(current)</span></a>
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
                                   <?php
                                    echo "<SELECT  name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                    $results = mysqli_query($con, "SELECT * FROM cities");
                                    echo'<option>'.'בדוק את הערים הקימות'.'</option>';
                                    while ($rows=mysqli_fetch_array($results))
                                    {
                                        echo'<option>'.$rows['cityName'].'</option>';
                                    }
                                    echo"</SELECT>";
                                  ?>
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
                                   <?php
                                      echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                      $results = mysqli_query($con, "SELECT * FROM courses");
                                      echo'<option>'.'בדוק את המקצועות הקיימים  '.'</option>';
                                      while ($rows=mysqli_fetch_array($results))
                                      {
                                          echo'<option>'.$rows['subject'].'</option>';
                                      }
                                      echo"</SELECT>";
                                    ?>
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
   <div class="ButtomSection">      
    <div class="container">
      <div class="row">
        <div class="col-sm-5">
          &copy;כל הזוכיות שמורות לאתר הכיתה
             
              <a href="https://www.jce.ac.il/">

                </a><br>
                קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          
                  <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
              
        </div>
        <div class="col-sm-3">
          📚            
      רשימת מקצועות לימוד
      <br>
      צור קשר איתנו📧
         
      <p >הוספת פרויפיל</p>
        </div>
        <div class="col-sm-4">
          עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
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
        window.location.href = "viewTeacherProfile.php?id=" + x;
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
