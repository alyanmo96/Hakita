<?php
  session_start();
  $Cities=$_POST['hidden_framework'];
  $Courses=$_POST['hidden_framework_courses']; 
/*
  echo " ";
  echo " ";
  echo $Cities;
  echo " ";
  echo " ";
  echo " ";
  echo $Courses;
  echo " ";
  echo " ";
*/
  function CityFunction(int $Id) 
  {
              $con=mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");  
              $result = mysqli_query($con, "SELECT * FROM teacher_cities");
              $MoreThanOneCity=0;
              $city=" ";
              while ($rows=mysqli_fetch_assoc($result)) 
              {
                if ($rows['id']==$Id&&$rows['id']!=211) 
                {
                  if (stristr($rows['cities'],"Acre")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='עכו';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Afula")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='עפולה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Arad")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='ערד';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Arraba")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='עראבה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ashdod")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='אשדוד';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ashkelon")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='אשכלון';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Baqa al-Gharbiyye")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='באקה אל גרביה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Bat Yam")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='בת ים';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Beersheba")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='באר שבע';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Beit She\'an")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='בית שאן';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Beit Shemesh")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='בית שמש';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Bnei Brak")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='בני ברק';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Dimona")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='דימונה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Eilat")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='אילת';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"El\'ad")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='אלעד';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Giv\'at Shmuel")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='גבעת שמואל';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Givatayim")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='גבעתיים';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Hadera")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='חדרה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Haifa")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='חיפה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Herzliya")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='הרצליה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Hod HaSharon")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='הוד השרון';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Holon")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='חולון';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Jerusalem")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='ירושלים';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kafr Qasim")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='כפר קאסם';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Karmiel")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='כרמיאל';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kfar Yona")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='כפר יונה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Ata")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית אתא';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Bialik")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית ביאליק';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Gat")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית גת';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Malakhi")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית מלאכי';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Motzkin")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית מוצקין';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Ono")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית אונו';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Shmona")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית שמונה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Kiryat Yam")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קרית ים';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Lod")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='לוד';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ma\'alot Tarshiha")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='מעלות תרשיחא';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Migdal HaEmek")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='מגדל העמק';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Modi\'in-Maccabim-Re\'ut")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='מודיעין מכבים רעות';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Nahariya")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='נהריה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Nesher")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='נשר';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Nazareth")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='נצרת';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ness Ziona")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='נס ציונה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Netanya")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='נתניה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Netivot")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='נתיבות';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Nof HaGalil")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='נוף הגליל';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ofakim")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='אופקים';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Or Akiva")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='אור עקיבה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Petah Tikva")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='פתח תקווה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Qalansawe")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='קלנסווה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ra\'anana")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='רעננה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Rahat")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='רהט';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ramat Gan")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='רמת גן';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ramat HaSharon")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='רמת השרון';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Ramla")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='רמלה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Rehovot")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='רחובות';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Rishon LeZion")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='ראשון לציון';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Rosh HaAyin")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='ראש העין';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Safed")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='צפת';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Sakhnin")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='סכנין';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Sderot")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='סדירות';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Shfa-\'Amr")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='שפא עמר';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Tamra")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='טמרה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Tayibe")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='טייבה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Tel Aviv-Yafo")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='תל-אביב יפו';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Tiberias")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='טבריה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Tira")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='טירה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Tirat Carmel")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='טירת הכרמל';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Umm al-Fahm")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='אום אל-פאחם';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Yavne")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='יבנה';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Yehud-Monosson")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='יהודה מונוסון';
                    $MoreThanOneCity++;
                  }
                  if (stristr($rows['cities'],"Yokneam Illit")) 
                  {
                    if ($MoreThanOneCity>=1) 
                    {
                      $city.=' , ';
                    }
                    $city.='יקנעם עילית';
                    $MoreThanOneCity++;
                  }
                }
              }
              return $city;
  }  
  $courseIdCounter=0;
  $CoursesIdArray = array(); 
  $CoursesIdArraylength = count($CoursesIdArray);
  $courseResultArrayCounter=0;
  $courseResultArray=array();
  if ($Courses!=null||$Cities!=null) 
  {
    if ($Courses!=null&&$Cities==null) 
    {
      $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
      $teachers_coursesResult = mysqli_query($con, "SELECT * FROM teachers_courses");
      while ($CourseRows=mysqli_fetch_array($teachers_coursesResult)) 
      {
        if(stristr($CourseRows['subject'],$Courses))
        {
          $CoursesIdArraylength+=5;
          $CoursesIdArray[$courseIdCounter]=$CourseRows['id'];
          $courseIdCounter+=1;
        }
      }
      $teachersResult = mysqli_query($con, "SELECT * FROM teachers");
      while ($teacherRows=mysqli_fetch_array($teachersResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherRows['id']==$CoursesIdArray[$i])
          {
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['id'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['fname'];
            $courseResultArray[$courseResultArrayCounter]=$courseResultArray[$courseResultArrayCounter]." ".$teacherRows['lname'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['phone'];
            $courseResultArrayCounter+=3;
          }
        }
      }
      $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherCitiesRows['id']==$courseResultArray[$i])
          {
            $courseResultArray[$i+3]=CityFunction($teacherCitiesRows['id']);
          }
        }
      }
      $teacher_images = mysqli_query($con, "SELECT * FROM images");
      while ($teacherImgRows=mysqli_fetch_array($teacher_images)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherImgRows['id']==$courseResultArray[$i])
          {
            $courseResultArray[$i+4]=$teacherImgRows['image'];
          }
        }
      }
    }
    else if ($Cities!=null&&$Courses==null) 
    {
      $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
      $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        if(stristr($teacherCitiesRows['cities'],$Cities))
        {
          $CoursesIdArraylength+=5;
          $CoursesIdArray[$courseIdCounter]=$teacherCitiesRows['id'];
          $courseIdCounter+=1;
        }
      }
      $teachersResult = mysqli_query($con, "SELECT * FROM teachers");
      while ($teacherRows=mysqli_fetch_array($teachersResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherRows['id']==$CoursesIdArray[$i])
          {
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['id'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['fname'];
            $courseResultArray[$courseResultArrayCounter]=$courseResultArray[$courseResultArrayCounter]." ".$teacherRows['lname'];
            $courseResultArrayCounter+=1;
            $courseResultArray[$courseResultArrayCounter]=$teacherRows['phone'];
            $courseResultArrayCounter+=3;
          }
        }
      }
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherCitiesRows['id']==$courseResultArray[$i])
          {
            $courseResultArray[$i+3]=CityFunction($teacherCitiesRows['id']);
          }
        }
      }
      $teacher_images = mysqli_query($con, "SELECT * FROM images");
      while ($teacherImgRows=mysqli_fetch_array($teacher_images)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherImgRows['id']==$courseResultArray[$i])
          {
            $courseResultArray[$i+4]=$teacherImgRows['image'];
          }
        }
      }
    }
  }
  else
  {
    #header('location: seachTeachers.php');
  }
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
          .IMG
          {
            max-width: 30%;
            max-height: 10%;
          }
          #searchButton
          {
             background-color: #00bdff;
              font-size: 20px;
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
      </ul>
    </div>
  </div>
</nav>
<hr>
<div class="container bootstrap snippet">
    <div class="row">
      <div ><!--left col-->
              
      <div class="col-sm-12">             
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="searchTeachers.php" method="post" id="registrationForm">
                      <div class="form-group">
                             <div class="col-sm-6">
                                  <div style=" padding-top: 1%;">
                                    חיפוש לפי עיר
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
                                    <option value="Ma\'alot Tarshiha">מעלות תרשיחא</option>
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
                             <div class="col-sm-6">
                                  <div style=" padding-top: 1%;">
                                     חיפוש לפי קורס
                                     <select name="frameworkCourse" id="frameworkCourse" class="form-control selectpicker" data-live-search="true" multiple >
                                        <option class="c" value="English">אינגלית</option>
                                        <option class="c" value="Arabic">ערבית</option>
                                        <option class="c" value="Math">מתמטיקה/חשבון</option>
                                        <option class="c" value="Music">מוסיקס</option>
                                        <option class="c" value="Physic">פיזיקה</option>
                                        <option class="c" value="Android">אנדרויד</option>
                                        <option class="c" value="Java">גאווה</option>
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
                                  <input id="searchButton" type="submit" name="Save" value="חפש">
                            </div>
                      </div>
                </form>
             </div><!--/tab-pane-->            
              </div><!--/tab-pane-->
          </div><!--/tab-content-->
        </div><!--/col-9-->
    </div><!--/row-->
  </div>
  <hr><hr>
    <section id="searchResult">
      <div class="container">
          <div class="row">
            <?php
              
                for($i=1;$i<$CoursesIdArraylength;$i+=5)
                {
                    echo "<div class=\"col-sm-6\">";
                      echo  $courseResultArray[$i]; 
                      $i++;
                      echo nl2br("\n");
                      echo $courseResultArray[$i];
                      $i++;
                      echo nl2br("\n");
                      echo  $courseResultArray[$i];
                      $i++;
                      echo nl2br("\n");
                      echo "<img src='img/".$courseResultArray[$i]."'   class='IMG'>";
                    echo "</div>";
                    $i-=3;
                    echo "<hr><hr>";
                } 
            ?>
          </div>
      </div>
    </section>
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
     $('#hidden_framework_courses').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }
  else
  {
    alert("נא לבחור קורס");
   return false;
  }
 });
});
</script>