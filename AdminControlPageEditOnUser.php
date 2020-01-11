<?php
  session_start();
  $ID=$_POST['ImgId'];
  $AdminPutId=$_GET['id'];
  if ($ID!=1) 
  {
      $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $msg = "";
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
					else
					{

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
        else if ($_POST['ImgUsername']!=null) 
        {
          $username=$_POST['ImgUsername'];
        }
        $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $results = mysqli_query($db, "SELECT * FROM teachers");
        $ID=0;
        $fN=" ";
        $lN=" ";
        $email=" ";
        $pri=" ";
        $sta=" "; 
        $Phone=" ";
        $username=" ";
        while ($row=mysqli_fetch_assoc($results)) 
        {
          if ($row['id']==$AdminPutId) 
          {
            $ID=$row['id'];
            $username=$row['username'];
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
  <title>הכיתה</title>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <style>
        body
        {
          direction: rtl;
          text-align: center;
        }
        input[type=submit] 
        {
            max-width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
          }
         input[type=submit]:hover 
         {
            background-color: #45a049;
         }
         .chooseImg
         {
          max-width: 10%
          padding-right:50%;
          margin-right: 46%;
         }
         .file-field.big .file-path-wrapper 
         {
            height: 3.2rem; 
          }
          .file-field.big .file-path-wrapper .file-path 
          {
            height: 3rem; 
          }
      </style>
</head>
<body>
 <nav class="navbar navbar-default">
        <div class="container">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-left">
            <li>
              <a href="MainPage.php">יציאה</a>
            </li>
            <li>
              <a href="AdminControlPage.php">עמוד המנהל</a>
            </li>
            <li>
              <a href="#">שאלות ותשובות</a>
            </li>
          </ul>
          <div class="navbar-header navbar-right">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <a class="navbar-brand" href="MainPage.php">הכיתה</a>
        </div>
        </div>
      </div>
    </nav>
<hr>
<div class="container bootstrap snippet">
    <div class="row">
      <div class="col-sm-10"><h1>עדכון פרטים</h1></div>
      <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="img/edit.jpg"></a></div>
    </div>
    <div class="row">
      <div ><!--left col-->
              
      <div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active">
                  <h1> <?php echo $username ?></h1>
                </li>
              </ul>              
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="AdminControlPageEditOnUserSaveEdit.php" method="post" id="registrationForm">
                      <div class="form-group">
                            <div class="col-xs-12">
                                <label for="user_name"></label>
                                <input type="hidden" class="form-control" name="username" value="<?php echo $username?>">
                            </div>
                        </div>
                      <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="last_name"><h4>שם משפחה</h4></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lN?>" >
                            </div>
                        </div>
                        <div class="form-group">                          
                            <div class="col-xs-6">
                                <label for="first_name"><h4>שם פרטי</h4></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $fN?>" title="enter your first name if any.">
                            </div>
                        </div> 
                        <div class="form-group">                         
                            <div class="col-xs-6">
                                <label for="phone"><h4>   מספר טלפון    </h4></label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                            </div>
                        </div>
                          
                      <div class="form-group">
                                <div class="col-xs-6">
                                <label for="email"><h4>Email</h4></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                               <label for="mobile"><h4>סטטוס</h4></label>
                                <input type="text" class="form-control" name="status" id="status" placeholder="<?php echo $sta?>" >
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="col-xs-6">
                                <label for="price"><h4>מחיר לשעה</h4></label>
                                <input type="number" class="form-control" name="price" placeholder="<?php echo $pri?>">
                            </div>
                        </div>
                        <div class="form-group">                          
                            <div class="col-xs-6">
                              <label for="password2"><h4>אימות סיסמה</h4></label>
                                <input type="password" class="form-control" name="password2" id="password2" placeholder="אימות הסיסמה החדשה">
                            </div>
                        </div>  
                        <div class="form-group">                          
                            <div class="col-xs-6">
                                <label for="password"><h4>סיסמה</h4></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                            </div>
                        </div> 
                      <div class="form-group">
                             <div class="col-xs-6">
                                  <div style=" padding-top: 2%;">
                                    עירים
                                     <select name="framework" id="framework" class="form-control selectpicker" data-live-search="true" multiple >
                                        <option class="c" value="Acre">עכו</option>
                                    <option value="Afula">עפולה</option>
                                    <option value="Arad">ערד</option>
                                    <option value="Arraba">עראבה</option>
                                    <option value="Ashdod">אשדוד</option>
                                    <option value="Ashkelon">אשכלון</option>
                                    <option value="Baqa al-Gharbiyye">באקה אל גרביה</option>
                                    <option value="Bat Yam">בת ים</option>
                                    <option value="Beersheba">באר שבע</option>
                                    <option value="Beit She\'an">בית שאן</option>
                                    <option value="Beit Shemesh">בית שמש</option>
                                    <option value="Bnei Brak">בני ברק</option>
                                    <option value="Dimona">דימונה</option>
                                    <option value="Eilat">אילת</option>
                                    <option value="El\'ad">אלעד</option>
                                    <option value="Giv\'at Shmuel">גבעת שמואל</option>
                                    <option value="Givatayim">גבעתיים</option>
                                    <option value="Hadera">חדרה</option>
                                    <option value="Haifa">חיפה</option>
                                    <option value="Herzliya">הרצליה</option>
                                    <option value="Hod HaSharon">הוד השרון</option>
                                    <option value="Holon">חולון</option>
                                    <option value="Jerusalem">ירושלים</option>
                                    <option value="Kafr Qasim">כפר קאסם</option>
                                    <option value="Karmiel">כרמיאל</option>
                                    <option value="Kfar Saba">כפר סבא</option>
                                    <option value="Kfar Yona">כפר יונה</option>
                                    <option value="Kiryat Ata">כפר אתא</option>
                                    <option value="Kiryat Bialik">קרית ביאליק</option>
                                    <option value="Kiryat Gat">קרית גת</option>
                                    <option value="Kiryat Malakhi">קרית מלאכי</option>
                                    <option value="Kiryat Motzkin">קרית מוצקין</option>
                                    <option value="Kiryat Ono">קרית אונו</option>
                                    <option value="Kiryat Shmona">קרית שמונה</option>
                                    <option value="Kiryat Yam">קרית ים</option>
                                    <option value="Lod">לוד</option>
                                    <option value="Ma'alot Tarshiha">מעלות תרשיחא</option>
                                    <option value="Migdal HaEmek">מגדל העמק</option>
                                    <option value="Modi\'in-Maccabim-Re\'ut">מודעין מכבים רעות</option>
                                    <option value="Nahariya">נהריה</option>
                                    <option value="Nazareth">נצרת</option>
                                    <option value="Nesher">נשר</option>
                                    <option value="Ness Ziona">נס ציונה</option>
                                    <option value="Netanya">נתניה</option>
                                    <option value="Netivot">נתיבות</option>
                                    <option value="Nof HaGalil">נוף הגליל</option>
                                    <option value="Ofakim">אופקים</option>
                                    <option value="Or Akiva">אור עקיבה</option>
                                    <option value="Or Yehuda">אור יהודה</option>
                                    <option value="Petah Tikva">פתח תקווה</option>
                                    <option value="Qalansawe">קלנסווה</option>
                                    <option value="Ra\'anana">רעננה</option>
                                    <option value="Rahat">רהט</option>
                                    <option value="Ramat Gan">רמת גן</option>
                                    <option value="Ramat HaSharon">רמת השרון</option>
                                    <option value="Ramla">רמלה</option>
                                    <option value="Rehovot">רחובות</option>
                                    <option value="Rishon LeZion">ראשון לציון</option>
                                    <option value="Rosh HaAyin">ראש העין</option>
                                    <option value="Safed">צפת</option>
                                    <option value="Sakhnin">סכנין</option>
                                    <option value="Sderot">סדירות</option>
                                    <option value="Shfa-\'Amr">שפא עמר</option>
                                    <option value="Tamra">טמרה</option>
                                    <option value="Tayibe">טייבה</option>
                                    <option value="Tel Aviv-Yafo">תל אביב-יפו</option>
                                    <option value="Tiberias">טבריה</option>
                                    <option value="Tira">טירה</option>
                                    <option value="Tirat Carmel">טירת-הכרמל</option>
                                    <option value="Umm al-Fahm">אום אל-פחם</option>
                                    <option value="Yavne">יבנה</option>
                                    <option value="Yehud-Monosson">יהוד מונוסון</option>
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
                                    קורסים שמלמד
                                     <select name="frameworkCourse" id="frameworkCourse" class="form-control selectpicker" data-live-search="true" multiple >
                                        <option class="c" value="English">אינגלית</option>
                                        <option class="c" value="Arabic">ערבית</option>
                                        <option class="c" value="Math">מתמטיקה/חשבון</option>
                                        <option class="c" value="Music">מוסיקס</option>
                                        <option class="c" value="Physic">פיזיקה</option>
                                        <option class="c" value="Android">אנדרויד</option>
                                        <option class="c" value="Java">גוו</option>
                                     </select>
                                     <br /><br />
                                     <input type="hidden" name="hidden_framework_courses" id="hidden_framework_courses" />                                  
                             
                                  <br />
                                 </div>
                                </div>  
                              </div>
                     <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                                  <label for="Save"><h4></h4></label>
                                  <input type="submit" name="Save" value="שמור">
                                <!--  <a href="secondEditPage.php?username=<?php echo $username ; ?>" >
                                <button type="button" class="btn btn-lg btn-success">Save</button>
                              </a>-->
                            </div>
                      </div>
                </form>
             </div><!--/tab-pane-->
             
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->
          <div class="col-sm-3">

            <form method="POST" action="edit.php" enctype="multipart/form-data">
          <input type="hidden" class="form-control" name="ImgUsername" value="<?php echo $username?>">
          <input type="hidden" class="form-control" name="ImgId" value="<?php echo $ID?>">
          <input type="hidden" name="size" value="1000000">
          <hr>
          <hr>
          <h4>צרף תמונה חדשה....</h4>
          <div class="chooseImg">
            <input class="file-path validate" type="file" name="image">
          </div>
          <div>
            <button type="submit" name="upload">שמור תמונה</button>
          </div>
        </form>
          <br><br>
          <button class="btn btn-dark" onClick="goToDeletePage()">מחק משתמש</button>
          </div>
        </div><!--/col-9-->
    </div><!--/row-->
    <script>
      function goToDeletePage()
      {
        var getIdFromPhpCode = "<?php echo $AdminPutId ?>";
        window.location.href="deleteUser.php?id="+getIdFromPhpCode;
      }
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
   return false;
  }
 });
});
</script>