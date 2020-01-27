<?php
    // this section will work after the user enter the inputs on (new user section)
  if (isset($_POST["username"])) {
    //check the valide of username and password
    if(strlen($_POST["username"])<=4 ||(strlen($_POST["username"])>15))
    {
        // if there is a wrong username input
        echo "<script type='text/javascript'>
                alert('שם המשתמש לא תקין');
            </script>";
           // header('location: loginSignUP.php'); 
           header('location: loginSignUP.php'); 
    }
    else
    {   //let password include a big and small letters and numbers
        $uppercase = preg_match('@[A-Z]@', $_POST["Password"]);
        $lowercase = preg_match('@[a-z]@', $_POST["Password"]);
        $number    = preg_match('@[0-9]@', $_POST["Password"]);
        // !!!! let password include chars like (!,@,#, etc... )
        //$specialChars = preg_match('@[^\w]@', $_POST["Password"]);

        //if the password string is less than 8 chars
        if(strlen($_POST["Password"])<8)
        {
           // if(!$uppercase || !$lowercase || !$number || !$specialChars )
           if(!$uppercase || !$lowercase || !$number)
           {
                echo "<script type='text/javascript'>
                    alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');
                </script>";
                //header('location: loginSignUP.php');  
                header('location: loginSignUP.php');
           }
        }//if the password string is bigger than 16 chars
        if(strlen($_POST["Password"])>16)
        {
            //if(!$uppercase || !$lowercase || !$number || !$specialChars)
            if(!$uppercase || !$lowercase || !$number)
            {
                echo "<script type='text/javascript'>
                alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');
                </script>";
                // header('location: loginSignUP.php');  
                header('location: loginSignUP.php');
            }
        }//if password not equal to confirmPassword
        if(strcmp($_POST["Password"], $_POST["confirmPassword"])!=0)
        {
            echo "<script type='text/javascript'>
                alert('הסיסמאות שונות');
            </script>";
            /*
               // document.getElementById('username').style.borderColor = 'red';
                //document.getElementById('Password').style.borderColor = 'red';
            */
            //header('location: loginSignUP.php');  
            header('location: loginSignUP.php');   
        }
        if($_POST["username"]==$_POST["Password"])//if username equal to password
        {
            echo "<script type='text/javascript'>
                alert('אין אפשרות ששם המשתמש והסיסמה יהיו שווים');
            </script>";
            /*
               // document.getElementById('username').style.borderColor = 'red';
                //document.getElementById('Password').style.borderColor = 'red';
            */
            //header('location: loginSignUP.php');  
            header('location: loginSignUP.php');   
        }
        else //if all aboves conditions are wrongs--> usernamer&&password&&confirmPassword are valid
        {
           // echo $_POST["Password"];
           // call the DB
           $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
           $results = mysqli_query($db, "SELECT * FROM teachers");
           $OtherAccount=-1;
           //check if there a username is equal to the new username
            while ($row=mysqli_fetch_assoc($results)) 
            {
                if ($row['username']==$_POST["username"]) 
                {
                    $OtherAccount=1;
                }
            }
            if ($OtherAccount==1) 
            {
                $OtherAccount=-1;
                echo "<script type='text/javascript'>
                alert('שם המשתמש כבר קיים נא לבחור שם משתמש אחר');
                </script>";     
                header('location: loginSignUP.php'); 
            }
            else// enter inputs and create a new row on DB
            {
                $USERNAME=$_POST["username"];
                $PASSWORD=$_POST["Password"];
                $todayDate=date('Y-m-d');
                $query="INSERT INTO `teachers`(`fname`,`lname`,`password`,`email`,`price`,`status`,`username`,`phone`,`createAccount`,`gender`,`setUserAs`) VALUES ('first name','last name','$PASSWORD','email','1','status','$USERNAME','phone','$todayDate','not','not')";
                $result = mysqli_query($db,$query);
                header('location: secondLogin.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <link rel="stylesheet" type="text/css" href="css/styleLogin.css">
        <style>
            .navbar-brand 
            {
                font-size:35px;
            }
            .navbar-brand:hover
            {
                font-size:40px;
            }
            .nav-link
            {
                font-size:23px;
            }    
            .nav-link:hover
            {
                font-size:30px;
            }
            .form-control
            {
                height:35px;
                border-radius: 300px;
            } 
            .navbar{
                background: url('./img/edit.jpg');   
            }
            .container-fluid{
                margin-top: -1%;
                background: url('./img/edit.jpg');
            }  
            .WordsOnMid
            {
                color: black;
                font-size: 35px;
            }
            .logSign
            {
                color: black;
            }
            .glyphicon {
    position: relative;
    top: 1px;
    display: list-item;
    /* font-family: "Glyphicons Halflings"; */
    font-style: italic;
    font-weight: 1000;
    line-height: 1;
    -moz-osx-font-smoothing: grayscale;
}
.logSignButton
{
    font-size: 15px;
}
input{
    border-radius: 300px;
}
        </style>
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
                <div class="container-fluid">
                    <div class="container">
                    <h2 class="WordsOnMid text-center">   כניסה או הרשמה</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>              
                            <h3><p class="logSign text-uppercase"> משתמש קיים: </p> </h3>
                                <br>
                                <form name="loginform" action="profile.php" method="post">
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" name="usernameLogin" placeholder="שם משתמש" title="הזנת שם משתמש " required>
                                </div> <br>
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" class="form-control" name="PasswordLogin" placeholder="סיסמה" title="הזנת סיסמה"required >
                                </div> <br> <br>
                                <div class="text-center">
                                    <input type="submit" class="logSignButton btn btn-lg btn-primary" value="כניסה" title="כפתור כניסה למערכת">
                                </div>
                                </form>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                       <!-- <form  name="loginform" action="secondPageLogin.php" method="post">-->
                        <form  name="loginform" action="loginSignUP.php" method="post">
                            <fieldset>              
                            <h3> <p class="logSign text-uppercase pull-center"> משתמש חדש</p> </h3> <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input  type="text" class="form-control" name="username" id="username" placeholder="שם משתמש" title="שם משתמש שעבורו נרשמת" required>
                            </div> <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input  type="password" class="form-control" name="Password" placeholder="סיסמה" title="הזנת סיסמה שדה חובה" required>
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