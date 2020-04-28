<?php
/**
 * this is the forget password page.
 * user have to isert Email address and press the button to send a data for the related Email.
 *  once user get the URL, click the link. go for rewrite password.
 */
$messageIsSentTOEmail=-1;
  if(isset($_POST["email_addy"])){//get the EMAIL address to send data.
    //first we need to check that the insert EMAIL address really used on site
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $IdResults = mysqli_query($con, "SELECT * FROM users");
    $EmailYesOnSite=-1;//varibale to check if this email is on site
    $to = $_POST["email_addy"];
    while($rows=mysqli_fetch_assoc($IdResults)){
      if(strcmp($rows['email'],$to)==0){//if we found the reqaired id
        $id=$rows['id'];$EmailAddress=$rows['email'];//variables attachment to the email
        $EmailYesOnSite=1;$USERNAME=$rows['username']; break;//we found the email address
      } 
    }
    if($EmailYesOnSite==1){//send the message
      $needToUpdataData=-1;//check if on table in DB, this user already insert a wrong password or not. 
      $to = $_POST["email_addy"];//sending to email address
      $from ="HakitaSite";// from
      date_default_timezone_set('Asia/Jerusalem');  
      $script_tz = date_default_timezone_get();
      $date=date("Y-m-d"); $hour = date('H:i');//today date + current hour ...to invalid the URL after hour of sending time
      $url="https://hakitaproject.000webhostapp.com/study/study/recoverPass.php?id=\"$id\"&email=\"$EmailAddress\"&time=\"$hour\"";//URL include variable of the user
      $subject="שחזר סיסמה";//subject of message
      $message="<p>על מנת לשחזר את הסיסמה שלך באתר יש ללחוץ עח הקישור המצורף להודעה</p>";
      $message.="<a href='$url'>קישור לשחזור סיסמה</a>";
      $headers="From:".$from."\r\n";
      $headers.="Content-type: text/html\r\n";
      if(mail($to,$subject,$message,$headers)){//send message, if there is any problem with send alert wrong message 
        $messageIsSentTOEmail=1;//varibale use on display, user after insert his email address and click send, will show just a messgae about that 
      }else{//if there any connection problem
        echo "בעית תקשורת בשליחת ההודעה למייל";
        echo "<script type='text/javascript'>alert('בעית תקשורת בשליחת ההודעה למייל');</script>";
      }
   }else{//email address not used on site
      echo "<script type='text/javascript'>alert(' המייל שהוכנס אינו רשום במערכת');</script>";
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
        <h1>שחזור סיסמה</h1>
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
            <ul class="panel-heading"><li class="panel-title"><a class="subMenu1" href="login.php"><span class="subMenuHighlight">כניסה</span></a></li></ul>
            <ul class="panel-heading"><li class="panel-title"><a class="subMenu1" href="Signup.php"><span>הרשמה</span></a></li></ul>
          </div>
          <div class="item item-nopad item-noborder item-gold"><a style="padding: 5% 0px;" href="FAQ.php" class="btn btn-primary btn-block" role="button">שאלות ותשובות </a></div>
        </div>
      </div>
        <?php        
        if($messageIsSentTOEmail==1){
            echo"<div class=\"container h-100 d-flex justify-content-center\">
              <div class=\"jumbotron my-auto\">
                <h1 class=\"display-3\">נא לבדוק את המייל שלך, במידה ולא קיבלת הודעה תוך כמה דקות לשלוח שוב. יש לבדוק את תיקיית הספאם.</h1>
              </div></div><br><br><br><br><br><br>";
            //this help us to know {to update row on table or to insert}.
          $resultsOfInsert=mysqli_query($con, "SELECT * FROM invailedPassword");
          while($rows=mysqli_fetch_assoc($resultsOfInsert)){
            if($rows['id']==$id){//if we found the reqaired id, 
                $needToUpdataData=1;
              break;
            } 
          }
            if($needToUpdataData==1){//after insert the email/username and send, this what going to display.
              $result=mysqli_query($con, "SELECT * FROM invailedPassword");
               $upDate="UPDATE `invailedPassword` SET `dateOfSendResetRequest`='$date', `hourOfSendResetRequest`='$hour' WHERE id=$id";//update data
               $result=mysqli_query($con,$upDate);  
             }else{//first time....that mean user not insert any wrong password on last hour
               $resultsOfInsert=mysqli_query($con, "SELECT * FROM invailedPassword");
              $query="INSERT INTO `invailedPassword`(`username`,`manyTimes`,`hourOfEnterPass`,`dateOfInvaild`,`id`,`dateOfSendResetRequest`,`hourOfSendResetRequest`) VALUES
               ('$USERNAME','1','$hour','$date','$id','$date','$hour')";
               $resultsOfInsert=mysqli_query($con,$query);
             } 
          }else{
            echo"<div class=\"col-sm-9 col-md-9 col-lg-10 content equal-height\">
            <div class=\"content-area-right\">
              <div class=\"content-crumb-div\">
              <a class=\"nav-link\" href=\"Hakita.php\"> עמוד הבית</a>
              </div>
              <div class=\"row\"><div class=\"col-md-5 forgot-form\">
                  <p>אחרי הכנסת שם משתמש או המייל יש ללחוץ על הכפתור שליחה, ואז יש לבדוק את המייל. במצב ולא קיבלה הודעה יש לעשות את זה שוב</p>
                  <form name=\"forgetPassForm\" action=\"forgetPassword.php\" method=\"post\" class=\"login-form\">
                    <label class=\"label-default\" for=\"un\"></label> <input id=\"email_addy\" name=\"email_addy\" class=\"form-control\" type=\"text\" placeholder=\"שם משתמש או דואר אלקטרוני\" ><br>
                    <a id=\"mybad\" class=\"btn btn-primary\" role=\"button\">שליחה</a>
                  </form>
                </div></div></div></div>";
          }
        ?>      
    </div></div></div>
  </body>
</html>