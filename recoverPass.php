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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/forget.css">
  </head>
  <body>
  <div id="highlighted" class="hl-basic hidden-xs">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-10 col-lg-offset-2">
        <h1>הגדרת סיסמה חדשה</h1>
      </div>
    </div>
  </div>
</div>
<div id="content" class="interior-page">
  <div class="container-fluid">
    <div class="row">
      <!--Sidebar-->
      <div class="col-sm-3 col-md-3 col-lg-2 sidebar equal-height interior-page-nav hidden-xs">
        <div class="dynamicDiv panel-group" id="dd.0.1.0">
          <div id="subMenu" class="panel panel-default">
            <ul class="subMenuHighlight panel-heading"><li class="subMenuHighlight panel-title" id="subMenuHighlight"><a id="li_291" class="subMenuHighlight" href="Hakita.php"><span>הכיתה</span></a></li></ul>
            <ul class="panel-heading"><li class="panel-title"><a class="subMenu1" href="forgetPassword.php"><span class="subMenuHighlight">שליחת מייל מחדש</span></a></li></ul>
            <ul class="panel-heading"><li class="panel-title"><a class="subMenu1" href="Signup.php"><span>הרשמה</span></a></li></ul>
          </div>
          <div class="item item-nopad item-noborder item-gold"><a style="padding: 5% 0px;" href="FAQ.php" class="btn btn-primary btn-block" role="button">שאלות ותשובות </a></div>
        </div>
      </div>
        <?php        
        if($validUrl!=1){
          echo"<div id=\"notfound\">
          <div class=\"notfound\">
            <div class=\"notfound-404\"><h1>404</h1></div>
            <h2>אופס! לא ניתן היה למצוא דף זה</h2>
            <p>מצטערים אבל הדף שאתה מחפש לא קיים, הוסר. שם השתנה או שהוא בלתי אפשרי לזמן מזמן</p>
            <a href=\"forgetPassword.php\">שחזור סיסימה</a>
          </div></div>"; 
          }else{
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
          }
        ?>      
    </div></div></div>     
  </body>
</html>