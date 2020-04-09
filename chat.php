<?php
//this going to be the chat page for all user also for admin
	$userId=$_GET['id'];
	

	session_start();
	/*
		*  $userId=$_SESSION['id']
		*   $_SESSION['id']=$userId;
	
	
	
	
		*/
/*
		if(!$userId){
			header("Location: logout.php");
		}




		*/
    function getImg($id){
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        $resultsOfImageTable = mysqli_query($con, "SELECT * FROM images");
        while($rows=mysqli_fetch_assoc($resultsOfImageTable)){
            if($rows['id']==$id){
                return $rows['image'];
            }	
        }
    }
    function getName($id){
        $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
		$IdResults = mysqli_query($con, "SELECT * FROM teachers");
        while($rows=mysqli_fetch_assoc($IdResults)){
            if($rows['id']==$id){
                $name=" ";
                $name.=$rows['fname'];
                $name.=" ";
                $name.=$rows['lname'];
                echo $name;
            }	
        }
	}
	function checkId($peopleMessageArray, $id, $idOther){
		if($id==$idOther){
			return -1;
		}
		for($i=0;$i<count($peopleMessageArray);$i++){
			if($peopleMessageArray[$i]==$idOther){
				return 1;
			}
		}
		return -1;
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>הכיתה</title>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
	  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	  <style>
	  	.container
	  	{
	  		max-width:1170px; margin:auto;
	  	}
		img
		{ 
			max-width:100%;
		}
		.inbox_people 
		{
		  background: #f8f8f8 none repeat scroll 0 0;
		  float: left;
		  overflow: hidden;
		  width: 40%; border-right:1px solid #c4c4c4;
		}
		.inbox_msg 
		{
		  border: 1px solid #c4c4c4;
		  clear: both;
		  overflow: hidden;
		}
		.top_spac
		{ 
			margin: 20px 0 0;
		}
		.recent_heading 
		{
			float: left; width:40%;
		}
		.srch_bar 
		{
		  display: inline-block;
		  text-align: right;
		  width: 60%; 
		  direction: rtl;
		}
		.headind_srch
		{ 
			padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;
			direction: rtl;
		}
		.recent_heading h4 
		{
		  color: #05728f;
		  font-size: 21px;
		  margin: auto;
		}
		.srch_bar input
		{ 
			border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%;padding:2px 0 4px 6px; background:none;
		}
		.srch_bar .input-group-addon button 
		{
		  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
		  border: medium none;
		  padding: 0;
		  color: #707070;
		  font-size: 18px;
		}
		.srch_bar .input-group-addon 
		{ 
			margin: 0 0 0 -27px;
		}
		.chat_ib h5
		{ 
			font-size:15px; color:#464646; margin:0 0 8px 0;
		}
		.chat_ib h5 span
		{ 
			font-size:13px; float:right;
		}
		.chat_ib p
		{ 
			font-size:14px; color:#989898; margin:auto
		}
		.chat_img 
		{
		  float: left;
		  width: 11%;
		}
		.chat_ib 
		{
		  float: left;
		  padding: 0 0 0 15px;
		  width: 88%;
		  direction: rtl;
		}
		.chat_people
		{ 
			overflow:hidden; clear:both;
		}
		.chat_list 
		{
		  border-bottom: 1px solid #c4c4c4;
		  margin: 0;
		  padding: 18px 16px 10px;
		}
		.inbox_chat 
		{ 
			height: 550px; overflow-y: scroll;
		}
		.active_chat
		{ 
			background:#ebebeb;
		}
		.incoming_msg_img 
		{
		  display: inline-block;
		  width: 6%;
		}
		.received_msg 
		{
		  display: inline-block;
		  padding: 0 0 0 10px;
		  vertical-align: top;
		  width: 92%;
		 }
		 .received_withd_msg p 
		 {
		  background: #ebebeb none repeat scroll 0 0;
		  border-radius: 3px;
		  color: #646464;
		  font-size: 14px;
		  margin: 0;
		  padding: 5px 10px 5px 12px;
		  width: 100%;
		}
		.time_date 
		{
		  color: #747474;
		  display: block;
		  font-size: 12px;
		  margin: 8px 0 0;
		  direction: rtl;
		}
		.received_withd_msg 
		{ 
			width: 57%;
		}
		.mesgs 
		{
		  float: left;
		  padding: 30px 15px 0 25px;
		  width: 60%;
		}
		 .sent_msg p 
		 {
			  background: #05728f none repeat scroll 0 0;
			  border-radius: 3px;
			  font-size: 14px;
			  margin: 0; color:#fff;
			  padding: 5px 10px 5px 12px;
			  width:100%;
		}
		.outgoing_msg
		{ 
			overflow:hidden; margin:26px 0 26px;
		}
		.sent_msg 
		{
		  float: right;
		  width: 46%;
		}
		.input_msg_write input 
		{
		  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
		  border: medium none;
		  color: #4c4c4c;
		  font-size: 15px;
		  min-height: 48px;
		  width: 100%;
		  direction: rtl;
		}
		.type_msg 
		{
			border-top: 1px solid #c4c4c4;position: relative;
		}
		.msg_send_btn 
		{
		  background: #05728f none repeat scroll 0 0;
		  border: medium none;
		  border-radius: 50%;
		  color: #fff;
		  cursor: pointer;
		  font-size: 17px;
		  height: 33px;
		  position: absolute;
		  right: 0;
		  top: 11px;
		  width: 33px;
		}
		.messaging 
		{
			 padding: 0 0 50px 0;
		}
		.msg_history 
		{
		  height: 516px;
		  overflow-y: auto;
		}
		.write_msg
		{
			direction: rtl;
		}
		.msgSide
		{
			direction: rtl;
		}
		.iimg{
			
		}
        body {
            margin: 0;
            overflow: hidden;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        #msg_history {
            height: 80vh;
            overflow: hidden;
            padding: 10px;
            background-color: bisque;
        }
        #msg_history{
            flex: 2;
        }
        .msg{
            background-color: #dcf8c6;
            padding: 5px 10px;
            border-radius: 5px;
            margin-bottom: 8px;
            width:fit-content;
        }
        .msg p{
            margin:0;
            font-weight: bold;
        }
	  </style> 	
    </head>	
    <body>
	<section><!--navbar section-->
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>            
				<?php     
					/*for the login user, first we check if the login user is a student or a teacher
						that help with redirect to his profile, case there is a different between theprofile of teacher and the profile of student
						for the login user the navbar include:main page/ my profile  /logout/search for a teacher/FAQ page
						( on {3,4} what's deffirnet with unlogin user, here we send the id of the user)
						*/   
						$isStudent=-1; 
						$IdResult = mysqli_query($con, "SELECT * FROM teachers");//include this file for calling the DB
						while($rows=mysqli_fetch_array($IdResult)){
							if ($rows['id']==$userId && $rows['setUserAs']=='student'){//found the required id
								$isStudent=1;break;//change the flag to one, and break, no need to continue.
							}
						}
						echo "<a class=\"navbar-brand\" href=\"Hakita.php?id=$userId\">הכיתה</a>
						<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
						<ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"Hakita.php?id=$userId\"> עמוד הבית</a></li>";
							if($isStudent==1){// if the login user was a student, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php?id=$userId\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}else{// if the login user was a teacher, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php?id=$userId\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}// login user go to search teachers page/FAQ page/exit from his account
							echo"<li class=\"nav-item\"><a class=\"nav-link\" href=\"searchTeachers.php?id=$userId\">חיפוש מורה</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"FAQ.php?id=$userId\">שאלות ותשובות</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"Hakita.php\">יציאה </a></li>";
						/*


						echo "<a class=\"navbar-brand\" href=\"Hakita.php\">הכיתה</a>
						<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">
						<ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"Hakita.php\"> עמוד הבית</a></li>";
							if($isStudent==1){// if the login user was a student, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"studentProfile.php\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}else{// if the login user was a teacher, then he want to access to his profile
							echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"profile.php\">פרופיל שלי <span class=\"sr-only\">(current)</span></a></li> ";
							}// login user go to search teachers page/FAQ page/exit from his account
							echo"<li class=\"nav-item\"><a class=\"nav-link\" href=\"searchTeachers.php\">חיפוש מורה</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"FAQ.php\">שאלות ותשובות</a></li>
							<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">יציאה </a></li>";







						*/
					?>
				</ul>
				</div>
			</nav>
		</section><hr>
    <div class="container">
        <h3 class=" text-center">תיבת הודעות </h3>
            <div class="messaging">
                <div class="inbox_msg">        
        <div class="mesgs">
          <div class="msg_history" id="msg_history">
			</div>
          <div class="type_msg">
            <div class="input_msg_write" id="input_msg_write">
            	
			</div>
          </div>
        </div>
		<div class="inbox_people">
				<div class="inbox_chat">
				<div class="chat_list">
				<div class="chat_people">
				<?php
				    $peopleMessageArray=array();
					$peopleMessageArrayCounter=0;
					$con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
					$messageResult=mysqli_query($con, "SELECT * FROM messages");
					while($rows=mysqli_fetch_assoc($messageResult)){
						if($rows['message_sender']==$userId && checkId($peopleMessageArray, $userId, $rows['message_receive'])==-1){					
							$peopleMessageArray[$peopleMessageArrayCounter]=$rows['message_receive'];
							$peopleMessageArrayCounter++;
						}elseif($rows['message_receive']==$userId && checkId($peopleMessageArray, $userId, $rows['message_sender'])==-1){
							$peopleMessageArray[$peopleMessageArrayCounter]=$rows['message_sender'];
							$peopleMessageArrayCounter++;
						}	
					}
					for($i=0;$i<$peopleMessageArrayCounter;$i++){
						echo"<button onclick=\"getMessage($userId, $peopleMessageArray[$i])\" id=\"$peopleMessageArray[$i]\">";
						echo'<div class="chat_ib"><h5>';
						getName($peopleMessageArray[$i]);
						echo'</h5></div>
						<div class="chat_img">';
						echo"<img src='img/".getImg($peopleMessageArray[$i])."'  class='iimg'>";
						echo'</div>
						</button>';
					}
				?>
				</div>
				</div>
				</div>
				</div>
			</div>      
			</div>
		</div>
    </body>
</html>    
<script>  
	var interval;
	function getData(idOwner,idOther){
		var url = 'messageData.php';
        $.get(url + '?idOwner='+idOwner+'&idOther='+idOther, function(result){
        if(result.items){
               $("#msg_history").empty();
               	result.items.forEach(item=>{
                $('#msg_history').append(renderMessage(item,idOther));
				$('#input_msg_write').append(writeMessage(idOwner,idOther));
				document.getElementById("idOwner").value = idOwner;
				document.getElementById("idOther").value = idOther;
                })
            };              
        });
	}
	function getMessage(idOwner, idOther){
		clearInterval(interval); 
		interval = setInterval( function() { getData(idOwner,idOther); }, 3000 );
	}
	function renderMessage(item){
		return`<div class="msg"><p>${item}</p></div>`;
	}
	function writeMessage(idOwner,idOther){
		return`<form action="">
			<input type="hidden" id="idOwner" name="idOwner">
			<input type="hidden" id="idOther" name="idOther">
			<input type="text" id="message"  name="message" autocomplete="off" autofocus placeholder="Type...">
			<input type="submit" value="send">
		</form>`;
	}
	/**
	need to check here	
	 */
	$(document).ready(function () {
        $('form').submit(function (e) {
            $.post(url, {
                message: $('#message').val(),
                idOther: $('#idOther').val(),
				idOwner: $('#idOwner').val()
            });
            $('#message').val('');
            return false;
        })
    });

	/*
	$(document).ready(function () {
        $('form').submit(function (e) {
            $.post(url, {
                message: $('#message').val(),
                from: from,
				idOther: $('#idOther').val(),
				idOwner: $('#idOwner').val(),
				idOwner:idOwner,
				idOther:idOther,
            });
            $('#message').val('');
            return false;
        })
    });

	*/
</script>