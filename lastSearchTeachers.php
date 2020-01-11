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
/*
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
  }  */

  $courseIdCounter=0;// count how many teachers learn this course or in this city
  $CoursesIdArray = array(); // array of teachers id's
  $CoursesIdArraylength = count($CoursesIdArray);
  $courseResultArrayCounter=0;
  $courseResultArray=array();// array of information for each teacher
  if ($Courses!=null||$Cities!=null) 
  {
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    if ($Courses!=null && $Cities!=null)//if user choose city and course for search
    {
        $teachers_coursesResult = mysqli_query($con, "SELECT * FROM teachers_courses");
        // check which teacher learn the specified course
        while ($CourseRows=mysqli_fetch_array($teachers_coursesResult)) 
        {
          if(stristr($CourseRows['subject'],$Courses))
          {
           // $CoursesIdArraylength+=5;// for each teacher we give five index(id,first name,last name,phone and image)
            $CoursesIdArray[$courseIdCounter]=$CourseRows['id'];//enter the id on the ID array
            $courseIdCounter+=1;//go to get the next id teacher
          }
        }
        //call the teacher_cities table 
        $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");

        while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
        {
          if(stristr($teacherCitiesRows['cities'],$Cities))
          {
            $checkIfTheIdWasInsertedBefor=-1;
            for($t=0;$t<count($CoursesIdArray);$t++)
            {
              if($CoursesIdArray[t]==$teacherCitiesRows['id'])
              {
                $checkIfTheIdWasInsertedBefor=1;
              }
            }
            if($checkIfTheIdWasInsertedBefor==1)
            {
              $checkIfTheIdWasInsertedBefor=-1;
              $CoursesIdArraylength+=5;
             // $CoursesIdArray[$courseIdCounter]=$teacherCitiesRows['id'];
              //$courseIdCounter+=1;
            }
          }
        }
        //call the teachers table
        $teachersResult = mysqli_query($con, "SELECT * FROM teachers");
        // form the teacher table we get the information about the teacher
        // like first name, last name and phone number
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
        
    }
    else if ($Courses!=null&&$Cities==null) //if one of the two values selected
    {
      $teachers_coursesResult = mysqli_query($con, "SELECT * FROM teachers_courses");
      // check which teacher learn the specified course
      while ($CourseRows=mysqli_fetch_array($teachers_coursesResult)) 
      {
        if(stristr($CourseRows['subject'],$Courses))
        {
          $CoursesIdArraylength+=5;// for each teacher we give five index(id,first name,last name,phone and image)
          $CoursesIdArray[$courseIdCounter]=$CourseRows['id'];//enter the id on the ID array
          $courseIdCounter+=1;//go to get the next id teacher
        }
      }
      //call the teachers table
      $teachersResult = mysqli_query($con, "SELECT * FROM teachers");
      // form the teacher table we get the information about the teacher
      // like first name, last name and phone number
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
      // call the teacher_cities table
      $teacher_citiesResult = mysqli_query($con, "SELECT * FROM teacher_cities");
      //to git the city for each teacher we need 
      while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResult)) 
      {
        for($i=0;$i<$CoursesIdArraylength;$i++)
        {
          if($teacherCitiesRows['id']==$courseResultArray[$i])
          {
             //$courseResultArray[$i+3]=CityFunction($teacherCitiesRows['id']);
             $courseResultArray[$i+3]=$teacherCitiesRows['cities'];
          }
        }
      }
      //get the image for each teacher if there is an image
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
            //$courseResultArray[$i+3]=CityFunction($teacherCitiesRows['id']);
            $courseResultArray[$i+3]=$teacherCitiesRows['cities'];
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
      <link rel="stylesheet" type="text/css" href="css/styleSearch.css">
</head>
<body>
    <a id="button"></a>
    <section>
        <div class="container">
            <div class="row">
                <a class="navbarOptions btn btn-secondary btn-lg active col-sm-3"  href="FAQ.php">שאלות ותשובות </a>
                <a class="navbarOptions btn btn-secondary btn-lg active col-sm-3"  href="MainPage.php">עמוד הבית </a>
                <a class="navbarOptions btn btn-secondary btn-lg active col-sm-3" href="firstLoginPage.php">כניסה/הרשמה</a>                  
            </div>
        </div class="container">
    </section>
<hr>
<div class="container bootstrap snippet">
    <div class="row">
      <div>            
      <div class="col-sm-12">             
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="searchTeachers.php" method="post" id="registrationForm">
                      <div class="form-group">
                             <div class="col-sm-6">
                                  <div style=" padding-top: 1%;">
                                   <p class="searchWords"> חיפוש מורה לפי עיר</p>
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
                             <div class="col-sm-6">
                                  <div style=" padding-top: 1%;">
                                   <p class="searchWords">  חיפוש מורה לפי קורס</p class="searchWords">
                                     <select name="frameworkCourse" id="frameworkCourse" class="form-control selectpicker" data-live-search="true" multiple >
                                        <option class="c" value="אנגלית">אנגלית</option>
                                        <option class="c" value="ערבית">ערבית</option>
                                        <option class="c" value="מתמטיקה">מתמטיקה/חשבון</option>
                                        <option class="c" value="מוסיקה">מוסיקה</option>
                                        <option class="c" value="פיזיקה">פיזיקה</option>
                                        <option class="c" value="אנדרויד">אנדרויד</option>
                                        <option class="c" value="ג'אווה">ג'אווה</option>
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