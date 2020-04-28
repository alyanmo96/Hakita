<?php
    session_start();      
    $ID=$_SESSION['id'];//get the teacher id.
    $_SESSION['id']=$ID;  
?>
<!DOCTYPE html>
<html>
  <body>
    <h1>online</h1>
    <div class="iframe-container" style="overflow: hidden; padding-top: 56.25%; position: relative;">
        <iframe allow="microphone; camera" style="border: 0; height: 100%; left: 0; position: absolute; top: 0; width: 100%;" src="https://success.zoom.us/wc/join/3469097483" frameborder="0">
        </iframe>
    </div>
  </body>
</html>