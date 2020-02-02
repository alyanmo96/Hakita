<?php
/**
 * 
 * 
 */
    session_start();
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    if(isset($_POST['newCourse']))
    {
        $course=$_POST['newCourse'];
        $query="INSERT INTO `courses`(`subject`) VALUES ('$course')";
        $result = mysqli_query($con,$query);
    }
    if(isset($_POST['newCity']))
    {
      $city=$_POST['newCity'];
      $query="INSERT INTO `cities`(`cityName`) VALUES ('$city')";
      $result = mysqli_query($con,$query);  
    }          
    if((isset($_POST['verifyPassword'])&&isset($_POST['password']))||
    isset($_POST['email'])||isset($_POST['phone'])||
    isset($_POST['first_name'])||isset($_POST['last_name']))
    {
        $adminId=211;
        $results = mysqli_query($con, "SELECT * FROM teachers");
        if ($_POST['first_name']) 
        {
            $fName=$_POST['first_name'];
            $upDate="UPDATE `teachers` SET `fname`='$fName'WHERE id=$adminId";
            $results = mysqli_query($con,$upDate);
        }        
        if ($_POST['last_name']) 
        {
            $lName=$_POST['last_name'];
            $upDate="UPDATE `teachers` SET `lname`='$lName'WHERE id=$adminId";
            $results = mysqli_query($con,$upDate);
        }
        if ($_POST['email']) 
        {
            $Email=$_POST['email'];
            $upDate="UPDATE `teachers` SET `email`='$Email'WHERE id=$adminId";
            $results = mysqli_query($con,$upDate);
        }        
        if ($_POST['password']) 
        {
            if ($_POST['password']==$_POST['verifyPassword']) 
            {
                $pass=$_POST['password'];
                $upDate="UPDATE `teachers` SET `password`='$pass'WHERE id=$adminId";
                $results = mysqli_query($con,$upDate);
            }
        }
        if ($_POST['phone']) 
        {
            $phone=$_POST['phone'];
            $upDate="UPDATE `teachers` SET `phone`='$phone'WHERE id=$adminId";
            $results = mysqli_query($con,$upDate);
        }  
    }
	$IdResults = mysqli_query($con, "SELECT * FROM teachers");
	$i=0;
	$IdArray = array();
	while ($rows=mysqli_fetch_array($IdResults))
	{
		if($rows['id']!=211)//not the admin.... also need to check that isnot a student
		{
			$IdArray[$i]=$rows['id'];
			$i++;
		}
	}
	$i-=1;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>הכיתה</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <link rel="stylesheet" type="text/css" href="css/AdminStyle.css">
    <style>
    .forme-group {
    margin-bottom: 1rem;
    float: right;
    margin: 1%;
}
    </style>
  </head>
  <body>
    <?php
        function getName($getIdOfUser)
        {
            $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
            $results = mysqli_query($con, "SELECT * FROM teachers");
            $NAME=" ";
            while ($rows=mysqli_fetch_array($results))
            {
                if ($rows['id']==$getIdOfUser)
                {
                    echo"<p>";
                    if ($rows["fname"]!=' '&&$rows["lname"]!=' ')
                    {
                        echo "" . $rows["fname"]. "  " . $rows["lname"]."<br />";
                    }
                    else if($rows["fname"]!=' '&&$rows["lname"]==' ')
                    {
                        echo "" . $rows["fname"]."<br />";
                    }
                    else if ($rows["fname"]==' '&&$rows["lname"]!=' ')
                    {
                        echo "" . $rows["lname"]."<br />";
                    }
                    echo"</p>";
                }
            }
            return $NAME;
        }
    ?>
    <a id="button"></a>
    <section><!--navbar section-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">הכיתה</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                  <li class="nav-item active">
                    <a class="nav-link" href="Hakita.php"> יציאה<span class="sr-only">(current)</span></a>
                  </li>
              </ul>
            </div>
          </nav>
    </section>
    <section class="choose">
                    <div class="row">
                    <button class="tablink col-sm-3" onclick="openPage('allUSers', this, 'blueviolet')"id="defaultOpen">   לכל המשתמשים </button>
                    <button class="tablink col-sm-3" onclick="openPage('teachers', this, 'orange')"> מורים</button>
                    <button class="tablink col-sm-3" onclick="openPage('students', this, 'blue')"> תלמידים</button> 
                    <button class="tablink col-sm-3" onclick="openPage('newCC', this, 'green')"> הוספת עיר/מקוצע חדשים </button>
                    <button class="tablink col-sm-3" onclick="openPage('newUSers', this, 'blueviolet')">   המשתמשים חדשים</button>
                    <button class="tablink col-sm-3" onclick="openPage('madeChange', this, 'green')"> מי עשה שינוי </button>
                    <button class="tablink col-sm-3" onclick="openPage('AdminDetails', this, 'orange')">  פרטי המנהל </button>

                </div>                
                <div id="allUSers" class="tabcontent">
                    <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6">
                                <?php                                
                                $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                                $allUsersArrayId=array();
                                $allUsersArrayIdCounter=0;
                                echo "<SELECT  name=\"searchAllChangedUsersByName\" id=\"searchAllChangedUsersByName\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                $results = mysqli_query($con, "SELECT * FROM teachers");
                                echo'<option >'.'בחר שם'.'</option>';
                                while ($rows=mysqli_fetch_array($results))
                                {
                                    if($rows['id']!=211)
                                    {
                                        echo'<option value="'.$rows['id'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
                                    }			
                                }
                                echo"</SELECT>";
                                echo"<input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\" />";
                                ?>
                        </div>
                        <br>
                        <hr>   
                        <section class="work">
                            <div class="container">
                            <div class="row">
                                <?php                              
                                    $j=0;
                                        while ($j<=$i)
                                        {
                                            if(1==1)
                                            {
                                                if($j%3==0)
                                                {
                                                    echo '<div class="teacher col-sm-12">';
                                                    echo "<hr><hr>";
                                                    echo "</div>";
                                                }
                                                $results = mysqli_query($con, "SELECT * FROM images");
                                                while ($rows=mysqli_fetch_array($results))
                                                {
                                                    if ($rows['id']==$IdArray[$j])
                                                    {
                                                        $allUsersArrayId[$allUsersArrayIdCounter]=$IdArray[$j]+155555;
                                                        $allUsersArrayIdCounter++;
                                                        $d=$IdArray[$j]+155555;
                                                        echo '<div class="teacher col-sm-4" id="$d">';
                                                        echo "<button value=\"$d\" id=\"$d\">";
                                                        echo"   <input type=\"hidden\" id=\"$d\">";
                                                        if ($rows['image']!='image'&&$rows['image']!=null)
                                                        {
                                                            echo "<img src='img/".$rows['image']."'   class='teacherImg img-rounded img-responsive'>";
                                                        }
                                                    }
                                                }
                                                $results = mysqli_query($con, "SELECT * FROM teachers");
                                                while ($rows=mysqli_fetch_array($results))
                                                {
                                                    if ($rows['id']==$IdArray[$j])
                                                    {
                                                        getName($IdArray[$j]);                                                        
                                                    }
                                                }
                                                echo "</button>";
                                                echo '</div>';
                                                echo "<br><br>";
                                            }
                                        $j++;
                                    }
                                ?>
                                </div>
                            </div>
                            </section> 
                    </div>                 
                  
                <div id="students" class="tabcontent">
                    <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6">
                                <?php                                
                                $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                                $studentArrayId=array();
                                $studentArrayIdCounter=0;
                                echo "<SELECT  name=\"searchStudentByName\" id=\"searchStudentByName\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                $results = mysqli_query($con, "SELECT * FROM teachers");
                                echo'<option >'.'בחר שם'.'</option>';
                                while ($rows=mysqli_fetch_array($results))
                                {
                                    if($rows['id']!=211&&$rows['setUserAs']=='student')
                                    {
                                        echo'<option value="'.$rows['id'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
                                    }			
                                }
                                echo"</SELECT>";
                                echo"<input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\" />";
                                ?>
                        </div>
                        <br>
                        <hr>   
                        <section class="work">
                            <div class="container">
                            <div class="row">
                                <?php
                                
                                    function checkUSerA($id)
                                    {
                                        $isStudent=-1;
                                        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                                        $resultsOfCheckUser = mysqli_query($con, "SELECT * FROM teachers");
                                        while ($rows=mysqli_fetch_array($resultsOfCheckUser))
                                        {
                                            if ($rows['id']==$id && $rows['setUserAs']=='student')
                                            {
                                                $isStudent=1;
                                                break;
                                            }
                                        } 
                                        return $isStudent;   
                                    }
                                    $j=0;
                                    $d=0;
                                        while ($j<=$i)
                                        {
                                            if(checkUSerA($IdArray[$j])==1)
                                            {
                                                if($j%3==0)
                                                {
                                                    echo '<div class="teacher col-sm-12">';
                                                    echo "<hr><hr>";
                                                    echo "</div>";
                                                }
                                                $results = mysqli_query($con, "SELECT * FROM images");
                                                while ($rows=mysqli_fetch_array($results))
                                                {
                                                    if ($rows['id']==$IdArray[$j])
                                                    {
                                                        $studentArrayId[$studentArrayIdCounter]=$IdArray[$j]+18888;
                                                        $studentArrayIdCounter++;
                                                        $d=$IdArray[$j]+18888;
                                                        echo '<div class="teacher col-sm-4" id="$d">';
                                                        echo "<button value=\"$d\" id=\"$d\">";
                                                        echo"   <input type=\"hidden\" id=\"$d\">";
                                                        if ($rows['image']!='image'&&$rows['image']!=null)
                                                        {
                                                            echo "<img src='img/".$rows['image']."'   class='teacherImg img-rounded img-responsive'>";
                                                        }
                                                    }
                                                }
                                                $results = mysqli_query($con, "SELECT * FROM teachers");
                                                while ($rows=mysqli_fetch_array($results))
                                                {
                                                    if ($rows['id']==$IdArray[$j]&&$rows['setUserAs']=='student')
                                                    {
                                                        getName($IdArray[$j]); 
                                                    }
                                                }
                                                echo "</button>";
                                                echo '</div>';
                                                echo "<br><br>";
                                            }
                                        $j++;
                                    }
                                ?>
                                </div>
                            </div>
                            </section> 
                    </div>                 
                        
                    <div id="madeChange" class="tabcontent">
                    <?php
                        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                        $results = mysqli_query($con, "SELECT * FROM teachers");
                        $makeChangeEnter = mysqli_query($con, "SELECT * FROM makeChange");
                        $getIdFromMakeChangeDataBaseCounter=0;
                        $getIdFromMakeChangeDataBase=array();
                        while ($row=mysqli_fetch_assoc($makeChangeEnter)) 
                        {  
                            $getIdFromMakeChangeDataBase[$getIdFromMakeChangeDataBaseCounter]=$row['id'];
                            $getIdFromMakeChangeDataBaseCounter++;
                        }
                        $i=0;
                        $IdArrayChanges = array(); 
                        while ($rows=mysqli_fetch_array($results)) 
                        {
                            for ($j=0; $j < count($getIdFromMakeChangeDataBase); $j++) 
                            { 
                                if ($rows['id']==$getIdFromMakeChangeDataBase[$j]) 
                                {
                                    $IdArrayChanges[$i]=$rows['id'];
                                    $i++;
                                }
                            }
                        }
                        $i-=1;
                    ?>                              
                    <br>
                    <hr>
                        <section class="work">
                    <div class="container">
                    <div class="row">
                        <?php
                       
                                $j=0;
                                $madeChangeIdArray=array();
                                $madeChangeIdArrayCounter=0;
                                while ($j<=$i)
                                {
                                $results = mysqli_query($con, "SELECT * FROM images");
                                while ($rows=mysqli_fetch_array($results))
                                {
                                    if ($rows['id']==$IdArrayChanges[$j])
                                    {
                                        $madeChangeIdArray[$madeChangeIdArrayCounter]=$IdArrayChanges[$j]+17777;
                                        $madeChangeIdArrayCounter++;
                                        $d=$IdArrayChanges[$j]+17777;
                                        echo '<div class="teacher col-sm-3" id="$d">';
                                        echo "<button value=\"$d\" id=\"$d\">";
                                        echo"<input type=\"hidden\" id=\"$d\">";
                                        if ($rows['image']!='image'&&$rows['image']!=null)
                                        {
                                            echo "<img src='img/".$rows['image']."'   class='teacherImg img-rounded img-responsive'>";
                                        }
                                    }
                                }
                                $results = mysqli_query($con, "SELECT * FROM teachers");
                                while ($rows=mysqli_fetch_array($results))
                                {
                                    if ($rows['id']==$IdArrayChanges[$j])
                                    {
                                        getName($IdArrayChanges[$j]); 
                                    }
                                }
                                echo "</button>";
                                echo '</div>';
                                $j++;
                            }
                        ?>
                        </div>
                    </div>
                    </section>
                    </div> 

                    <div id="teachers" class="tabcontent">
                            <h1 class="col-sm-12">חפש לפי שם או בחר מהרשימה למטה</h1>
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                                $teacherIdArray=array();
                                $teacherIdArrayCounter=0;
                                echo "<SELECT  name=\"searchByName\" id=\"searchByName\" class=\"form-control selectpicker\" data-live-search=\"true\">";
                                $results = mysqli_query($con, "SELECT * FROM teachers");
                                echo'<option >'.'בחר שם'.'</option>';
                                while ($rows=mysqli_fetch_array($results))
                                {
                                    if($rows['id']!=211&&$rows['setUserAs']!='student')
                                    {
                                        echo'<option value="'.$rows['id'].'">'.$rows['fname']." ".$rows['lname'].'</option>';
                                    }			
                                }
                                echo"</SELECT>";
                                echo"<input type=\"hidden\" name=\"hidden_framework\" id=\"hidden_framework\" />";
                                ?>
                        </div>
                        <br>
                        <hr>   
                        <section class="work">
                            <div class="container">
                            <div class="row">
                                <?php
                                    function checkUSerAs($id)
                                    {
                                        $isStudent=-1;
                                        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                                        $resultsOfCheckUser = mysqli_query($con, "SELECT * FROM teachers");
                                        while ($rows=mysqli_fetch_array($resultsOfCheckUser))
                                        {
                                            if ($rows['id']==$id && $rows['setUserAs']=='student')
                                            {
                                                $isStudent=1;
                                                break;
                                            }
                                        } 
                                        return $isStudent;   
                                    }
                                        $j=0;
                                        while ($j<=$i)
                                        {
                                            if(checkUSerAs($IdArray[$j])==-1)
                                            {
                                                if($j%3==0)
                                                {
                                                    echo '<div class="teacher col-sm-12">';
                                                    echo "<hr><hr>";
                                                    echo "</div>";
                                                }
                                                $results = mysqli_query($con, "SELECT * FROM images");
                                                while ($rows=mysqli_fetch_array($results))
                                                {
                                                    if ($rows['id']==$IdArray[$j])
                                                    {
                                                        $teacherIdArray[$teacherIdArrayCounter]=$IdArray[$j]+14444;
                                                        $teacherIdArrayCounter++;
                                                        $ddd=$IdArray[$j]+14444;
                                                        echo '<div class="teacher col-sm-4" id="$d">';
                                                        echo "<button value=\"$ddd\" id=\"$ddd\">";
                                                        echo"<input type=\"hidden\" id=\"$ddd\">";
                                                        
                                                        if ($rows['image']!='image'&&$rows['image']!=null)
                                                        {
                                                            echo "<img src='img/".$rows['image']."'   class='teacherImg img-rounded img-responsive'>";
                                                        }
                                                    }
                                                }
                                                $results = mysqli_query($con, "SELECT * FROM teachers");
                                                while ($rows=mysqli_fetch_array($results))
                                                {
                                                    if ($rows['id']==$IdArray[$j]&&$rows['setUserAs']!='student')
                                                    {
                                                        getName($IdArray[$j]); 
                                                    }
                                                }
                                                echo "</button>";
                                                echo '</div>';
                                                echo "<br><br>";
                                            }
                                        $j++;
                                    }
                                ?>
                                </div>
                            </div>
                            </section>     
                    </div>  
                                    
                    <div id="newCC" class="tabcontent">
                    <form action="AdminPage.php" method="post">  
                        <?php
                            $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");                            
                            echo'<div class="form-group">
                            <div class="col-xs-6">';
                            echo "<SELECT class=\"form-control selectpicker\" data-live-search=\"true\">";
                            $results = mysqli_query($con, "SELECT * FROM cities");
                            echo'<option >'.'בדוק את הערים הקימות'.'</option>';
                            while ($rows=mysqli_fetch_array($results))
                            {
                                echo'<option>'.$rows['cityName'].'</option>';
                            }
                            echo"</SELECT>";
                            echo"<br><br>";
                            echo'<input type="text" placeholder="עיר חדשה" name="newCity">';
                            echo'</div></div><br><br>';
                            echo'<div class="form-group">
                            <div class="col-xs-6">';
                            echo "<SELECT class=\"form-control selectpicker\" data-live-search=\"true\">";
                            $results = mysqli_query($con, "SELECT * FROM courses");
                            echo'<option >'.'בדוק את המקצועות הקיימים  '.'</option>';
                            while ($rows=mysqli_fetch_array($results))
                            {
                                echo'<option>'.$rows['subject'].'</option>';
                            }
                            echo"</SELECT>";
                            echo'</div></div>';
                            echo"<br><br>";
                            echo'<input type="text" placeholder="מקצוע חדש" name="newCourse">';
                            echo'
                            <fieldset> 
                            <div class="text-center">
                                    <input type="submit" class="logSignButton btn btn-info btn-primary text-center"  value="הוספה">
                            </div>
                            </fieldset>
                            ';
                            
                        ?>
                        </form> 
                    </div>   
                    <div id="newUSers" class="tabcontent">
                        <?php
                            session_start();
                            $todayDate=date('Y-m-d');
                            $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                            $IdResults = mysqli_query($con, "SELECT * FROM teachers");
                            $idCount=0;
                            $newUsersIdArray = array();
                            while ($rows=mysqli_fetch_array($IdResults))
                            {
                                $creat=$rows['createAccount'];
                                $sameYear=1;
                                if(($todayDate[5]>$creat[5])&&($todayDate[6]!=($creat[6]+1)))
                                {
                                    $sameYear=-1;
                                }
                                    else if($todayDate[5]==$creat[5])
                                    {
                                        if($todayDate[6]>($creat[6]+1))
                                        {
                                        $sameYear=-1;
                                        }
                                        else
                                        {
                                        if($todayDate[6]!=($creat[6]+1)){}
                                        else if($todayDate[6]!=($creat[6]+1))
                                            {
                                            $sameYear=-1; 
                                            }
                                        }
                                    }
                                    for($i=0;$i<strlen($todayDate);$i++)
                                    {
                                        $t = substr($todayDate, $i, 1);
                                        $nT = substr($creat, $i, 1);
                                        if($i<5 && $t!=$nT)
                                        {
                                        $sameYear=-1;
                                            break;
                                        }
                                    }
                                    // echo $sameYear. "<br>";
                                    if ($sameYear==1) 
                                    {
                                        $newUsersIdArray[$idCount]=$rows['id'];
                                        $idCount++;
                                    }
                            }    
                        ?>                    
                    <section class="work">
                        <div class="container">
                        <div class="row">
                            <?php
                                    $j=0;
                                    $newUsersSiteIdArray=array();
                                    $newUsersSiteIdArrayCounter=0;
                                    while ($j<=$i)
                                    {
                                    $results = mysqli_query($con, "SELECT * FROM images");
                                    while ($rows=mysqli_fetch_array($results))
                                    {
                                        if ($rows['id']==$newUsersIdArray[$j])
                                        {
                                            $newUsersSiteIdArray[$newUsersSiteIdArrayCounter]=$newUsersIdArray[$j]+19999;
                                            $newUsersSiteIdArrayCounter++;
                                            $d=$newUsersIdArray[$j]+19999;
                                            echo '<div class="teacher col-sm-3" id="$d">';
                                            echo "<button value=\"$d\" id=\"$d\">";
                                            echo"   <input type=\"hidden\" id=\"$d\">";
                                            if ($rows['image']!='image'&&$rows['image']!=null)
                                            {
                                                echo "<img src='img/".$rows['image']."'   class='teacherImg img-rounded img-responsive'>";
                                            }
                                        }
                                    }
                                    $results = mysqli_query($con, "SELECT * FROM teachers");
                                    while ($rows=mysqli_fetch_array($results))
                                    {
                                        if ($rows['id']==$newUsersIdArray[$j])
                                        {
                                            getName($newUsersIdArray[$j]); 
                                        }
                                    }
                                    echo "</button>";
                                    echo '</div>';
                                    $j++;
                                }
                            ?>
                            </div>
                        </div>
                        </section>
                    </div>        
                    
                    <div id="AdminDetails" class="tabcontent">
                        <!--<h1>שלום וברכה מנהל האתר</h1>
                        <button onclick="addANewAdminPage()">הוספת מנהל חדש</button>
                     --><?php
                            $firstName=" ";
                            $lastName=" ";
                            $email=" ";
                            $Phone=" ";
                            $username=" ";
                            $ID;
                            $db = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
                            $results = mysqli_query($db, "SELECT * FROM teachers");
                           //$adminsArray=array();
                           //$adminsArrayCounter=0;
                            while ($row=mysqli_fetch_assoc($results)) 
                            {
                                //if($row['setUserAs']=='ADMIN')
                                if($row['id']=='211')
                                {
                                    //$adminsArray[$adminsArrayCounter]=$row['id'];
                                    //$adminsArrayCounter++;
                                    $ID=$row['id'];
                                    $username=$row['username'];
                                    $firstName=$row['fname'];
                                    $lastName=$row['lname'];
                                    $email=$row['email'];
                                    $Phone=$row['phone'];
                                }
                            }
                        ?>                        
                        <hr>
                        <div class="container">
                            <div class="row">
                            <div class="col-sm-12"><h1>עדכון פרטים המנהל</h1></div>
                            </div>
                            <div class="row">
                            <div ><!--left col-->
                                    
                            <div class="col-sm-12">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                        <h1> <?php echo $username ?></h1>
                                        </li>
                                    </ul>              
                                <div class="tab-content">
                                    <div class="tab-pane active" id="home">
                                        <hr>
                                        <form class="form" action="AdminPage.php" method="post" id="registrationForm">
                                            
                                        <div class="forme-group">                          
                                                    <div class="col-xs-6">
                                                        <label for="first_name"><h4>שם פרטי</h4></label>
                                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo $firstName?>" title="enter your first name if any.">
                                                    </div>
                                                </div> 
                                            <div class="forme-group">                          
                                                    <div class="col-xs-6">
                                                    <label for="last_name"><h4>שם משפחה</h4></label>
                                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo $lastName?>" >
                                                    </div>
                                                </div>
                                                <div class="forme-group">                         
                                                    <div class="col-xs-6">
                                                        <label for="phone"><h4>   מספר טלפון    </h4></label>
                                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $Phone?>">
                                                    </div>
                                                </div>
                                            <div class="forme-group">
                                                        <div class="col-xs-6">
                                                        <label for="email"><h4>Email</h4></label>
                                                        <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email?>">
                                                    </div>
                                                </div>  
                                                <div class="forme-group">                          
                                                    <div class="col-xs-6">
                                                        <label for="password"><h4>סיסמה</h4></label>
                                                        <input type="password" class="form-control" name="password" id="password" placeholder="סיסמה חדשה">
                                                    </div>
                                                </div> 
                                                <div class="forme-group">                          
                                                    <div class="col-xs-6">
                                                    <label for="verifyPassword"><h4>אימות סיסמה</h4></label>
                                                        <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="אימות הסיסמה החדשה">
                                                    </div>
                                                </div>
                                            <div class="forme-group">
                                                <div class="col-xs-12">
                                                        <br>
                                                        <label for="Save"><h4></h4></label>
                                                        <input type="submit" name="Save" value="שמור">                                                        
                                                    </div>
                                            </div>
                                        </form>
                                    </div><!--/tab-pane-->                                  
                                    
                                    </div><!--/tab-pane-->
                                </div><!--/tab-content-->
                    </div>

                <div class="ButtomSection">      
    <div class="container">
      <div class="row">
        
      <div class="col-sm-4">
          עקובו אחרינו ב-פייסבוק:-
            <a href="https://www.facebook.com/hakita.co.il/" class="fa fa-facebook"></a>
        </div>


        <div class="col-sm-3">
          📚            
      רשימת מקצועות לימוד
      <br>
      צור קשר איתנו📧
         
      <p >הוספת פרויפיל</p>
        </div>
        <div class="col-sm-5">
          &copy;כל הזוכיות שמורות לאתר הכיתה
             
              <a href="https://www.jce.ac.il/">

                </a><br>
                קבוצת פיתוח: המכללה האקדמית להנדסה עזריאלי ירושלים
          
                  <img id="jceImg" src="img/jce2.png" href="https://www.jce.ac.il/">              
              
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
$(document).ready(function()
{
	$("#searchStudentByName").on('change',function(){
	var id =$(this).val();
	if (id)
	{
       window.location.href = "AdminControlPageEditOnUser.php?id=" + id;
	}
	});
    $("#searchByName").on('change',function(){
	var id =$(this).val();
	if (id)
	{
        window.location.href = "AdminControlPageEditOnUser.php?id=" + id;
	}
	});
    $("#searchAllChangedUsersByName").on('change',function(){
	var id =$(this).val();
	if (id)
	{
        window.location.href = "AdminControlPageEditOnUser.php?id=" + id;
	}
	});
});
</script>
<script>
	$(document).ready(function(){
	 $('.selectpicker').selectpicker();

	 $('#searchByName').change(function(){
	  $('#hidden_framework').val($('#searchByName').val());
	 });

	 $('#multiple_select_form').on('Save', function(event){
	  event.preventDefault();
	  if($('#searchByName').val() != '')
	  {
	   var form_data = $(this).serialize();
	   var id =$(this).val();
	   $.ajax({
	    url:"AdminControlPageEditOnUser.php",
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
	   return false;
	  }
	 });
	});
</script>

<script>
	var teachesIdArrayLength = <?php echo end($teacherIdArray);?>;
	$(document).ready(function()
	{
        for (var i = 14444; i <= teachesIdArrayLength; i++)
        { 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function()
            {
                x-=14444;
               if(x>0)
               {
                 window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
               }
            });
        }
        var studentsIdArrayLength = <?php echo end($studentArrayId);?>;
        for (var i = 18888; i <= studentsIdArrayLength; i++)
        { 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function()
            {
                x-=18888;
                if(x>0)
               {
                     window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
               }
            });
        }
	    var madeChangeIdArrayLength = <?php echo end($madeChangeIdArray);?>;
        for (var i = 17777; i <= madeChangeIdArrayLength; i++)
        { 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function()
            {                
                x-=17777;
            if(x>0)
               {
                window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
               }
            });
        }
	    var allUsersArrayId = <?php echo end($allUsersArrayId);?>;
        for (var i = 155555; i <= allUsersArrayId; i++)
        { 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function()
            {                
                x-=155555;
            if(x>0)
               {
                    window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
               }
            });
        }
	    var newUsersSiteIdArray = <?php echo end($newUsersSiteIdArray);?>;
        for (var i = 19999; i <= newUsersSiteIdArray; i++)
        { 
            let x=i;
            let n = x.toString();
            $("#"+n).click(function()
            {                
                x-=19999;
            if(x>0)
               {
                    window.location.href = "AdminControlPageEditOnUser.php?id=" + x;
               }
            });
        }
	});
</script>