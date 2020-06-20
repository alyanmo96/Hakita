<?php
//calling this file from other files to use functions.some functions for return data, and other for insert or remove data on DB , check id and more.

    function name($id){//function to return name, include first and last name as one string.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        $name=" ";
        $found=-1;
        while ($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id){
              $name.=$row['fname'];
              $name.="&nbsp;";
              $name.=$row['lname'];
              $found=1;
              break;
            }
          }
          if($found==1){
            return $name;
          }elseif($id==211){
            $name="מנהל אתר";
            return $name;
        }
        $name="משתמש לא רשום במערכת";
        return $name;      
    }

    function email($id){//function to return email.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        $email=" ";
        while ($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id){
                $email=$row['email'];break;
            }
        }return $email;  
    }

    function phoneNumber($id){//function to return phone number.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        while ($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id){
                return $row['phone'];
            }
        } 
    }

    function Image($id){//function to return image.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
        while ($ImgRow=mysqli_fetch_assoc($resultsOfImageTable)){
            if($ImgRow['id']==$id){
                 return $ImgRow['image'];
            }
        }return 'user.png';
    } 

    function price($id){//function to return price.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $results= mysqli_query($con, "SELECT * FROM users");
        while ($Row=mysqli_fetch_assoc($results)){
            if($Row['id']==$id){
                return $Row['price'];
            }
        }
    } 

    function updatePrice($id,$price){//function to update teacher lesson price.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `price`='$price'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);
        return;
    }

    function status($id){//function to return status.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $results= mysqli_query($con, "SELECT * FROM users");
        while ($Row=mysqli_fetch_assoc($results)){
            if($Row['id']==$id){
                return $Row['status'];
            }
        }
    }

    function updateStatus($id,$status){//function to update teacher status.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `status`='$status'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);
        return;
    }   

    function Gender($id){//function to return gender.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        while ($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id&&$row['gender']=='male'){
                return 1;
            }
        }return -1;
    }

    function UpdateGender($id, $gender){//function to update teacher gender.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `gender`='$gender'WHERE id=$id";
        $result=mysqli_query($con,$upDate);
        return;
    }

    function Password($id, $password, $verifyPassword){//function to check the password validate if valid insert else return error message as alert.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $invalidPass=-1;//variable use to check if the new student password is valid or not.
        if ($password==$verifyPassword){//check that the insert password equal to the verify password
            $uppercase = preg_match('@[A-Z]@', $password);//password need to include uppercase
            $lowercase = preg_match('@[a-z]@', $password);//password need to include lowercase
            $number = preg_match('@[0-9]@', $password);//password need to include number
            if(strlen($password)<8){//if password is less than 8 chars-->wrong
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                  echo "<script type='text/javascript'>alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                      echo "<script type='text/javascript'>alert('סיסמה קצרה מדי');</script>";
                }
            }else if(strlen($password)>16){//if the password string is bigger than 16 chars
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                    echo "<script type='text/javascript'> alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                    echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי'); </script>";
                }
            }else{
              if(!$uppercase || !$lowercase || !$number){//a valid length of password, but it's not include uppercase or lowercase chars
                  $invalidPass=1;
                  echo "<script type='text/javascript'>alert('הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }
            }
            if($invalidPass==-1){//if it's a valid password-->update it
              $upDate="UPDATE `users` SET `password`='$password'WHERE id=$id";//update new data on DB
              $IdResults = mysqli_query($con,$upDate);
            }
        }return $invalidPass;//if its equal to 1, that mean user insert a bad password, let the field password input to be on red color
    }

    function updateAdminPassword($id, $password, $verifyPassword){//function to check the password validate if valid insert else return error message as alert.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $invalidPass=-1;//variable use to check if the new student password is valid or not.
        if ($password==$verifyPassword){//check that the insert password equal to the verify password
            $uppercase = preg_match('@[A-Z]@', $password);//password need to include uppercase
            $lowercase = preg_match('@[a-z]@', $password);//password need to include lowercase
            $number = preg_match('@[0-9]@', $password);//password need to include number
            if(strlen($password)<8){//if password is less than 8 chars-->wrong
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                  echo "<script type='text/javascript'>alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                      echo "<script type='text/javascript'>alert('סיסמה קצרה מדי');</script>";
                }
            }else if(strlen($password)>16){//if the password string is bigger than 16 chars
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                    echo "<script type='text/javascript'> alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                    echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי'); </script>";
                }
            }else{
              if(!$uppercase || !$lowercase || !$number){//a valid length of password, but it's not include uppercase or lowercase chars
                  $invalidPass=1;
                  echo "<script type='text/javascript'>alert('הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }
            }
            if($invalidPass==-1){//if it's a valid password-->update it
              $upDate="UPDATE `AdminTable` SET `password`='$password'WHERE id=$id";//update new data on DB
              $IdResults = mysqli_query($con,$upDate);
            }
        }return $invalidPass;//if its equal to 1, that mean user insert a bad password, let the field password input to be on red color
    }

    function updateAdminUsername($id, $username){
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `AdminTable` SET `username`='$username'WHERE id=$id";//update new username for admin on DB
        $IdResults = mysqli_query($con,$upDate);
    }
    function PasswordValidate($password, $verifyPassword){//function to check the password validate if valid insert else return error message as alert.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $invalidPass=-1;//variable use to check if the new student password is valid or not.
        if ($password==$verifyPassword){//check that the insert password equal to the verify password
            $uppercase = preg_match('@[A-Z]@', $password);//password need to include uppercase
            $lowercase = preg_match('@[a-z]@', $password);//password need to include lowercase
            $number = preg_match('@[0-9]@', $password);//password need to include number
            if(strlen($password)<8){//if password is less than 8 chars-->wrong
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                  echo "<script type='text/javascript'>alert('סיסמה קצרה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                      echo "<script type='text/javascript'>alert('סיסמה קצרה מדי');</script>";
                }
            }elseif(strlen($password)>16){//if the password string is bigger than 16 chars
                $invalidPass=1;
                if(!$uppercase || !$lowercase || !$number){
                    echo "<script type='text/javascript'> alert('סיסמה ארוכה מדי, הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }else{
                    echo "<script type='text/javascript'>alert('סיסמה ארוכה מדי'); </script>";
                }
            }else{
              if(!$uppercase||!$lowercase||!$number){//a valid length of password, but it's not include uppercase or lowercase chars
                  $invalidPass=1;
                  echo "<script type='text/javascript'>alert('הסיסמה אמורה להכיל אותיות גדולות וקטנות ומספרים');</script>";
                }
            }
        }return $invalidPass;//if its equal to 1, that mean user insert a bad password, let the field password input to be on red color
    }

    function DeleteAccount($ID){//delete user account, need to delete every relative thing of this account from all tables on DB
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $sql = "DELETE FROM users WHERE id=$ID";//delete from the main table
        if ($con->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM images WHERE id=$ID";//delete from the image table
        if ($con->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM dBOfComments WHERE idOfCommentWriter=$ID";//delete from the feedback table
        if ($con->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM dBOfComments WHERE idOfTeacher=$ID";//delete from the feedback table
        if ($con->query($sql) === TRUE){
        }
        $sql = "DELETE FROM makeChange WHERE id=$ID";//delete from the make Change table
        if ($con->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM teacherSchedule WHERE idOfStudent=$ID";//delete from the teacher Schedule table
        if ($con->query($sql) === TRUE){
        }return;
    }

    function updateFirstName($id, $newFirstName){//function to update user first name.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `fname`='$newFirstName'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate); 
        return;
    }

    function updateAdminFirstName($id, $newFirstName){//function to update admin first name.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `AdminTable` SET `fname`='$newFirstName'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate); 
        return;
    }

    function updateLastName($id, $newLastName){//function to update user last name.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `lname`='$newLastName'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);  
        return;
    }

    function updateAdminLastName($id, $newLastName){//function to update admin last name.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `AdminTable` SET `lname`='$newLastName'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate); 
        return;
    }

    function updateEmail($id, $newEmail){//function to update user email.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        while($row=mysqli_fetch_assoc($IdResults)){
            if($row['email']==$newEmail){
                return -1;
            }
        }
        $upDate="UPDATE `users` SET `email`='$newEmail'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);  
        return 1;
    }

    function updateAdminEmail($id, $newEmail){//function to update admin email.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM AdminTable");
        while($row=mysqli_fetch_assoc($IdResults)){
            if($row['email']==$newEmail){
                return -1;
            }
        }
        $upDate="UPDATE `AdminTable` SET `email`='$newEmail'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);  
        return 1;
    }

    function updatePhoneNumber($id, $newPhone){//function to update user phone number.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `phone`='$newPhone'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);  
        return;
    }

    function updateAdminPhoneNumber($id, $newPhone){//function to update user phone number.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `AdminTable` SET `phone`='$newPhone'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);  
        return;
    }

    function updatePhoneNumberTwo($id, $newPhone){//function to update user phone number.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `phoneTwo`='$newPhone'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate);  
        return;
    }

    function updateImage($ID, $newImage, $image_text){//function to update user image.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $image_text=mysqli_real_escape_string($con, $image_text);// Get text
        $target = "img/".basename($newImage);// image file directory
        $upDate="UPDATE `images` SET `image`='$newImage'WHERE id=$ID";//Update user image
        $resultsOfImageTable = mysqli_query($con,$upDate);
        move_uploaded_file($_FILES['image']['tmp_name'], $target); 
        return;
    }

    function setUserAs($id,$setUserAs){//function to update student account to teacher account.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `setUserAs`='$setUserAs'WHERE id=$id";
        $result = mysqli_query($con,$upDate);
        return;
    }

    function checkUserDefineAs($ID){//function to return if the user is a student or teacher, used usually on navbar section to know to which page to redirect.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $resultsOfCheckUser = mysqli_query($con, "SELECT * FROM users");
        while ($rows=mysqli_fetch_array($resultsOfCheckUser)){
            if ($rows['id']==$ID && $rows['setUserAs']=='student'){
                return 1;
            }
        }return -1;  
    }

    function teacherRating($ID){//retutn the ratin of teacher
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
        $countRatingOfTeacher=0;        
        $totalCountRatingOfTeacher=0;
        while ($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
            if($ratingOfTeacher['idOfTeacher']==$ID){
              $countRatingOfTeacher++;  $totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
            }
        }
        $fill=$totalCountRatingOfTeacher/$countRatingOfTeacher;
        $allRating=ceil($fill);                 
        for($stars=0;$stars<$allRating;$stars++){
            echo '<span class="fa fa-star checked"></span>';
        }
        $emptyStars=5-$allRating;$e=0;
        while($e<$emptyStars){
            $e++;echo '<span class="fa fa-star"></span>';
        }return;
    }
    
    function getToggleButtonStatus($ID){//function use to check the status of toggle button
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$ID&&$rows['checkbox']==1){return 1;}
        }return -1;//dont display board time lesson
    }

    function getTeacherTeachedLessonsAmount($ID){//function to know how many times teacher learned
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$ID){return $rows['lessonsAmount'];}
        }return 0;//dont display board time lesson
    }

    function getTeacherLaterLessonsAmount($ID){//function to know how many times teacher have to learn
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        $lessonsCounter=0;
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$ID&&$rows['fullOrFree']==1){$lessonsCounter++;}
        }return $lessonsCounter;//dont display board time lesson
    }

    function getLessonTime($teacherID,$studentId){//function to get the lesson time
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        $lessonsCounter=0;
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$teacherID&&$rows['idOfStudent']==$studentId)
            {
                return $rows['hourOFLesson'];
            }
        }
    }
    
    function getLessonDate($teacherID,$studentId){//function to get the lesson date
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
        $lessonsCounter=0;
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['idOfTeacher']==$teacherID&&$rows['idOfStudent']==$studentId)
            {
                return $rows['lessonDate'];
            }
        }
    }

    function updateOrInsertTeacherLinks($ID, $numberOfInput, $newLink){//-->update the related link
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $scheduleResult=mysqli_query($con, "SELECT * FROM shareTable");
        //-->update the related link
        while($rows=mysqli_fetch_assoc($scheduleResult)){
            if($rows['id']==$ID)
            {
                if($numberOfInput==1){
                    $upDate="UPDATE `shareTable` SET `facebook`='$newLink'WHERE id=$ID";
                    $result = mysqli_query($con,$upDate);
                  }if($numberOfInput==2){
                    $upDate="UPDATE `shareTable` SET `linkedin`='$newLink'WHERE id=$ID";
                    $result = mysqli_query($con,$upDate);
                  }if($numberOfInput==3){
                    $upDate="UPDATE `shareTable` SET `youtube`='$newLink'WHERE id=$ID";
                    $result = mysqli_query($con,$upDate);
                  }if($numberOfInput==4){
                    $upDate="UPDATE `shareTable` SET `firstOtherLink`='$newLink'WHERE id=$ID";
                    $result = mysqli_query($con,$upDate);
                  }if($numberOfInput==5){
                    $upDate="UPDATE `shareTable` SET `secondOtherLink`='$newLink'WHERE id=$ID";
                    $result = mysqli_query($con,$upDate);
                  }
            break;
            }
        }
    }
    
    function randValues($val){//used on searchTeacher and moreTeachers files to encrypt id, by generate with random string three times length 15 and add the number of id digist and the id
        $id='teacher';
        $characters = '0123456789abcdefghijklm!@#$%^*&()_-nopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = '';       
        for ($i = 0; $i < 15; $i++) { 
          $index = rand(0, strlen($characters) - 1); 
          $randomString .= $characters[$index]; 
        } 
        $id.=$randomString;
        $id.=strlen($val);
        $id.=$val; 
        $characters = '0123456789';
        for ($i = 0; $i < 15; $i++) { 
          $index = rand(0, strlen($characters) - 1); 
          $randomString .= $characters[$index]; 
        } 
        $id.=$randomString;
        
        $characters = '0123456789abcdefghijklm!@#$%^*&()_-nopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < 15; $i++) { 
          $index = rand(0, strlen($characters) - 1); 
          $randomString .= $characters[$index]; 
        } 
        $id.=$randomString;
        return $id;
      }
    
    function getRandValues($val){
        $digit=substr($val, 22, 1);
        $id=substr($val, 23, $digit);
        return $id;
    }

    function randMessageValue($val){            
        $characters = '123456789'; 
        $randomString = '';       
        for ($i = 0; $i < 10; $i++) { 
          $index = rand(0, strlen($characters) - 1); 
          $randomString .= $characters[$index]; 
        } 
        $id.=$randomString;
        $id.=strlen($val);
        $id.=$val; 
        return $id;
    }

    //function to check that the id's of the two side of each chat are different. used pn adminMessageRoom file 
    function checkDifferentId($array, $id, $idOther){
		if($id==$idOther){return -1;}
		for($i=0;$i<count($array);$i++){
			if($array[$i]==$idOther){return 1;}
		}return -1;
    }
    
    function SiteCities($city){//function to check if admin going to insert a city that is already on DB or not
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
         $teacher_citiesResultForArray=mysqli_query($con, "SELECT * FROM cities");//call the table of cities
         $arrayOFAll=array();
           while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResultForArray)){
             $r=$teacherCitiesRows['cityName'];
             array_push($arrayOFAll,$r);//insert a list of cities names on array, each city on different index on array, 
             //to compare on next section(after loop) what user choose as a cities and what we have on DB
           } 
           for($t=0;$t<count($arrayOFAll);$t++){
             if((strcmp($city, $arrayOFAll[$t])==0)){return 1;}
           }return -1;
    }   
    
    function SiteCourses($course){//function to check if admin going to insert a course that is already on DB or not
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $resultsOfCourses = mysqli_query($con, "SELECT * FROM courses");//call the table of courses
        $arrayOFAll=array();
          while($teacherCourseRows=mysqli_fetch_array($resultsOfCourses)){
            $r=$teacherCourseRows['subject'];
            array_push($arrayOFAll,$r);//insert a list of courses names on array, each city on different index on array, 
            //to compare on next section(after loop) what user choose as a courses and what we have on DB
          }      
          for($t=0;$t<count($arrayOFAll);$t++){
            if(strcmp($course,$arrayOFAll[$t])==0){return 1;}
          }return -1;
    }   //delete City from DB
     
    function displayPeopleFunctionOnAdminPage($arrayOfId,$relatedNumber,$i){
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $j=0;$arrayIdCounter=0;
        echo'<div class="teacher col-sm-12">';
        echo"<form id=\"fform\"  class=\"col-sm-12\" method=\"post\" action=\"AdminControlPageEditOnUser.php\">";
        while($j<count($arrayOfId)&&count($arrayOfId)>0){//diplay all users
            if(1==1){//true section
                    if(checkUserDefineAs($arrayOfId[$j])==1&&$relatedNumber==14444){$j++; continue;}
                    elseif(checkUserDefineAs($arrayOfId[$j])==-1&&$relatedNumber==18888){$j++;continue;}
                
                $results=mysqli_query($con, "SELECT * FROM images");
                while($rows=mysqli_fetch_array($results)){
                    if($rows['id']==$arrayOfId[$j]){
                        $value=randValues($arrayOfId[$j]);
                        echo"<div class=\"col-sm-4\">
                        <button name=\"user\" value=\"$value\">";
                        if($rows['image']!='image'&&$rows['image']!=null){//display image
                            echo"<img src='img/".$rows['image']."'class='teacherImg img-rounded img-responsive'>";
                            echo"<p>".name($arrayOfId[$j])."</p>";//print name
                            echo"</button></div><div class=\"displayOnSmallScreen\"><br></div>";
                        }
                    }
                }
            }$j++;//help with diplay as we said above.
        }
        echo"</form>";
        echo'</div>';
    }

    function getstudentLaterLessonsAmount($ID){//to display the list of studnt lessons
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
            $scheduleResult=mysqli_query($con, "SELECT * FROM teacherSchedule");
            $lessonsCounter=0;
            while($rows=mysqli_fetch_assoc($scheduleResult)){
                if($rows['idOfStudent']==$ID&&$rows['fullOrFree']==1){$lessonsCounter++;}
            }return $lessonsCounter;//dont display board time lesson
    }

    function returnStringWithoutComma($new,$last){//function use to remove over comma's
        $new.=',';//addin a new comma, cause we going to add a new subject
        $new.=$last;//add the currently subject
        if(substr($new, -1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $new=rtrim($new, ",");
        }
        if(substr($new, 0, 1)==','){//after delete the city on DB will keep the comma of it, so we need to delete it
          $new=ltrim($new, $new[0]); 
        }return $new;//return data
    }


    //this function is for return the name of teacher cities on teachers section like new teacher
    function teacherCities($id){//need to conncet with the DB, the main connection not useful inside function
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities");  
        $MoreThanOneWordSoAddComma=0;//this variable using case there is a teachers with more than one city, so write a comma between each two cities
        $city=" ";//city variable
        while($teacher_citiesRows=mysqli_fetch_assoc($resultOFTeachersCity)){//searching on cities table about the teacher id
            if ($teacher_citiesRows['id']==$id){//if the id on table eqaul to the id of teacher, check in which city he/she is
                if($MoreThanOneWordSoAddComma>=1){ //for more than one city add comma
                    $city.=' , ';
                }
                if($teacher_citiesRows['cities']!='cities'){//add the city name
                    $city.=$teacher_citiesRows['cities'];
                    $MoreThanOneWordSoAddComma++;
                }
            }
        }return $city;//return which cities we get from table if there is
    }

    //this function is for return the name of teacher courses who learn on teachers section like new teacher
    function teacherCourses($id){//need to conncet with the DB, the main connection not useful inside function
        $MoreThanOneWordSoAddComma=0;//this variable using case there is a teachers learn more than one course, so write a comma between each two courses
        $CourseName=" ";//course variable     
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
        while($CoursesResultsRows=mysqli_fetch_array($CoursesOfTeachersResults)){
        if($CoursesResultsRows['id']==$id){ //if the id on table eqaul to the id of teacher, check which course he/she learn
            if($MoreThanOneWordSoAddComma>=1){ //for more than one city add comma
                $CourseName.=" , ";
            }
            if($CoursesResultsRows['subject']!='subject'){//add the course name
                $CourseName=$CoursesResultsRows['subject'];
                $MoreThanOneWordSoAddComma++;
            }
        }	
        }return $CourseName;//return the courses that teacher learn
    }

    function returnTeacherCourses($id){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
      $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
      $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
      while($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
        if($rows['id']==$id){//wanted id
            if($rows['subject']!='subject'){//teacher courses not null
              return $rows['subject'];// return data
            }     
        }   
      }           
    }
    function returnTeacherCities($id){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
      $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
      $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
      while($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
          if($rows['id']==$id){//wanted id
              if($rows['cities']!='cities'){//teacher courses not null
                return $rows['cities'];// return data
              }     
          }   
      }           
    }

    //next function is for display teachers on teachers sections, include name, image, teacher status rating, price, cities, courses.
    function displayTeacherSection($array){
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        echo"<form method=\"post\" action=\"viewTeacherProfile.php\">";
        for($i=0;$i<count($array);$i++){
          $commentResult=mysqli_query($con, "SELECT * FROM dBOfComments");//for rating
          $countRatingOfTeacher=0;        
          $totalCountRatingOfTeacher=0;
          while($ratingOfTeacher=mysqli_fetch_assoc($commentResult)){
              if($ratingOfTeacher['idOfTeacher']==$array[$i]){//ID
                $countRatingOfTeacher++;  $totalCountRatingOfTeacher+=$ratingOfTeacher['rating'];
              }
          }
          $fill=$totalCountRatingOfTeacher/$countRatingOfTeacher;
          $getRatingOfEachComment=ceil($fill);
          $value=randValues($array[$i]);
          echo "<button class=\"buttonCard col-sm-4\"  name=\"showTeacher\" value=\"$value\" style=\"margin-left:2%;\">";
          echo"<img src='img/".Image($array[$i])." 'class=\"img\">";
          if(Gender($array[$i])==-1){echo"<h2 style=\"color: deeppink; font-weight: 700;\">".name($array[$i])."</h2>";}//just for style
          else{echo"<h2 style=\"color:blue; font-weight: 700;\">".name($array[$i])."</h2>";}//just for style
          if($getRatingOfEachComment>0){
            for($star=0;$star<$getRatingOfEachComment;$star++){//the orange star's
              echo'<span class="fa fa-star checked"></span>';
            }
            $emptyStars=5-$getRatingOfEachComment;$e=0;
            while($e<$emptyStars){//the empty star's
                $e++;echo '<span class="fa fa-star"></span>';
            } 
          }          
          if(strcmp(status($array[$i]),'status')!=0){//teacher status, if the string length is bigger than 26 letters, write instead ....
            $stst=status($array[$i]); 
            if(strlen($stst)>26){
              $status = mb_substr($stst,0,25,'utf-8');                            
            }else{
              $status=$stst;
            }$status.="...";                     
            echo"<div id=\"statusDiv\"><p class=\"clearfix\" style=\"height:20px;overflow:hidden;\">\"". $status."</p></div>";          
          }          
          if(returnTeacherCourses($array[$i])!=NULL){//teacher course, if the string length is bigger than 26 letters, write instead ....
            $courses =returnTeacherCourses($array[$i]);
            if(strlen($courses )>26){
              $courses = mb_substr($courses,0,25,'utf-8'); 
            }$courses.="...";                     
            echo"<div id=\"courseDiv\"><p>".$courses."</p></div>";
          }       
          if(returnTeacherCities($array[$i])!=NULL){//teacher cities, if the string length is bigger than 26 letters, write instead ....
            $cities=returnTeacherCities($array[$i]);
            if(strlen($cities )>26){
              $cities = mb_substr($cities,0,25,'utf-8'); 
            }$cities.="...";         
            echo"<div id=\"cityDiv\"><p><small class=\"cityAndPrice\">".$cities."</span></p></div>"; 
         }   

         $price=price($array[$i]);
          if(strlen($price)>15){          
            $price = substr($price,0,25);
            $price.="...";  
          }                   
          echo"<p>".$price."</p></small>";
          echo"</button>"; 
        }echo"</form>";
    }

    function checkId($peopleMessageArray, $id, $idOther){//used on messages file to check that the two users are differents
		if($id==$idOther){return -1;}
		for($i=0;$i<count($peopleMessageArray);$i++){
			if($peopleMessageArray[$i]==$idOther){return 1;}
		}return -1;
    }
    
    function deleteUnrelativeElementFromArray($Id,$includeSubject){//function to keep the relative id's on array. using for {more english teachers}for example.
		$con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
		$CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
		while($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
			if($rows['id']==$Id && (strpos($rows['subject'] , $includeSubject)!==FALSE)){//if we found the reqaired id, check if teacher learn this subject
				return 1;//yes learn, dont need to continue, back true.
			}	
		}return -1;//in case teacher not learn...
    }
    
    function returnTeacherInformationIntoArray($id,$teacherImforamtionArray){
        $thereIsNoAccountLikeThis=1;
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        while($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id){//get variables to use on HTML view 
                $teacherImforamtionArray[1]=$row['fname'];//first name
                $teacherImforamtionArray[2]=$row['lname'];//last name
                $teacherImforamtionArray[3]=$row['email'];//email
                $teacherImforamtionArray[4]=$row['price'];//price
                $teacherImforamtionArray[5]=$row['status'];//teacher status
                $teacherImforamtionArray[6]=$row['phone'];//teacher phone number
                $thereIsNoAccountLikeThis=-1;
                return $teacherImforamtionArray;
            }
        }
        if($thereIsNoAccountLikeThis==1){
            header('location: Logout.php');
        }
    }
    
    function relativeCities($whatSelected,$arrayOfChoosen){
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $teacher_citiesResultForArray = mysqli_query($con, "SELECT * FROM cities");//call the table of cities
        $arrayOFAll=array();
          while ($teacherCitiesRows=mysqli_fetch_array($teacher_citiesResultForArray)){
            $r=$teacherCitiesRows['cityName'];
            array_push($arrayOFAll,$r);//insert a list of cities names on array, each city on different index on array, 
            //to compare on next section(after loop) what user choose as a cities and what we have on DB
          }
          $counterOFArrayOfChoosen=0;      
          for($t=0;$t<count($arrayOFAll);$t++){
            if(stristr($whatSelected,$arrayOFAll[$t])){
              $arrayOfChoosen[$counterOFArrayOfChoosen]=$arrayOFAll[$t];
              $counterOFArrayOfChoosen++;
            }
          }return $arrayOfChoosen;
    }

    //for eaxmple on Jerusalem nutton on this page redirect user to all teachers on Jerusalem...
    function insertCitiesAndCoursesOnArray($subject,$arrayOfTeacherCoursesOrCities){
        $subject.=",ADD";//adding space to string
        $IndexOfArrayOfTeacher=0;
        $length=strlen($subject); //case we will get the cities or cources as a one string 
        $lastComma=0;$counterOfDigits=0;$ifFoundAComma=-1;$howManyTimesFindComma=0;    
        for($q=0;$q<$length;$q++){
            if(substr($subject, $q, 1)==","){
                $ifFoundAComma=1;
                if($howManyTimesFindComma==0){
                    $arrayOfTeacherCoursesOrCities[$IndexOfArrayOfTeacher]=substr($subject, $lastComma,$q); $howManyTimesFindComma++;
                }else{
                    $arrayOfTeacherCoursesOrCities[$IndexOfArrayOfTeacher]=substr($subject, $lastComma,$counterOfDigits-1);                    
                }  
                $IndexOfArrayOfTeacher++;  $counterOfDigits=0; $lastComma=$q+1;
            }
            if($ifFoundAComma==1){
                $counterOfDigits++;
            }   
        }return $arrayOfTeacherCoursesOrCities;
    }

    
    function returnTeacherCitiesOrCoursesIntoArray($id,$whatToReturn){//function te return courses that teacher learn and cities he location in, the variable {whatToReturn} is used to return cities or courses
        $returnData="";//data{cities or courses want to return}
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
        if($whatToReturn==5){//for courses
            while ($rows=mysqli_fetch_assoc($CoursesOfTeachersResults)){
                if ($rows['id']==$id){
                    if($rows['subject']!='subject'){
                        $returnData.=$rows['subject'];break;
                    }
                }	
            }
        }else{//for cities
            $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
            while ($rows=mysqli_fetch_assoc($resultOFTeachersCity)){
                if ($rows['id']==$id){
                    if($rows['cities']!='cities'){
                        $returnData.=$rows['cities'];break;
                    }			
                }		
            }
        }return $returnData;//return data     
    }

    function displayBlogText($articalText){//sub text and display the blog

        if(strlen($articalText)>250){
            $articalText = mb_substr($articalText,0,250,'utf-8'); 
        }
        $articalText.="...";   
        echo'<p>'.$articalText.'</p>';
    }

    function getBlogImage($blogID){//function to return the blog image
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $articalResults=mysqli_query($con, "SELECT * FROM artical");
        while($row=mysqli_fetch_assoc($articalResults)){
            if($row['articalNumber']==$blogID){
               echo" <img class=\"blog\" src=\"img/'".$row['articalImg']."'\">";
            break;
            }
        }              
    }

    function displayBlogTitie($blogID){//sub text and display the blog
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $articalResults=mysqli_query($con, "SELECT * FROM artical");
        while($row=mysqli_fetch_assoc($articalResults)){
            if($row['articalNumber']==$blogID){
               echo"<p>".$row['articalTitle']."</p>";
            break;
            }
        } 
    }

    function invalidPassword($USERNAME){//next section for insert wrong password
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        
        $invailedLoginPassword=1;$isItNotFirstTimeToEnterInvailPassword=-1;$round;$datrOfInvalidPass;
        $ID;
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
?>