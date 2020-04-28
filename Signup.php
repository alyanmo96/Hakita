<?php
// this section will work after the user enter the inputs on (new user section)
    session_start();
    include 'userData.php';
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $invailedUsername=-1;/*variable use to check if user insert a valid username or not*/ 
    $invailedPassword=-1;
    if(isset($_POST["username"])){//check the valide of username and password
        if(strlen($_POST["username"])<=4||(strlen($_POST["username"])>15)){
            $invailedUsername=1;
        }
        if(($invailedUsername==-1)&&(strpos($_POST['password'],$_POST["username"])!==false)||(strpos($_POST["username"],$_POST['password'])!==false)) {
            $invailedPassword=1;
        }
        if($invailedUsername==-1&&$invailedPassword==-1){
            $invailedPassword=PasswordValidate($_POST['password'], $_POST['verifyPassword']);
            if($invailedPassword==-1){
                $results=mysqli_query($con, "SELECT * FROM users");       
                while($row=mysqli_fetch_assoc($results)){//check if there is already a username same to the new username
                    if($row['username']==$_POST["username"]){
                        $invailedUsername=1;break;//yes there is, need to change the username
                    }
                }
                if($invailedUsername==-1){
                    date_default_timezone_set('Asia/Jerusalem');$script_tz = date_default_timezone_get();
                    $date=date("Y-m-d"); $hour = date('H:i');//today date + current hour
                    $USERNAME=$_POST["username"];$PASSWORD=$_POST["password"];//get the password and username
                    $todayDate=date('Y-m-d');//date of create account...used for dsiplay it on profile
                    $query="INSERT INTO `users`(`id`,`username`,`fname`,`lname`,`password`,`email`,`price`,`priceTwo`,`status`,`phone`,`phoneTwo`,`createAccount`,`gender`,`setUserAs`,`old`) VALUES 
                    ('','$USERNAME','first name','last name','$PASSWORD','email','1','2','status','phone','phoneTwo','$todayDate','not','not','0')";
                    if($result = mysqli_query($con,$query))
                    {
                        header('location: secondLogin.php');              
                    }
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active"><a class="nav-link" href="Hakita.php">עמוד הבית </a></li>
                        <li class="nav-item active"><a class="nav-link" href="login.php">כניסה</a></li>
                    <li class="nav-item"><a class="nav-link" href="searchTeachers.php">חיפוש מורה</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ.php">שאלות ותשובות</a></li>
              </ul>
            </div>
          </nav>
    </section>    
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt><img src="img/signup.jpg" alt="IMG"></div>
					<form class="login100-form validate-form" action="signup.php" method="POST">
						<span class="login100-form-title">הרשמת משתמש/ת חדש/ה</span>
						<div class="wrap-input100 validate-input" data-validate = "Valid username is required: ex@abc.xyz">
							<?php
                                if($invailedUsername==-1){//if user insert invalied username, it will be with a red border
                                    echo'<input class="input100" type="text" name="username" placeholder="שם משתמש">';
                                }else{
                                    echo'<input class="input100  border-danger" type="text" name="username" placeholder="שם משתמש אינו תקין">';
                                }
                            ?>
                            <span class="focus-input100"></span>
							<span class="symbol-input100"><i class="fa fa-envelope" aria-hidden="true"></i></span>
						</div>
						<div class="wrap-input100 validate-input" data-validate = "Password is required">	
                            <?php
                                if($invailedPassword==-1){//if user insert invalied password, it will be with a red border
                                    echo'<input class="input100" type="password" name="password" placeholder="סיסמה">';
                                }else{
                                    echo'<input class="input100  border-danger" type="password" name="password" placeholder="סיסמה אינה תקינה">';
                                }
                            ?>
                            <span class="focus-input100"></span>
							<span class="symbol-input100"><i class="fa fa-lock" aria-hidden="true"></i></span>
						</div>	
						<div class="wrap-input100 validate-input" data-validate = "Password is required">
							<input class="input100" type="password" name="verifyPassword" placeholder="אימות סיסמה">
							<span class="focus-input100"></span>
							<span class="symbol-input100"><i class="fa fa-lock" aria-hidden="true"></i></span>
						</div>					
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">הרמשה</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php include_once 'footer.php';?>    
	</body>
</html>