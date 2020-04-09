<?php
/**
 * this is the forget password page.
 * user have to isert Email address and press the button to send a data for the related Email.
 *  once user get the URL, click the link. go for rewrite password.
 */
  if(isset($_POST["email_addy"])){//get the EMAIL address to send data.
    //first we need to check that the insert EMAIL address really used on site
//    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki"); 
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
    <!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>הכיתה</title><!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/form-elements.css">
    <link rel="stylesheet" href="css/forgetStyle.css">
  </head>
  <body>
    <section><!--navbar section, there is two styles for showing: 1- for any user  2- user after login  -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active"><a class="nav-link" href="loginSignUP.php">כניסה/הרשמה </a></li>
                <li class="nav-item"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>
                <li class="nav-item"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>
              </ul>
            </div>
        </nav>
    </section>    
    <?php
      if($messageIsSentTOEmail){
        echo"<div class=\"container h-100 d-flex justify-content-center\">
          <div class=\"jumbotron my-auto\">
            <h1 class=\"display-3\">נא לבדוק את המייל שלך, במידה ולא קיבלת הודעה תוך כמה דקות יש לבדוק את תיקיית הספאם.</h1>
          </div>
      </div><br><br><br><br><br><br>";
        //this help us to know {to update row on table or to insert}.
      $resultsOfInsert=mysqli_query($con, "SELECT * FROM invailedPassword");
      while($rows=mysqli_fetch_assoc($resultsOfInsert)){
        if($rows['id']==$id){//if we found the reqaired id, 
            $needToUpdataData=1;
          break;
        }	
      }
        if($needToUpdataData==1){
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
        echo "
        <div class=\"top-content\">
        <div class=\"inner-bg\">
            <div class=\"container\">                     	
                      <div class=\"form-box\">
                        <div class=\"form-top\">
                          <div class=\"form-top-left\">
                            <h3>יש להכניס שם משתמש או דואר אלקטרוני</h3>
                          </div></div>
                          <div class=\"form-bottom\">
                            <fieldset><form name=\"forgetPassForm\" action=\"forgetPassword.php\" method=\"post\" class=\"login-form\">
                                <div class=\"form-group\">
                                  <label class=\"sr-only\" for=\"form-username\">Username</label>
                                    <input type=\"text\" name=\"email_addy\" placeholder=\"שם משתמש או דואר אלקטרוני\" class=\"form-username form-control\" id=\"email_addy\">
                                  </div>				                        
                                <button type=\"submit\" class=\"btn col-sm-12\">שליחה</button><br><br>
                              </form></fieldset> 
                            </div>
                        </div>
                    
            </div>
        </div>
    </div>  
        ";
      }
    ?>        
    <div class="Bumenu">
      <div class="row">
        <div class="col-sm-5">
           &copy;כל הזוכיות שמורות לאתר הכיתה
          <a href="https://www.jce.ac.il/"></a><br>
            קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
        </div><br/>
        <div class="col-sm-3"> 📚           
          רשימת מקצועות לימוד<br>
          צור קשר איתנו📧  
          <p>הוספת פרויפיל</p>
        </div><br/>
        <div class="col-sm-4">        עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
        </div>
      </div>
    </div> 
  </body>
</html>