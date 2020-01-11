<?php
  session_start();
  $ID=$_POST['ImgId'];
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
        //echo " will print {";    echo $_GET['username'];      
        if ($_GET['username']!=null) 
        {
          $username=$_GET['username'];
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>הכיתה</title>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    
        
        <link rel="stylesheet" type="text/css" href="css/editProfilePageStyle.css">
    </head>
    <body>
        <a id="button"></a>
        <section class="topOptions">
            <div class="container">
                <div class="row">
                    <a class="navbarOptions btn btn-secondary btn-lg active col-sm-3"  href="MainPage.php"> יציאה </a>
                    <a class="navbarOptions btn btn-secondary btn-lg active col-sm-3"  href="MainPage.php"> עמוד הבית </a>
                    <a class="navbarOptions btn btn-secondary btn-lg active col-sm-3" href="profile.php">חזרה לעמוד הפרופיל</a>                  
                </div>
            </div class="container">
        </section>
        <section class="choose">
            <div class="row">
            <button class="tablink col-sm-3" onclick="openPage('Links', this, 'blue')">קישורים</button>
            <button class="tablink col-sm-3" onclick="openPage('citiesAndCourses', this, 'orange')">קורסים ועירים</button>
            <button class="tablink col-sm-3" onclick="openPage('Account', this, 'green')">הגדרת חשבון</button>
            <button class="tablink col-sm-3" onclick="openPage('profile', this, 'blueviolet')"id="defaultOpen">הגדרות פרופיל</button>
        </div>
            <div id="profile" class="tabcontent">  
                <form class="form" action="secondEditPage.php" method="post" id="registrationForm">
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
                <div class="form-group">
                    <div class="col-sm-6"> 
                       <label for="mobile"><h4  class="inputTitle">סטטוס</h4></label>
                        <input type="text" class="form-control" name="status" id="status" placeholder="<?php echo $sta?>" >
                </div>
            </div>
                <div class="form-group">
                    <div class="col-sm-6"> 
                        <label for="price"><h4  class="inputTitle">מחיר לשעה</h4></label>
                        <input type="number" class="form-control" name="price" placeholder="<?php echo $pri?>">                   
                </div>
            </div>
                 <div class="form-group">
                    <br>
                      <label for="Save"><h4></h4></label>
                      <input class="btn btn-primary" type="submit" name="Save" value="שמור">
                </div>
            </form>
            <div id="image" class="ImageSection">

                <form method="POST" action="edit.php" enctype="multipart/form-data">
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
                
                <form class="form" action="secondEditPage.php" method="post" id="registrationForm">
                <div class="form-group">  
                        <label for="password"><h4  class="inputTitle">סיסמה</h4></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                </div> 
                <div class="form-group">  
                      <label for="password2"><h4  class="inputTitle">אימות סיסמה</h4></label>
                        <input type="password" class="form-control" name="password2" id="password2" placeholder="אימות הסיסמה החדשה">
                </div>
                <div class="form-group">
                    <br>
                      <label for="Save"><h4></h4></label>
                      <input class="btn btn-light" type="submit" name="Save" value="שמור">
                </div>
            </form>
            </div>

            <div id="citiesAndCourses" class="tabcontent">
                <form method="POST" action="secondEditPage.php" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-xs-6">
                         <div style=" padding-top: 2%;">
                           <h4  class="inputTitleCitiesAndCourses">עיר</h4>
                           <select name="framework" id="framework" class="form-control selectpicker" data-live-search="true" multiple >
                           <option class="c" value="עכו">עכו</option>
                           <option value="עפולה">עפולה</option>
                           <option value="ערד">ערד</option>
                           <option value="עראבה">עראבה</option>
                           <option value="אשדוד">אשדוד</option>
                           <option value="אשכלון">אשכלון</option>
                           <option value="באקה אל גרביה">באקה אל גרביה</option>
                           <option value="בת ים">בת ים</option>
                           <option value="באר שבע">באר שבע</option>
                           <option value="בית שאן">בית שאן</option>
                           <option value="בית שמש">בית שמש</option>
                           <option value="בני ברק">בני ברק</option>
                           <option value="דימונה">דימונה</option>
                           <option value="אילת">אילת</option>
                           <option value="אלעד">אלעד</option>
                           <option value="גבעת שמואל">גבעת שמואל</option>
                           <option value="גבעתיים">גבעתיים</option>
                           <option value="חדרה">חדרה</option>
                           <option value="חיפה">חיפה</option>
                           <option value="הרצליה">הרצליה</option>
                           <option value="הוד השרון">הוד השרון</option>
                           <option value="חולון">חולון</option>
                           <option value="ירושלים">ירושלים</option>
                           <option value="כפר קאסם">כפר קאסם</option>
                           <option value="כרמיאל">כרמיאל</option>
                           <option value="כפר סבא">כפר סבא</option>
                           <option value="כפר יונה">כפר יונה</option>
                           <option value="כפר אתא">כפר אתא</option>
                           <option value="קרית ביאליק">קרית ביאליק</option>
                           <option value="קרית גת">קרית גת</option>
                           <option value="קרית מלאכי">קרית מלאכי</option>
                           <option value="קרית מוצקין">קרית מוצקין</option>
                           <option value="קרית אונו">קרית אונו</option>
                           <option value="קרית שמונה">קרית שמונה</option>
                           <option value="קרית ים">קרית ים</option>
                           <option value="לוד">לוד</option>
                           <option value="מעלות תרשיחא">מעלות תרשיחא</option>
                           <option value="מגדל העמק">מגדל העמק</option>
                           <option value="מודעין מכבים רעות">מודעין מכבים רעות</option>
                           <option value="נהריה">נהריה</option>
                           <option value="נצרת">נצרת</option>
                           <option value="נשר">נשר</option>
                           <option value="נס ציונה">נס ציונה</option>
                           <option value="נתניה">נתניה</option>
                           <option value="נתיבות">נתיבות</option>
                           <option value="נוף הגליל">נוף הגליל</option>
                           <option value="אופקים">אופקים</option>
                           <option value="אור עקיבה">אור עקיבה</option>
                           <option value="אור יהודה">אור יהודה</option>
                           <option value="פתח תקווה">פתח תקווה</option>
                           <option value="קלנסווה">קלנסווה</option>
                           <option value="רעננה">רעננה</option>
                           <option value="רהט">רהט</option>
                           <option value="רמת גן">רמת גן</option>
                           <option value="רמת השרון">רמת השרון</option>
                           <option value="רמלה">רמלה</option>
                           <option value="רחובות">רחובות</option>
                           <option value="ראשון לציון">ראשון לציון</option>
                           <option value="ראש העין">ראש העין</option>
                           <option value="צפת">צפת</option>
                           <option value="סכנין">סכנין</option>
                           <option value="שדרות">שדרות</option>
                           <option value="שפרעם"> שפרעם</option>
                           <option value="טמרה">טמרה</option>
                           <option value="טייבה">טייבה</option>
                           <option value="תל אביב-יפו">תל אביב-יפו</option>
                           <option value="טבריה">טבריה</option>
                           <option value="טירה">טירה</option>
                           <option value="טירת הכרמל">טירת-הכרמל</option>
                           <option value="אום אל-פחם">אום אל-פחם</option>
                           <option value="יבנה">יבנה</option>
                           <option value="יהוד-מונוסון">יהוד מונוסון</option>
                           <option value="Yokneam Illit">יקנעם עלית</option>
                            </select>
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
                              <select name="frameworkCourse" id="frameworkCourse" class="form-control selectpicker" data-live-search="true" multiple >
                              <option class="c" value="אנגלית">אנגלית</option>
                                   <option class="c" value="ערבית">ערבית</option>
                                   <option class="c" value="מתמטיקה">מתמטיקה/חשבון</option>
                                   <option class="c" value="מוסיקה">מוסיקה</option>
                                   <option class="c" value="פיזיקה">פיזיקה</option>
                                   <option class="c" value="אנדרויד">אנדרויד</option>
                                   <option class="c" value="גאווה">ג'אווה</option>
                                </select>
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
