<?php
/**
 * (-)on this page admin can make many functions as like look for users(all users/teachers/students/new users/
 * add a new city or anew course/which user make changes and admin settings), send Email's for many users, check messages.
 * (-)ADMIN look for a user by choose him on list or at the display users section bellow can found him.
 * (-)the section of new user. display user with a new account less than one month.
 */
    session_start();
    $ID=$_SESSION['id'];//get the Admin id.
    $_SESSION['id']=$ID;
    if(!$ID){
        header("location: logout.php");   
    }
    include 'userData.php';//call this file to use some functions.
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        
    //delete user who has made change on his account before a month and more
    date_default_timezone_set('Asia/Jerusalem'); 
    $script_tz = date_default_timezone_get();
    $current_month=date('m');
    $madeChange = mysqli_query($con, "SELECT * FROM makeChange");
    while ($rows=mysqli_fetch_array($madeChange)){
        if($rows['dateOfChane']<$current_month){
            $deleteID=$rows['id'];
            $sql = "DELETE FROM makeChange WHERE id=$deleteID";//delete from the teacher Schedule table
            if ($con->query($sql) === TRUE){
            }
        }
    }

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
            if($con->query($sql) === TRUE){$cityDeleted=1;
                echo"<script type='text/javascript'>alert('העיר נמחקה בהצלחה  ');</script>";//delete succues 
            }
        }else{echo "אין עיר כזאת ברשימה<br>";}//when ADMIN want to delete a city that there is no city by this name
    } 

    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    
    if(isset($_POST['newCity'])&&$_POST['newCity']!=''&&$cityDeleted!=1){//this section for adding a new city to site. statring by get the name of the new city, check that's really a new city, if yes add it else not
      $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
      $city=$_POST['newCity'];//get the name of the new city
      if(SiteCities($city)==-1){
        $query="INSERT INTO `cities`(`cityName`) VALUES ('$city')";//insert on DB
        $result=mysqli_query($con,$query); 
        echo"<script type='text/javascript'>alert('העיר הוספה בהצלחה  ');</script>";//add succues
      }else{echo"<script type='text/javascript'>alert('העיר כבר קיימת במערכת');</script>";}//when ADMIN want to add anew city that there is already over city with this name
    }//delete City from DB 
    if(isset($_POST['deleteCourse'])&&$_POST['deleteCourse']!=NULL){
        $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
        $deleteCourse=$_POST['deleteCourse'];
        $resultsOfCourses=mysqli_query($con, "SELECT * FROM courses");
        while($CourseRows=mysqli_fetch_array($resultsOfCourses)){
            if(strcmp($CourseRows['subject'], $deleteCourse)==0){$courseID=$CourseRows['id'];}
        } 
        if($courseID){      
            $sql="DELETE FROM courses WHERE id=$courseID";
            if($con->query($sql) === TRUE){$courseDeleted=1;
                echo"<script type='text/javascript'>alert('הקורס נמחק בהצלחה');</script>";//delete succues 
            }else{
            echo"<script type='text/javascript'>alert('הקורס לא קיים במערכת');</script>";//delete failed            
        }
    }
    }   
    if(isset($_POST['newCourse'])&&$_POST['newCourse']!=''&&$cityDeleted!=1){//this section for adding a new city to site. statring by get the name of the new course, check that's really a new course, if yes add it else not
        $course=$_POST['newCourse'];//get the name of the new course
        $cityAndCourseNavbar=1;//variable use to check if the ADMIN update on city or course section
        if(SiteCourses($course)==-1){
            $query="INSERT INTO `courses`(`subject`) VALUES ('$course')";//insert on DB
            $result = mysqli_query($con,$query);
            echo"<script type='text/javascript'>alert('הקורס הוסף בהצלחה  ');</script>";//add succues
        }else{echo"<script type='text/javascript'>alert('הקורס כבר קיים במערכת');</script>";}//add faild
    }       
    if((isset($_POST['verifyPassword'])&&isset($_POST['password']))||
    isset($_POST['email'])||isset($_POST['phone'])||
    isset($_POST['first_name'])||isset($_POST['last_name'])){//this section related to ADMIN settings, upload his information as password, email, phone number, name.
        $settingsNavbar=1;//variable use to check if the ADMIN update his information for second navbar
        $results = mysqli_query($con, "SELECT * FROM users");//connect with user table
        if($_POST['first_name']){//ADMIN update his first name
            updateAdminFirstName(27341, $_POST['first_name']);
        }        
        if($_POST['last_name']){//ADMIN update his last name
            updateAdminLastName(27341, $_POST['last_name']);
        }
        if($_POST['email']){//ADMIN update his email
            updateAdminEmail(27341, $_POST['email']);
        }
        if($_POST['phone']){//ADMIN update his phone number
            updateAdminPhoneNumber(27341, $_POST['phone']);
        }
        if($_POST['password']){
            $invalidPass=updateAdminPassword(27341, $_POST['password'], $_POST['verifyPassword']);
        }  
    }
    
    //get all user id's....not include admin
    $IdResults = mysqli_query($con, "SELECT * FROM users");
    $i=0; $IdArray = array();
    while ($rows=mysqli_fetch_array($IdResults)){
        $IdArray[$i]=$rows['id'];$i++;
    }$i-=1;//we use it to know how many users there is, in this case after the loop we eill get then count of users + one, so we minus one
     
    if(isset($_POST['sendEmails'])){
        //check the select option value
        $to = "";//sending to email address
        $from ="HakitaSite";// from
        $kindOfUsers=$_POST['hidden_send_framework'];//for send EMAILS--->all users/teachers/students
        $subject=$_POST['emailSubject'];//subject of message
        $message=$_POST['emailInput'];        
        $headers="From:".$from."\r\n";
        $headers.="Content-type: text/html\r\n";
        $results=mysqli_query($con, "SELECT * FROM users");
        while($rows=mysqli_fetch_array($results)){
            $to=$rows['email'];
            if($kindOfUsers==0){//for all users
                mail($to,$subject,$message,$headers);
            }elseif($kindOfUsers==1&&checkUserDefineAs($rows['id'])==-1){//for teachers
                mail($to,$subject,$message,$headers);
            }elseif($kindOfUsers==2&&checkUserDefineAs($rows['id'])==1){//for students
                mail($to,$subject,$message,$headers);
            }
        }      
    }

    if(isset($_POST['trashButton'])){//delete a blog
        $blogId=$_POST['trashButton'];//id Of blog
        $sql="DELETE FROM artical WHERE  articalNumber=$blogId";
        if($con->query($sql)===TRUE){
        }              
    }

    if(isset($_POST['trashQuestionButton'])){//delete a question of how to use site
        $questionId=$_POST['trashQuestionButton'];//id Of question
        $sql="DELETE FROM questionAboutUsingSite WHERE  questionNumber=$questionId";
        if($con->query($sql)===TRUE){
        }              
    }//

    if(isset($_POST['upload'])){//add a new blog, inclue title, text, image
        $image=$_FILES['image']['name']; 
        $articalText=$_POST['blogText'];
        $text= str_replace("'", "''", $articalText);//if the blog text include {'}
        $articalTitle=$_POST['blogTitle'];
        $title= str_replace("'", "''", $articalTitle);//if the blog title include {'}
        
        $query="INSERT INTO `artical`(`articalText`,`articalTitle`,`articalImg`) VALUES 
                    ('$text','$title','$image')";
        $result = mysqli_query($con,$query);
        
        $articalNumber;
        $Results=mysqli_query($con, "SELECT * FROM artical");
        while ($row=mysqli_fetch_assoc($Results)){
            $articalNumber=$row['articalNumber'];
        }
        $target = "img/".basename($image);// image file directory
        $upDate="UPDATE `artical` SET `articalImg`='$image'WHERE articalNumber=$articalNumber";//Update user image
        $resultsOfImageTable = mysqli_query($con,$upDate);
        move_uploaded_file($_FILES['image']['tmp_name'], $target); 
    }

    if(isset($_POST['questionUpload'])){//add a new question of to use site
        $questionText=$_POST['questionText'];
        $text= str_replace("'", "''", $questionText);//if the blog text include {'}
        $questionTitle=$_POST['questionTitle'];
        $title= str_replace("'", "''", $questionTitle);//if the blog title include {'}
        
        $query="INSERT INTO `questionAboutUsingSite`(`questionTitle`,`questionAnswer`) VALUES 
                    ('$title','$text')";
        $result = mysqli_query($con,$query);
    }

?>
<!DOCTYPE html>
<html>
    <head><!--import bootstrap for (STYLE)-->
        <?php include 'header.php';?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <link rel="stylesheet" type="text/css" href="css/Admin.css"><!--some addition CSS-->
        <style>
        * {
        box-sizing: border-box;
        }

        /* Create two unequal columns that floats next to each other */
        /* Left column */
        .leftcolumn {   
        float: left;
        width: 75%;
        }

        /* Add a card effect for articles */
        .cardBlog {
        background-color: white;
        padding: 20px;
        margin-top: 20px;
        }
        .blog{
            max-width:160px;
            max-height:170px;
        }
        </style>
    </head>
    <body>
        <a id="button"></a><!--up button, on click the button will back to here this id the top of the page-->
        <section><!--navbar section-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active"><a class="nav-link" href="adminMessageRoom.php">הודעות</a></li>
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
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminDetails', this, 'blueviolet')\"id=\"defaultOpen\">  פרטי המנהל </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminSendEmails', this, 'orange')\">  שליחת מייל </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('blog', this, 'blueviolet')\">מאמרים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('famousQuestion', this, 'orange')\">שאלות נפוצות</button>";
                }elseif($cityAndCourseNavbar){//new course/city section on the main page
                    echo "                    
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('allUSers', this, 'blueviolet')\">לכל המשתמשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('teachers', this, 'orange')\"> מורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('students', this, 'blueviolet')\"> תלמידים</button> 
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newCC', this, 'orange')\"id=\"defaultOpen\"> הוספת עיר/מקוצע חדשים </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newUSers', this, 'blueviolet')\">   המשתמשים חדשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('madeChange', this, 'orange')\"> מי עשה שינוי </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminDetails', this, 'blueviolet')\">  פרטי המנהל </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminSendEmails', this, 'orange')\">שליחת מייל</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('blog', this, 'blueviolet')\">מאמרים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('famousQuestion', this, 'orange')\">שאלות נפוצות</button>";
                }else{//default mode, display the all users section on the main page
                    echo "                    
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('allUSers', this, 'blueviolet')\"id=\"defaultOpen\">לכל המשתמשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('teachers', this, 'orange')\"> מורים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('students', this, 'blueviolet')\"> תלמידים</button> 
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newCC', this, 'orange')\"> הוספת עיר/מקוצע חדשים </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('newUSers', this, 'blueviolet')\">   המשתמשים חדשים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('madeChange', this, 'orange')\"> מי עשה שינוי </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminDetails', this, 'blueviolet')\">  פרטי המנהל </button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('AdminSendEmails', this, 'orange')\">שליחת מייל</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('blog', this, 'blueviolet')\">מאמרים</button>
                    <button class=\"tablink col-sm-3\" onclick=\"openPage('famousQuestion', this, 'orange')\">שאלות נפוצות</button>";
               }
            ?>
        </div><!--next section for all users, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list, by select any user will redirect to AdminControlPage by used Jquery from script file-->              
        <div id="allUSers" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                    <?php
                        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                        echo"<SELECT name=\"frameworkAllUsers\"  id=\"frameworkAllUsers\" class=\"selectpicker\" data-live-search=\"true\">";
                        $resuls=mysqli_query($con, "SELECT * FROM users");
                        while($rows=mysqli_fetch_array($resuls)){
                            echo'<option value="'.$rows['username'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
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
                           displayPeopleFunctionOnAdminPage($IdArray,155555,$i);//call this function to display all users. function in userData file
                        ?>
                    </div>
                </div>
            </section> 
        </div><!--next section for students, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list, by select any user will redirect to AdminControlPage by used Jquery from script file-->                  
        <div id="students" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                    <?php
                        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                        echo"<SELECT name=\"frameworkStudent\"  id=\"frameworkStudent\" class=\"selectpicker\" data-live-search=\"true\">";
                        $resuls=mysqli_query($con, "SELECT * FROM users");
                        while($rows=mysqli_fetch_array($resuls)){
                            if($rows['setUserAs']=='student'){
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
                            displayPeopleFunctionOnAdminPage($IdArray,18888,$i);//call this function to display all students. function in userData file
                        ?>
                    </div>
                </div>        
            </section>
        </div>
        <div id="blog" class="tabcontent"><!--this section is for add/delete blogs-->
            <h1>הוספת מאמר חדש</h1>
            <form action="AdminPage.php" method="POST"  enctype="multipart/form-data">
                <input type="text" placeholder="כותרת המאמר" name="blogTitle" required>
                <br>
                <input type="text" placeholder="תוכן המאמר" name="blogText" required>
                <input type="hidden" name="size" value="1000000">
                <h4 class="inputImgTitle">תמונת המאמר</h4>
                <div class="chooseImg">
                    <input class="file-path validate" type="file" name="image" required>
                </div><div><br>
                    <button  class="btn btn-primary" type="submit" name="upload">הוספת מאמר </button>
                </div>
            </form>
            <hr><hr><br>
            <h1>צפות במאמרים</h1>
            <br>
            <div class="row">
                <div class="leftcolumn">
                    <?php
                        $articalResults=mysqli_query($con, "SELECT * FROM artical");
                        echo"<form action=\"AdminPage.php\" method=\"POST\">";
                        while($row=mysqli_fetch_assoc($articalResults)){
                            echo'<div class="cardBlog">';
                            echo'<button class="btn" name="trashButton" value="'.$row['articalNumber'].'" title="מחיקת מאמר"><i class="fa fa-trash"></i></button>';
                                echo'<h2 class="h2InsideCard" style="text-align:center;">'.$row['articalTitle'].'</h2>';
                                echo'<div class="divInsideCard" style="height:auto; text-align: center;"><img class="blog" src="img/'.$row['articalImg'].'"></div>';
                                echo "<p>".$row['articalText']."</p>";
                            echo'</div>';
                        }echo"</form>";
                    ?>
                </div>
            </div>
        </div>   
        
        <div id="famousQuestion" class="tabcontent"><!--add/delete question on FAQ page about site using-->
            <h1>הוספת שאלה חדשה</h1>
            <form action="AdminPage.php" method="POST">
                <input type="text" placeholder="כותרת השאלה" name="questionTitle" required>
                <br>
                <input type="text" placeholder="תוכן השאלה" name="questionText" required>
                <div>
                    <br>
                    <button  class="btn btn-primary" type="submit" name="questionUpload">הוספת שאלה </button>
                </div>
            </form>
            <hr><hr><br>
            <h1>צפות בשאלות</h1>
            <br>
            <div class="row">
                <div class="leftcolumn">
                    <?php
                        $questionsResults=mysqli_query($con, "SELECT * FROM questionAboutUsingSite");
                        echo"<form action=\"AdminPage.php\" method=\"POST\">";
                        while($row=mysqli_fetch_assoc($questionsResults)){
                            echo'<div class="cardBlog">';
                            echo'<button class="btn" name="trashQuestionButton" value="'.$row['questionNumber'].'" title="מחיקת שאלה"><i class="fa fa-trash"></i></button>';
                                echo'<h2 class="h2InsideCard" style="text-align:center;">'.$row['questionTitle'].'</h2>';
                                echo "<p>".$row['questionAnswer']."</p>";
                            echo'</div>';
                        }echo"</form>";
                    ?>
                </div>
            </div>
        </div>        
        <!--next section for user who made changed on last month, 
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
                            displayPeopleFunctionOnAdminPage($IdArrayChanges,17777,$i);//call this function to display all users made changes. function in userData file
                        ?>
                    </div>
                </div>
            </section>
        </div><!--next section for teachers, 
        on this section we can show all users on a cards include image and name. 
        can click on any card to redirect to edit on choosen card, or choos from list, by select any user will redirect to AdminControlPage by used Jquery from script file-->  
        <div id="teachers" class="tabcontent">
            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                    <?php
                        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                        echo"<SELECT name=\"frameworkTeacher\"  id=\"frameworkTeacher\" class=\"selectpicker\" data-live-search=\"true\">";
                        $resuls=mysqli_query($con, "SELECT * FROM users");
                        while($rows=mysqli_fetch_array($resuls)){
                            if($rows['setUserAs']!='student'){
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
                           displayPeopleFunctionOnAdminPage($IdArray,14444,$i);//call this function to display all teachers. function in userData file
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
                    
                    echo'<div class="form-group"><div class="col-xs-12">';
                    echo "<SELECT class=\"form-control selectpicker\" data-live-search=\"true\">";
                    $results = mysqli_query($con, "SELECT * FROM courses");
                    echo'<option>בדוק את המקצועות הקיימים  </option>';
                    while ($rows=mysqli_fetch_array($results)){//list of courses on DB
                        echo'<option>'.$rows['subject'].'</option>';
                    }echo"</SELECT></div></div><br><br><br>";
                    echo'<br><br><input type="text" placeholder="הוספת מקצוע חדש" name="newCourse" id="newCourse" required>';
                    echo'<input type="text" placeholder="מחיקת מקצוע " name="deleteCourse" id="deleteCourse" required>';
                   
                    echo'<br><br>';

                    echo'<div class="form-group"><div class="col-xs-12">';
                    echo "<SELECT class=\"form-control selectpicker\" data-live-search=\"true\">";
                    $results = mysqli_query($con, "SELECT * FROM cities");
                    echo'<option>בדוק את הערים הקימות</option>';
                    while ($rows=mysqli_fetch_array($results)){//list of cities on DB
                        echo'<option>'.$rows['cityName'].'</option>';
                    }
                    echo"</SELECT></div></div><br><br><br>";
                    echo'<br><br><input type="text" placeholder="הוספת עיר חדשה" name="newCity" id="newCity" required>';
                    echo'<input type="text" placeholder="מחיקת עיר" name="deleteCity" id="deleteCity" required>';

                    
                    echo'<fieldset> 
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
                            displayPeopleFunctionOnAdminPage($newUsersIdArray,19999,$i);//call this function to display all new users (new account less than one month). function in userData file
                        ?>
                    </div>
                </div>
            </section>
        </div><!--next section for admin to update his information-->         
        <div id="AdminDetails" class="tabcontent col-sm-12">
            <?php
                $firstName=" ";$lastName=" ";$email=" ";$Phone=" ";$username=" ";//variable of admin inforamtion to display it 
                $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                $results=mysqli_query($con, "SELECT * FROM AdminTable");
                while($row=mysqli_fetch_assoc($results)){//get admin information from DB, to display it.
                        $username=$row['username'];
                        $firstName=$row['fname'];$lastName=$row['lname'];
                        $email=$row['email'];$Phone=$row['phone'];
                    break;
                }
            ?><hr><!--update admin details-->
            <div class="container">
                <div class="row"><div class="col-sm-12"><h1>עדכון פרטים המנהל</h1></div></div>
                <div class="row">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs"><li class="active"><h1><?php echo $username ?></h1></li></ul>              
                    <div class="tab-content">
                        <div class="tab-pane active" id="home"><hr>
                            <form class="form" action="AdminPage.php" method="post" id="registrationForm">                                
                                <div class="forme-group">                          
                                    <div class="col-xs-12"><!--update admin first name-->
                                        <label for="first_name"><h4>שם פרטי</h4></label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $firstName?>" title="enter your first name">
                                    </div>
                                </div> 
                                <div class="forme-group">                          
                                    <div class="col-xs-12"><!--update admin last name-->
                                        <label for="last_name"><h4>שם משפחה</h4></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lastName?>" >
                                    </div>
                                </div>
                                <div class="forme-group">                         
                                    <div class="col-xs-12"><!--update admin phone number-->
                                        <label for="phone"><h4>   מספר טלפון    </h4></label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                                    </div>
                                </div>
                                <div class="forme-group">
                                    <div class="col-xs-12"><!--update admin email-->
                                        <label for="email"><h4>Email</h4></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">
                                    </div>
                                </div>  
                                <div class="forme-group">                          
                                    <div class="col-xs-12"><!--update admin password-->
                                        <label for="password"><h4>סיסמה</h4></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                                    </div>
                                </div> 
                                <div class="forme-group">                          
                                    <div class="col-xs-12"><!--update admin password-->
                                    <label for="verifyPassword"><h4>אימות סיסמה</h4></label>
                                        <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה">
                                    </div>
                                </div>
                                <div class="forme-group"><!--save admin details-->
                                    <div class="col-xs-12"><br>
                                        <label for="Save"><h4></h4></label>
                                        <input type="submit" name="Save" value="שמור">                                                        
                                    </div>
                                </div>
                            </form>
            </div></div></div></div></div></div>
            <!--this section let admin send email's for {all users {happy holiday for example}/ teachers {discount on user}/students {there a new subjects on site}}-->
            <div id="AdminSendEmails" class="tabcontent">
               <form class="form" action="AdminPage.php" method="post">
                    <div class="form-group col-sm-6">
                    <br><br><br><br>
                        <input name="emailSubject" type="text" placeholder="נושא המייל" class="form-control">
                            <br>
                        <input name="emailInput" type="text" placeholder="תוכן המייל" class="form-control" style="height: 100px;">
                    </div>
                    <div class="form-group col-sm-6">
                        <p >שלח מייל ל-</p>
                        <SELECT id="send_framework" class="selectpicker">
                            <option value="0">לכל המשתמשים</option>
                            <option value="1">לכל המורים</option>
                            <option value="2">לכל התלמידים</option>
                        </SELECT>                                   
                        <input type="hidden" name="hidden_send_framework" id="hidden_send_framework"/><br/>
                    </div>
                    <div id="v"><label for="Save"></label><input id="sendEmails" type="submit" name="sendEmails" value="שלח"></div>
                </form>                
            </div><!--next to div's for small screen design-->
            <div id="forSmallScreen"><br><br><br><br><br><br><br><br><br><br><br><br></div>
            <div id="forPixelScreen"><br><br><br><br><br><br><br><br><br><br><br></div>
    </body>
</html>
<?php include 'script.php';/*user script like the select list/ up button*/?>  