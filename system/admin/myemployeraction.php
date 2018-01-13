<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");


 $dbcon->connect();

    $scriptMsg = "Employer Notified";
    $userid = $_POST["id"]; 
    $message=$_POST["message"];
    
    
    if (empty($message))
    	 header("location: myemployer.php?error=Message Required.");

    $data[message]=quote_check($message);
    $data[date_time]=date('Y-m-d H:i:s');
    $data[user_id]=quote_check($userid);
   
    $idmessage=$dbcon->insert("message", $data);

    
    
   header("location: myemployerlist.php?success=Message Sent.");
   exit();

            
   

       

    
?>