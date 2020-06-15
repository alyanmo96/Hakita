<?php
/*this is the logout file, to unset id or any username.
then redirect to the main page*/
session_start();
session_destroy();
    if($_SESSION['username']){
        unset($_SESSION["username"]);
    }  
    if($_SESSION['id']){
        unset($_SESSION["id"]);
    } 
   header("Location: Hakita.php");   
   exit;
?>