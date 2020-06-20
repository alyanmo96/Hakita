<?php
//this going to be the chat page for all user also for admin
    //start with check user validate
    session_start();
    $userId=$_SESSION['id'];
    $_SESSION['id']=$userId;
    
    if(!$userId){//no user like this, redirect to logout file to dismiss details and redirect to main page
        header("Location: logout.php");
    }

    include 'userData.php';//call userData, to use some function from
?>
<!DOCTYPE html>
<html>
    <head><!--import bootstrap (help with showing{STYLE}), js for the list of cities and courses also for the up button, connect with CSS file and write the TITLE-->
        <?php include 'header.php';/*get the header from header.php file*/?>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/message.css">  
    </head> 
    <body>
    <?php
      $undisplay='messageRoom';//this and next two lines for the navbar, to not display the home page
    ?>
    <?php include_once 'nav.php'?><hr>
        <div class="container">
            <h3 class=" text-center">תיבת הודעות </h3><!--main page title-->
            <div class="messaging">
                <div class="inbox_msg">        
                    <div class="mesgs">
                        <div class="msg_history" id="msg_history"></div><!--the chat message will display here-->
                        <div class="type_msg">
                            <div class="input_msg_write" id="input_msg_write"></div><!--input feild-->
                        </div>
                    </div>
                <div class="inbox_people">
                    <div class="inbox_chat">
                        <div class="chat_list">
                            <div class="chat_people">
                                <?php
                                    //first we check on message table which messages related for this user(sent by this user, or sent for this user)
                                    $peopleMessageArray=array();//array of users user talk with them
                                    $peopleMessageArrayCounter=0;
                                    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");//DB connection
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
                                    //display other users(talked with them as a list, on click on any user will display the chat history)
                                    for($i=0;$i<$peopleMessageArrayCounter;$i++){
                                        echo"<button class=\"userCard\" onclick=\"getMessage($userId, $peopleMessageArray[$i])\">";
											echo'<div class="chat_ib"><h5>';
                                                echo ''.name($peopleMessageArray[$i]);
                                            echo'</h5></div>
                                            <div class="chat_img">';
                                                echo"<img src='img/".Image($peopleMessageArray[$i])."'  class='iimg'>";
                                            echo'</div>
                                        </button>';
                                    }
                                ?>
                                <div><br><br><br><br></div>
                                <div id="forSmallIphone"><br><br><br><br></div>
        </div></div></div></div></div></div></div>
        <div id="forSmallScreen"><br><br><br><br><br><br><br><br><br><br><br><br></div><!--next to div's for small screen design-->
    </body>
</html>    
<script>  
    var interval;//for refresh the chat history

    function getData(idOwner, idOther){//get to this method from getMessage function to get the message history from messageData.php file, by sending to id's. one for the user and the second for the other user(clicked on form the list view)
        var url = 'messageData.php';
        $.get(url+ '?idOwner='+idOwner+'&idOther='+idOther, function(result){
            if(result){
                $("#msg_history").empty();//delete the message display history to display it again with a new message or display other messages
                $('#msg_history').append(renderMessage(result));//display the new details
            };           
        });
    }

    function getMessage(idOwner, idOther){//after click on one of the user on the display list, will get to this function, to display the message and refresh it again.
        clearInterval(interval); 
        $('#input_msg_write').append(writeMessage(idOwner, idOther));
        interval = setInterval( function() { getData(idOwner, idOther); },2000);
    }

    function renderMessage(item){//display the message history, help with append()
        return`<div class="msg"><p>${item}</p></div>`;
    }

    function insertMessageOnTable(idOwner, idOther){//after click on send message will get to this function, to redirect information for messageData.php file to insert it on table(dB)
        var messageVal = document.getElementById("message").value;
        if(messageVal!=''){
            var url = 'messageData.php';
            $.get(url+ '?idOwner='+idOwner+'&idOther='+idOther +'&messageVal='+messageVal, function(result){
                if(result){
                }; 
            });
        }
        $("#msg_history").empty();
        getMessage(idOwner, idOther);//redirect to this function to display the new message
    }

    function writeMessage(idOwner,idOther){//display the field of insert message and send
        $("#input_msg_write").empty();
        return`<br><br>
            <input type="text" id="message" autocomplete="off" autofocus placeholder="כתב/י....">
            <input type="submit" class="btn btn-primary" id="messageSendButton" value="שלח/י" onclick="insertMessageOnTable(${idOwner}, ${idOther})">`;
    }
</script>
