<?php
/**
 *on this page  after check the validate of the URL, user have to insert the new password and confirm it.
 * we check the valid of the password. if there is some wrong with that return a message, 
 * else rediredt to user profile. 
 */
session_start();
//get the local time, case on sending message to mail we use the local time here also we need to check that, for check the validete of the URL
    date_default_timezone_set('Asia/Jerusalem');  
    $script_tz = date_default_timezone_get();
    $date=date("Y-m-d"); $hour = date('H:i');
    $time=$_GET['time'];  $EMAIL= $_GET['email'];

    include 'userData.php';//call userData.php for the check validate of password

    $validUrl=-1;
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $resultOfValidPassOnPast = mysqli_query($con, "SELECT * FROM invailedPassword");
    while($resultRowOFValidPass=mysqli_fetch_assoc($resultOfValidPassOnPast)){//go through table to check if there any old wrong insert
        if(($resultRowOFValidPass['hourOfEnterPass']+1) >= $hour&& $resultRowOFValidPass['email']==$EMAIL){//found any row on table
          $ID=$resultRowOFValidPass['id'];
          $validUrl=1;break;
        }
    }
    if(isset($_POST["Password"])){//check the password valide
      $validUrl=1;
      $invalidPass=Password($ID, $_POST['Password'], $_POST['confirmPassword']);
      if($invalidPass==-1){
        $_SESSION['id']=$ID;//used on redirect to user profile
        if(checkUserDefineAs($ID)==-1){
           header("location: profile.php");//redirect to teacher profile
        }
        elseif(checkUserDefineAs($ID)==1){
          header("location: studentProfile.php");//redirect to student profile
        }else{
          header("location: AdminPage.php");//redirect to ADMIN
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:700,900" rel="stylesheet">
    <link rel="stylesheet" href="css/form-elements.css">
    <link rel="stylesheet" href="css/forgetStyle.css">
    <link type="text/css" rel="stylesheet" href="css/notFoundStyle.css"/>
  </head>
  <body><!--next section{the HTML display has two section in deffernt status
        1- user get a valid URL link, that's mean user get into link in less than two hour
        2- after two hours the link will not be valid}--->
      <?php
        if($validUrl==1){//valid URL, let user insert the new password
              echo"<div class=\"top-content\">
              <div class=\"inner-bg\">
              <div class=\"container\" id=\"cen\">
                    <div class=\"col-sm-6 col-sm-offset-3 text\"><div class=\"form-box\"><div class=\"form-top\"><div class=\"form-top-left\">
                        <h3>הגדרת סיסמה חדשה לאתר הכיתה</h3></div></div>
                <div class=\"form-bottom\">
                  <fieldset><form name=\"recoverPasswordForm\" action=\"recoverPass.php\" method=\"post\" class=\"login-form\"><input type=\"hidden\" name=\"id\" value=\"$ID\"> 
                   <div class=\"form-group\">";//the id of user for easly search on DB.
                  if($invailedPassword==1){//if password is invalid show input as red border
                    echo "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                    <input type=\"password\" class=\"form-username form-control border-danger\" name=\"Password\" placeholder=\"סיסמה\" title=\"הזנת סיסמה שדה חובה\" required>";
                }else{
                    echo "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                    <input type=\"password\" class=\"form-username form-control\" name=\"Password\" placeholder=\"סיסמה\" title=\"הזנת סיסמה שדה חובה\" required>";
                }echo" </div>			
                        <input type=\"password\" class=\"form-username form-control\" name=\"confirmPassword\" placeholder=\"אמת סיסמה\"  title=\"כתיבת סיסמה פעם נוספת לוודא שהכנסת נכון\" required> 	                        
                      <button type=\"submit\" class=\"btn col-sm-12\">ריסט סיסמה</button><br><br>
                    </form></fieldset> 
                  </div></div></div></div></div></div>";
        }else{//unvalid URL, let user to insert his email again on forgetPassword page
           echo"
          <div id=\"notfound\">
          <div class=\"notfound\">
            <div class=\"notfound-404\"><h1>404</h1></div>
            <h2>אופס! לא ניתן היה למצוא דף זה</h2>
            <p>מצטערים אבל הדף שאתה מחפש לא קיים, הוסר. שם השתנה או שהוא בלתי אפשרי לזמן מזמן</p>
            <a href=\"forgetPassword.php\">שחזור סיסימה</a>
          </div></div>";
        }
      ?>
  </body>
</html>