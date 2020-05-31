<?php
/**
 *  this file let ADMIN to update details or delete user.
 */
    session_start();
    /*start with get the user id.
      case on Admin.php there is more than one section for user {AllUser, teacher, student,..} 
      so the same user will found on more than on section, that's mean user could found on AllUser section
      and on teacher for example so we need a deffrent id for the same user. 
    */
    if($_POST['frameworkAllUsers']){//id from AllUser
      $AdminPutId=$_POST['frameworkAllUsers'];  
    }elseif($_POST['frameworkStudent']){//id from students
      $AdminPutId=$_POST['frameworkStudent'];  
    }elseif($_POST['frameworkTeacher']){//id from teacher
      $AdminPutId=$_POST['frameworkTeacher']; 
    }elseif($_POST['user']){//id from AllUser
    $AdminPutId=$_POST['user'];
  }elseif($_POST['id']){//id from AllUser
    $AdminPutId=$_POST['id'];
  }

  //DB connection
  $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
  //if we get an username, case on AdminPage the same user will display on alluser and on other section so we cant use the same id for same person as a different persons
  if(is_string($AdminPutId)){
    $getUserID=mysqli_query($con, "SELECT * FROM users");
    while($row=mysqli_fetch_assoc($getUserID)){
        if($row['username']==$AdminPutId){
          $AdminPutId=$row['id'];
        break;
        }
    }
  }
  include 'userData.php';//call userData file, to use function like update password,...
  // if the admin update password/ email/ name/ phone number / courses/ cities of user. function of userData file.
  if((isset($_POST['verifyPassword'])&&isset($_POST['password']))||
    isset($_POST['email'])||isset($_POST['phone'])||isset($_POST['price'])||isset($_POST['status'])||
    isset($_POST['first_name'])||isset($_POST['last_name'])||
    isset($_POST['hidden_framework'])||isset($_POST['hidden_framework_courses']))
  {
      if($_POST['first_name']){//if ADMIN update user first name
        updateFirstName($AdminPutId, $_POST['first_name']); 
      }        
      if($_POST['last_name']){//if ADMIN update user last name
        updateLastName($AdminPutId, $_POST['last_name']);
      }        
      if($_POST['price']){//if ADMIN update user min price
        updatePrice($AdminPutId,$_POST['price']);//new price 
      }         
      if($_POST['priceTwo']){//if user update his max price.
        updatePriceTwo($ID,$_POST['priceTwo']);//new price            
      }       
      if($_POST['status']){//if ADMIN update user status
        updateStatus($AdminPutId,$_POST['status']);//new status  
      }
      if($_POST['email']){//if ADMIN update user email
        updateEmail($AdminPutId, $_POST['email']);
      }        
      if($_POST['password']){//if ADMIN update user password
        $invalidPass=Password($AdminPutId, $_POST['password'], $_POST['verifyPassword']);
      }
      if($_POST['phone']){//if ADMIN update user phone
          updatePhoneNumber($AdminPutId, $_POST['phone']);
      }  
      if($_POST['phoneTwo']){//if admin update user second phone number
        updatePhoneNumberTwo($ID, $_POST['phoneTwo']);
      } 
      if($_POST['hidden_framework']){//if ADMIN update teacher cities
        $Cities=$_POST['hidden_framework'];
        $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$AdminPutId";//update it on table
        $result=mysqli_query($con,$upDate);
      } 
      if ($_POST['hidden_framework_courses']){// if ADMIN update teacher courses
        $Courses=$_POST['hidden_framework_courses']; 
        $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$AdminPutId";//update it on table
        $result=mysqli_query($con,$upDate);
      }
  }
  if(isset($_POST['changeFromStudentAccountToTeacherAccount'])){//ADMIN going to change student account to teacher account
    $results=mysqli_query($con, "SELECT * FROM users");
    $upDate="UPDATE `users` SET `setUserAs`='teacher'WHERE id=$AdminPutId";//update it on table
    $results=mysqli_query($con,$upDate);
  }
  if(isset($_POST['deleteUserButton'])){//ADMIN going to delete the choosen user
    $deleteUserId=$_POST['id'];//get the ID of user to delete
    DeleteAccount($deleteUserId);unset($deleteUserId);
    header('location: AdminPage.php');
  }    

  //admin going to start a message with user
  if(isset($_POST['sendMessageUserButton'])){     
     $message_date = date("y-m-d h:i");
     $message_text='';
     $query="INSERT INTO `messages`(`message_sender`,`message_receive`,`message_text`,`message_date`) VALUES
     ('211',' $AdminPutId','$message_text','$message_date')";
     $messageResults = mysqli_query($con,$query);
 
     $_SESSION['id']=211;//redirect to admin message room chat
     header("Location: adminMessageRoom.php");
  } 

  if ($_POST['ImgId']){ // any changed on user IMAGE
    $image=$_FILES['image']['name'];
    updateImage($AdminPutId, $image,$_POST['image_text']);
  }  
  $username=($_GET['ImgUsername']) ? $_GET['ImgUsername'] : $_POST['ImgUsername'];
  $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
  $results=mysqli_query($db, "SELECT * FROM users");
  //varibale use to display user information for ADMIN 
  $firstName=" ";$lastName=" ";$price=" ";$status=" ";$username=" ";$maxPrice;
  while($row=mysqli_fetch_assoc($results)){//get the details from teachers table
    if($row['id']==$AdminPutId){
      $username=$row['username'];
      $firstName=$row['fname'];$lastName=$row['lname'];      
      $price=$row['price'];$maxPrice=$row['priceTwo'];
      $status=$row['status'];
    break;
    }
  }
  $_SESSION['varname']=$username;
?>
<!DOCTYPE html>
<html>
  <head><!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <title>הכיתה</title>
    <meta charset="utf-8">
    <?php include_once 'header.php';?>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/AdminControlPageEditOnUser.css">
  </head>
  <body>
  <section><!--navbar section// for login user and unlogin user-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>  
                <a class="navbar-brand" href=""></a>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="AdminPage.php">חזרה לעמוד המנהל</a></li>
                            <li class="nav-item active"><a class="nav-link" href="logout.php"> יציאה</a></li>
                            
                    </ul>
                </div>
            </nav>
        </section>
  <hr>
    <div class="container bootstrap snippet">
      <div class="row"><!--next section related to let ADMIN to update user information-->
        <div class="col-sm-10"><h1>עדכון פרטים <?php echo $username ?></h1></div>
          <div class="col-sm-2">
          <a href="/users" class="pull-right">
            <?php
              echo "<img id=\"img-circle\" src='img/".Image($AdminPutId)."'   class='img-circle img-responsive'>";
            ?>
          </a>
        </div>
      </div>
      <div class="row">
        <div>            
          <div class="col-sm-9">
            <ul class="nav nav-tabs"><!--print username of user--></ul>              
            <div class="tab-content">
              <div class="tab-pane active" id="home"><hr>
                    <form class="form" action="AdminControlPageEditOnUser.php" method="post" id="registrationForm">
                        <div class="form-group"><!--hidden username use on update-->
                          <div class="col-xs-12"><label for="user_name"></label><input type="hidden" class="form-control" name="username" value="<?php echo $username?>"></div>
                        </div>
                        <div class="form-group"><!--hidden id use on update-->
                          <div class="col-xs-12"><label for="id"></label><input type="hidden" class="form-control" name="id" value="<?php echo $AdminPutId?>"></div>
                        </div>
                        <div class="form-group">                          
                          <div class="col-xs-6">
                            <label for="last_name"><h4>שם משפחה</h4></label><!--lable use to  update last_name-->
                              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lastName?>" >
                          </div>
                        </div>
                        <div class="form-group">                          
                          <div class="col-xs-6">
                            <label for="first_name"><h4>שם פרטי</h4></label><!--lable use to  update first_name-->
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $firstName?>">
                          </div>
                        </div> 
                        <div class="form-group">                         
                          <div class="col-xs-6">
                            <label for="phone"><h4>מספר טלפון</h4></label><!--lable use to  update phone-->
                            <input type="text" class="form-control" name="phoneTwo" id="phoneTwo" placeholder="<?php echo phoneNumber($AdminPutId)?>">
                          </div>
                        </div>
                        <div class="form-group">                         
                          <div class="col-xs-6">
                            <label for="phone"><h4>מספר טלפון</h4></label><!--lable use to  update phone-->
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo phoneNumber($AdminPutId)?>">
                          </div>
                        </div>                        
                        <div class="form-group">
                          <div class="col-xs-6">
                            <label for="mobile"><h4>סטטוס</h4></label>
                            <input type="text" class="form-control" name="status" id="status" placeholder="<?php echo $status?>" >
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-6">
                            <label for="email"><h4>Email</h4></label><!--lable use to  update email-->
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo email($AdminPutId)?>">
                          </div>
                        </div>
                          <?php
                            if(checkUserDefineAs($AdminPutId)==-1){//display just for teahers account <!---lable use to  update status and price-->
                              echo"<div class=\"form-group\"><div class=\"col-xs-12\"><label for=\"price\"><h4>מחיר לשעה</h4></label><input type=\"text\" class=\"form-control\" name=\"price\" placeholder=\" $price\"></div></div>";
                            }
                          ?>
                          <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="verifyPassword"><h4>אימות סיסמה</h4></label><!--lable use to  update password-->
                                <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה">
                            </div>
                          </div>  
                          <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="password"><h4> סיסמה חדשה</h4></label><!--lable use to  update password-->
                              <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                            </div>
                          </div> 
                          <?php
                            if(checkUserDefineAs($AdminPutId)==-1){//display just for teahers account
                              echo'<div class="form-group">
                                <div class="col-xs-6">
                                  <div style=" padding-top: 2%;">  עירים ';
                                    echo "<SELECT name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple>";
                                    $results = mysqli_query($con, "SELECT * FROM cities");
                                    echo'<option >'.'בדוק את הערים הקימות'.'</option>';
                                    while ($rows=mysqli_fetch_array($results)){
                                        echo'<option>'.$rows['cityName'].'</option>';
                                    }
                                    echo"</SELECT><br/><br/>
                                    <input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\" />                                 
                                    <br/></div></div></div>
                                    <div class=\"form-group\">
                                    <div class=\"col-xs-6\">
                                    <div style=\" padding-top: 2%;\"> קורסים";  
                                      echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\" class=\"form-control selectpicker\" data-live-search=\"true\" multiple>";
                                      $results = mysqli_query($con, "SELECT * FROM courses");
                                      echo'<option >'.'קורסים שמלמד'.'</option>';
                                      while ($rows=mysqli_fetch_array($results)){
                                          echo'<option>'.$rows['subject'].'</option>';
                                      }
                                      echo"</SELECT><br/><br/>";
                                      echo"<input type=\"hidden\" name=\"hidden_framework_courses\" id=\"hidden_framework_courses\"/>                 
                                <br/></div></div></div>";                           
                              }
                          ?>         
                      <div class="form-group"><!--save button-->
                        <div class="col-xs-12"><br>
                          <label for="Save"></label><input type="submit" name="Save" value="שמור">                              
                        </div>
                      </div>
                  </form>
            </div></div></div><!--update user image-->
            <div class="col-sm-3">
              <form method="POST" action="AdminControlPageEditOnUser.php" enctype="multipart/form-data">
                  <input type="hidden" class="form-control" name="ImgUsername" value="<?php echo $username?>">
                  <input type="hidden" class="form-control" name="ImgId">
                  <input type="hidden" name="size" value="1000000"><hr><hr>
                  <h4>צרף תמונה חדשה....</h4>
                  <div class="chooseImg"><input class="file-path validate" type="file" name="image"></div>
                  <div><button type="submit" name="upload">שמור תמונה</button></div>
              </form><br><br>
              <!--start a message with user-->
              <form method="POST" action="AdminControlPageEditOnUser.php" enctype="multipart/form-data">
                <button name="sendMessageUserButton" class="btn btn-info">שלח הודעה למשתמש </button>
                <div class="form-group">
                    <div class="col-xs-12"><label for="id"></label>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $AdminPutId?>">
                    </div></div>
            </form><br><br>
            <!--delete user account-->
            <form method="POST" action="AdminControlPageEditOnUser.php" enctype="multipart/form-data">
                <button name="deleteUserButton" class="btn btn-danger">מחק משתמש</button>
                <div class="form-group">
                    <div class="col-xs-12"><label for="id"></label>
                        <input type="hidden" class="form-control" name="id"value="<?php echo $AdminPutId?>">
                    </div></div>
            </form><br><br>
            <?php
              if(checkUserDefineAs($AdminPutId)==1){//for students, change account to teacher account.
                echo"<form method=\"POST\" action=\"AdminControlPageEditOnUser.php\" enctype=\"multipart/form-data\">
                  <button name=\"changeFromStudentAccountToTeacherAccount\" class=\"btn btn-warning\"> שינוי לחשבון של מורה</button>
                  <div class=\"form-group\"><br><br>
                      <div class=\"col-xs-12\"><label for=\"id\"></label>
                          <input type=\"hidden\" class=\"form-control\" name=\"id\" value=\"$ID\">
                      </div>
                  </div>
                </form>";
              }
            ?>
          </div>
      </div>  
    </div>
  </body>
</html>
<?php include 'script.php';/*call some function, like up button, select for list of courses for teachers,...*/?>