<?php
// get to this page/file ---> after the new user sign up
  session_start();
  if(isset($_POST['first_name'])||isset($_POST['last_name']))
  {
    $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $resultsOfTeachers = mysqli_query($db, "SELECT * FROM teachers");
    $resultsOfImageTable = mysqli_query($db, "SELECT * FROM images");
    $max=0;
    $user=" ";
    //get the new user id and username
    while ($row=mysqli_fetch_assoc($resultsOfTeachers)) 
    {
      $max=$row['id'];
      $user=$row['username'];
    }
    
    $fN=$_POST['first_name'];
    $lN=$_POST['last_name'];
    $eMail=$_POST['email'];
    //$pri=$_POST['price'];
    $sta=$_POST['status'];
    $PHONE=$_POST['phone'];

    $gender=$_POST['frameworkGender'];
    $studentOrTeacher=$_POST['frameworkstudentOrTeacher'];
      
    // enter the new information like (first name, last name, email address,etc...)
    $upDate="UPDATE `teachers` SET `fname`='$fN'WHERE id=$max";
    $result = mysqli_query($db,$upDate);

    $upDate="UPDATE `teachers` SET `lname`='$lN'WHERE id=$max";
    $result = mysqli_query($db,$upDate);

    $upDate="UPDATE `teachers` SET `email`='$eMail'WHERE id=$max";
    $result = mysqli_query($db,$upDate);

    if($gender!='male')
    {
      $upDate="UPDATE `teachers` SET `gender`='$gender'WHERE id=$max";
      $result = mysqli_query($db,$upDate);    
      $ImgSource="womenDefaultImage.png";
      $upDate="UPDATE `images` SET `image`='$ImgSource'WHERE id=$max";
      $result = mysqli_query($db,$upDate);
    }
    else
    {
      $gender='male';
      $upDate="UPDATE `teachers` SET `gender`='$gender'WHERE id=$max";
      $result = mysqli_query($db,$upDate);
      $ImgSource="manDefaultImage.png";
      $upDate="UPDATE `images` SET `image`='$ImgSource'WHERE id=$max";
      $result = mysqli_query($db,$upDate);
    }

    if($studentOrTeacher!='teacher')
    {
      $upDate="UPDATE `teachers` SET `setUserAs`='$studentOrTeacher'WHERE id=$max";
      $result = mysqli_query($db,$upDate);
    }
    else
    {
      $studentOrTeacher='teacher';
      $upDate="UPDATE `teachers` SET `setUserAs`='$studentOrTeacher'WHERE id=$max";
      $result = mysqli_query($db,$upDate);
    }

    /*
    $upDate="UPDATE `teachers` SET `price`='$pri'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
    */
    
    $upDate="UPDATE `teachers` SET `status`='$sta'WHERE id=$max";
    $result = mysqli_query($db,$upDate);

    $upDate="UPDATE `teachers` SET `phone`='$PHONE'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
  /* $upDate="UPDATE `teachers` SET `image`='$IMG'WHERE id=$max";
    $result = mysqli_query($db,$upDate);
  */

  $_SESSION['varname'] = $user;
    if ($user=="AdminEliEssiak") // login of admin (need to change that)
    {
      header('location: AdminControlPage.php');
    }
    else// sign up of a normal user
    {
      if( $studentOrTeacher=='teacher')
      {
        header('location: profile.php');
      }
      else{
        header('location: studentProfile.php');
      }
    }
  }
  $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  $results = mysqli_query($db, "SELECT * FROM teachers");
  $ID;
  //get the last ID (the new user)
  while ($row=mysqli_fetch_assoc($results)) 
  {
    $ID=$row['id'];
  }  
  // create a new Tables and enter the new user in
    $query="INSERT INTO `teachers_courses`(`id`,`subject`) VALUES ('$ID','subject')";
    $result = mysqli_query($db,$query);

    $query="INSERT INTO `teacher_cities`(`id`,`cities`) VALUES ('$ID','cities')";
    $result = mysqli_query($db,$query);

    $query="INSERT INTO `images`(`image`,`text`,`id`) VALUES ('image','text','$ID')";
    $result = mysqli_query($db,$query);
?>
<!DOCTYPE html>
<html>
        <head>
        <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>הכיתה</title>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    
          <link rel="stylesheet" type="text/css" href="css/styleLogin.css">
          <style>
          #button 
        {
            display: inline-block;
            background-color: #4cae4c;
            width: 50px;
            height: 50px;
            text-align: center;
            border-radius: 4px;
            position: fixed;
            bottom: 30px;
            right: 30px;
            transition: background-color .3s, 
                opacity .5s, visibility .5s;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
         }
            #button::after {
            content: "\f077";
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            font-size: 2em;
            line-height: 50px;
            color: #fff;
            }
            #button:hover {
            cursor: pointer;
            background-color: #333;
            }
            #button:active {
            background-color: #555;
            }
            #button.show {
            opacity: 1;
            visibility: visible;
            }

            /* Styles for the content section */

            .content {
            width: 77%;
            margin: 50px auto;
            font-family: 'Merriweather', serif;
            font-size: 17px;
            color: #6c767a;
            line-height: 1.9;
            }
            @media (min-width: 500px) {
            .content {
                width: 43%;
            }
            #button {
                margin: 30px;
            }
            }
          
          </style>
          <script>
            function myFunction(x) 
            {
              x.style.background = "#00bdff";
            }
            </script>
        </head>
        <body>
          <a id="button"></a>
            <nav class="navbar navbar-inverse">
            <div class="container-fluid">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="Hakita.php">עמוד הבית</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="Hakita.php">יציאה</a></li>
            </ul>
            </div>
        </div>
        </nav>
        <div class="container bootstrap snippet">
            <div class="row">
                <h1 id="title">נא למלא את הפרטים</h1>
            <div class="row">
              </hr><br>      
                </div>
              <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li class="active">
                          <h1>
                          <?php
                            echo $us;
                          ?>
                          </h1>
                        </li>
                      </ul>              
                  <div class="tab-content col-sm-9">
                    <div class="tab-pane active" id="home">
                        <hr>
                          <form class="form" action="secondLogin.php" method="post" id="registrationForm">                   
                              <div class="form-group">
                                  <div class="col-xs-12">
                                      <label for="user_name"></label>
                                      <input type="hidden" class="form-control" name="username">
                                  </div>
                              </div>
                              <div class="form-group"> 
                                <div class="col-sm-12">
                                    <label for="first_name"><h4 class="inputWords">שם פרטי</h4></label>
                                    <input type="text" class="inputWordsInside form-control" name="first_name" id="first_name" placeholder="שם פרטי" title="enter your first name if any.">
                                </div>
                            </div>
                              <div class="form-group">                          
                                  <div class="col-sm-12">
                                    <label for="last_name"><h4 class="inputWords">שם משפחה</h4></label>
                                      <input type="text" class="inputWordsInside form-control" name="last_name" id="last_name"placeholder="שם משפחה" >
                                  </div>
                              </div>             
                              <div class="form-group">                         
                                  <div class="col-sm-12">
                                      <label for="phone"><h4 class="inputWords">מספר טלפון</h4></label>
                                      <input type="text" class="inputWordsInside form-control" name="phone" id="phone" placeholder="מספר טלפון">
                                  </div>
                              </div>  
                              <div class="form-group">
                                      <div class="email col-sm-12">
                                      <label for="email"><h4 class="inputWords">Email</h4></label>
                                      <input type="email" class="inputWordsInside form-control" name="email" id="email" placeholder="your.email@email.com" title="enter your email.">
                                  </div>
                              </div>
                        <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="studentOrTeacher"><h4 class="inputWords">משתמש באתר מוגדר כ-</h4></label>
                                        <select name="frameworkstudentOrTeacher" id="frameworkstudentOrTeacher" class="form-control selectpicke"  data-live-search="true" >
                                            <option class="c" value="teacher">מורה</option>
                                            <option class="c" value="student">תלמיד/ה</option>
                                            <option class="c" value="teacher">גם מורה גם תלמיד</option>
                                          </select>
                                <br /><br />
                                <input type="hidden" name="hidden_framework_studentOrTeacher" id="hidden_framework_studentOrTeacher"/>                                  
                        
                             <br />
                                    </div>
                              </div>   
                              <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="gender"><h4 class="inputWords">מין</h4></label>
                                        <select name="frameworkGender" id="frameworkGender" class="form-control selectpicke"  data-live-search="true" >
                                            <option class="c" value="male">זכר</option>
                                            <option class="c" value="female">נקבה</option>
                                            <option class="c" value="male">אחר</option>
                                          </select>
                                <br /><br />
                                <input type="hidden" name="hidden_framework_gender" id="hidden_framework_gender"/>                                  
                        
                             <br />
                                    </div>
                              </div>   
                             <div class="form-group">
                                   <div class="col-xs-12">
                                        <br>
                                          <label for="Save"></label>
                                          <input id="saveButton" type="submit" name="Save" value="שמור והמשך">
                                    </div>
                              </div>
                        </form>
                     </div>             
                  </div>
                  <div class="tab-content col-sm-3">
                    <h5 id="titleOfCanChangeInformations">***ניתן יהיה לשנות את כל הפרטים אחר כך***</h5>
                    <br>
                    <br>
                    <br>
                    <p>
                      שתי השדות של שם פרטי ושם משפחה לייצג אותך להציג אותך כמשתמש בהודעות. במידה והחשבון הוגדר כמורה ניתן יהיה לחפש לפי השם
                    </p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p>מספר הטלפון כך לצור איתך קשר, אפשר שלא לרשום גם</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p>
                        הגדרת המשתמש כ-תלמיד לא תיתן את האפשרות לחפש אותך ב- (חיפוש מורה)
                    </p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p>
                      במידה והחשבון הוגדר כתלמיד/ה החשבון לא יופיע כמורה 
                    </p>
                    <br>
                    <br>
                    <p>
                      הגדרת המין עוזרת בחיפוש לאנשים שמעדיפים מורים גברים או נשים 
                    </p>
                  </div>
                  </div>
                </div>
            </div>
            <script>
              var btn = $('#button');
              $(window).scroll(function() {
              if ($(window).scrollTop() > 300) {
                  btn.addClass('show');
              } else {
                  btn.removeClass('show');
              }
              });
              btn.on('click', function(e) {
              e.preventDefault();
              $('html, body').animate({scrollTop:0}, '300');
              });
          </script>
    </body>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
</html>  
      
<script>
    $(document).ready(function(){
     $('.selectpicker').selectpicker();
    
     $('#frameworkstudentOrTeacher').change(function(){
      $('#hidden_framework_studentOrTeacher').val($('#frameworkstudentOrTeacher').val());
     });
    
     $('#multiple_select_form').on('Save', function(event){
      event.preventDefault();
      if($('#frameworkstudentOrTeacher').val() != '')
      {
       var form_data = $(this).serialize();
       $.ajax({
        url:"thirdPageLogin.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
         //console.log(data);
         $('#hidden_framework_studentOrTeacher').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       alert("נא לבחור הגדרה");
       return false;
      }
     });
    });
    </script>       
<script>
    $(document).ready(function(){
     // console.log("is here");
     $('.selectpicker').selectpicker();
    
     $('#frameworkGender').change(function(){
      $('#hidden_framework_gender').val($('#frameworkGender').val());
     });
    
     $('#multiple_select_form').on('Save', function(event){
      event.preventDefault();
      if($('#frameworkGender').val() != '')
      {
       var form_data = $(this).serialize();
       $.ajax({
        url:"thirdPageLogin.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
         console.log(data);
         $('#hidden_framework_gender').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       alert("נא לבחור מין");
       return false;
      }
     });
    });
    </script>                                                  