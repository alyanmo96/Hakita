<?php
    $userId = ($_GET['idOwner']) ? $_GET['idOwner'] : $_POST['idOwner'];
    $idOther = ($_GET['idOther']) ? $_GET['idOther'] : $_POST['idOther'];
    $con = mysqli_connect("Localhost","id11176973_haki1","haki321","id11176973_haki");
        
    if($_POST['form']){
        date_default_timezone_set('Asia/Jerusalem'); 
        $script_tz = date_default_timezone_get();
        $message_date = date("y-m-d h:i");
        $message_text=$_POST['message'];
        $query="INSERT INTO `messages`(`message_sender`,`message_receive`,`message_text`,`message_date`) VALUES ('$userId',' $idOther','$message_text','$message_date')";
        $messageResults = mysqli_query($con,$query);
    }
        $message_text=" ";
        $message_date;   
        $fData=" ";
        $q='SELECT * FROM `messages` WHERE `message_receive`="'.$idOther.'" AND `message_sender`="'.$userId.'"
        OR `message_receive`="'.$userId.'" AND `message_sender`="'.$idOther.'"';    
        $r=mysqli_query($con,$q);		
        if($r){
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
                                <p class=\"msgSide\">'. $message_text.'</p>
                                <span class=\"time_date\">'. $message_date.'</span>
                        </div>
                    </div>
                </div>";
                }
            }  
        $data = htmlentities($fData, ENT_QUOTES);
        echo json_encode($fData);
    }
exit();
?>