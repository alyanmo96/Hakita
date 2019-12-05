<?php
  
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
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <script src="jquery/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <style >
          body
          {
            direction: rtl;
            max-width: 100%;
          }
          #title
          {
            font-style: inherit;
            font-size: 60px;
            color: #00bdff;
          }
          .logSign
          {
            font-size: 30px;
            color: #00bdff;
          }
          .logSignButton
          {
            background-color: #00bdff;
          }
        </style>
    </head>
      <body>
          <nav class="navbar navbar-inverse">
      <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="MainPage.php">הכיתה</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li>
              <a alt="work 1" data-toggle="modal" data-target="#myModalc">צור קשר</a>
              <div class="modal fade" id="myModalc" tabindex="-1" role="dialog" aria-labelledby="myModalLabelv">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabelv">צור קשר</h4>
                  </div>
                  <div class="modal-body">
                   <img id="aboutimg" src="img/call.jpg" alt="work 1">
                    <hr>
                    <p class="pA">
                      Admin: Eli Isaak.
                      <hr>
                      Phone: 0522222222.
                      <hr>
                      Email:EliIsaak@EliIsaak.com
                </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   </div>
                </div>
              </div>
            </div>
            </li>
        <li>    <a href="#">שאלות ותשובות</a>       </li>
        <li>  <a href="searchTeachers.php">חיפוש מורה</a>        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a class="navbar-brand" href="MainPage.php">עמוד הבית</a></li>
      </ul>
    </div>
  </div>
</nav>
      <div class="container-fluid">
        <div class="container">
          <h2 class="text-center" id="title">   כניסה והרשמה</h2>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <form name="loginform" action="secondPageLogin.php" method="post">
                <fieldset>              
                 <h3> <p class="logSign text-uppercase pull-center"> משתמש חדש</p> </h3> <br>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input  type="text" class="form-control" name="username" placeholder="שם משתמש">
                  </div> <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="Password" placeholder="סיסמה">
                </div> <br>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="confirmPassword" placeholder="אמת סיסמה">
                </div>
                <br>
                <br>
                  <div class="text-center">
                        <input type="submit" class="logSignButton btn btn-lg btn-primary text-center" value="רשום">
                  </div>
                </fieldset>
              </form>
            </div>
            <div class="col-md-6">
                <fieldset>              
                  <h3><p class="logSign text-uppercase"> משתמש קיים: </p> </h3>
                     <br>
                    <form name="loginform" action="profile.php" method="post">
                      <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                      <input type="text" class="form-control" name="usernameLogin" placeholder="שם משתמש">
                    </div> <br>
                        <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="PasswordLogin" placeholder="סיסמה">
                      </div> <br> <br>
                      <div class="text-center">
                        <input type="submit" class="logSignButton btn btn-lg btn-primary" value="כניסה">
                      </div>
                     </form>
                </fieldset>
            </div>
          </div>
        </div>
      </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</html>