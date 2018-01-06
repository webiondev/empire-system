<?php
include_once("inc/cDbcon.php");
include_once("inc/functions.php");
include_once("inc/security.php");

date_default_timezone_set('Asia/Kuala_Lumpur');


 $dbcon->connect();

    $scriptMsg = "Attendance Given";
    $userid = $_POST["id"];
    $image=$_POST["image"];

    if (false){

        header("location: attendance.php?userid=".$userid."&error=An error occur while processing. Image required.");
        exit();
    }

    else{
        
       


            $data[user_id]=quote_check($userid);
            $data[date_time]=date('Y-m-d H:i:s');
            $data[photo]=quote_check($image);

            $idattendance=$dbcon->insert("attendance", $data);

           header("location: attendance.php?userid=".$userid."&success=Attendance Submitted.");
           exit();

            
       }

       

    
?>