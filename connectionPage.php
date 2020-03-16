<?php
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
    $CoursesOfTeachersResults = mysqli_query($con, "SELECT * FROM teachers_courses");
    $resultOFTeachersCity = mysqli_query($con, "SELECT * FROM teacher_cities"); 
    $IdResults = mysqli_query($con, "SELECT * FROM teachers");
    $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
    $resultsOfCities = mysqli_query($con, "SELECT * FROM cities");
    $makeChangeEnter = mysqli_query($con, "SELECT * FROM makeChange");//call table
    $resultsOfCourses = mysqli_query($con, "SELECT * FROM courses");
    $commentResult = mysqli_query($con, "SELECT * FROM dBOfComments");
    ////////////////////////////////////////////////////////////////////////////
    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
    $todayOnWeek=date('Y-m-d');
    while ($scheduleRow=mysqli_fetch_assoc($scheduleResult)){
        if ($scheduleRow['lessonDate']<$todayOnWeek){
            $ID=$scheduleRow['idOfTeacher'];
            $hour=$scheduleRow['hourOFLesson'];
            $day=$scheduleRow['dayOfLesson'];
            $sql = "DELETE FROM teacherSchedule WHERE idOfTeacher=$ID and hourOFLesson = $hour and dayOfLesson=$day";
            if ($con->query($sql) === TRUE){
            } 
        }
    }
    $scheduleResult = mysqli_query($con, "SELECT * FROM teacherSchedule");
?>