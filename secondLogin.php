<?php
/*continue sign up page to get more details about the new user, like first/last name,
 email address, phone number, gender to insert a defaul image user, student or teachers.  
*/
  session_start();
  include 'userData.php';//calling userData to use some function like updatePhoneNumber function and more...

  if(isset($_POST['first_name'])||isset($_POST['last_name'])){
    $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $resultsOfTeachers = mysqli_query($db, "SELECT * FROM users");
    $ID=0;$username=" ";    
    while($row=mysqli_fetch_assoc($resultsOfTeachers)){//get the new user id and username for the new account,case it's the newest id, it's goning to be the last one.
      $ID=$row['id'];$username=$row['username'];
    }// create a new Tables and enter the new user temporary detaile
    $query="INSERT INTO `images`(`image`,`text`,`id`) VALUES ('image','text','$ID')";
    $result = mysqli_query($db,$query);
    //next variables that what user insert, for save it on DB
    $first_name=$_POST['first_name'];$last_name=$_POST['last_name'];
    $email=$_POST['email'];$PHONE=$_POST['phone'];
    $gender=$_POST['frameworkGender'];
    $studentOrTeacher=$_POST['frameworkstudentOrTeacher'];      
    // enter the new information like (first name, last name, email address,etc...)
    //before that page we insert a temporary information, so here we need to update the new information
    updateFirstName($ID, $first_name);
    updateLastName($ID, $last_name);
    $updateEmail=updateEmail($ID, $email);
    if($gender!='male'){//the defaul gender for user is male, this going to user for the default image of user  
      $ImgSource="womanDefaultImage.png";//female account, update his image also
    }else{//male account, update his image also
      $ImgSource="manDefaultImage.png";
    }
    UpdateGender($ID, $gender);//update the user gender
    updateImage($ID, $ImgSource,'text');//update the user default image (male or female)
    if($studentOrTeacher!='teacher'){//create account for user as a student
    }else{//create account for user as a teacher
      $query="INSERT INTO `teachers_courses`(`id`,`subject`) VALUES ('$ID','subject')";
      $result = mysqli_query($db,$query);
      $query="INSERT INTO `teacher_cities`(`id`,`cities`) VALUES ('$ID','cities')";
      $result = mysqli_query($db,$query);
      $query="INSERT INTO `shareTable`(`id`,`facebook`,`linkedin`,`youtube`,`firstOtherLink`,`secondOtherLink`) VALUES ('$ID','facebook','linkedin','youtube','firstOtherLink','secondOtherLink')";
      $result = mysqli_query($db,$query);
    }
    setUserAs($ID,$studentOrTeacher);//update user as a teacher or a student
    updatePhoneNumber($ID, $PHONE);//update the user phone number
    $_SESSION['id']=$ID;
    if($username=="AdminEliEssiak"){// login of admin (need to change that)
      header('location: AdminControlPage.php');
    }else{// sredirect to user page
      //send Email for the new user
      $to = $email;//sending to email address
      $from ="HakitaSite";// from
      date_default_timezone_set('Asia/Jerusalem');  
      $script_tz = date_default_timezone_get();
      $date=date("Y-m-d"); $hour = date('H:i');//today date + current hour ...to invalid the URL after hour of sending time
      $subject="משתמש חדש באתר הכיתה";//subject of message
      $message="<p>שלום </p>";
      $message.=$first_name;
      $message.="<br>";
      $message.="<p>ברכות על הצטרפותך למשפחת אתר הכיתה </p>";
      $headers="From:".$from."\r\n";
      $headers.="Content-type: text/html\r\n";
      if(mail($to,$subject,$message,$headers)){
      }else{//if there any connection problem
        echo "בעית תקשורת בשליחת ההודעה למייל";
        echo "<script type='text/javascript'>alert('בעית תקשורת בשליחת ההודעה למייל');</script>";
      }
      if( $studentOrTeacher=='teacher'){//teacher page
        header("Location: profile.php");
      }else{//student page
        header("Location: studentProfile.php");
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <?php include 'header.php';?>
    <link rel="stylesheet" type="text/css" href="css/secondLogin.css">
  </head>
  <body>
    <a id="button"></a><!--up button{will display after down to 300 px and more}-->
    <div class="container bootstrap snippet">
      <div class="row">
        <h1 id="title">נא למלא את הפרטים למטה</h1><!--title-->
        <div class="row col-sm-12"></hr><br></div>
          <div class="col-sm-12"><!--display username-->
              <ul class="nav nav-tabs"><li class="active"></li></ul>              
              <div class="tab-content col-sm-3"><!--some information for the user {user can update his details later}-->
                <h5 id="titleOfCanChangeInformations"><p>***ניתן יהיה לשנות את כל הפרטים אחר כך***</p></h5>
                <p>  שתי השדות של שם פרטי ושם משפחה להציג אותך כמשתמש בהודעות. במידה והחשבון הוגדר כמורה ניתן יהיה למצוא אותך בתוצאות החיפוש</p>
                <p>מספר הטלפון כך לצור איתך קשר, לכנס לחשבון, להחזיר סיסמה.</p>
                <p> הגדרת המשתמש כ-תלמיד לא תיתן את האפשרות לחפש אותך ב- (חיפוש מורה)</p>
                <p> במידה והחשבון הוגדר כתלמיד/ה. תהיה אפשרות לשנות לחשבון של כמורה </p>
              </div>
              <div class="tab-content col-sm-9">
                <div class="tab-pane active" id="home"><hr>
                  <form class="form" action="secondLogin.php" method="post" id="registrationForm">                   
                    <div class="form-group"> <!--lable for first_name-->
                      <div class="col-sm-12">
                          <label for="first_name"><h4 class="inputWords">שם פרטי</h4></label>
                          <input type="text" class="inputWordsInside form-control" name="first_name" id="first_name" placeholder="שם פרטי" title="שם פרטי" required>
                      </div>
                    </div>
                    <div class="form-group">    <!--lable for last_name-->                      
                        <div class="col-sm-12">
                          <label for="last_name"><h4 class="inputWords">שם משפחה</h4></label>
                          <input type="text" class="inputWordsInside form-control" name="last_name" id="last_name"placeholder="שם משפחה" required>
                        </div>
                    </div>             
                    <div class="form-group"> <!--lable for phone-->                        
                      <div class="col-sm-12">
                        <label for="phone"><h4 class="inputWords">מספר טלפון</h4></label>
                        <input type="text" class="inputWordsInside form-control" name="phone" id="phone" placeholder="מספר טלפון" required>
                      </div>
                    </div>  
                    <div class="form-group"><!--lable for Email-->
                      <div class="email col-sm-12">
                        <label for="email"><h4 class="inputWords">Email</h4></label>
                      <?php
                        if($updateEmail==-1){                          
                          echo' <input type="email" class="inputWordsInside form-control  border-danger" name="email" id="email" placeholder="המייל כבר רשום במערכת" title="דואר אלקטרוני"required>';
                        }else{
                          echo' <input type="email" class="inputWordsInside form-control" name="email" id="email" placeholder="your.email@email.com" title="דואר אלקטרוני"required>';
                        }
                      ?>
                      </div>
                    </div>
                    <div class="form-group"><!--lable for define the account of user as a teacher or a student-->
                      <div class="col-sm-12">
                          <label for="studentOrTeacher"><h4 class="inputWords">משתמש באתר מוגדר כ-</h4></label>
                              <select name="frameworkstudentOrTeacher" id="frameworkstudentOrTeacher" class="form-control selectpicke" data-live-search="true" >
                                <option class="c" value="teacher">מורה</option>
                                <option class="c" value="student">תלמיד/ה</option>
                              </select><br/><br/>
                          <input type="hidden" name="hidden_framework_studentOrTeacher" id="hidden_framework_studentOrTeacher"/>
                      </div>
                    </div>   
                    <div class="form-group"><!--lable fordefine the account of user as a male or a female-->
                      <div class="col-sm-12">
                          <label for="gender"><h4 class="inputWords">מין</h4></label>
                              <select name="frameworkGender" id="frameworkGender" class="form-control selectpicke"  data-live-search="true" >
                                  <option class="c" value="male">זכר</option>
                                  <option class="c" value="female">נקבה</option>
                                  <option class="c" value="male">אחר</option>
                                </select><br/><br/>
                          <input type="hidden" name="hidden_framework_gender" id="hidden_framework_gender"/>
                      </div>
                    </div>   
                    <div class="form-group"><!--save button-->
                      <div class="col-xs-12"><br>
                        <label for="Save"></label>
                        <input id="saveButton" type="submit" name="Save" value="שמור והמשך">
                      </div>
                    </div>
                  </form>
      </div></div></div></div></div>
  </body>
</html>
<?php include 'script.php';/*some scripts like up button, select form list*/?>                                             