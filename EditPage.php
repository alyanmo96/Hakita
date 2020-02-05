<?php
/**
 * edit page for teachers
 */
  $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
  session_start();
  $makeChangeEnter = mysqli_query($con, "SELECT * FROM makeChange");
  $userMakeChange=-1;
  if(isset($_POST['first_name'])||isset($_POST['last_name'])||
  isset($_POST['email'])||isset($_POST['phone'])||
  isset($_POST['password'])||isset($_POST['verifyPassword'])||
  isset($_POST['price'])||isset($_POST['status'])||
  isset($_POST['hidden_framework'])||isset($_POST['hidden_framework_courses']))
  {
        $ID=$_POST['id'];
        $results = mysqli_query($con, "SELECT * FROM teachers");
        if ($_POST['first_name']) 
        {
            $fName=$_POST['first_name'];
            $upDate="UPDATE `teachers` SET `fname`='$fName'WHERE id=$ID";
            $results = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }        
        if ($_POST['last_name']) 
        {
            $lName=$_POST['last_name'];
            $upDate="UPDATE `teachers` SET `lname`='$lName'WHERE id=$ID";
            $results = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }
        if ($_POST['email']) 
        {
            $Email=$_POST['email'];
            $upDate="UPDATE `teachers` SET `email`='$Email'WHERE id=$ID";
            $results = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }        
        if ($_POST['password']) 
        {
            if ($_POST['password']==$_POST['verifyPassword']) 
            {
                $pass=$_POST['password'];
                $upDate="UPDATE `teachers` SET `password`='$pass'WHERE id=$ID";
                $results = mysqli_query($con,$upDate);
                $userMakeChange=1;
            }
        }
        if ($_POST['phone']) 
        {
            $phone=$_POST['phone'];
            $upDate="UPDATE `teachers` SET `phone`='$phone'WHERE id=$ID";
            $results = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }  
        if ($_POST['status']) 
        {
            $status=$_POST['status'];
            $upDate="UPDATE `teachers` SET `status`='$status'WHERE id=$ID";
            $results = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }          
        if ($_POST['price']) 
        {
            $price=$_POST['price'];
            $upDate="UPDATE `teachers` SET `price`='$price'WHERE id=$ID";
            $results = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }          
        if ($_POST['hidden_framework']) 
        {
            $Cities=$_POST['hidden_framework'];
            $upDate="UPDATE `teacher_cities` SET `cities`='$Cities'WHERE id=$ID";
            $result = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }          
        if ($_POST['hidden_framework_courses']) 
        {
            $Courses=$_POST['hidden_framework_courses']; 
            $upDate="UPDATE `teachers_courses` SET `subject`='$Courses'WHERE id=$ID";
            $result = mysqli_query($con,$upDate);
            $userMakeChange=1;
        }  
  }
  if ($userMakeChange==1)//this table used for admin, to check who make change
  {
      $query="INSERT INTO `makeChange`(`id`) VALUES ('$ID')";
      $makeChangeEnter = mysqli_query($con,$query);
  }
  //update image
  if($_POST['ImgId'])
  {
    $ID=$_POST['ImgId'];
  }  
  if ($ID!=1) 
  {
    //echo " if (ID!=1) ";
      $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $msg = "";
        // If upload button is clicked ...
        if (isset($_POST['upload'])) {
          // Get image name
          $image = $_FILES['image']['name'];
          // Get text
          $image_text = mysqli_real_escape_string($con, $_POST['image_text']);

          // image file directory
          $target = "img/".basename($image);
          $ThereIsImage=-1;
            $results = mysqli_query($con, "SELECT * FROM images");
      while ($rows=mysqli_fetch_array($results)) 
      {
        if ($rows['id']==$ID) 
        {
          if (($rows['image']!=null)||($rows['image']!='image'))
          {
            $ThereIsImage=1;
          }
        }
      }
      if ($ThereIsImage==-1) 
      {
        $sql="INSERT INTO `images`(`image`,`text`,`id`) VALUES ('$image','$image_text','$ID')";
            // execute query
        $result =mysqli_query($con, $sql);
      }
      else
      {
        $upDate="UPDATE `images` SET `image`='$image'WHERE id=$ID";
        $result = mysqli_query($con,$upDate);
      }
          if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
          }else{
            $msg = "Failed to upload image";
          }
        }
  }   
        if ($_GET['username']!=null) 
        {
          $username=$_GET['username'];
        }
        else if ($_POST['username']!=null) 
        {
          $username=$_POST['username'];
        }
        else if ($_POST['ImgUsername']!=null) 
        {
          $username=$_POST['ImgUsername'];
        }
       // echo " } ";
        $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $results = mysqli_query($db, "SELECT * FROM teachers");
        $ID=0;
        $fN=" ";
        $lN=" ";
        $email=" ";
        $pri=" ";
        $sta=" "; 
        $Phone=" ";
        while ($row=mysqli_fetch_assoc($results)) 
        {
          if ($row['username']==$username) 
          {
              $ID=$row['id'];
              $fN=$row['fname'];
              $lN=$row['lname'];
              $email=$row['email'];
              $pri=$row['price'];
              $sta=$row['status'];
              $Phone=$row['phone'];
          }
        }
        $_SESSION['varname'] = $username;
?>
<!DOCTYPE html>
<html>
    <head>

    <meta charset="utf-8">
  <title>הכיתה</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/editPageStyle.css">
  
    </head>
    <body>

    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="Hakita.php">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="profile.php"> עמוד הפרופיל<span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="Hakita.php"> עמוד הבית</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="Hakita.php">יציאה </a>
                  </li>
              </ul>
            </div>
          </nav>
    </section>  
    <a id="button"></a>
        <section class="choose">
        <div class="container">
                      
            <?php
                $isStudent=-1;
                $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                $resultss = mysqli_query($con, "SELECT * FROM teachers");
                while ($row=mysqli_fetch_assoc($resultss)) 
                {
                    if($row['id']==$ID && $row['setUserAs']=='student')
                    {
                        $isStudent=1;
                        echo"<div class=\"r\">  ";
                    }
                }
                if($isStudent==-1)
                {
                    echo"<div class=\"row\">  ";
                    echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('Links', this, 'blue')\">קישורים</button>";
                    echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('citiesAndCourses', this, 'orange')\">קורסים ועירים</button>";
                    echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('Account', this, 'green')\">הגדרת חשבון</button>";
                    echo" <button class=\"tablink col-sm-3\" onclick=\"openPage('profile', this, 'blueviolet')\"id=\"defaultOpen\">הגדרות פרופיל</button>";
                }
                else
                {
                    echo" <button class=\"tablink col-sm-4\" onclick=\"openPage('Links', this, 'orange')\">קישורים</button>";
                    
                    echo" <button class=\"tablink col-sm-4\" onclick=\"openPage('Account', this, 'green')\">הגדרת חשבון</button>";
                    
                    echo" <button class=\"tablink col-sm-4\" onclick=\"openPage('profile', this, 'blueviolet')\"id=\"defaultOpen\">הגדרות פרופיל</button>";
                }
            ?>
            </div>
        </div>
            <div id="profile" class="tabcontent">  
                <form class="form" action="EditPage.php" method="post" id="registrationForm">
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="user_name"></label>
                        <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="id"></label>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="col-sm-6"> 
                      <label for="last_name"><h4  class="inputTitle">שם משפחה</h4></label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lN?>" >
                </div>
            </div>
                <div class="form-group">
                    <div class="col-sm-6">   
                        <label for="first_name"><h4  class="inputTitle">שם פרטי</h4></label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $fN?>" title="enter your first name if any.">
                </div> 
            </div>
                <div class="form-group">
                    <div class="col-sm-6">   
                        <label for="phone"><h4  class="inputTitle">   מספר טלפון    </h4></label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                </div>
            </div>
              <div class="form-group">
                <div class="col-sm-6"> 
                        <label for="email"><h4  class="inputTitle">Email</h4></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">                   
                </div>
            </div>
                
            <?php
                if($isStudent!=1)
                {
                   echo " <div class=\"form-group\">
                            <div class=\"col-sm-6\"> 
                            <label for=\"mobile\"><h4  class=\"inputTitle\">סטטוס</h4></label>
                                <input type=\"text\" class=\"form-control\" name=\"status\" id=\"status\" placeholder=\" $sta\" >
                        </div>
                    </div>";
                    echo "<div class=\"form-group\">
                        <div class=\"col-sm-6\"> 
                            <label for=\"price\"><h4  class=\"inputTitle\">מחיר לשעה</h4></label>
                            <input type=\"number\" class=\"form-control\" name=\"price\" placeholder=\" $pri\">                   
                        </div>
                    </div>";
                }
                else
                {
                    echo " <div class=\"form-group\">
                            <div class=\"col-sm-12\"> 
                            <label for=\"mobile\"><h4  class=\"inputTitle\">סטטוס</h4></label>
                                <input type=\"text\" class=\"form-control\" name=\"status\" id=\"status\" placeholder=\" $sta\" >
                        </div>
                    </div>";
                }
            ?>                
                 <div class="form-group">
                    <br>
                      <label for="Save"><h4></h4></label>
                      <input class="btn btn-primary" type="submit" name="Save" value="שמור">
                </div>
            </form>
            <div id="image" class="ImageSection">

                <form method="POST" action="EditPage.php" enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="ImgUsername" value="<?php echo $username?>">
                <input type="hidden" class="form-control" name="ImgId" value="<?php echo $ID?>">
                <input type="hidden" name="size" value="1000000">
                <hr>
                <hr>
                <h4  class="inputImgTitle">לשנות תמונת פרופיל  </h4>
                <div class="chooseImg">
                    <input class="file-path validate" type="file" name="image" id="imgSource">
                </div>
                <div>
                    <br>
                    <button  class="btn btn-primary" id="saveImageButton" type="submit" name="upload">שמור תמונה</button>
                </div>
                </form>
              </div>
            </div>

            <div id="Account" class="tabcontent">
                
                <form class="form" action="EditPage.php" method="post" id="registrationForm">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="user_name"></label>
                            <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="id"></label>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                        </div>
                    </div>
                    <div class="form-group">  
                            <label for="password"><h4  class="inputTitle">סיסמה</h4></label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                    </div> 
                    <div class="form-group">  
                          <label for="verifyPassword"><h4  class="inputTitle">אימות סיסמה</h4></label>
                            <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה">
                    </div>
                    <div class="form-group">
                        <br>
                          <label for="Save"><h4></h4></label>
                          <input class="btn btn-light" type="submit" name="Save" value="שמור">
                    </div>
            </form>
            </div>

            <div id="citiesAndCourses" class="tabcontent">
                <form method="POST" action="EditPage.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="user_name"></label>
                            <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="id"></label>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $ID?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div style=" padding-top: 2%;">
                              <h4  class="inputTitleCitiesAndCourses">עיר</h4>
                              <?php
                                echo "<SELECT   name=\"framework\" id=\"framework\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                $results = mysqli_query($con, "SELECT * FROM cities");
                                echo'<option >'.'בדוק את הערים הקימות'.'</option>';
                                while ($rows=mysqli_fetch_array($results))
                                {
                                    echo'<option>'.$rows['cityName'].'</option>';
                                }
                                echo"</SELECT>";
                              ?>
                                <br /><br />
                                <input type="hidden" name="hidden_framework" id="hidden_framework" />                                  
                        
                            <br />
                            </div>
                          </div>  
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <div style=" padding-top: 2%;">
                                  <h4  class="inputTitleCitiesAndCourses">קורסים שמלמד</h4>
                                    <?php
                                      echo "<SELECT name=\"frameworkCourse\" id=\"frameworkCourse\"  class=\"form-control selectpicker\" data-live-search=\"true\">";
                                      $results = mysqli_query($con, "SELECT * FROM courses");
                                      echo'<option >'.'בדוק את המקצועות הקיימים  '.'</option>';
                                      while ($rows=mysqli_fetch_array($results))
                                      {
                                          echo'<option>'.$rows['subject'].'</option>';
                                      }
                                      echo"</SELECT>";
                                    ?>
                                    <br /><br />
                                    <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses" />                                  
                            
                                <br />
                                </div>
                              </div>  
                            </div>
                            <div class="form-group">
                                <br>
                                  <label for="Save"><h4></h4></label>
                                  <input class="btn btn-info" id="citiesAndCoursesSaveButton" type="submit" name="Save" value="שמור">
                            </div>
                    </form>
            </div>
            <div id="Links" class="tabcontent">
                <form class="form" action="secondEditPage.php" method="post" id="registrationForm">
                <div class="form-group">
                    <label for="facebook"><h4  class="inputTitleIcon">FACEBOOK</h4><div class="fa fa-facebook"></div></label>
                    <input type="text" class="form-control" name="facebook" placeholder="">                   
                </div>
                <div class="form-group">
                    <label for="linkedin"><h4  class="inputTitleIcon">LINKEDIN</h4><div class="fa fa-linkedin"></div></label>
                    <input type="text" class="form-control" name="linkedin" placeholder="">                   
                </div>
                <div class="form-group">
                    <label for="youtube"><h4  class="inputTitleIcon">YOUTUBE</h4><div class="fa fa-youtube"></div></label>
                    <input type="text" class="form-control" name="youtube" placeholder="">                   
                </div>
                <div class="form-group">
                    <label for="otherLinkOne"><h4  class="inputTitleIcon">קישור אחר</h4></label>
                    <input type="text" class="form-control" name="otherLinkOne" placeholder="">                   
                </div>
                <div class="form-group">
                    <label for="otherLinkTwo"><h4  class="inputTitleIcon">קישור אחר</h4></label>
                    <input type="text" class="form-control" name="otherLinkTwo" placeholder="">                   
                </div>
                <div class="form-group">
                    <br>
                      <label for="Save"><h4></h4></label>
                      <input class="btn btn-secondary" id="iconsSaveButton" type="submit" name="Save" value="שמור">
                </div>
            </form>
            </div>
            <div>
                
            </div>
        </section>
        <div class="ButtomSection">      
    <div class="container">
      <div class="row">
        <div class="col-sm-5">
          &copy;כל הזוכיות שמורות לאתר הכיתה
             
              <a href="https://www.jce.ac.il/">

                </a><br>
                קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          
                  <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
              
        </div>
        <div class="col-sm-3">
          📚            
      רשימת מקצועות לימוד
      <br>
      צור קשר איתנו📧
         
      <p >הוספת פרויפיל</p>
        </div>
        <div class="col-sm-4">
          עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
        </div>
      </div>
    </div>
      </div>


    <script>
    function openPage(pageName,elmnt,color) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = color;
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
    </script>
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
</html> 

<script>
    $(document).ready(function(){
     $('.selectpicker').selectpicker();
    
     $('#framework').change(function(){
       
      $('#hidden_framework').val($('#framework').val());
     });
    
     $('#multiple_select_form').on('Save', function(event){
      event.preventDefault();
      if($('#framework').val() != '')
      {
       var form_data = $(this).serialize();
       $.ajax({
        url:"secondEditPage.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
         //console.log(data);
         $('#hidden_framework').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       alert("נא לבחור עיר");
       return false;
      }
     });
    });
    </script>
    
    <script>
    $(document).ready(function(){
     $('.selectpicker').selectpicker();
    
     $('#frameworkCourse').change(function(){
      $('#hidden_framework_courses').val($('#frameworkCourse').val());
     });
    
     $('#multiple_select_form').on('Save', function(event){
      event.preventDefault();
      if($('#frameworkCourse').val() != '')
      {
       var form_data = $(this).serialize();
       $.ajax({
        url:"secondEditPage.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
         //console.log(data);
         $('#hidden_framework_courses').val('');
         $('.selectpicker').selectpicker('val', '');
         alert(data);
        }
       })
      }
      else
      {
       alert("נא לבחור עיר");
       return false;
      }
     });
    });
    </script>
