<?php
/*
    this file used foe script functions as:
    (A)the up button, (B)get what user selected form the list of cities/courses, on 
    Admin page ehat Admin select on user list.
    (C)for the second navbar on profile page/student view teacher profile, and on ADMIN page.
    (D)copy the URL of teacher profile.
*/
?>



<!DOCTYPE html>
<html>
</html>


<script>
  //this section for the up button, after 300px down on screen the up button will display
  var btn = $('#button');
  $(window).scroll(function(){
    if($(window).scrollTop() > 300){
        btn.addClass('show');//display the button
    }else{
        btn.removeClass('show');//undisplay the button
    }
  });
  btn.on('click', function(e){
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });
</script>
<script>
//for the second navbar on profile page/student view teacher profile, and on ADMIN page.
   function openPageSection(evt, pageName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    document.getElementById(pageName).style.display = "block";
    evt.currentTarget.className += " active";
    }
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
<script>//get the courses/cities/users names users or admin choose
$(document).ready(function(){
 $('.selectpicker').selectpicker();
 $('#framework').change(function(){
  $('#hidden_framework').val($('#framework').val());
 });
 $('#frameworkCourse').change(function(){
  $('#hidden_framework_courses').val($('#frameworkCourse').val());
 });
 $('#frameworkAllUsers').change(function(){
  $('#hidden_framework_allUsers').val($('#frameworkAllUsers').val());
 });
 $('#frameworkStudent').change(function(){
  $('#hidden_framework_student').val($('#frameworkStudent').val());
 });
 $('#frameworkTeacher').change(function(){
  $('#hidden_framework_teacher').val($('#frameworkTeacher').val());
 });
 $('#send_framework').change(function(){
  $('#hidden_send_framework').val($('#send_framework').val());
 });

 $('#multiple_select_form').on('Save', function(event){
  event.preventDefault();
  if($('#framework').val() != ''){
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
  else if($('#frameworkCourse').val() != ''){
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
  else if($('#frameworkAllUsers').val() != ''){
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#hidden_framework_allUsers').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }
  else if($('#frameworkStudent').val() != ''){
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#hidden_framework_student').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }

  else if($('#frameworkTeacher').val() != ''){
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#hidden_framework_teacher').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }

  else if($('#send_framework').val() != ''){
   var form_data = $(this).serialize();
   $.ajax({
    url:"secondEditPage.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#hidden_send_framework').val('');
     $('.selectpicker').selectpicker('val', '');
     alert(data);
    }
   })
  }


  else{
   alert("נא לבחור עיר");
   return false;
  }
 }); 
});
</script>
<script>
jQuery(function ($) {//    
    var $inputs = $('input[name=newCourse],input[name=deleteCourse],input[name=newCity],input[name=deleteCity]');
    $inputs.on('input', function () {
        // Set the required property of the other input to false if this input is not empty.
        $inputs.not(this).prop('required', !$(this).val().length);
    });
});
</script>
<script>
    function myFunction(){//script for copy the profile link, plus show a message.
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        var userId = <?PHP echo (!empty($IDOfTeacher) ? json_encode($IDOfTeacher) : json_encode($ID)); ?>;
        var url="http://hakita.rf.gd/viewTeacherProfile.php?id=";
        url = url.concat(userId);
        x.setAttribute("value", url);
        document.body.appendChild(x);
        x.select();
        x.setSelectionRange(0, 99999)
        document.execCommand("copy"); 
        alert('קישור הפרופיל הועתק');
        x.setAttribute("type", "hidden");
        }
</script>