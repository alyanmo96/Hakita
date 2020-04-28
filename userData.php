<?php
//calling this file from other files to use functions.some functions for return data, and other for insert or remove data on DB , accourding to the id.

    function name($id){//function to return name, include first and last name as one string.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $IdResults=mysqli_query($con, "SELECT * FROM users");
        $name=" ";
        while ($row=mysqli_fetch_assoc($IdResults)){
            if($row['id']==$id){
              $name.=$row['fname'];
              $name.="&nbsp;";
              $name.=$row['lname'];
              break;
            }
          }return $name;      
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
        }
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
    function updatePriceTwo($id,$price){//function to update teacher lesson price.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `priceTwo`='$price'WHERE id=$id";//update new data on DB
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
        if ($db->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM images WHERE id=$ID";//delete from the image table
        if ($db->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM dBOfComments WHERE idOfCommentWriter=$ID";//delete from the feedback table
        if ($db->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM makeChange WHERE id=$ID";//delete from the make Change table
        if ($db->query($sql) === TRUE){
        }  
        $sql = "DELETE FROM teacherSchedule WHERE idOfStudent=$ID";//delete from the teacher Schedule table
        if ($db->query($sql) === TRUE){
        }return;
    }
    function updateFirstName($id, $newFirstName){//function to update user first name.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `fname`='$newFirstName'WHERE id=$id";//update new data on DB
        $IdResults = mysqli_query($con,$upDate); 
        return;
    }
    function updateLastName($id, $newLastName){//function to update user last name.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `lname`='$newLastName'WHERE id=$id";//update new data on DB
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
    function updatePhoneNumber($id, $newPhone){//function to update user phone number.
        $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
        $upDate="UPDATE `users` SET `phone`='$newPhone'WHERE id=$id";//update new data on DB
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
?>