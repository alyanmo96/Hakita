<?php
session_start();
session_destroy();
    if($_SESSION['username']){
        unset($_SESSION["fname"]);
    }  
    if($_SESSION['id']){
        unset($_SESSION["id"]);
    } 
   header("Location: Hakita.php");   
   exit;
?>