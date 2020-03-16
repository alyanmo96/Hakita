<?php
    /*
      this is the main page. include navbar : login/signUp, FAQ, search a techer.      an image on the top of page, search section.
      new teacher section, there willl be a sections for english teachers, arabic.....
      we start as we get the id and some information about teacher,
    we does not need any deatils about student for showing them 
    */
    //this function is for return the name of teacher cities on teachers section like new teacher
    function teacherCities($id){//need to conncet with the DB, the main connection not useful inside function
      include 'connectionPage.php';//include this file for calling the DB
      $MoreThanOneWordSoAddComma=0;//this variable using case there is a teachers with more than one city, so write a comma between each two cities
      $city=" ";//city variable
      while ($teacher_citiesRows=mysqli_fetch_assoc($resultOFTeachersCity)){//searching on cities table about the teacher id
          if ($teacher_citiesRows['id']==$id){//if the id on table eqaul to the id of teacher, check in which city he/she is
              if ($MoreThanOneWordSoAddComma>=1){ //for more than one city add comma
                $city.=' , ';
              }
              if($teacher_citiesRows['cities']!='cities'){//add the city name
                $city.=$teacher_citiesRows['cities'];
                $MoreThanOneWordSoAddComma++;
              }
          }
      }
      return $city;//return which cities we get from table if there is
    }
    //this function is for return the name of teacher courses who learn on teachers section like new teacher
    function teacherCourses($id){//need to conncet with the DB, the main connection not useful inside function
      include 'connectionPage.php';//include this file for calling the DB
      $MoreThanOneWordSoAddComma=0;//this variable using case there is a teachers learn more than one course, so write a comma between each two courses
      $CourseName=" ";//course variable
      while($CoursesResultsRows=mysqli_fetch_array($CoursesOfTeachersResults)){
          if ($CoursesResultsRows['id']==$id){ //if the id on table eqaul to the id of teacher, check which course he/she learn
              if ($MoreThanOneWordSoAddComma>=1){ //for more than one city add comma
                $CourseName.=" , ";
              }
              if($CoursesResultsRows['subject']!='subject'){//add the course name
                $CourseName=$CoursesResultsRows['subject'];
                $MoreThanOneWordSoAddComma++;
              }
          }	
      }	
      return $CourseName;//return the courses that teacher learn
    }
    //this function is for return the name of teacher image
    function teacherImage($id){
      include 'connectionPage.php';//include this file for calling the DB
      while ($rows=mysqli_fetch_array($resultsOfImageTable)){
        if ($rows['id']==$id){
          return $rows['image'];
        }
      }
    }
    $allUsersArrayWithThereMainInformations=array();//this array include all inforation about user, like id's, first and last name
    $EnglishTeachersIdArray=array();//array for using on english teacher section
    $EnglishTeachersIdArrayCounter=0;
    $teachersIdArray=array();/*create array for the new teachers, random a three new teachers */
    include 'connectionPage.php';//include this file for calling the DB
    $i=0; $j=0;//$i for $allUsersArrayWithThereMainInformations, and $j using for arrays help us with showing section
    while ($rows=mysqli_fetch_array($IdResults)){/*create array for the new teachers, random a three new teachers */
        if($rows['id']!=211&&$rows['setUserAs']!='student'&&($rows['id']!=$_GET['id']&&$rows['id']!=$_POST['id'])){//get just the teachers
            $allUsersArrayWithThereMainInformations[$i]=$rows['id'];$i++;//get the id, and forward index
            $teachersIdArray[$j]=$rows['id'];$j++;//this useful for showing teachers sections like new teachers or engilsh teachers, and forward index
            $allUsersArrayWithThereMainInformations[$i]=$rows['fname'];$i++;//get first name, and forward index
            $allUsersArrayWithThereMainInformations[$i]=$rows['lname'];$i++;// get last name, and forward index
            $allUsersArrayWithThereMainInformations[$i]=teacherCourses($rows['id']);$i++;/////course, and forward index
            if(strpos($allUsersArrayWithThereMainInformations[$i-1], 'אנגלית') !== false){//for english teacher section
              $EnglishTeachersIdArray[$EnglishTeachersIdArrayCounter]=$rows['id'];
              $EnglishTeachersIdArrayCounter++;
            }            
            $allUsersArrayWithThereMainInformations[$i]=teacherCities($rows['id']);$i++;// cities, and forward index
            $allUsersArrayWithThereMainInformations[$i]=teacherImage($rows['id']);$i++;// cities, and forward index   
        }
    }
    $NewTeachersArray = array_rand($teachersIdArray,3);//this going to be used for the new teachers section, chooseing by random
    for($i=0;$i<count($NewTeachersArray);$i++){//get a three teachers
      $NewTeachersArray[$i]=$teachersIdArray[$NewTeachersArray[$i]];   
    }
    $EnglishTeachersArray = array_rand($EnglishTeachersIdArray,3);//this going to be used for the english teachers section, chooseing by random
    for($i=0;$i<count($EnglishTeachersArray);$i++){//get a three teachers
      $EnglishTeachersArray[$i]=$EnglishTeachersIdArray[$EnglishTeachersArray[$i]];   
    }
    function getAboutTeacherFunction($id,$allUsersArrayWithThereMainInformations){
      for($i=0;$i<count($allUsersArrayWithThereMainInformations);$i++){//get the teacher name
        if($allUsersArrayWithThereMainInformations[$i]==$id){//get the teacher id from teachers array and print it
          echo "<img src='img/".$allUsersArrayWithThereMainInformations[$i+5]."' class='img-rounded img-responsive'>";
          echo "" . $allUsersArrayWithThereMainInformations[$i+1]. "  " . $allUsersArrayWithThereMainInformations[$i+2];echo nl2br("\n");                                    
          echo "" . $allUsersArrayWithThereMainInformations[$i+3];echo nl2br("\n");
          echo "" . $allUsersArrayWithThereMainInformations[$i+4];echo nl2br("\n");
        }   
      }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
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
      .teacher 
      {
        margin: 1%;
        max-height:288px;
      }
      .img-rounded 
      {
        border-radius: 6px;
        max-height: 100px;
      }
    </style>
  </head>
  <body>
    <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
    <section><!--navbar section, there is two styles for showing: 1- for any user  2- user after login  -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <?php                    
                    if(!$_GET['id']&&!$_POST['id']){//for the unlogin user will display (signin/sign up) search for a teacher and FAQ page
                        echo '<li class="nav-item active">
                        <a class="nav-link" href="loginSignUP.php">כניסה/הרשמה </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="searchTeachers.php">חיפוש מורה</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
                        </li>';
                    }
                    else{/*for the login user, first we check if the login user is a student or a teacher
                      that help with redirect to his profile, case there is a different between theprofile of teacher and the profile of student
                      for the login user the navbar include:
                        1- my profile
                        2- logout
                        3- search for a teacher
                        4- FAQ page
                        ( on {3,4} what's deffirnet with unlogin user, here we send the id of the user)
                        */   
                        $isStudent=-1; 
                        $IDOfUser;// get the id of login user(teacher/student) by POST or GET
                        if($_GET['id']){
                            $IDOfUser=$_GET['id'];
                        }else{
                            $IDOfUser=$_POST['id'];
                        }
                        include 'connectionPage.php';//include this file for calling the DB
                        while ($rows=mysqli_fetch_array($IdResults)){
                          if ($rows['id']==$IDOfUser && $rows['setUserAs']=='student'){
                              $isStudent=1;
                              break;
                          }
                        }
                        if($isStudent==1){
                          // if the login user was a student, then he want to access to his profile
                          echo "<li class=\"nav-item active\">
                            <a class=\"nav-link\" href=\"studentProfile.php?id=$IDOfUser\">פרופיל שלי <span class=\"sr-only\">(current)</span></a>
                          </li> ";
                        }else
                        {// if the login user was a teacher, then he want to access to his profile
                          echo "<li class=\"nav-item active\">
                            <a class=\"nav-link\" href=\"profile.php?id=$IDOfUser\">פרופיל שלי <span class=\"sr-only\">(current)</span></a>
                          </li> ";
                        }// login user go to search teachers page/FAQ page/exit from his account
                        echo"<li class=\"nav-item\">
                          <a class=\"nav-link\" href=\"searchTeachers.php?id=$IDOfUser\">חיפוש מורה</a>
                        </li>
                        <li class=\"nav-item\">
                          <a class=\"nav-link\" href=\"FAQ.php?id=$IDOfUser\">שאלות ותשובות</a>
                        </li>
                        <li class=\"nav-item\">
                          <a class=\"nav-link\" href=\"Hakita.php\">יציאה </a>
                        </li>";
                    }
                  ?>
              </ul>
            </div>
          </nav>
    </section>    
    <section class="mainPagePhoto"> </section><hr><!--main photo , the class mainPagePhoto is on the CSS file-->     
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
                                            if($isStudent==1){
                                              echo "<input type=\"hidden\" name=\"studentID\" id=\"$IDOfUser\" value=\"$IDOfUser\">";
                                            }
                                            include 'connectionPage.php';//include this file for calling the DB
                                            echo "<SELECT  name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                            echo'<option>'.'בדוק את הערים הקימות'.'</option>';
                                            while ($rows=mysqli_fetch_array($resultsOfCities)){
                                              echo'<option>'.$rows['cityName'].'</option>';
                                            }
                                            echo"</SELECT>";
                                        ?>
                                        <br/><br/>
                                          <input type="hidden" name="hidden_framework" id="hidden_framework" />                             
                                        <br/>
                                        </div>
                                    </div>  
                                  </div>
                                  <div class="form-group">
                                <div class="col-sm-6">
                                      <div style=" padding-top: 1%;">
                                        <p class="searchWords">  חיפוש מורה לפי תחום</p class="searchWords">
                                        <?php
                                            include 'connectionPage.php';//include this file for calling the DB
                                            echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                            echo'<option>'.'בדוק את המקצועות הקיימים  '.'</option>';
                                            while ($rows=mysqli_fetch_array($resultsOfCourses)){
                                                echo'<option>'.$rows['subject'].'</option>';
                                            }
                                            echo"</SELECT>";
                                        ?>
                                        <br/><br/>
                                        <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses" />                                                              
                                        <br/>
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
                  for($i=0;$i<count($NewTeachersArray);$i++){
                      $id=$NewTeachersArray[$i]+3333;
                      echo "<button value=\"$id\" id=\"$id\" class=\"teacher col-sm-3\">";
                      echo"<input type=\"hidden\" id=\"$id\">"; 
                      echo "<blockquote>";
                      getAboutTeacherFunction($NewTeachersArray[$i],$allUsersArrayWithThereMainInformations);
                      echo "</button>";	
                  }
                ?>
            <div class=" buttonCheckForMoreTeachers text-center col-md-12">
                <?php
                if($IDOfUser){                  
                  echo "<a href=\"moreTeachers.php?subject=AllTeachers&id=$IDOfUser\" class=\"moreTeachers btn btn-info btn-lg\">";
                }else{
                  echo "<a href=\"moreTeachers.php?subject=AllTeachers\" class=\"moreTeachers btn btn-info btn-lg\">";

                }
              ?> 
                <span class="glyphicon glyphicon-arrow-left"></span>
                לעוד מורים חדשים באתר
                <span class="glyphicon glyphicon-arrow-left"></span> 
              </a> 
          </div>
      </section>
      <!--english teachers section-->
      <hr><hr>
        <section class="newTeachersSection">
            <div class="container">
                <div class="row">
                    <div class="title text-center">
                      <h1>מורים אנגלית </h1>                   
                      <div class="border"></div>
                      <br>
                      <br>
                  </div>
                <?php /*get the data for each one of the three choose as an english teachers to show them */
                   for($i=0;$i<count($EnglishTeachersArray);$i++){
                      $id=$EnglishTeachersArray[$i]+8888;
                      echo "<button value=\"$id\" id=\"$id\" class=\"teacher col-sm-3\">";
                      echo"<input type=\"hidden\" id=\"$id\">"; 
                      echo "<blockquote>";
                      getAboutTeacherFunction($EnglishTeachersArray[$i],$allUsersArrayWithThereMainInformations);
                      echo "</button>";	
                    }
                ?>
            <div class=" buttonCheckForMoreTeachers text-center col-md-12">
              <?php
                if($IDOfUser){                  
                  echo "<a href=\"moreTeachers.php?subject=אנגלית&id=$IDOfUser\" class=\"moreTeachers btn btn-info btn-lg\">";
                }else{
                  echo "<a href=\"moreTeachers.php?subject=אנגלית\" class=\"moreTeachers btn btn-info btn-lg\">";

                }
              ?> 
                <span class="glyphicon glyphicon-arrow-left"></span>
                לעוד מורים אנגלית באתר
                <span class="glyphicon glyphicon-arrow-left"></span> 
              </a> 
          </div>
      </section>
      <div class="ButtomSection">      
        <div class="container">
          <div class="row">
            <div class="col-sm-5">
              &copy;כל הזוכיות שמורות לאתר הכיתה
              <a href="https://www.jce.ac.il/"></a><br>
                    קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
              <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
            </div>
            <div class="col-sm-3">📚      רשימת מקצועות לימוד
              <br>      צור קשר איתנו📧
              <p >הוספת פרויפיל</p>
            </div>
            <div class="col-sm-4">          עקובו אחרינו ב-פייסבוק:-
              <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
            </div>
            </div>
        </div>
      </div>
  </body>
</html>
<!--
  next section going to be the script, using to know what user select from the main page.
  for example there is 1-the new teacher section, so when user click on any teacher, we 
  get the id card and send it to (viewTeacherProfile.php) file.
  2- the up button script, method to show the up button after down more than 300px on the page.
  3- the section of choosing course or city, after choosing from the list menu,get the framework
  and send it for search teacher page by POST 
-->
<script>
//this section on <script> is using for redirect the user to the choosen teacher profile
  var phpId = <?php echo end($NewTeachersArray)+3333;?>;
  var ifThereAnLoginUSer = <?PHP echo (!empty($IDOfUser) ? json_encode($IDOfUser) : '""'); ?>;
  $(document).ready(function(){
    for (var i = 3333; i <= phpId; i++){ 
      let x=i;
      let n = x.toString();
      $("#"+n).click(function(){ //redirect page---> to teacher choosen profile
        x-=3333;
        if(ifThereAnLoginUSer){// click to show teacher profile with login user
          window.location.href = "viewTeacherProfile.php?id=" + x+"&studentID="+ifThereAnLoginUSer;
        }else
        {// click to show teacher profile without login user
          window.location.href = "viewTeacherProfile.php?id=" + x;
        }
      });
    }
  });
  var phId = <?php echo end($EnglishTeachersArray)+8888;?>;
  $(document).ready(function(){
    for (var i = 8888; i <= phId; i++){ 
      let x=i;
      let n = x.toString();
      $("#"+n).click(function(){ //redirect page---> to teacher choosen profile
        x-=8888;
       if(ifThereAnLoginUSer){// click to show english teacher profile with login user
          window.location.href = "viewTeacherProfile.php?id=" + x+"&studentID="+ifThereAnLoginUSer;
        }else
        {// click to show english teacher profile without login user
          window.location.href = "viewTeacherProfile.php?id=" + x;
        }
      });
    }
  });
  //this section for the up button, after 300px down on screen the up button will display
  var btn = $('#button');
  $(window).scroll(function(){
    if ($(window).scrollTop() > 300){
        btn.addClass('show');//display the button
    }else{
        btn.removeClass('show');//undisplay the button
    }
  });
  btn.on('click', function(e){
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });
</script>


<script>//get the cities names student choose
$(document).ready(function(){
 $('.selectpicker').selectpicker();

 $('#framework').change(function(){
  $('#hidden_framework').val($('#framework').val());
 });

 $('#frameworkCourse').change(function(){
  $('#hidden_framework_courses').val($('#frameworkCourse').val());
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
  else if($('#frameworkCourse').val() != '')
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
   alert("נא לבחור עיר");
   return false;
  }
 }); 
});
</script>