<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");




 $dbcon->connect();

    $scriptMsg = "Request Sent";
    $recieverid = $_POST["recieverid"];
    $message=$_POST["message_n"];
    

   $data_m[message]=quote_check($message);
   $data_m[date_time]=date('Y-m-d H:i:s');
   $data_m[user_idfrom]=quote_check($_COOKIE["user_id"]);
   $data_m[user_idfor]=quote_check($recieverid);//admin


   $dbcon->insert("message", $data_m);

    

    header("location: messagelist.php?message sent.");
    exit();

    
?>

