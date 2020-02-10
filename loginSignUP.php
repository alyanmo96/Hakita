<?php
    /**
     * login and sign up page 
     */    
    // this section for delete invalid inputs from last times
    $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $resultOfValidPassOnPast = mysqli_query($con, "SELECT * FROM invailedPassword");
    $date=date("Y-m-d"); $hour = date('H:i');
    while ($resultRowOFValidPass=mysqli_fetch_assoc($resultOfValidPassOnPast)) 
    {
        if( $resultRowOFValidPass['dateOfInvaild'] > $date || $resultRowOFValidPass['hourOfEnterPass'] > $hour )
        {
            $deleteUsername=$resultRowOFValidPass['username'];
            $deleteUsername=$resultRowOFValidPass['manyTimes'];
            $deleteUsername=$resultRowOFValidPass['dateOfInvaild'];
            $deleteRos=$resultRowOFValidPass['hourOfEnterPass'];
            $sql = "DELETE FROM invailedPassword WHERE username=$deleteUsername ";
            if ($con->query($sql) === TRUE) 
            {
                //header('location: AdminPage.php');
                //echo "Record deleted successfully";
            } 
            else 
            {
                echo "Error deleting record: " . $con->error;
            }
        }
    }
    // this section will work after the user enter the inputs on (new user section)
    $invailedUsername=-1; $invailedPassword=-1;    $tooShortPassword=-1;$tooLongPassword=-1;
    $diffPasswords=-1;$usernameAndPasswordEqaul=-1;    $chooseOtherUsername=-1;$passwordHaveChar=-1;
    if (isset($_POST["username"])) 
    {//check the valide of username and password
        if(strlen($_POST["username"])<=4 ||(strlen($_POST["username"])>15))
        {
            $invailedUsername=1;
        }//let password include a big and small letters and numbers
        $uppercase = preg_match('@[A-Z]@', $_POST["Password"]);
        $lowercase = preg_match('@[a-z]@', $_POST["Password"]);
        $number    = preg_match('@[0-9]@', $_POST["Password"]);
        
        if(strlen($_POST["Password"])<8)//if the password string is less than 8 chars
        {
            $invailedPassword=1;$tooShortPassword=1;
            if(!$uppercase || !$lowercase || !$number)
            {
                $passwordHaveChar=1;
            }
        }
        else if(strlen($_POST["Password"])>16)//if the password string is bigger than 16 chars
        {
            $invailedPassword=1;$tooLongPassword=1;
            if(!$uppercase || !$lowercase || !$number)
            {
                $passwordHaveChar=1;
            }
        }
       if(strcmp($_POST["Password"], $_POST["confirmPassword"])!=0)//if password not equal to confirmPassword
        {
            $invailedPassword=1; $diffPasswords=1; 
        }
        if($_POST["username"]==$_POST["Password"])//if username equal to password
        {
            $invailedPassword=1; $invailedUsername=1; $usernameAndPasswordEqaul=1; 
        }
        else if($invailedUsername==-1&& $invailedPassword==-1)//if all aboves conditions are wrongs--> usernamer&&password&&confirmPassword are valid
        {
           $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
           $results = mysqli_query($db, "SELECT * FROM teachers");
           $OtherAccount=-1;           
            while ($row=mysqli_fetch_assoc($results)) //check if there a username is equal to the new username
            {
                if ($row['username']==$_POST["username"]) 
                {
                    $OtherAccount=1;
                    $invailedUsername=1; 
                    break;
                }
            }
            if ($OtherAccount==1) 
            {
                $OtherAccount=-1;     $chooseOtherUsername=1;          $invailedUsername=1;   
            }
            else// enter inputs and create a new row on DB if all inputs are valid
            {
                $USERNAME=$_POST["username"];
                $PASSWORD=$_POST["Password"];
                $todayDate=date('Y-m-d');
                $query="INSERT INTO `teachers`(`fname`,`lname`,`password`,`email`,`price`,`status`,`username`,`phone`,`createAccount`,`gender`,`setUserAs`) VALUES ('first name','last name','$PASSWORD','email','1','status','$USERNAME','phone','$todayDate','not','not')";
                $result = mysqli_query($db,$query);
                header('location: secondLogin.php');
            }
        }    
        //invalid inputs messages        
        if( $invailedUsername == 1 && $invailedPassword == 1)
        {
            if($usernameAndPasswordEqaul==1)
            {
                echo "<script type='text/javascript'>
                    alert('שם המשתמש והסיסמה אמורים להיות שונים');
                </script>";
            }
            else
            {
                echo "<script type='text/javascript'>
                    alert('שם המשתמש לא תקין');
                </script>";
            }
        }
        else if($invailedUsername==1&&$invailedPassword!=1)
        {
            if($chooseOtherUsername==1)
            {
                echo "<script type='text/javascript'>
                alert('שם המשתמש כבר קיים נא לבחור שם משתמש אחר');
                </script>";                                         
            }
            else
            {
                echo "<script type='text/javascript'>
                    alert('שם המשתמש אינו תקין נא לבחור אחר');
                </script>";
            }
        }
        else if($invailedUsername!=1&&$invailedPassword==1)
        {
            if($diffPasswords==1)
            {
                echo "<script type='text/javascript'>
                alert('הסיסמאות שונות');
            </script>";
            }
            else if($tooShortPassword==1&&$passwordHaveChar==-1)
            {
                echo "<script type='text/javascript'>
                    alert('סיסמה קצרה מדי');
                </script>";
            }
            else if($tooLongPassword==1&&$passwordHaveChar==-1)
            {
                echo "<script type='text/javascript'>
                alert('סיסמה ארוכה מדי');
                </script>";
            }
            else if($tooShortPassword==1&&$passwordHaveChar==1)
            {
                echo "<script type='text/javascript'>
                    alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');
                </script>";
            }
            else if($tooLongPassword==1&&$passwordHaveChar==1)
            {
                echo "<script type='text/javascript'>
                alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');
                </script>";
            }
        }
    }
    /*
     * login for an active account
     */
    $invailedLoginPassword=-1;
    if (isset($_POST["usernameLogin"])) 
    {
        $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $results = mysqli_query($con, "SELECT * FROM teachers");
  		while ($row=mysqli_fetch_assoc($results)) 
		{
            if($row['password']==$_POST['PasswordLogin']&&
            (   $row['username']==$_POST['usernameLogin']||
                $row['email']==$_POST['usernameLogin']||
                $row['phone']==$_POST['usernameLogin']
            ))//get variables to use on HTML view
			{
				$ID=$row['id'];
                if($row['setUserAs']=='student')//if account for a student go to student profile
                {
                   header('location: studentProfile.php?id='.$ID);
                }
                else
                {//if account for a teacher go to teacher profile
                    header('location: profile.php?id='.$ID);
                }
            }// else if user enter a right username or right phone number or right email and unright password
            else if((  $row['username']==$_POST['usernameLogin']||
            $row['email']==$_POST['usernameLogin']||
            $row['phone']==$_POST['usernameLogin']
            )&&$row['password']!=$_POST['PasswordLogin'])
            {
                $message = " הסיסמה לא נכונה ";
                echo "<script type='text/javascript'>alert('$message');</script>";
                $resultOfRightUserName = mysqli_query($con, "SELECT * FROM teachers");
                while ($row=mysqli_fetch_assoc($resultOfRightUserName)) 
                {
                    if($row['username']==$_POST['usernameLogin']||
                    $row['email']==$_POST['usernameLogin']||
                    $row['phone']==$_POST['usernameLogin']
                    )
                    {
                        $USERNAME=$row['username'];
                    }
                }
                $invailedLoginPassword=1; $isItNotFirstTimeToEnterInvailPassword=-1;$round;
                $datrOfInvalidPass;
                $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                $resultOFValidPass = mysqli_query($con, "SELECT * FROM invailedPassword");
                while ($resultRowOFValidPass=mysqli_fetch_assoc($resultOFValidPass)) 
                {
                    if($resultRowOFValidPass['username']==$USERNAME)
                    {
                        $isItNotFirstTimeToEnterInvailPassword=1;
                        $round=$resultRowOFValidPass['manyTimes']; 
                        $datrOfInvalidPass=$resultRowOFValidPass['dateOfInvaild'];
                    }
                }
                if($isItNotFirstTimeToEnterInvailPassword==1)
                {// need to check hours                
                    $resultOfValidPass = mysqli_query($con, "SELECT * FROM invailedPassword");
                    if($round==1)//second time user enter uncorrect password
                    {
                        $round=2;
                        $upDate="UPDATE `invailedPassword` SET `manyTimes`='$round'WHERE manyTimes=1";
                        $resultOfValidPass = mysqli_query($con,$upDate);
                    }
                    else if($round==2)//third time user enter uncorrect password
                    {
                        $round=3;
                        $upDate="UPDATE `invailedPassword` SET `manyTimes`='$round'WHERE manyTimes=2";
                        $resultOfValidPass = mysqli_query($con,$upDate);
                    }
                    else//more than three times
                    {
                        echo "<script type='text/javascript'>
                        alert('three times');
                    </script>";
                    }
                }
                else//if it's first time 
                {
                    $resultOfRightUsername = mysqli_query($con, "SELECT * FROM teachers");
                    while ($row=mysqli_fetch_assoc($resultOfRightUsername)) 
                    {
                        if($row['username']==$_POST['usernameLogin']||
                        $row['email']==$_POST['usernameLogin']||
                        $row['phone']==$_POST['usernameLogin']
                        )
                        {
                            $USERNAME=$row['username'];
                        }
                    }
                    $hour = date('H:i');
                    $date=date("Y/m/d");
                    $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                    $resultsOfInsert = mysqli_query($db, "SELECT * FROM invailedPassword");
                    $query="INSERT INTO `invailedPassword`(`username`,`manyTimes`,`hourOfEnterPass`,`dateOfInvaild`) VALUES
                    ('$USERNAME','1','$hour','$date')";
                    $resultsOfInsert = mysqli_query($db,$query);   
                }
            }
		}
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>הכיתה</title>        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="jquery/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/LoginStyle.css">

    </head>
      <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand active" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="Hakita.php">עמוד הבית <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="searchTeachers.php">חיפוש מורה</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="FAQ.php">שאלות ותשובות</a>
                  </li>
              </ul>
            </div>
          </nav>
          <br>
                <div class="container-fluid">
                    <div class="container">
                    <h2 class="WordsOnMid text-center">   כניסה או הרשמה</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>              
                            <h3><p class="logSign text-uppercase"> משתמש קיים: </p> </h3>
                                <br>
                                <form name="loginform" action="loginSignUP.php" method="post">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" name="usernameLogin" placeholder="שם משתמש או אמייל או מספר  טלפון" title="הזנת שם משתמש או אמייל או מספר  טלפון " required>                               
                                </div> <br>
                                    <div class="input-group">
                                    <?php
                                        if($invailedLoginPassword==1)//if password is wrong show input as red border
                                        {
                                            echo "
                                            <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                            <input type=\"password\" class=\"form-control border-danger\" name=\"PasswordLogin\" placeholder=\"סיסמה\" title=\"הזנת סיסמה\"required >";
                                        }
                                        else
                                        {
                                            echo "
                                            <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                            <input type=\"password\" class=\"form-control\" name=\"PasswordLogin\" placeholder=\"סיסמה\" title=\"הזנת סיסמה\"required >";
                                        }
                                    ?>
                                </div> <br> <br>
                                <br> <br>
                                <div class="text-center">
                                <p><a href="ForgetPassword.php">שחכתי סיסמה</a></p><!--re define password section-->
                                </div> <br>
                                <div class="text-center">
                                    <input type="submit" class="logSignButton btn btn-lg btn-primary" value="כניסה" title="כפתור כניסה למערכת">
                                </div> <br>
                            <br>
                                </form>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                        <form  name="loginform" action="loginSignUP.php" method="post">
                            <fieldset>              
                            <h3> <p class="logSign text-uppercase pull-center"> משתמש חדש</p> </h3> <br>
                            <div class="input-group">
                            <?php
                                if($invailedUsername==1)//if username is invalid show input as red border
                                {
                                    echo "
                                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                                    <input  type=\"text\" class=\"form-control border-danger\" name=\"username\" id=\"username\" placeholder=\"שם משתמש\" title=\"שם משתמש שעבורו נרשמת\" required>";
                                }
                                else
                                {
                                    echo "
                                    <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                                    <input  type=\"text\" class=\"form-control\" name=\"username\" id=\"username\" placeholder=\"שם משתמש\" title=\"שם משתמש שעבורו נרשמת\" required>";
                                }
                            ?>
                            </div> <br>
                            <div class="input-group">
                                <?php
                                    if($invailedPassword==1)//if password is invalid show input as red border
                                    {
                                        echo "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                        <input  type=\"password\" class=\"form-control border-danger\" name=\"Password\" placeholder=\"סיסמה\" title=\"הזנת סיסמה שדה חובה\" required>
                                        ";
                                    }
                                    else
                                    {
                                        echo "<span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                                        <input  type=\"password\" class=\"form-control\" name=\"Password\" placeholder=\"סיסמה\" title=\"הזנת סיסמה שדה חובה\" required>
                                        ";
                                    }
                                ?>
                                
                            </div> <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input  type="password" class="form-control" name="confirmPassword" placeholder="אמת סיסמה"  title="כתיבת סיסמה פעם נוספת לוודא שהכנסת נכון" required>
                            </div>
                            <br>
                            <br>
                            <div class="text-center">
                                    <input type="submit" class="logSignButton btn btn-lg btn-primary text-center" title="שמירת נתונים והמשך" value="רשום">
                            </div>
                            </fieldset>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>                
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</html>