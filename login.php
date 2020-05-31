<?php
    session_start();
    include 'userData.php';
    /*   next section for :=>    login for an active account, in each time user insert an incorrect password around
        one hour it will save as invalied on DB, when it the third or more times, user will automaticly 
        redirect to forgetPage.
        user can insert username/email/phone number.
    */
    $invailedLoginPassword=-1;
    if(isset($_POST["username"])){
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $results = mysqli_query($con, "SELECT * FROM users");
  		while($row=mysqli_fetch_assoc($results)){
            if($row['password']==$_POST['password']&&
                ($row['username']==$_POST['username']||
                $row['email']==$_POST['username']||
                $row['phone']==$_POST['username']
            )){//user can insert his {username/ email/ phone number} as a username.
                $ID=$row['id'];
                $_SESSION['id']=$ID;
                if($row['setUserAs']=='Admin'||$row['username']=='AdminEliEssiak'){
                    header("Location: AdminPage.php");
                }
                elseif($row['setUserAs']=='student'){//if account for a student go to student profile
                    header("Location: studentProfile.php");
                }else{//if account for a teacher go to teacher profile
                  header("Location: profile.php");
                }
            }// else if user enter a right username or right phone number or right email and unright password
            elseif(($row['username']==$_POST['username']||
            $row['email']==$_POST['username']||
            $row['phone']==$_POST['username']
            )&&$row['password']!=$_POST['password']){
                $message=" הסיסמה לא נכונה ";

                //next section for insert wrong password
                $invailedLoginPassword=1;$isItNotFirstTimeToEnterInvailPassword=-1;$round;$datrOfInvalidPass;
                $resultOFValidPass=mysqli_query($con, "SELECT * FROM invailedPassword");
                while ($resultRowOFValidPass=mysqli_fetch_assoc($resultOFValidPass)){
                    if($resultRowOFValidPass['username']==$USERNAME){//check how many times, user insert wrong password
                        $isItNotFirstTimeToEnterInvailPassword=1;
                        $round=$resultRowOFValidPass['manyTimes'];$datrOfInvalidPass=$resultRowOFValidPass['dateOfInvaild'];$ID=$resultRowOFValidPass['id'];
                    }
                }
                if($isItNotFirstTimeToEnterInvailPassword==1){// need to check hours                
                    $resultOfValidPass = mysqli_query($con, "SELECT * FROM invailedPassword");
                    if($round==1){//second time user enter uncorrect password
                        $round=2;
                        $upDate="UPDATE `invailedPassword` SET `manyTimes`='$round'WHERE id=$ID";
                        $resultOfValidPass=mysqli_query($con,$upDate);
                        echo"<script type='text/javascript'>alert('$message');</script>";
                    }else if($round==2){//third time user enter uncorrect password
                        $round=3;
                        $upDate="UPDATE `invailedPassword` SET `manyTimes`='$round'WHERE id=$ID";
                        $resultOfValidPass=mysqli_query($con,$upDate);
                    }elseif($round>=3){//more than three times
                        header('location: forgetPassword.php');
                        $message="הכנסת סיסמה שגויה כמה פעמים, יש אפשרות לעדכן אותה דרך לחיצה על כפתור {שכחתי סיסמה } למטה";
                        echo"<script type='text/javascript'>alert('$message');</script>";
                    }
                }else{//if it's first time user insert wrong password, create a row on table.
                    $resultOfRightUsername=mysqli_query($con, "SELECT * FROM users");
                    while($row=mysqli_fetch_assoc($resultOfRightUsername)){
                        if($row['username']==$_POST['username']||
                        $row['email']==$_POST['username']||
                        $row['phone']==$_POST['username']){
                            $USERNAME=$row['username'];
                            //$ID=$row['id'];
                        }
                    }
                    date_default_timezone_set('Asia/Jerusalem');//local time, israel 
                    $script_tz = date_default_timezone_get();
                    $hour=date('H:i');$date=date("Y/m/d");
                    $db=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
                    $resultsOfInsert=mysqli_query($db, "SELECT * FROM invailedPassword");
                    $query="INSERT INTO `invailedPassword`(`username`,`manyTimes`,`hourOfEnterPass`,`dateOfInvaild`,`id`,`dateOfSendResetRequest`,`hourOfSendResetRequest`) VALUES
                    ('$USERNAME','1','$hour','$date','$ID','0000-00-00','00:00:00')";
                    $resultsOfInsert=mysqli_query($db,$query);
                    echo"<script type='text/javascript'>alert('$message');</script>";   
                }
            }
		}
    }
    
?>
<!DOCTYPE html>
    <html>
	<head>
        <?php include 'header.php';?>
		<link rel="stylesheet" type="text/css" href="css/LoginStyle.css">
	</head>
	<body>
		<section><!--navbar section, there is two styles for showing: 1- for any user  2- user after login  -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <a class="navbar-brand" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active"><a class="nav-link" href="Hakita.php">עמוד הבית </a></li>
                <li class="nav-item active"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>
                <li class="nav-item active"><a class="nav-link" href="Signup.php">הרשמה</a></li>
                <li class="nav-item active"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>
              </ul>
            </div>
          </nav>
    </section><br><br><br>    
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt><img id="loginPageImage" src="img/loginPagePhoto.jpg"></div>
					<form class="login100-form validate-form" action="login.php" method="POST">
						<span class="login100-form-title">כניסה לחשבון</span>
						<div class="wrap-input100 validate-input" data-validate = "Valid username is required: ex@abc.xyz">
							<input class="input100" type="text" name="username" placeholder=" שם משתמש או מייל או מספר טלפון">
							<span class="focus-input100"></span>
							<span class="symbol-input100"><i class="fa fa-envelope" aria-hidden="true"></i></span>
						</div>
						<div class="wrap-input100 validate-input" data-validate = "Password is required">
							<input class="input100" type="password" name="password" placeholder="סיסמה">
							<span class="focus-input100"></span>
							<span class="symbol-input100"><i class="fa fa-lock" aria-hidden="true"></i></span>
						</div>				
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">כניסה</button>
						</div>
                    </form>
                    <div class="container-login100-form-btn">
                        <p><a href="forgetPassword.php">שחכתי סיסמה</a></p><!--re define password section-->
                    </div>
				</div>
			</div>
		</div>
		<?php include_once 'footer.php';?>    
	</body>
</html>