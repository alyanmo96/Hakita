<?php
/**
 * this is the ADMIN page.
 * (-)on this page admin can make many functions as  looke for users(all users/teachers/students/new users/
 * add a new city or anew course/which user make changes and admin settings).
 * (-)ADMIN look for a user by choose him on list or at the section of user(teachers for example) can found him.
 * (-)before adding a new city, ADMIN can look for all citites on site(cant add same city or same course twice).
 * (-)the section of new user. display user with a new account less than one month.
 */
    session_start();


  /*  
  $userId=$_SESSION['id']
   $_SESSION['id']=$userId;

*/
    function SiteCities($city){//function to check if admin going to insert a city that is already on DB or not
       // $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
       $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
 
       $teacher_citiesResultForArray=mysqli_query($con, "SELECT * FROM cities");//call the table of cities
        $arrayOFAll=array();
          while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResultForArray)){
            $r=$teacherCitiesRows['cityName'];
            array_push($arrayOFAll,$r);//insert a list of cities names on array, each city on different index on array, 
            //to compare on next section(after loop) what user choose as a cities and what we have on DB
          } 
          for($t=0;$t<count($arrayOFAll);$t++){
            if(stristr($city,$arrayOFAll[$t])){return 1;}
          }return -1;
    }   
    function SiteCourses($course){//function to check if admin going to insert a course that is already on DB or not
//        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $resultsOfCourses = mysqli_query($con, "SELECT * FROM courses");//call the table of courses
        $arrayOFAll=array();
          while($teacherCitiesRows=mysqli_fetch_array($resultsOfCourses)){
            $r=$teacherCitiesRows['subject'];
            array_push($arrayOFAll,$r);//insert a list of courses names on array, each city on different index on array, 
            //to compare on next section(after loop) what user choose as a courses and what we have on DB
          }      
          for($t=0;$t<count($arrayOFAll);$t++){
            if(stristr($course,$arrayOFAll[$t])){return 1;}
          }return -1;
    }   //delete City from DB
    if(isset($_POST['deleteCity'])&&$_POST['deleteCity']!=NULL){
//        $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
        $deleteCity=$_POST['deleteCity'];
        $resultsOfCities=mysqli_query($con, "SELECT * FROM cities");
        while($CitiesRows=mysqli_fetch_array($resultsOfCities)){
            if(strcmp($CitiesRows['cityName'], $deleteCity)==0){$cityID=$CitiesRows['id'];}
        }   
        if($cityID){      
            $sql="DELETE FROM cities WHERE id=$cityID";
            if($con->query($sql) === TRUE){$cityDeleted=1;}
        }else{echo "אין עיר כזאת ברשימה<br>";}
    } 
//    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    if(isset($_POST['newCity'])&&$cityDeleted!=1){//this section for adding a new city to site. statring by get the name of the new city, check that's really a new city, if yes add it else not
      $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
      $city=$_POST['newCity'];//get the name of the new city
      if(SiteCities($city)==-1){
        $query="INSERT INTO `cities`(`cityName`) VALUES ('$city')";//insert on DB
        $result=mysqli_query($con,$query); 
      }else{echo"<script type='text/javascript'>alert('העיר כבר קיימת במערכת');</script>";} 
    }//delete City from DB 
    if(isset($_POST['deleteCourse'])&&$_POST['deleteCourse']!=NULL){
        $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
        // $sql="DELETE FROM courses WHERE subject=$deleteUserId ";
        if($con->query($sql) === TRUE){$courseDeleted=1;}
    }   
    if(isset($_POST['newCourse'])&&$cityDeleted!=1){//this section for adding a new city to site. statring by get the name of the new course, check that's really a new course, if yes add it else not
        $course=$_POST['newCourse'];//get the name of the new course
        $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
        if(SiteCourses($course)==-1){
            $query="INSERT INTO `courses`(`subject`) VALUES ('$course')";//insert on DB
            $result = mysqli_query($con,$query);
        }else{echo"<script type='text/javascript'>alert('הקורס כבר קיים במערכת');</script>";}
    }       
    if((isset($_POST['verifyPassword'])&&isset($_POST['password']))||
    isset($_POST['email'])||isset($_POST['phone'])||
    isset($_POST['first_name'])||isset($_POST['last_name'])){//this section related to ADMIN settings, upload his information as password, email, phone number, name.
        $settingsNavbar=1;//variable use to check if the ADMIN update his information for second navbar
        $adminId=211;
        $results = mysqli_query($con, "SELECT * FROM users");//connect with user table
        if($_POST['first_name']){//ADMIN update his first name
            $fName=$_POST['first_name'];//get the new information
            $upDate="UPDATE `users` SET `fname`='$fName'WHERE id=$adminId";//update on DB
            $results = mysqli_query($con,$upDate);
        }        
        if($_POST['last_name']){//ADMIN update his last name
            $lName=$_POST['last_name'];//get the new information
            $upDate="UPDATE `users` SET `lname`='$lName'WHERE id=$adminId";//update on DB
            $results = mysqli_query($con,$upDate);
        }
        if($_POST['email']){//ADMIN update his email
            $Email=$_POST['email'];//get the new information
            $upDate="UPDATE `users` SET `email`='$Email'WHERE id=$adminId";//update on DB
            $results = mysqli_query($con,$upDate);
        }
        if($_POST['phone']){//ADMIN update his phone number
            $phone=$_POST['phone'];
            $upDate="UPDATE `users` SET `phone`='$phone'WHERE id=$adminId";//update on DB
            $results = mysqli_query($con,$upDate);
        }
        if($_POST['password']){//if ADMIN update his password
            $invalidPass=-1;//variable use to check if the new user password is valid or not.
            if($_POST['password']==$_POST['verifyPassword']){//check that the insert password equal to the verify password
                $uppercase = preg_match('@[A-Z]@', $_POST["password"]);//password need to include uppercase
                $lowercase = preg_match('@[a-z]@', $_POST["password"]);//password need to include lowercase
                $number = preg_match('@[0-9]@', $_POST["password"]);//password need to include number
                if(strlen($_POST["password"])<8){//if password is less than 8 chars-->wrong
                    $invalidPass=1;
                    if(!$uppercase || !$lowercase || !$number){echo"<script type='text/javascript'>alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";}
                    else{echo"<script type='text/javascript'>alert('סיסמה קצרה מדי');</script>";}
                }elseif(strlen($_POST["password"])>16){//if the password string is bigger than 16 chars
                    $invalidPass=1;
                    if(!$uppercase || !$lowercase || !$number){echo"<script type='text/javascript'>alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";}
                    else{echo"<script type='text/javascript'>alert('סיסמה ארוכה מדי');</script>";}
                }else{
                  if(!$uppercase || !$lowercase || !$number){//a valid length of password, but it's not include uppercase or lowercase chars
                      $invalidPass=1;echo "<script type='text/javascript'>alert('הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                    }
                }
                if($invalidPass==-1){//if it's a valid password-->update it
                  $pass=$_POST['password'];
                  $upDate="UPDATE `users` SET `password`='$pass'WHERE id=$adminId";//update on DB
                  $results = mysqli_query($con,$upDate);
                }
            }
        }  
    }//get all user id's....not include admin id
    $IdResults = mysqli_query($con, "SELECT * FROM users");
    $i=0; $IdArray = array();
    while ($rows=mysqli_fetch_array($IdResults)){
        if($rows['id']!=211){/*not the admin*/$IdArray[$i]=$rows['id'];$i++;}
    }$i-=1;//we use it to know how many users there is, in this case after the loop we eill get then count of users + one, so we minus one
    
    function teacherNameFunction($id){//function used to return name
//        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $IdResults = mysqli_query($con, "SELECT * FROM users");
        while($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id){//found wanted id -> get variables to use on HTML view               
                echo"<p>".$row['fname']." ".$row['lname']."<br/></p>";//get the first and last name as a name
          }
        }
    }

    function checkUserDefineAs($ID){
       // $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
      // $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
       $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

       $resultsOfCheckUser = mysqli_query($con, "SELECT * FROM users");
        while ($rows=mysqli_fetch_array($resultsOfCheckUser)){
            if ($rows['id']==$ID && $rows['setUserAs']=='student'){
                return 1;
            }
        } 
        return -1;  
    }
    function displayFunction($arrayOfId,$relatedNumber,$returnArray,$i){
        //$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        //$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

        $j=0;$arrayIdCounter=0;
        while($j<=count($arrayOfId)&&count($arrayOfId)>0){//diplay all users
            if(1==1){//true section
                    if(checkUserDefineAs($arrayOfId[$j])==1&&$relatedNumber==14444){$j++; continue;}
                    elseif(checkUserDefineAs($arrayOfId[$j])==-1&&$relatedNumber==18888){$j++;continue;}
                if($j%3==0&&count($returnArray)>2){//for display, each three cards at the same line
                    echo'<div class="teacher col-sm-12"><hr><hr></div>';
                }
                $results=mysqli_query($con, "SELECT * FROM images");
                while($rows=mysqli_fetch_array($results)){
                    if($rows['id']==$arrayOfId[$j]){
                        $returnArray[$arrayIdCounter]=$arrayOfId[$j]+$relatedNumber;
                        $arrayIdCounter++;//insert id , forward index next
                        $id=$arrayOfId[$j]+$relatedNumber;
                        echo"<div class=\"teacher col-sm-4\" id=\"$id\"><button value=\"$id\" id=\"$id\"><input type=\"hidden\" id=\"$id\">";
                        if($rows['image']!='image'&&$rows['image']!=null){//display image
                            echo"<img src='img/".$rows['image']."'class='teacherImg img-rounded img-responsive'>";
                            teacherNameFunction($arrayOfId[$j]); //print name  
                            echo "</button></div><br><br>";
                        }
                    }
                }
            }$j++;//help with diplay as we said above.
        }return $returnArray;
    }
?>
<!DOCTYPE html>
<html>
<!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>הכיתה</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
        <link rel="stylesheet" type="text/css" href="css/AdminStyle.css">
        <style>
            .forme-group {
            margin-bottom: 1rem;
            float: right;
            margin: 1%;
            }
            @media only screen and (max-width: 960px) {
                .col-sm-3{
                width: 95%;
    margin-right: auto;
            }
          }            
        </style>
    </head>
    <body>
    <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a>
                  
                  
                  <!--

  <a class="nav-link" href="logout.php"> יציאה<span class="sr-only">(current)</span></a>
                  


                  -->
                  </li>
              </ul>
            </div>
        </nav>
    </section>
    <section class="choose">    
        <div class="row"><!--second navbar for admin, route to all user section/teachers/student/new users...-->
            <?php
                if($settingsNavbar){//admin settings
                    echo "                    
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('allUSers', this, 'blueviolet')\">לכל המשתמשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('teachers', this, 'orange')\"> מורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('students', this, 'blueviolet')\"> תלמידים</button> 
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newCC', this, 'orange')\"> הוספת עיר/מקוצע חדשים </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newUSers', this, 'blueviolet')\">   המשתמשים חדשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('madeChange', this, 'orange')\"> מי עשה שינוי </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminDetails', this, 'blueviolet')\"id=\"defaultOpen\">  פרטי המנהל </button>";
                }elseif($cityAndCourseNavbar){//new course/city
                    echo "                    
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('allUSers', this, 'blueviolet')\">לכל המשתמשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('teachers', this, 'orange')\"> מורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('students', this, 'blueviolet')\"> תלמידים</button> 
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newCC', this, 'orange')\"id=\"defaultOpen\"> הוספת עיר/מקוצע חדשים </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newUSers', this, 'blueviolet')\">   המשתמשים חדשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('madeChange', this, 'orange')\"> מי עשה שינוי </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminDetails', this, 'blueviolet')\">  פרטי המנהל </button>";
                }else{//default mode
                    echo "                    
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('allUSers', this, 'blueviolet')\"id=\"defaultOpen\">לכל המשתמשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('teachers', this, 'orange')\"> מורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('students', this, 'blueviolet')\"> תלמידים</button> 
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newCC', this, 'orange')\"> הוספת עיר/מקוצע חדשים </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newUSers', this, 'blueviolet')\">   המשתמשים חדשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('madeChange', this, 'orange')\"> מי עשה שינוי </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminDetails', this, 'blueviolet')\">  פרטי המנהל </button>";
               }
            ?>
        </div><!--next section for all users, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list-->              
        <div id="allUSers" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <?php                                
                    //$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
        
                    $allUsersArrayId=array();//array using to redirect (insert id users on array)
                    echo"<SELECT name=\"searchAllChangedUsersByName\" id=\"searchAllChangedUsersByName\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                    $results = mysqli_query($con, "SELECT * FROM users");
                    echo'<option >בחר שם</option>';
                    while($rows=mysqli_fetch_array($results)){
                        if($rows['id']!=211){echo'<option value="'.$rows['id'].'">'.$rows['fname']." ".$rows['lname'].'</option>';}           
                    }
                    echo"</SELECT><input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\"/>";
                ?>
            </div><br><hr><!--create line and down a line for display-->   
            <section class="work">
                <div class="container">
                    <div class="row">
                        <?php     
                            $allUsersArrayId=displayFunction($IdArray,155555,$allUsersArrayId,$i);     
                        ?>
                    </div>
                </div>
            </section> 
        </div><!--next section for students, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list-->                  
        <div id="students" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <?php                                
        //            $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                   // $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
                    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

                    $studentArrayId=array();
                    echo"<SELECT name=\"searchStudentByName\" id=\"searchStudentByName\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                    $results=mysqli_query($con, "SELECT * FROM users");
                    echo'<option>בחר שם</option>';
                    while($rows=mysqli_fetch_array($results)){//search student on list(search by name)
                        if($rows['id']!=211 && $rows['setUserAs']=='student'){echo'<option value="'.$rows['id'].'">'.$rows['fname']." ".$rows['lname'].'</option>';}           
                    }
                    echo"</SELECT><input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\"/>";
                ?>
            </div><br><hr>   
            <section class="work">
                <div class="container">
                    <div class="row"><!--for dsplay -->
                        <?php
                           $studentArrayId=displayFunction($IdArray,18888,$studentArrayId,$i);
                        ?>
                    </div>
                </div>
            </section> 
        </div> <!--next section for user who made changed on last month, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list-->                          
        <div id="madeChange" class="tabcontent">
            <?php
        //        $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
               // $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

                $results=mysqli_query($con, "SELECT * FROM users");
                $makeChangeEnter=mysqli_query($con, "SELECT * FROM makeChange");
                $getIdFromMakeChangeDataBaseCounter=0;$getIdFromMakeChangeDataBase=array();//array to include id's of people made changed
                while($row=mysqli_fetch_assoc($makeChangeEnter)){//insert array of related people on array  
                    $getIdFromMakeChangeDataBase[$getIdFromMakeChangeDataBaseCounter]=$row['id'];$getIdFromMakeChangeDataBaseCounter++;//insert id , forward index next
                }
                $i=0;$IdArrayChanges=array(); //last array will include the wanted id's
                while($rows=mysqli_fetch_array($results)){
                    for($j=0; $j < count($getIdFromMakeChangeDataBase); $j++){ 
                    if($rows['id']==$getIdFromMakeChangeDataBase[$j]){$IdArrayChanges[$i]=$rows['id'];$i++;/*insert id , forward index next*/}
                    }
                }$i-=1;
            ?><br><hr>
            <section class="work">
                <div class="container">
                    <div class="row">
                        <?php
                            $madeChangeIdArray=array(); //array that will include the display people
                            $madeChangeIdArray=displayFunction($IdArray,17777,$madeChangeIdArray,$i);
                        ?>
                    </div>
                </div>
            </section>
        </div><!--next section for teachers, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list-->  
        <div id="teachers" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
            <div class="col-sm-6"></div>
            <div class="col-sm-6"><!--search teach by name(show as a list of names)-->
                <?php
                    //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                   // $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
                    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

                    $teacherIdArray=array();//array teachers id
                    echo "<SELECT  name=\"searchByName\" id=\"searchByName\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                    $results=mysqli_query($con, "SELECT * FROM users");
                    echo'<option >בחר שם</option>';
                    while ($rows=mysqli_fetch_array($results)){//show every teacher
                        if($rows['id']!=211&&$rows['setUserAs']!='student'){
                            echo'<option value="'.$rows['id'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
                        }           
                    }
                    echo"</SELECT><input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\" />";
                ?>
            </div><br><hr>   
            <section class="work">
                <div class="container">
                    <div class="row">
                        <?php
                            $teacherIdArray=displayFunction($IdArray,14444,$teacherIdArray,$i);
                        ?>
                    </div>
                </div>
            </section>     
        </div><!--next section for adding a new city or a new course
        what we show here: cities/course already on DB,  adding a new-->    
        <div id="newCC" class="tabcontent">
            <form action="AdminPage.php" method="post">  
                <?php
        //            $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");                            
//                    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
                    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

                    echo'<div class="form-group"><div class="col-xs-6">';
                    echo "<SELECT class=\"form-control selectpicker\" data-live-search=\"true\">";
                    $results = mysqli_query($con, "SELECT * FROM cities");
                    echo'<option >בדוק את הערים הקימות</option>';
                    while ($rows=mysqli_fetch_array($results)){//list of cities on DB
                        echo'<option>'.$rows['cityName'].'</option>';
                    }
                    echo"</SELECT><br><br>";
                    echo'<input type="text" placeholder="הוספת עיר חדשה" name="newCity" id="newCity" required/>
                    <input type="text" placeholder="מחיקת עיר" name="deleteCity" id="deleteCity" required/></div></div><br><br>';
                    echo'<div class="form-group"><div class="col-xs-6">';
                    echo "<SELECT class=\"form-control selectpicker\" data-live-search=\"true\">";
                    $results = mysqli_query($con, "SELECT * FROM courses");
                    echo'<option >בדוק את המקצועות הקיימים  </option>';
                    while ($rows=mysqli_fetch_array($results)){//list of courses on DB
                        echo'<option>'.$rows['subject'].'</option>';
                    }
                    echo"</SELECT></div></div><br><br>";
                    echo'<input type="text" placeholder="הוספת מקצוע חדש" name="newCourse" required>';
                    echo'<input type="text" placeholder="מחיקת מקצוע " name="deleteCourse" required>
                    <fieldset> 
                        <div class="text-center">
                            <input type="submit" class="logSignButton btn btn-info btn-primary text-center"  value="שמירת שינוי">
                        </div>
                    </fieldset>';                    
                ?>
            </form> 
        </div><!--next section for new users, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list--> 
        <div id="newUSers" class="tabcontent">
            <?php
                session_start();
                $todayDate=date('Y-m-d');
                //$con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
               // $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

                $IdResults=mysqli_query($con, "SELECT * FROM users");
                $idCount=0;$newUsersIdArray = array();
                while ($rows=mysqli_fetch_array($IdResults)){
                    $creat=$rows['createAccount'];
                    $sameYear=1;
                    if(($todayDate[5]>$creat[5])&&($todayDate[6]!=($creat[6]+1))){
                        $sameYear=-1;
                    }else if($todayDate[5]==$creat[5]){
                            if($todayDate[6]>($creat[6]+1)){
                            $sameYear=-1;
                        }else{
                            if($todayDate[6]!=($creat[6]+1)){}else if($todayDate[6]!=($creat[6]+1)){
                                $sameYear=-1; 
                            }
                        }
                    }
                    for($i=0;$i<strlen($todayDate);$i++){
                        $t = substr($todayDate, $i, 1);
                        $nT = substr($creat, $i, 1);
                        if($i<5 && $t!=$nT){
                            $sameYear=-1;break;
                        }
                    }
                    if($sameYear==1){
                        $newUsersIdArray[$idCount]=$rows['id'];$idCount++;
                    }
                }    
            ?>                    
            <section class="work">
                <div class="container">
                    <div class="row">
                        <?php
                            $newUsersIdArray=displayFunction($newUsersIdArray,19999,$newUsersIdArray,$i);
                        ?>
                    </div>
                </div>
            </section>
        </div><!--next section for admin to update his information-->         
        <div id="AdminDetails" class="tabcontent">
            <?php
                $firstName=" ";$lastName=" ";$email=" ";$Phone=" ";$username=" ";$ID;//variable of admin inforamtion to display it 
        //        $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
               // $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");//include this file for calling the DB
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

                $results = mysqli_query($con, "SELECT * FROM users");
                while ($row=mysqli_fetch_assoc($results)){//get admin information from DB
                    if($row['id']=='211'){
                        $ID=$row['id'];
                        $username=$row['username'];
                        $firstName=$row['fname'];
                        $lastName=$row['lname'];
                        $email=$row['email'];
                        $Phone=$row['phone'];
                    break;
                    }
                }
            ?><hr>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12"><h1>עדכון פרטים המנהל</h1></div>
                </div>
                <div class="row">
                    <div><!--left col-->
                <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><h1><?php echo $username ?></h1></li>
                    </ul>              
                    <div class="tab-content">
                        <div class="tab-pane active" id="home"><hr>
                            <form class="form" action="AdminPage.php" method="post" id="registrationForm">                                
                                <div class="forme-group">                          
                                    <div class="col-xs-6">
                                        <label for="first_name"><h4>שם פרטי</h4></label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $firstName?>" title="enter your first name if any.">
                                    </div>
                                </div> 
                                <div class="forme-group">                          
                                    <div class="col-xs-6">
                                        <label for="last_name"><h4>שם משפחה</h4></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lastName?>" >
                                    </div>
                                </div>
                                <div class="forme-group">                         
                                    <div class="col-xs-6">
                                        <label for="phone"><h4>   מספר טלפון    </h4></label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                                    </div>
                                </div>
                                <div class="forme-group">
                                    <div class="col-xs-6">
                                        <label for="email"><h4>Email</h4></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">
                                    </div>
                                </div>  
                                <div class="forme-group">                          
                                    <div class="col-xs-6">
                                        <label for="password"><h4>סיסמה</h4></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                                    </div>
                                </div> 
                                <div class="forme-group">                          
                                    <div class="col-xs-6">
                                    <label for="verifyPassword"><h4>אימות סיסמה</h4></label>
                                        <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה">
                                    </div>
                                </div>
                                <div class="forme-group">
                                    <div class="col-xs-12"><br>
                                        <label for="Save"><h4></h4></label>
                                        <input type="submit" name="Save" value="שמור">                                                        
                                    </div>
                                </div>
                            </form>
                        </div><!--/tab-pane-->                                
                    </div><!--/tab-pane-->
                </div><!--/tab-content-->
            </div>
    </body>
</html>
<!---














check window.location.href without parameters



--->
<script>
jQuery(function ($) {//    
    var $inputs = $('input[name=newCourse],input[name=deleteCourse],input[name=newCity],input[name=deleteCity]');
    $inputs.on('input', function () {
        // Set the required property of the other input to false if this input is not empty.
        $inputs.not(this).prop('required', !$(this).val().length);
    });
});
function openPage(pageName,elmnt,color){//for the second navbar, open what user click, there is a default show section
   var i, tabcontent, tablinks;
   tabcontent = document.getElementsByClassName("tabcontent");
   for(i=0;i<tabcontent.length;i++){tabcontent[i].style.display="none";}
   tablinks = document.getElementsByClassName("tablink");
   for (i=0;i<tablinks.length;i++){tablinks[i].style.backgroundColor = "";}
   document.getElementById(pageName).style.display = "block";
   elmnt.style.backgroundColor = color;
   }        
   document.getElementById("defaultOpen").click();// Get the element with id="defaultOpen" and click on it
       var btn = $('#button');
       $(window).scroll(function() {
       if($(window).scrollTop() > 300) {btn.addClass('show');}else{btn.removeClass('show');}
       });
       btn.on('click', function(e) {
       e.preventDefault();
       $('html, body').animate({scrollTop:0}, '300');
       });
$(document).ready(function(){
    $("#searchStudentByName").on('change',function(){
    var id =$(this).val();
    if(id){window.location.href = "AdminControlPageEditOnUser.php?id=" + id;}
    });
    $("#searchByName").on('change',function(){
    var id =$(this).val();
    if(id){window.location.href = "AdminControlPageEditOnUser.php?id=" + id;}
    });
    $("#searchAllChangedUsersByName").on('change',function(){
    var id =$(this).val();
    if(id){window.location.href = "AdminControlPageEditOnUser.php?id=" + id;}
    });
});
$(document).ready(function(){
     $('.selectpicker').selectpicker();
     $('#searchByName').change(function(){
      $('#hidden_framework').val($('#searchByName').val());
     });
     $('#multiple_select_form').on('Save', function(event){
      event.preventDefault();
      if($('#searchByName').val() != ''){
       var form_data = $(this).serialize();
       var id =$(this).val();
       $.ajax({
        url:"AdminControlPageEditOnUser.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
         $('#hidden_framework').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }else{return false;
      }
     });
    });
    var teachesIdArrayLength = <?PHP echo (!empty(end($teacherIdArray)) ? json_encode(end($teacherIdArray)) : '""'); ?>;
    $(document).ready(function(){
        for(var i = 14444; i <= teachesIdArrayLength; i++){ 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function(){x-=14444;
               if(x>0){window.location.href = "AdminControlPageEditOnUser.php?id=" + x;}
            });
        }
        var studentsIdArrayLength = <?PHP echo (!empty(end($studentArrayId)) ? json_encode(end($studentArrayId)) : '""'); ?>;
        for(var i = 18888; i <= studentsIdArrayLength; i++){ 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function(){x-=18888;
                if(x>0){window.location.href = "AdminControlPageEditOnUser.php?id=" + x;}
            });
        }
        var madeChangeIdArrayLength = <?PHP echo (!empty(end($madeChangeIdArray)) ? json_encode(end($madeChangeIdArray)) : '""'); ?>;
        for(var i = 17777; i <= madeChangeIdArrayLength; i++){ 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function(){ x-=17777;
            if(x>0){window.location.href = "AdminControlPageEditOnUser.php?id=" + x;}
            });
        }
        var allUsersArrayId = <?PHP echo (!empty(end($allUsersArrayId)) ? json_encode(end($allUsersArrayId)) : '""'); ?>;
        for(var i = 155555; i <= allUsersArrayId; i++){ 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function(){                
                x-=155555;
            if(x>0){
                 window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
            }
            });
        }
        var newUsersSiteIdArray = <?PHP echo (!empty(end($newUsersSiteIdArray)) ? json_encode(end($newUsersSiteIdArray)) : '""'); ?>;
        for(var i = 19999; i <= newUsersSiteIdArray; i++){ 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function(){x-=19999;
            if(x>0){window.location.href = "AdminControlPageEditOnUser.php?id=" + x;}
            });
        }
    });
</script>