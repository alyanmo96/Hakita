<?php
/**
 * (-)on this page admin can make many functions as look for users(all users/teachers/students/new users/
 * add a new city or anew course/which user make changes and admin settings).
 * (-)ADMIN look for a user by choose him on list or at the display users section bellow can found him.
 * (-)the section of new user. display user with a new account less than one month.
 */
    session_start();
    include 'userData.php';//call this file to use some functions.

    function SiteCities($city){//function to check if admin going to insert a city that is already on DB or not
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
        }else{echo "אין עיר כזאת ברשימה<br>";}//when ADMIN want to delete a city that there is no city by this name
    } 
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    if(isset($_POST['newCity'])&&$cityDeleted!=1){//this section for adding a new city to site. statring by get the name of the new city, check that's really a new city, if yes add it else not
      $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
      $city=$_POST['newCity'];//get the name of the new city
      if(SiteCities($city)==-1){
        $query="INSERT INTO `cities`(`cityName`) VALUES ('$city')";//insert on DB
        $result=mysqli_query($con,$query); 
      }else{echo"<script type='text/javascript'>alert('העיר כבר קיימת במערכת');</script>";}//when ADMIN want to add anew city that there is already over city with this name
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
            updateFirstName($adminId, $_POST['first_name']);
        }        
        if($_POST['last_name']){//ADMIN update his last name
            updateLastName($adminId, $_POST['last_name']);
        }
        if($_POST['email']){//ADMIN update his email
            updateEmail($adminId, $_POST['email']);
        }
        if($_POST['phone']){//ADMIN update his phone number
            updatePhoneNumber($adminId, $_POST['phone']);
        }
        if($_POST['password']){
            $invalidPass=Password($adminId, $_POST['password'], $_POST['verifyPassword']);
        }  
    }//get all user id's....not include admin id
    $IdResults = mysqli_query($con, "SELECT * FROM users");
    $i=0; $IdArray = array();
    while ($rows=mysqli_fetch_array($IdResults)){
        if($rows['id']!=211){/*not the admin*/$IdArray[$i]=$rows['id'];$i++;}
    }$i-=1;//we use it to know how many users there is, in this case after the loop we eill get then count of users + one, so we minus one
    
    function displayFunction($arrayOfId,$relatedNumber,$i){
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $j=0;$arrayIdCounter=0;
        echo'<div class="teacher col-sm-12">';
        echo"<form id=\"fform\"  class=\"col-sm-12\" method=\"post\" action=\"AdminControlPageEditOnUser.php\">";
        while($j<count($arrayOfId)&&count($arrayOfId)>0){//diplay all users
            if(1==1){//true section
                    if(checkUserDefineAs($arrayOfId[$j])==1&&$relatedNumber==14444){$j++; continue;}
                    elseif(checkUserDefineAs($arrayOfId[$j])==-1&&$relatedNumber==18888){$j++;continue;}
                
                $results=mysqli_query($con, "SELECT * FROM images");
                while($rows=mysqli_fetch_array($results)){
                    if($rows['id']==$arrayOfId[$j]){
                        echo"<div class=\"col-sm-4\">
                        <button name=\"user\" value=\"$arrayOfId[$j]\">";
                        if($rows['image']!='image'&&$rows['image']!=null){//display image
                            echo"<img src='img/".$rows['image']."'class='teacherImg img-rounded img-responsive'>";
                            echo"<p>".name($arrayOfId[$j])."</p>";//print name
                            echo"</button></div>";
                        }
                    }
                }
            }$j++;//help with diplay as we said above.
        }
        echo"</form>";
        echo'</div>';
    }
?>
<!DOCTYPE html>
<html>
    <head><!--import bootstrap for (STYLE)-->
        <?php include 'header.php';?>
        <link rel="stylesheet" type="text/css" href="css/AdminStyle.css">
    </head>
    <body>
    <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה<span class="sr-only"></span></a></li>
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
                }elseif($cityAndCourseNavbar){//new course/city section on the main page
                    echo "                    
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('allUSers', this, 'blueviolet')\">לכל המשתמשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('teachers', this, 'orange')\"> מורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('students', this, 'blueviolet')\"> תלמידים</button> 
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newCC', this, 'orange')\"id=\"defaultOpen\"> הוספת עיר/מקוצע חדשים </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newUSers', this, 'blueviolet')\">   המשתמשים חדשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('madeChange', this, 'orange')\"> מי עשה שינוי </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminDetails', this, 'blueviolet')\">  פרטי המנהל </button>";
                }else{//default mode, display the all users section on the main page
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
                <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                    <?php
                        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                        echo"<SELECT name=\"frameworkAllUsers\"  id=\"frameworkAllUsers\" class=\"selectpicker\" data-live-search=\"true\">";
                        $resuls=mysqli_query($con, "SELECT * FROM users");
                        while($rows=mysqli_fetch_array($resuls)){
                            if($rows['id']!=211){
                                echo'<option value="'.$rows['username'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
                            }
                        }echo"</SELECT>";
                    ?>                                      
                    <input type="hidden" name="hidden_framework_allUsers" id="hidden_framework_allUsers"/><br/>
                    <label for="Save"></label><input id="searchButton" type="submit" name="Save" value="עדכן">
                </form>
            <br><hr><!--create line and down a line for display-->   
            <section class="work">
                <div class="container">
                    <div class="row">
                        <?php     
                           displayFunction($IdArray,155555,$i);//call this function to display all users
                        ?>
                    </div>
                </div>
            </section> 
        </div><!--next section for students, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list-->                  
        <div id="students" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                    <?php
                        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                        echo"<SELECT name=\"frameworkStudent\"  id=\"frameworkStudent\" class=\"selectpicker\" data-live-search=\"true\">";
                        $resuls=mysqli_query($con, "SELECT * FROM users");
                        while($rows=mysqli_fetch_array($resuls)){
                            if($rows['id']!=211&& $rows['setUserAs']=='student'){
                                echo'<option value="'.$rows['username'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
                            }
                        }echo"</SELECT>";
                    ?>                                      
                    <input type="hidden" name="hidden_framework_student" id="hidden_framework_student"/><br/>
                    <label for="Save"></label><input id="searchButton" type="submit" name="Save" value="עדכן">
                </form><br><hr>   
            <section class="work">
                <div class="container">
                    <div class="row"><!--for display -->
                        <?php
                            displayFunction($IdArray,18888,$i);//call this function to display all students
                        ?>
                    </div>
                </div>        
            </section>
        </div> <!--next section for user who made changed on last month, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list-->                          
        <div id="madeChange" class="tabcontent">
            <?php
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                $results=mysqli_query($con, "SELECT * FROM users");
                $makeChangeEnter=mysqli_query($con, "SELECT * FROM makeChange");
                $getIdFromMakeChangeDataBaseCounter=0;$getIdFromMakeChangeDataBase=array();//array to include id's of people made changed
                while($row=mysqli_fetch_assoc($makeChangeEnter)){//insert array of related people on array  
                    $getIdFromMakeChangeDataBase[$getIdFromMakeChangeDataBaseCounter]=$row['id'];$getIdFromMakeChangeDataBaseCounter++;//insert id , forward index next
                }
                $i=0;$IdArrayChanges=array();//last array will include the wanted id's
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
                            displayFunction($IdArray,17777,$i);//call this function to display all users made changes
                        ?>
                    </div>
                </div>
            </section>
        </div><!--next section for teachers, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list-->  
        <div id="teachers" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                    <?php
                        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                        echo"<SELECT name=\"frameworkTeacher\"  id=\"frameworkTeacher\" class=\"selectpicker\" data-live-search=\"true\">";
                        $resuls=mysqli_query($con, "SELECT * FROM users");
                        while($rows=mysqli_fetch_array($resuls)){
                            if($rows['id']!=211&&$rows['setUserAs']!='student'){
                                echo'<option value="'.$rows['username'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
                            }
                        }echo"</SELECT>";
                    ?>                                      
                    <input type="hidden" name="hidden_framework_teacher" id="hidden_framework_teacher"/><br/>
                    <label for="Save"></label><input id="searchButton" type="submit" name="Save" value="עדכן">
                </form><br><hr>   
            <section class="work">
                <div class="container">
                    <div class="row">
                        <?php
                           displayFunction($IdArray,14444,$i);//call this function to display all teachers
                        ?>
                    </div>
                </div>
            </section>     
        </div><!--next section for adding a new city or a new course
        what we show here: cities/course already on DB,  adding a new-->    
        <div id="newCC" class="tabcontent">
            <form action="AdminPage.php" method="post">  
                <?php
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
                    }echo"</SELECT></div></div><br><br>";
                    echo'<input type="text" placeholder="הוספת מקצוע חדש" name="newCourse" required>';
                    echo'<input type="text" placeholder="מחיקת מקצוע " name="deleteCourse" required>
                    <fieldset> 
                        <div class="text-center"><input type="submit" class="logSignButton btn btn-info btn-primary text-center"  value="שמירת שינוי"></div>
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
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                $IdResults=mysqli_query($con, "SELECT * FROM users");
                $idCount=0;$newUsersIdArray = array();
                while($rows=mysqli_fetch_array($IdResults)){
                    $creat=$rows['createAccount'];
                    $sameYear=1;
                    if(($todayDate[5]>$creat[5])&&($todayDate[6]!=($creat[6]+1))){
                        $sameYear=-1;
                    }elseif($todayDate[5]==$creat[5]){
                            if($todayDate[6]>($creat[6]+1)){
                            $sameYear=-1;
                        }else{
                            if($todayDate[6]!=($creat[6]+1)){}else if($todayDate[6]!=($creat[6]+1)){
                                $sameYear=-1; 
                            }
                        }
                    }
                    for($i=0;$i<strlen($todayDate);$i++){
                        $t=substr($todayDate,$i,1);
                        $nT=substr($creat,$i,1);
                        if($i<5&&$t!=$nT){
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
                            displayFunction($newUsersIdArray,19999,$i);//call this function to display all new users (new account less than one month)
                        ?>
                    </div>
                </div>
            </section>
        </div><!--next section for admin to update his information-->         
        <div id="AdminDetails" class="tabcontent">
            <?php
                $firstName=" ";$lastName=" ";$email=" ";$Phone=" ";$username=" ";$ID;//variable of admin inforamtion to display it 
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                $results=mysqli_query($con, "SELECT * FROM users");
                while($row=mysqli_fetch_assoc($results)){//get admin information from DB, to display it.
                    if($row['id']=='211'){
                        $ID=$row['id'];
                        $username=$row['username'];
                        $firstName=$row['fname'];$lastName=$row['lname'];
                        $email=$row['email'];$Phone=$row['phone'];
                    break;
                    }
                }
            ?><hr>
            <div class="container">
                <div class="row"><div class="col-sm-12"><h1>עדכון פרטים המנהל</h1></div></div>
                <div class="row">
                    <div><!--left col-->
                <div class="col-sm-12">
                    <ul class="nav nav-tabs"><li class="active"><h1><?php echo $username ?></h1></li></ul>              
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
            </div></div></div></div>
    </body>
</html>
<?php include 'script.php';/*user script like the select list/ up button*/?>  