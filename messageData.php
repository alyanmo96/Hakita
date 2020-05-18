<?php
    //this file for insert a new message or export message

    //start with get two id's, one for the real user, and other for the selected user form the list on messageRoom
    $userId = ($_GET['idOwner']) ? $_GET['idOwner'] : $_POST['idOwner'];
    $idOther = ($_GET['idOther']) ? $_GET['idOther'] : $_POST['idOther'];

    //connect with DB
    $con=mysqli_connect("sql105.epizy.com","epiz_25492203","3vHHD8yqUaFf8z","epiz_25492203_Hakita");     
    
    if($_GET['messageVal']){//insert a new message
        date_default_timezone_set('Asia/Jerusalem');//get the local date, for display on chat
        $script_tz = date_default_timezone_get();
        $message_date = date("y-m-d h:i");
        $message_text=$_GET['messageVal'];//the message input
        $query="INSERT INTO `messages`(`message_sender`,`message_receive`,`message_text`,`message_date`) VALUES ('$userId',' $idOther','$message_text','$message_date')";
        $messageResults = mysqli_query($con,$query);//insert into DB
    }
    // next section is for return the messages betweent two side, to display it

    $fData=" ";//the HTML tag's and messages.      
    $message_text=" ";//set the message as a variable
    $message_date=" ";  //message date
        
    //get all message between the two side (user could be a message receive or a message sender)
    $db='SELECT * FROM `messages` WHERE `message_receive`="'.$idOther.'" AND `message_sender`="'.$userId.'"
    OR `message_receive`="'.$userId.'" AND `message_sender`="'.$idOther.'"'; 

    $r=mysqli_query($con,$db);		
    if($r){//if we get somthing (any message then...let $fData include it. $fData also will include tags like <div>)
        while($rows=mysqli_fetch_assoc($r)){                
            $message_text=$rows['message_text'];
            $message_date=$rows['message_date'];
            if($rows['message_sender']==$userId){
                $fData.='
                <div class="outgoing_msg">
                    <div class="sent_msg">
                        <p class="msgSide">'.$message_text.'</p>
                        <span class="time_date">'. $message_date.'</span> 
                    </div>
                </div>';
            }else{
                $fData.="
                <div class=\"incoming_msg\">
                    <div class=\"received_msg\">
                        <div class=\"received_withd_msg\">
                            <p class=\"msgSide\">". $message_text."</p>
                            <span class=\"time_date\">'. $message_date.'</span>
                    </div>
                </div>
            </div>";
            }
        }//to return it as a json to convert it to a HTML code
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = htmlentities($fData, ENT_QUOTES | ENT_IGNORE, "UTF-8");
        echo json_encode($fData);
    }
    $db->close();//close the connection
exit();//exit from this file---like return>
?>