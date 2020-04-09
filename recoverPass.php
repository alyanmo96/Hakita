<?php
/**
 *on this page  after check the validate of the URL, user have to insert the new password and confirm it.
 * we check the valid of the password. if there is some wrong with that return a message, 
 * else rediredt to user profile. 
 */
session_start();
/*
	*  $userId=$_SESSION['id']
	*   $_SESSION['id']=$userId;




	*/
    date_default_timezone_set('Asia/Jerusalem');  
    $script_tz = date_default_timezone_get();
    $date=date("Y-m-d"); $hour = date('H:i');
    $time=$_GET['time'];  $EMAIL= $_GET['email'];$ID=$_GET['id'];// these two variable we get it from the Link that sent to email
    $validUrl=-1;
//    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

    $resultOfValidPassOnPast = mysqli_query($con, "SELECT * FROM invailedPassword");
    while($resultRowOFValidPass=mysqli_fetch_assoc($resultOfValidPassOnPast)){//go through table to check if there any old wrong insert
        if(($resultRowOFValidPass['hourOfEnterPass']+1) >= $hour&& $resultRowOFValidPass['id']==$ID){//found any row on table
            $validUrl=1;break;
        }
    }
    if(isset($_POST["Password"])){//check the password valide
      $validUrl=1;
        $ID=$_POST['id'];
        $passwordHaveChar=-1;$invailedPassword=-1;$tooShortPassword=-1; $tooLongPassword=-1;  $diffPasswords=-1;$invailedUsername=-1;/*variables use to check if user insert a valid password or not*/ 
        //let password include a big and small letters and numbers
        $uppercase=preg_match('@[A-Z]@',$_POST["Password"]);
        $lowercase=preg_match('@[a-z]@',$_POST["Password"]);
        $number=preg_match('@[0-9]@',$_POST["Password"]);
        if(strlen($_POST["Password"])<8){//if the password string is less than 8 chars
            $invailedPassword=1;$tooShortPassword=1;
            if(!$uppercase||!$lowercase||!$number){$passwordHaveChar=1;}
        }elseif(strlen($_POST["Password"])>16){//if the password string is bigger than 16 chars
            $invailedPassword=1;$tooLongPassword=1;
            if(!$uppercase||!$lowercase||!$number){$passwordHaveChar=1;}
        }else{
          if(!$uppercase || !$lowercase || !$number){//wrong insert password
              echo "<script type='text/javascript'>alert('הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
              $invailedPassword=1;
            }
        }//if password not equal to confirmPassword
        if(strcmp($_POST["Password"], $_POST["confirmPassword"])!=0){$invailedPassword=1; $diffPasswords=1;}
        //// need to check that username is not a part of password or oppesite
        if($invailedPassword==-1){//if all aboves conditions are wrongs--> password&&confirmPassword are valid
            $isATeacher=-1;//variable use to redirect to user profile, after update on DB
//            $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
            $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");

            $results = mysqli_query($db, "SELECT * FROM users");          
            while($row=mysqli_fetch_assoc($results)){
                if(($row["username"]==$_POST["Password"])||(strpos($row["username"], $_POST["Password"]) !== false)||(strpos( $_POST["Password"],$row["username"]) !== false)){//if username equal to password
                    $invailedPassword=1; $invailedUsername=1;break;//invalid password, break and return wrong input message on alert for user
                }
                if($row['id']==$ID&&$row['setUserAs']=='student'){$isATeacher=1;break;}
            }
            if($invailedPassword==-1){
                // enter inputs and create a new row on DB if all inputs are valid
                $PASSWORD=$_POST["Password"];//get the password
                $upDate="UPDATE `teachers` SET `password`='$PASSWORD'WHERE id=$ID";
                $result=mysqli_query($db,$upDate);    
                //redirect to profile
                $sql = "DELETE FROM invailedPassword WHERE id=$ID";
                if ($db->query($sql) === TRUE){
                }else{// delete user and back to admin main page
                    echo "Error deleting record: " . $con->error;
                }


                /*
                  $_SESSION['id']=$ID;

                */
                if($isATeacher=-1){
                                   
                  
                  header('location: profile.php?id='.$ID);
                /*
                header("location: profile.php");

                */
                
                }
                else{
                  
                  
                  header('location: studentProfile.php?id='.$ID);


                  /*
                header("location: studentProfile.php");

                */
                
                } 
            }                           
        }//invalid inputs messages  {used alert}    
        if($invailedUsername==1&&$invailedPassword==1){
            if($usernameAndPasswordEqaul==1){echo "<script type='text/javascript'>alert('שם המשתמש והסיסמה אמורים להיות שונים');</script>";}
            else{echo "<script type='text/javascript'>alert('שם המשתמש לא תקין');</script>";}
        }elseif($invailedUsername==1&&$invailedPassword!=1){
            if($chooseOtherUsername==1){echo "<script type='text/javascript'>alert('שם המשתמש כבר קיים נא לבחור שם משתמש אחר');</script>";}
            else{echo "<script type='text/javascript'>alert('שם המשתמש אינו תקין נא לבחור אחר');</script>";}
        }elseif($invailedUsername!=1&&$invailedPassword==1){
            if($diffPasswords==1){echo "<script type='text/javascript'>alert('הסיסמאות שונות');</script>";}
            elseif($tooShortPassword==1&&$passwordHaveChar==-1){echo "<script type='text/javascript'>alert('סיסמה קצרה מדי');</script>";}
            elseif($tooLongPassword==1&&$passwordHaveChar==-1){echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי');</script>";}
            elseif($tooShortPassword==1&&$passwordHaveChar==1){echo "<script type='text/javascript'>alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";}
            elseif($tooLongPassword==1&&$passwordHaveChar==1){echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";}
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