<?php
    //this file will check automaticlly each hour which users have a lesson
    //to send for them an Email and SMS message
    
    function sendingMail($id){
        $from ="HakitaSite";// from
        $subject="שיעור באתר הכיתה ";//subject of message
        $message="<p>שלום רב, אנחנו מזכירים לך שקיים עבורך שיעור בעוד שעה.</p>";
        $headers="From:".$from."\r\n";
        $headers.="Content-type: text/html\r\n";
        mail($to,$subject,$message,$headers);
    }

    date_default_timezone_set('Asia/Jerusalem');
    $script_tz = date_default_timezone_get();
    $todayOnWeek=date('d-m-Y');
    $day_of_week = date('N', strtotime($todayOnWeek)); 
    $currentHour=date('H');
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");
    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
    while($scheduleRow=mysqli_fetch_assoc($scheduleResult)){
        if($scheduleRow['lessonDate']==$todayOnWeek && ($scheduleRow['hourOFLesson']-1)==$currentHour){
            sendingMail($scheduleRow['idOfTeacher']); 
            sendingMail($scheduleRow['idOfStudent']);
        }
    }
?>