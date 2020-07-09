<?php 
/*
  This is the main page. include navbar : login, signUp, FAQ and search techer.   
  Search section.
  Teachers sections, there will be a sections for a new teachers, english teachers, arabic.....
  we start as we get the id and some information about teachers, id of login user in status of login.
  we need deatils about student for dsiplay on navbar my profile instead of login or sign up, and redirect to other pages. 
*/

  session_start();
  include 'userData.php';//this file include function to return user details like name.
  $ID=$_SESSION['id'];//the id of the login user.
  $_SESSION['id']=$ID;//share the id, used on redirect to other pages.

  $allUsersArrayWithThereMainInformations=array();//this array include all inforation about user, like id's, first and last name
  $EnglishTeachersIdArray=array();//array for using on english teacher section
  $EnglishTeachersIdArrayCounter=0;

  $TongueTeachersIdArray=array();//array for using on tongue teacher section
  $TongueTeachersIdArrayCounter=0;

  $ArabicTeachersIdArray=array();//array for using on Arabic teacher section
  $ArabicTeachersIdArrayCounter=0;

  $teachersIdArray=array();/*create array for the new teachers, random a three new teachers */
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
  $IdResults=mysqli_query($con, "SELECT * FROM users");
  $i=0;$j=0;//$i for $allUsersArrayWithThereMainInformations, and $j using for arrays help us with showing section
  while($rows=mysqli_fetch_array($IdResults)){/*create array for the new teachers, random a three new teachers */
    if($rows['setUserAs']!='student'&&($rows['id']!=$ID)){//get just the teachers
      $allUsersArrayWithThereMainInformations[$i]=$rows['id'];$i++;//get the id, and forward index
      $teachersIdArray[$j]=$rows['id'];$j++;//this useful for showing teachers sections like new teachers or engilsh teachers, and forward index
      $allUsersArrayWithThereMainInformations[$i]=$rows['fname'];$i++;//get first name, and forward index
      $allUsersArrayWithThereMainInformations[$i]=$rows['lname'];$i++;// get last name, and forward index
      $allUsersArrayWithThereMainInformations[$i]=teacherCourses($rows['id']);$i++;/////course, and forward index
      if(strpos($allUsersArrayWithThereMainInformations[$i-1], 'אנגלית') !== false){//for english teacher section
        $EnglishTeachersIdArray[$EnglishTeachersIdArrayCounter]=$rows['id'];
        $EnglishTeachersIdArrayCounter++;
      }

      if(strpos($allUsersArrayWithThereMainInformations[$i-1], 'לשון') !== false){//for tongue teacher section
        $TongueTeachersIdArray[$TongueTeachersIdArrayCounter]=$rows['id'];
        $TongueTeachersIdArrayCounter++;
      }
      if(strpos($allUsersArrayWithThereMainInformations[$i-1], 'ערבית') !== false){//for arabic teacher section
        $ArabicTeachersIdArray[$ArabicTeachersIdArrayCounter]=$rows['id'];
        $ArabicTeachersIdArrayCounter++;
      }
      
      
      $allUsersArrayWithThereMainInformations[$i]=teacherCities($rows['id']);$i++;// cities, and forward index
      $allUsersArrayWithThereMainInformations[$i]=Image($rows['id']);$i++;// cities, and forward index   
     }
   }

   $NewTeachersArray=array_rand($teachersIdArray,3);//this going to be used for the new teachers section, chooseing by random
   for($i=0;$i<count($NewTeachersArray);$i++){//get a three teachers
     $NewTeachersArray[$i]=$teachersIdArray[$NewTeachersArray[$i]];   
   }

   $EnglishTeachersArray=array_rand($EnglishTeachersIdArray,3);//this going to be used for the english teachers section, chooseing by random
   for($i=0;$i<count($EnglishTeachersArray);$i++){//get a three teachers
     $EnglishTeachersArray[$i]=$EnglishTeachersIdArray[$EnglishTeachersArray[$i]];   
   }
   
   $TongueTeachersArray=array_rand($TongueTeachersIdArray,3);//this going to be used for the tongue teachers section, chooseing by random
   for($i=0;$i<count($TongueTeachersArray);$i++){//get a three teachers
     $TongueTeachersArray[$i]=$TongueTeachersIdArray[$TongueTeachersArray[$i]];   
   }
   
   $ArabicTeachersArray=array_rand($ArabicTeachersIdArray,3);//this going to be used for the arabic teachers section, chooseing by random
   for($i=0;$i<count($ArabicTeachersArray);$i++){//get a three teachers
     $ArabicTeachersArray[$i]=$ArabicTeachersIdArray[$ArabicTeachersArray[$i]];   
   }
    
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <?php include 'header.php';?>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/HakitaStyle.css">
  </head>
  <body>
    <a id="button"></a><!--up button-->
    <?php
      $undisplay='Hakita';//this and next two lines for the navbar, to not display the home page
    ?>
    <?php include_once 'nav.php'?>
    <div class="bgimg-1"><!--the main photo, include main title--->
      <div class="caption"><span class="border">הכיתה - אינדקס המורים הפרטיים הגדול של ישראל</span></div>
    </div><br><br>
    <div style="color: #777;background-color:white;text-align:center;text-align: justify;">
    <div class="container"><div class="row"><div class="col-sm-12"><div class="limiter"><div class="container-login100"><div class="form-group col-sm-12">
			<!--search section, include search by city/course, search button., by select any subject or city will redirect to searchTeacher page by used Jquery from script file--->
        <form class="form" action="searchTeachers.php" method="post" id="registrationForm">
              <div class="form-group col-sm-6">
                 <p class="searchWords"> חיפוש מורה לפי עיר</p>
                   <?php
                     echo"<SELECT title=\"בדוק את הערים הקימות\" id=\"framework\" class=\"selectpicker\" data-live-search=\"true\" multiple>";
                     $results=mysqli_query($con, "SELECT * FROM cities");
                     while($rows=mysqli_fetch_array($results)){
                         echo'<option>'.$rows['cityName'].'</option>';
                     }
                     echo"</SELECT>";
                   ?>                                      
                <input type="hidden" name="hidden_framework" id="hidden_framework"/><br/>
               </div> 
              <div class="form-group col-sm-6" id="searchByCourse">
             <p class="searchWords">  חיפוש מורה לפי קורס</p>
             <?php
                 echo"<SELECT name=\"frameworkCourse\" title=\"בדוק את המקצועות הקיימים\" id=\"frameworkCourse\" class=\"selectpicker\" data-live-search=\"true\">";
                 $results=mysqli_query($con, "SELECT * FROM courses");
                 while($rows=mysqli_fetch_array($results)){
                     echo'<option>'.$rows['subject'].'</option>';
                 }
                 echo"</SELECT>";
               ?>                                      
               <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses"/><br/>
            </div>
              <div id="v"><label for="Save"></label><input id="searchButton" type="submit" name="Save" value="חפש"></div>
          </form>
				</div></div></div></div></div>
        <!--teacher sections, include new teachers, english teachers,....--->
    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify; min-height: 650px;">
      <h3 style="text-align:center; color:white;">מורים חדשים באתר</h3><hr>
      <p><small>
        <?php /*get the data for each one of the three choose as an english teachers to show them */
          displayTeacherSection($NewTeachersArray);//go to this function to display teachers
        ?>
      </small></p>  
      <div class=" buttonCheckForMoreTeachers text-center col-md-12">
        <a href="moreTeachers.php?subject=AllTeachers" class="moreTeachers btn btn-info btn-lg">
          <span class="glyphicon glyphicon-arrow-left"></span>
          <span class="moreTeachersTitle">לעוד מורים חדשים באתר</span>
          <span class="glyphicon glyphicon-arrow-left"></span> 
        </a> 
      </div></div></div>
      <div class="bgimg-2">
        <div class="caption"></div>
      </div>
    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify; min-height: 650px;">
        <h3 style="text-align:center; color:white;">מורים אנגלית </h3><hr>
        <p><small>
        <?php /*get the data for each one of the three choose as an english teachers to show them */
          displayTeacherSection($EnglishTeachersArray);//go to this function to display teachers
        ?>
        </small></p>  
      <div class=" buttonCheckForMoreTeachers text-center col-md-12">
        <a href="moreTeachers.php?subject=אנגלית" class="moreTeachers btn btn-info btn-lg">
          <span class="glyphicon glyphicon-arrow-left"></span>
          <span class="moreTeachersTitle">לעוד מורים אנגלית באתר</span>
          <span class="glyphicon glyphicon-arrow-left"></span> 
        </a> 
      </div></div></div>
    <div class="bgimg-3">
      <div class="caption">
        <span class="border" style="background-color:transparent;font-size:25px;color: black;">ללמוד תוך אווירה נעימה</span>
      </div></div>
      <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify; min-height: 650px;">
      <h3 style="text-align:center; color:white;">מורים ללשון באתר</h3><hr>
      <p><small>
        <?php /*get the data for each one of the three choose as an tongue teachers to show them */
          displayTeacherSection($TongueTeachersArray);//go to this function to display teachers
        ?>
      </small></p>  
      <div class=" buttonCheckForMoreTeachers text-center col-md-12">
        <a href="moreTeachers.php?subject=לשון" class="moreTeachers btn btn-info btn-lg">
          <span class="glyphicon glyphicon-arrow-left"></span>
          <span class="moreTeachersTitle">לעוד מורים ללשון באתר</span>
          <span class="glyphicon glyphicon-arrow-left"></span> 
        </a> 
      </div></div></div>
      <div class="bgimg-2">
        <div class="caption"></div>
      </div>
    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify; min-height: 650px;">
      <h3 style="text-align:center; color:white;">מורים לערבית באתר</h3><hr>
      <p><small>
        <?php /*get the data for each one of the three choose as an arabic teachers to show them */
          displayTeacherSection($ArabicTeachersArray);//go to this function to display teachers
        ?>
      </small></p>  
      <div class=" buttonCheckForMoreTeachers text-center col-md-12">
        <a href="moreTeachers.php?subject=ערבית" class="moreTeachers btn btn-info btn-lg">
          <span class="glyphicon glyphicon-arrow-left"></span>
          <span class="moreTeachersTitle">לעוד מורים לערבית באתר</span>
          <span class="glyphicon glyphicon-arrow-left"></span> 
        </a> 
      </div></div></div>
      <div class="bgimg-2">
        <div class="caption"></div>
      </div>               
    <div class="bgimg-1"><div class="caption"><div class="containe" id="containe" name="containe"><div class="row"><div class="col-sm-12">
    </div></div></div></div></div><br><br><br><br>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ec53990697c2288"></script>
                        
    <?php include_once 'footer.php';?><!--get the bottom footer-->
    <div id="forSmallScreen"><br><br><br><br><br><br><br><br></div><!--next to div's for small screen design-->
  </body>
</html>

<?php include_once 'script.php';?><!--getsome functions like the up button, choose form courses/cities list-->